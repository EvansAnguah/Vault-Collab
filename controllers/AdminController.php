<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class AdminController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
        require_once BASE_PATH . '/models/Program.php';
    }

    /**
     * Manage Users List
     */
    public function manageUsers() {
        $userModel = new \User();
        $deptModel = new \Department();

        $filters = [
            'role' => $_GET['role'] ?? null,
            'department_id' => $_GET['department_id'] ?? null,
            'search' => $_GET['search'] ?? null
        ];

        $users = $userModel->getAllWithDetails($filters);
        $departments = $deptModel->findAll();

        $this->view('admin/users', [
            'pageTitle' => 'Manage Users',
            'users' => $users,
            'departments' => $departments,
            'filters' => $filters
        ], 'app');
    }

    /**
     * Create HOD Page
     */
    public function createHodPage() {
        $deptModel = new \Department();
        $departments = $deptModel->findAll();

        $this->view('admin/create_user', [
            'pageTitle' => 'Create HOD',
            'role' => 'hod',
            'departments' => $departments
        ], 'app');
    }

    /**
     * Create HOD Process
     */
    public function createHod() {
        $this->validateCsrf();
        $userModel = new \User();
        $deptModel = new \Department();

        $data = [
            'first_name' => $this->postData('first_name'),
            'last_name' => $this->postData('last_name'),
            'email' => $this->postData('email'),
            'department_id' => $this->postData('department_id'),
            'role' => 'hod',
            'is_verified' => 1,
            'is_active' => 1
        ];

        // Basic validation
        if (empty($data['first_name']) || empty($data['email']) || empty($data['department_id'])) {
            $this->redirectWithMessage('/admin/create-hod', 'error', 'Please fill in all required fields.');
        }

        if ($userModel->findByEmail($data['email'])) {
            $this->redirectWithMessage('/admin/create-hod', 'error', 'Email already exists.');
        }

        // Generate temporary password or set a default one
        $password = 'Password123!'; 
        $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);

        $userId = $userModel->create($data);

        if ($userId) {
            // Update department with HOD ID
            $deptModel->update($data['department_id'], ['hod_id' => $userId]);
            $this->redirectWithMessage('/admin/users?role=hod', 'success', "HOD created successfully. Temporary password: $password");
        } else {
            $this->redirectWithMessage('/admin/create-hod', 'error', 'Failed to create HOD.');
        }
    }

    /**
     * Create Supervisor Page
     */
    public function createSupervisorPage() {
        $deptModel = new \Department();
        $departments = $deptModel->findAll();

        $this->view('admin/create_user', [
            'pageTitle' => 'Create Supervisor',
            'role' => 'supervisor',
            'departments' => $departments
        ], 'app');
    }

    /**
     * Create Supervisor Process
     */
    public function createSupervisor() {
        $this->validateCsrf();
        $userModel = new \User();

        $data = [
            'first_name' => $this->postData('first_name'),
            'last_name' => $this->postData('last_name'),
            'email' => $this->postData('email'),
            'department_id' => $this->postData('department_id'),
            'role' => 'supervisor',
            'is_verified' => 1,
            'is_active' => 1
        ];

        if (empty($data['first_name']) || empty($data['email'])) {
            $this->redirectWithMessage('/admin/create-supervisor', 'error', 'Required fields missing.');
        }

        if ($userModel->findByEmail($data['email'])) {
            $this->redirectWithMessage('/admin/create-supervisor', 'error', 'Email already exists.');
        }

        $password = 'Password123!';
        $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);

        if ($userModel->create($data)) {
            $this->redirectWithMessage('/admin/users?role=supervisor', 'success', "Supervisor created successfully. Password: $password");
        } else {
            $this->redirectWithMessage('/admin/create-supervisor', 'error', 'Failed to create Supervisor.');
        }
    }

    /**
     * Upload Students Page
     */
    public function uploadStudentsPage() {
        $this->view('admin/upload_students', [
            'pageTitle' => 'Bulk Upload Students'
        ], 'app');
    }

    /**
     * Upload Students Process (CSV)
     */
    public function uploadStudents() {
        $this->validateCsrf();
        
        if (!isset($_FILES['student_csv']) || $_FILES['student_csv']['error'] !== UPLOAD_ERR_OK) {
            $this->redirectWithMessage('/admin/upload-students', 'error', 'Please upload a valid CSV file.');
        }

        $file = $_FILES['student_csv']['tmp_name'];
        $handle = fopen($file, "r");
        
        if ($handle === FALSE) {
            $this->redirectWithMessage('/admin/upload-students', 'error', 'Could not open file.');
        }

        $userModel = new \User();
        $deptModel = new \Department();
        $progModel = new \Program();

        // Skip header
        $header = fgetcsv($handle);
        
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== FALSE) {
            // Expected columns: first_name, last_name, email, index_number, department_code, program_name, year
            if (count($row) < 5) continue;

            $deptCode = trim($row[4]);
            $dept = $deptModel->findByCode($deptCode);
            
            if (!$dept) {
                $errors[] = "Line " . ($successCount + $errorCount + 2) . ": Department code '$deptCode' not found.";
                $errorCount++;
                continue;
            }

            $userData = [
                'first_name' => trim($row[0]),
                'last_name' => trim($row[1]),
                'email' => trim($row[2]),
                'index_number' => trim($row[3]),
                'department_id' => $dept['id'],
                'role' => 'student',
                'is_uploaded' => 1,
                'is_verified' => 0,
                'is_active' => 1
            ];

            if ($userModel->findByEmail($userData['email']) || $userModel->findByIndexNumber($userData['index_number'])) {
                $errorCount++;
                continue;
            }

            if ($userModel->create($userData)) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }
        fclose($handle);

        $msg = "Successfully uploaded $successCount students.";
        if ($errorCount > 0) $msg .= " $errorCount errors occurred.";
        
        $type = $successCount > 0 ? 'success' : 'error';
        $this->redirectWithMessage('/admin/users?role=student', $type, $msg);
    }

    /**
     * Manage Departments & Programs
     */
    public function departments() {
        $deptModel = new \Department();
        $progModel = new \Program();

        $departments = $deptModel->getWithStats();
        
        // Enrich departments with their programs
        foreach ($departments as &$dept) {
            $dept['programs'] = $progModel->getByDepartment($dept['id']);
        }

        $this->view('admin/departments', [
            'pageTitle' => 'Manage Departments',
            'departments' => $departments
        ], 'app');
    }

    /**
     * Create Department
     */
    public function createDepartment() {
        $this->validateCsrf();
        $deptModel = new \Department();

        $data = [
            'name' => $this->postData('name'),
            'code' => strtoupper($this->postData('code')),
            'description' => $this->postData('description')
        ];

        if ($deptModel->create($data)) {
            $this->redirectWithMessage('/admin/departments', 'success', 'Department created successfully.');
        } else {
            $this->redirectWithMessage('/admin/departments', 'error', 'Failed to create department.');
        }
    }

    /**
     * Create Program
     */
    public function createProgram() {
        $this->validateCsrf();
        $progModel = new \Program();

        $data = [
            'name' => $this->postData('name'),
            'department_id' => $this->postData('department_id'),
            'duration_years' => $this->postData('duration', 4)
        ];

        if ($progModel->create($data)) {
            $this->redirectWithMessage('/admin/departments', 'success', 'Program added successfully.');
        } else {
            $this->redirectWithMessage('/admin/departments', 'error', 'Failed to add program.');
        }
    }

    /**
     * Toggle User Status (AJAX or Redirect)
     */
    public function toggleUserStatus() {
        $this->validateCsrf();
        $userId = $this->postData('user_id');
        $status = $this->postData('status');

        $userModel = new \User();
        if ($userModel->updateStatus($userId, $status)) {
            $this->redirectWithMessage('/admin/users', 'success', 'User status updated.');
        } else {
            $this->redirectWithMessage('/admin/users', 'error', 'Failed to update status.');
        }
    }
}
