<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class ProfileController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
    }

    /**
     * Display profile page
     */
    public function index() {
        $userId = Auth::id();
        $userModel = new \User();
        $user = $userModel->find($userId); // Refresh data from DB
        
        $deptName = 'None';
        if ($user['department_id']) {
            $deptModel = new \Department();
            $dept = $deptModel->find($user['department_id']);
            if ($dept) $deptName = $dept['name'];
        }

        $this->view('profile/index', [
            'pageTitle' => 'My Profile',
            'user' => $user, // Send fresh user data specifically for the form
            'departmentName' => $deptName
        ], 'app');
    }

    /**
     * Update basic profile details
     */
    public function update() {
        $this->validateCsrf();
        
        $userId = Auth::id();
        $phone = $this->postData('phone', '');
        
        // Strip non-numeric from phone
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        $userModel = new \User();
        
        if ($userModel->update($userId, ['phone' => $phone])) {
            $user = $userModel->find($userId);
            Session::set('user', $user); // Update session global user
            $this->redirectWithMessage('/profile', 'success', 'Profile updated successfully.');
        } else {
            $this->redirectWithMessage('/profile', 'error', 'Failed to update profile.');
        }
    }

    /**
     * Upload a new profile picture
     */
    public function uploadPhoto() {
        $this->validateCsrf();
        
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->redirectWithMessage('/profile', 'error', 'Please select a valid image file. Ensure it is under ' . (MAX_PROFILE_PHOTO_SIZE / 1024 / 1024) . 'MB.');
        }

        $file = $_FILES['photo'];
        
        // Validation
        if ($file['size'] > MAX_PROFILE_PHOTO_SIZE) {
            $this->redirectWithMessage('/profile', 'error', 'File size exceeds 5MB limit.');
        }

        // Safe MIME type checking
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, ALLOWED_IMAGE_TYPES)) {
            $this->redirectWithMessage('/profile', 'error', 'Only JPG, PNG, WEBP, and GIF images are allowed.');
        }

        // Setup upload directory
        $uploadDir = BASE_PATH . PROFILE_UPLOAD_DIR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate safe unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'user_' . Auth::id() . '_' . time() . '.' . $ext;
        $destination = $uploadDir . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $userId = Auth::id();
            $userModel = new \User();
            
            // Delete old photo if exists
            $user = $userModel->find($userId);
            if ($user['profile_photo']) {
                $oldFile = BASE_PATH . $user['profile_photo'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Save new path
            $dbPath = PROFILE_UPLOAD_DIR . '/' . $filename;
            $userModel->update($userId, ['profile_photo' => $dbPath]);
            
            // Update session
            $user = $userModel->find($userId);
            Session::set('user', $user);

            $this->redirectWithMessage('/profile', 'success', 'Profile photo updated successfully.');
        } else {
            $this->redirectWithMessage('/profile', 'error', 'Failed to save photo to the server. Check directory permissions.');
        }
    }

    /**
     * Change user password securely
     */
    public function changePassword() {
        $this->validateCsrf();
        
        $currentPassword = $this->postData('current_password');
        $newPassword = $this->postData('new_password');
        $confirmPassword = $this->postData('confirm_password');
        $userId = Auth::id();

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $this->redirectWithMessage('/profile', 'error', 'All fields are required.');
        }

        if ($newPassword !== $confirmPassword) {
            $this->redirectWithMessage('/profile', 'error', 'New passwords do not match.');
        }

        if (strlen($newPassword) < MIN_PASSWORD_LENGTH) {
            $this->redirectWithMessage('/profile', 'error', 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters long.');
        }

        $userModel = new \User();
        $user = $userModel->find($userId);

        if (!password_verify($currentPassword, $user['password_hash'])) {
            $this->redirectWithMessage('/profile', 'error', 'Current password is incorrect.');
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        
        if ($userModel->update($userId, ['password_hash' => $hash])) {
            $this->redirectWithMessage('/profile', 'success', 'Password changed successfully!');
        } else {
            $this->redirectWithMessage('/profile', 'error', 'Failed to change password. Please try again.');
        }
    }
}
