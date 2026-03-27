<?php

use App\Core\Controller;
use App\Core\Session;
use App\Core\Auth;
use App\Core\Mailer;

class AuthController extends Controller {

    private $userModel;
    private $departmentModel;
    private $programModel;

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
        require_once BASE_PATH . '/models/Program.php';
        $this->userModel = new \User();
        $this->departmentModel = new \Department();
        $this->programModel = new \Program();
    }

    /**
     * Show login page
     */
    public function loginPage() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }
        $this->view('auth/login', [
            'pageTitle' => 'Sign In'
        ], 'auth');
    }

    /**
     * Process login
     */
    public function login() {
        $this->validateCsrf();

        $email = $this->postData('email');
        $password = $this->postData('password');
        $remember = $this->postData('remember');

        // Validate
        if (empty($email) || empty($password)) {
            $this->redirectWithMessage('/login', 'error', 'Please enter your email and password.');
            return;
        }

        // Find user
        $user = $this->userModel->findByEmail($email);

        if (!$user || !$user['password_hash'] || !Auth::verifyPassword($password, $user['password_hash'])) {
            $this->redirectWithMessage('/login', 'error', 'Invalid email or password.');
            return;
        }

        // Check if account is active
        if (!$user['is_active']) {
            $this->redirectWithMessage('/login', 'error', 'Your account has been deactivated. Contact administration.');
            return;
        }

        // Check email verification (students only)
        if ($user['role'] === 'student' && !$user['email_verified_at'] && !$user['is_uploaded']) {
            $this->redirectWithMessage('/login', 'error', 'Please verify your email address. Check your inbox for the verification link.');
            return;
        }

        // Login successful
        $userData = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'department_id' => $user['department_id'],
            'program_id' => $user['program_id'],
            'profile_photo' => $user['profile_photo'],
            'index_number' => $user['index_number'],
        ];

        Session::login($userData);

        // Update last login
        $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

        // Remember me - set cookie
        if ($remember) {
            $token = Auth::generateToken();
            $this->userModel->update($user['id'], ['remember_token' => $token]);
            setcookie('remember_token', $token, time() + REMEMBER_ME_LIFETIME, '/', '', false, true);
        }

        $this->redirect('/dashboard');
    }

    /**
     * Show registration page
     */
    public function registerPage() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }

        $departments = $this->departmentModel->findAll('name', 'ASC');

        $this->view('auth/register', [
            'pageTitle' => 'Create Account',
            'panelClass' => 'register-panel',
            'departments' => $departments
        ], 'auth');
    }

    /**
     * Process registration
     */
    public function register() {
        $this->validateCsrf();

        $data = [
            'first_name' => $this->postData('first_name'),
            'last_name' => $this->postData('last_name'),
            'email' => strtolower($this->postData('email')),
            'index_number' => strtoupper($this->postData('index_number')),
            'phone' => $this->postData('phone'),
            'department_id' => $this->postData('department_id'),
            'program_id' => $this->postData('program_id'),
        ];
        $password = $this->postData('password');
        $confirmPassword = $this->postData('confirm_password');
        $acceptTerms = $this->postData('accept_terms');

        // Validations
        $errors = [];

        if (empty($data['first_name'])) $errors[] = 'First name is required.';
        if (empty($data['last_name'])) $errors[] = 'Last name is required.';
        if (empty($data['email'])) $errors[] = 'Email is required.';
        if (empty($data['index_number'])) $errors[] = 'Index number is required.';
        if (empty($data['phone'])) $errors[] = 'Phone number is required.';
        if (empty($data['department_id'])) $errors[] = 'Department is required.';
        if (empty($data['program_id'])) $errors[] = 'Program is required.';
        if (empty($password)) $errors[] = 'Password is required.';
        if (!$acceptTerms) $errors[] = 'You must accept the terms and conditions.';

        // Email validation
        if (!Auth::isValidStudentEmail($data['email'])) {
            $errors[] = 'Email must end with @' . STUDENT_EMAIL_DOMAIN;
        }

        // Password validation
        if (!Auth::isValidPassword($password)) {
            $errors[] = 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }

        // Check unique email
        if ($this->userModel->findByEmail($data['email'])) {
            $errors[] = 'An account with this email already exists.';
        }

        // Check unique index number
        if ($this->userModel->findByIndexNumber($data['index_number'])) {
            $errors[] = 'An account with this index number already exists.';
        }

        if (!empty($errors)) {
            $this->redirectWithMessage('/register', 'error', implode(' ', $errors));
            return;
        }

        // Create user
        $verificationToken = Auth::generateToken();
        $data['password_hash'] = Auth::hashPassword($password);
        $data['role'] = 'student';
        $data['verification_token'] = $verificationToken;
        $data['is_verified'] = 0;

        try {
            $userId = $this->userModel->create($data);

            // Send verification email
            try {
                $mailer = new Mailer();
                $mailer->sendVerificationEmail(
                    $data['email'],
                    $data['first_name'],
                    $verificationToken
                );
            } catch (\Exception $e) {
                // Log error but don't block registration
                error_log("Failed to send verification email: " . $e->getMessage());
            }

            $this->redirectWithMessage('/login', 'success', 'Account created successfully! Please check your email to verify your account.');

        } catch (\Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            $this->redirectWithMessage('/register', 'error', 'An error occurred during registration. Please try again.');
        }
    }

    /**
     * Verify email address
     */
    public function verifyEmail() {
        $token = $this->getData('token');

        if (empty($token)) {
            $this->redirectWithMessage('/login', 'error', 'Invalid verification link.');
            return;
        }

        $user = $this->userModel->findByVerificationToken($token);

        if (!$user) {
            $this->redirectWithMessage('/login', 'error', 'Invalid or expired verification link.');
            return;
        }

        // Verify the user
        $this->userModel->update($user['id'], [
            'email_verified_at' => date('Y-m-d H:i:s'),
            'is_verified' => 1,
            'verification_token' => null,
        ]);

        $this->redirectWithMessage('/login', 'success', 'Email verified successfully! You can now sign in.');
    }

    /**
     * Show verify account page (for uploaded students)
     */
    public function verifyAccountPage() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('auth/verify', [
            'pageTitle' => 'Verify Account',
            'step' => 1
        ], 'auth');
    }

    /**
     * Process account verification
     */
    public function verifyAccount() {
        $this->validateCsrf();

        $step = $this->postData('step', '1');

        if ($step === '1') {
            // Step 1: Verify identity
            $email = strtolower($this->postData('email'));
            $indexNumber = strtoupper($this->postData('index_number'));

            $user = $this->userModel->verifyUploadedStudent($email, $indexNumber);

            if (!$user) {
                $this->redirectWithMessage('/verify-account', 'error', 'No matching record found. Please check your email and index number, or contact your HOD.');
                return;
            }

            // Show step 2 - create password
            $this->view('auth/verify', [
                'pageTitle' => 'Create Password',
                'step' => 2,
                'verifiedUser' => $user
            ], 'auth');

        } elseif ($step === '2') {
            // Step 2: Set password
            $userId = $this->postData('user_id');
            $password = $this->postData('password');
            $confirmPassword = $this->postData('confirm_password');

            if (empty($userId) || empty($password)) {
                $this->redirectWithMessage('/verify-account', 'error', 'Invalid request.');
                return;
            }

            if (!Auth::isValidPassword($password)) {
                $this->redirectWithMessage('/verify-account', 'error', 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters.');
                return;
            }

            if ($password !== $confirmPassword) {
                $this->redirectWithMessage('/verify-account', 'error', 'Passwords do not match.');
                return;
            }

            // Update password
            $this->userModel->update($userId, [
                'password_hash' => Auth::hashPassword($password),
                'is_verified' => 1,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ]);

            $this->redirectWithMessage('/login', 'success', 'Password set successfully! You can now sign in.');
        }
    }

    /**
     * Show forgot password page
     */
    public function forgotPasswordPage() {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('auth/forgot-password', [
            'pageTitle' => 'Forgot Password'
        ], 'auth');
    }

    /**
     * Process forgot password
     */
    public function forgotPassword() {
        $this->validateCsrf();

        $email = strtolower($this->postData('email'));

        if (empty($email)) {
            $this->redirectWithMessage('/forgot-password', 'error', 'Please enter your email address.');
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $resetToken = Auth::generateToken();
            $this->userModel->update($user['id'], [
                'reset_token' => $resetToken,
                'reset_token_expires' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ]);

            // Send reset email
            try {
                $mailer = new Mailer();
                $mailer->sendPasswordResetEmail($email, $user['first_name'], $resetToken);
            } catch (\Exception $e) {
                error_log("Failed to send reset email: " . $e->getMessage());
            }
        }

        // Always show success to prevent email enumeration
        $this->redirectWithMessage('/forgot-password', 'success', 'If an account exists with that email, a password reset link has been sent.');
    }

    /**
     * Show reset password page
     */
    public function resetPasswordPage() {
        $token = $this->getData('token');

        if (empty($token)) {
            $this->redirectWithMessage('/login', 'error', 'Invalid reset link.');
            return;
        }

        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->redirectWithMessage('/login', 'error', 'Invalid or expired reset link. Please request a new one.');
            return;
        }

        $this->view('auth/reset-password', [
            'pageTitle' => 'Reset Password',
            'token' => $token
        ], 'auth');
    }

    /**
     * Process password reset
     */
    public function resetPassword() {
        $this->validateCsrf();

        $token = $this->postData('token');
        $password = $this->postData('password');
        $confirmPassword = $this->postData('confirm_password');

        if (empty($token)) {
            $this->redirectWithMessage('/login', 'error', 'Invalid request.');
            return;
        }

        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->redirectWithMessage('/login', 'error', 'Invalid or expired reset link.');
            return;
        }

        if (!Auth::isValidPassword($password)) {
            $this->redirectWithMessage('/reset-password?token=' . $token, 'error', 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters.');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->redirectWithMessage('/reset-password?token=' . $token, 'error', 'Passwords do not match.');
            return;
        }

        // Update password
        $this->userModel->update($user['id'], [
            'password_hash' => Auth::hashPassword($password),
            'reset_token' => null,
            'reset_token_expires' => null,
        ]);

        $this->redirectWithMessage('/login', 'success', 'Password reset successfully! You can now sign in.');
    }

    /**
     * Logout
     */
    public function logout() {
        // Clear remember token
        if (Auth::check()) {
            $userId = Auth::id();
            $this->userModel->update($userId, ['remember_token' => null]);
        }

        Session::logout();

        // Clear remember cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        $this->redirectWithMessage('/login', 'success', 'You have been signed out.');
    }

    /**
     * Terms & Conditions page (standalone)
     */
    public function terms() {
        $this->view('auth/terms', ['pageTitle' => 'Terms & Conditions'], 'auth');
    }

    /**
     * API: Get programs by department
     */
    public function getPrograms() {
        $departmentId = $this->getData('department_id');

        if (empty($departmentId)) {
            $this->json(['programs' => []]);
            return;
        }

        $programs = $this->programModel->getByDepartment($departmentId);
        $this->json(['programs' => $programs]);
    }
}
