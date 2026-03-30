<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class StudentController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Group.php';
        require_once BASE_PATH . '/models/RepoRequest.php';
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
    }

    /**
     * Show student's group page
     */
    public function myGroup() {
        $groupModel = new \Group();
        $userModel = new \User();
        $requestModel = new \RepoRequest();
        
        $userId = Auth::id();
        $group = $groupModel->getByUser($userId);
        
        $data = [
            'pageTitle' => 'My Project Group',
            'group' => $group,
            'members' => [],
            'pendingRequest' => null,
            'repository' => null
        ];

        if ($group) {
            $data['members'] = $groupModel->getMembers($group['id']);
            
            // Check for pending repo request
            $stmt = $this->db->prepare("SELECT * FROM repo_requests WHERE group_id = :gid ORDER BY created_at DESC LIMIT 1");
            $stmt->execute(['gid' => $group['id']]);
            $data['pendingRequest'] = $stmt->fetch();

            // Check for active repository
            $stmt = $this->db->prepare("SELECT * FROM repositories WHERE group_id = :gid LIMIT 1");
            $stmt->execute(['gid' => $group['id']]);
            $data['repository'] = $stmt->fetch();
        }

        $this->view('student/group', $data, 'app');
    }

    /**
     * Create Group Page
     */
    public function createGroupPage() {
        $userId = Auth::id();
        $groupModel = new \Group();
        
        if ($groupModel->getByUser($userId)) {
            $this->redirectWithMessage('/student/group', 'info', 'You are already in a group.');
            return;
        }

        $this->view('student/create_group', [
            'pageTitle' => 'Form a Project Group'
        ], 'app');
    }

    /**
     * Process Group Creation
     */
    public function createGroup() {
        $this->validateCsrf();
        $userId = Auth::id();
        $user = Auth::user();
        
        $groupName = $this->postData('name');
        
        if (empty($groupName)) {
            $this->redirectWithMessage('/student/create-group', 'error', 'Group name is required.');
            return;
        }

        $groupModel = new \Group();
        
        // 1. Create the group
        $groupId = $groupModel->create([
            'name' => $groupName,
            'department_id' => $user['department_id'],
            'created_by' => $userId,
            'created_by_role' => 'student',
            'status' => 'active'
        ]);

        if ($groupId) {
            // 2. Add creator as leader
            $this->db->prepare("INSERT INTO group_members (group_id, user_id, role) VALUES (?, ?, ?)")
                     ->execute([$groupId, $userId, 'leader']);
            
            $this->redirectWithMessage('/student/group', 'success', 'Group created successfully! You can now add members.');
        } else {
            $this->redirectWithMessage('/student/create-group', 'error', 'Failed to create group.');
        }
    }

    /**
     * Add Member to Group
     */
    public function addMember() {
        $this->validateCsrf();
        $userId = Auth::id();
        $indexNumber = $this->postData('index_number');
        
        $groupModel = new \Group();
        $group = $groupModel->getByUser($userId);
        
        if (!$group) {
            $this->redirectWithMessage('/student/group', 'error', 'You must be in a group first.');
            return;
        }

        // Check if current user is leader
        $stmt = $this->db->prepare("SELECT role FROM group_members WHERE group_id = ? AND user_id = ?");
        $stmt->execute([$group['id'], $userId]);
        $membership = $stmt->fetch();
        
        if ($membership['role'] !== 'leader') {
            $this->redirectWithMessage('/student/group', 'error', 'Only the group leader can add members.');
            return;
        }

        // Check member limit (max 4)
        $members = $groupModel->getMembers($group['id']);
        if (count($members) >= 4) {
            $this->redirectWithMessage('/student/group', 'error', 'Group member limit reached (Max 4).');
            return;
        }

        $userModel = new \User();
        $newMember = $userModel->findByIndexNumber($indexNumber);

        if (!$newMember || $newMember['role'] !== 'student') {
            $this->redirectWithMessage('/student/group', 'error', 'Student with index number ' . $indexNumber . ' not found.');
            return;
        }

        // Check if student is already in a group
        $stmt = $this->db->prepare("SELECT id FROM group_members WHERE user_id = ?");
        $stmt->execute([$newMember['id']]);
        if ($stmt->fetch()) {
            $this->redirectWithMessage('/student/group', 'error', 'This student is already in a group.');
            return;
        }

        // Add to group
        $this->db->prepare("INSERT INTO group_members (group_id, user_id, role) VALUES (?, ?, ?)")
                 ->execute([$group['id'], $newMember['id'], 'member']);
        
        $this->redirectWithMessage('/student/group', 'success', $newMember['first_name'] . ' has been added to the group.');
    }

    /**
     * Request Repository Page
     */
    public function requestRepoPage() {
        $userId = Auth::id();
        $groupModel = new \Group();
        $group = $groupModel->getByUser($userId);

        if (!$group) {
            $this->redirectWithMessage('/student/group', 'info', 'You must form a group before requesting a repository.');
            return;
        }

        $this->view('student/request_repo', [
            'pageTitle' => 'Request Project Repository',
            'group' => $group
        ], 'app');
    }

    /**
     * Process Repo Request
     */
    public function requestRepo() {
        $this->validateCsrf();
        $userId = Auth::id();
        $groupModel = new \Group();
        $group = $groupModel->getByUser($userId);

        if (!$group) {
            $this->redirectWithMessage('/student/group', 'error', 'Request failed.');
            return;
        }

        $title = $this->postData('title');
        $desc = $this->postData('description');
        $obj = $this->postData('objectives');

        if (empty($title) || empty($desc)) {
            $this->redirectWithMessage('/student/request-repo', 'error', 'Title and description are required.');
            return;
        }

        $requestModel = new \RepoRequest();
        $requestId = $requestModel->create([
            'group_id' => $group['id'],
            'title' => $title,
            'description' => $desc,
            'objectives' => $obj,
            'status' => 'pending'
        ]);

        if ($requestId) {
            $this->redirectWithMessage('/student/group', 'success', 'Project repository requested! HOD will review it shortly.');
        } else {
            $this->redirectWithMessage('/student/request-repo', 'error', 'Failed to submit request.');
        }
    }

    /**
     * Submit Final Project
     */
    public function submitProject() {
        $this->validateCsrf();
        $userId = Auth::id();
        
        $stmt = $this->db->prepare("SELECT r.id FROM repositories r JOIN group_members gm ON r.group_id = gm.group_id WHERE gm.user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        $repo = $stmt->fetch();

        if (!$repo) {
            $this->redirectWithMessage('/dashboard', 'error', 'No active repository found to submit.');
            return;
        }

        // Logic for formal submission to supervisor
        $this->db->prepare("INSERT INTO project_submissions (repo_id, submitted_by, submission_type, status) VALUES (?, ?, ?, ?)")
                 ->execute([$repo['id'], $userId, 'to_supervisor', 'pending']);
        
        $this->redirectWithMessage('/dashboard', 'success', 'Project submitted to supervisor for review.');
    }

    /**
     * API: Search students for member addition
     */
    public function searchStudents() {
        $query = $this->getData('query');
        $userModel = new \User();
        $user = Auth::user();
        
        $students = $userModel->searchStudents($query, $user['department_id']);
        $this->json($students);
    }
}
