<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class HodController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Group.php';
        require_once BASE_PATH . '/models/RepoRequest.php';
        require_once BASE_PATH . '/models/Repository.php';
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
    }

    /**
     * Manage Department Groups
     */
    public function manageGroups() {
        $user = Auth::user();
        $groupModel = new \Group();
        
        $stmt = $this->db->prepare(
            "SELECT g.*, 
                    (SELECT COUNT(*) FROM group_members gm WHERE gm.group_id = g.id) as member_count
             FROM `groups` g
             WHERE g.department_id = :dept
             ORDER BY g.created_at DESC"
        );
        $stmt->execute(['dept' => $user['department_id']]);
        $groups = $stmt->fetchAll();

        $this->view('hod/groups', [
            'pageTitle' => 'Departmental Project Groups',
            'groups' => $groups
        ], 'app');
    }

    /**
     * Review Repository Requests
     */
    public function repoRequests() {
        $user = Auth::user();
        $requestModel = new \RepoRequest();
        $requests = $requestModel->getPendingByDepartment($user['department_id']);

        // Get supervisors for immediate assignment
        $userModel = new \User();
        $supervisors = $userModel->getSupervisorsByDepartment($user['department_id']);

        $this->view('hod/repo_requests', [
            'pageTitle' => 'Project Repository Requests',
            'requests' => $requests,
            'supervisors' => $supervisors
        ], 'app');
    }

    /**
     * Process Repo Request Review
     */
    public function reviewRequest() {
        $this->validateCsrf();
        $requestId = $this->postData('request_id');
        $action = $this->postData('action'); // approved or declined
        $comment = $this->postData('comment');
        $supervisorId = $this->postData('supervisor_id');
        $userId = Auth::id();

        $requestModel = new \RepoRequest();
        $request = $requestModel->find($requestId);

        if (!$request) {
            $this->redirectWithMessage('/hod/repo-requests', 'error', 'Request not found.');
            return;
        }

        $data = [
            'status' => $action,
            'hod_comment' => $comment,
            'reviewed_by' => $userId,
            'reviewed_at' => date('Y-m-d H:i:s')
        ];

        if ($requestModel->update($requestId, $data)) {
            if ($action === 'approved') {
                if (empty($supervisorId)) {
                    $this->redirectWithMessage('/hod/repo-requests', 'error', 'Supervisor is required for approval.');
                    return;
                }

                // If approved, create the repository
                $repoModel = new \Repository();
                $repoModel->create([
                    'group_id' => $request['group_id'],
                    'request_id' => $requestId,
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'supervisor_id' => $supervisorId,
                    'status' => 'active'
                ]);

                // Update group status if necessary
                $this->db->prepare("UPDATE `groups` SET status = 'active' WHERE id = ?")
                         ->execute([$request['group_id']]);
                
                $this->redirectWithMessage('/hod/repo-requests', 'success', 'Request approved. Repository created and supervisor assigned.');
            } else {
                $this->redirectWithMessage('/hod/repo-requests', 'info', 'Request declined with comments.');
            }
        } else {
            $this->redirectWithMessage('/hod/repo-requests', 'error', 'Failed to update request status.');
        }
    }

    /**
     * Assign Supervisor Page
     */
    public function assignSupervisorPage() {
        $user = Auth::user();
        $repoModel = new \Repository();
        
        // Find repositories in this department without a supervisor
        $stmt = $this->db->prepare(
            "SELECT r.*, g.name as group_name FROM repositories r
             JOIN `groups` g ON r.group_id = g.id
             WHERE g.department_id = :dept AND r.supervisor_id IS NULL AND r.is_archived = 0"
        );
        $stmt->execute(['dept' => $user['department_id']]);
        $unassignedRepos = $stmt->fetchAll();

        // Get supervisors in this department
        $userModel = new \User();
        $supervisors = $userModel->getSupervisorsByDepartment($user['department_id']);

        $this->view('hod/assign_supervisor', [
            'pageTitle' => 'Assign Project Supervisors',
            'repositories' => $unassignedRepos,
            'supervisors' => $supervisors
        ], 'app');
    }

    /**
     * Process Supervisor Assignment
     */
    public function assignSupervisor() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $supervisorId = $this->postData('supervisor_id');

        if (empty($repoId) || empty($supervisorId)) {
            $this->redirectWithMessage('/hod/assign-supervisor', 'error', 'Assignment failed.');
            return;
        }

        $repoModel = new \Repository();
        if ($repoModel->update($repoId, ['supervisor_id' => $supervisorId])) {
            $this->redirectWithMessage('/hod/assign-supervisor', 'success', 'Supervisor assigned successfully.');
        } else {
            $this->redirectWithMessage('/hod/assign-supervisor', 'error', 'Failed to assign supervisor.');
        }
    }

    /**
     * View Project Submissions (Final HOD Review)
     */
    public function reviewSubmissions() {
        $user = Auth::user();
        $stmt = $this->db->prepare(
            "SELECT ps.*, r.title as repo_title, g.name as group_name, u.first_name as sup_first, u.last_name as sup_last
             FROM project_submissions ps
             JOIN repositories r ON ps.repo_id = r.id
             JOIN `groups` g ON r.group_id = g.id
             JOIN users u ON r.supervisor_id = u.id
             WHERE g.department_id = :dept AND ps.status = 'pending' AND ps.submission_type = 'to_hod'"
        );
        $stmt->execute(['dept' => $user['department_id']]);
        $submissions = $stmt->fetchAll();

        $this->view('hod/submissions', [
            'pageTitle' => 'Final Project Submissions',
            'submissions' => $submissions
        ], 'app');
    }

    /**
     * Archive Project
     */
    public function archiveProject() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $userId = Auth::id();

        $repoModel = new \Repository();
        $repo = $repoModel->getWithDetails($repoId);

        if (!$repo) {
            $this->redirectWithMessage('/hod/submissions', 'error', 'Project not found.');
            return;
        }

        // Create immutable snapshot record
        $this->db->prepare("INSERT INTO archived_projects (repo_id, group_name, project_title, department_id, supervisor_name, members, snapshot_data, archived_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
                 ->execute([
                     $repoId, 
                     $repo['group_name'], 
                     $repo['title'], 
                     Auth::user()['department_id'],
                     $repo['supervisor_first'] . ' ' . $repo['supervisor_last'],
                     json_encode([]), // Placeholder for member snapshot
                     json_encode([]), // Placeholder for full project snapshot
                     $userId
                 ]);

        // Update repository status to archived
        $repoModel->update($repoId, ['status' => 'archived', 'is_archived' => 1, 'archived_at' => date('Y-m-d H:i:s'), 'archived_by' => $userId]);

        $this->redirectWithMessage('/hod/archived', 'success', 'Project successfully archived and moved to history.');
    }

    /**
     * Upload Students Page (HOD version)
     */
    public function uploadStudentsPage() {
        $this->view('hod/upload_students', [
            'pageTitle' => 'Bulk Student Registration'
        ], 'app');
    }

    /**
     * Process Student Upload
     */
    public function uploadStudents() {
        $this->validateCsrf();
        $file = $_FILES['csv_file'];
        $user = Auth::user();

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->redirectWithMessage('/hod/upload-students', 'error', 'File upload failed.');
            return;
        }

        $handle = fopen($file['tmp_name'], 'r');
        $headers = fgetcsv($handle); // Skip header row
        $userModel = new \User();
        $count = 0;

        while (($row = fgetcsv($handle)) !== FALSE) {
            if (count($row) < 4) continue;
            
            $data = [
                'first_name' => $row[0],
                'last_name' => $row[1],
                'email' => strtolower($row[2]),
                'index_number' => $row[3],
                'department_id' => $user['department_id'],
                'role' => 'student',
                'is_uploaded' => 1
            ];

            if (!$userModel->findByEmail($data['email'])) {
                $userModel->create($data);
                $count++;
            }
        }
        fclose($handle);

        $this->redirectWithMessage('/hod/groups', 'success', "Successfully uploaded $count students to your department.");
    }
}
