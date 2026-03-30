<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class SupervisorController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Repository.php';
        require_once BASE_PATH . '/models/Notice.php';
        require_once BASE_PATH . '/models/ProjectSubmission.php';
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Group.php';
    }

    /**
     * Show supervisor's assigned groups
     */
    public function myGroups() {
        $userId = Auth::id();
        $repoModel = new \Repository();
        
        $groups = $repoModel->getBySupervisor($userId);

        $this->view('supervisor/groups', [
            'pageTitle' => 'My Assigned Projects',
            'groups' => $groups
        ], 'app');
    }

    /**
     * Review Project Submission
     */
    public function reviewProject() {
        $id = $this->getData('id'); // repo_id or submission_id? Let's say repo_id
        $repoModel = new \Repository();
        $repo = $repoModel->getWithDetails($id);

        if (!$repo || $repo['supervisor_id'] != Auth::id()) {
            $this->redirectWithMessage('/supervisor/groups', 'error', 'Project access denied.');
            return;
        }

        // Get latest submission
        $stmt = $this->db->prepare("SELECT * FROM project_submissions WHERE repo_id = :rid ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(['rid' => $id]);
        $submission = $stmt->fetch();

        $this->view('supervisor/review', [
            'pageTitle' => 'Project Review Hub',
            'repo' => $repo,
            'submission' => $submission
        ], 'app');
    }

    /**
     * Process Submission Review
     */
    public function submitReview() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $action = $this->postData('action'); // accepted or declined
        $comments = $this->postData('comments');
        $userId = Auth::id();

        $stmt = $this->db->prepare("SELECT id FROM project_submissions WHERE repo_id = :rid AND status = 'pending' ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(['rid' => $repoId]);
        $submission = $stmt->fetch();

        if ($submission) {
            $this->db->prepare("UPDATE project_submissions SET status = ?, comments = ?, reviewed_by = ?, reviewed_at = NOW() WHERE id = ?")
                     ->execute([$action, $comments, $userId, $submission['id']]);
            
            // If accepted, update repository status
            if ($action === 'accepted') {
                $this->db->prepare("UPDATE repositories SET status = 'under_review' WHERE id = ?")
                         ->execute([$repoId]);
            }
            
            $this->redirectWithMessage('/supervisor/review?id=' . $repoId, 'success', 'Review submitted successfully.');
        } else {
            $this->redirectWithMessage('/supervisor/groups', 'error', 'No pending submission found.');
        }
    }

    /**
     * Post Notice to Group
     */
    public function postNotice() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $title = $this->postData('title');
        $content = $this->postData('content');
        $userId = Auth::id();

        if (empty($title) || empty($content)) {
            $this->redirectWithMessage('/supervisor/review?id=' . $repoId, 'error', 'Notice title and content are required.');
            return;
        }

        $noticeModel = new \Notice();
        $noticeId = $noticeModel->create([
            'repo_id' => $repoId,
            'supervisor_id' => $userId,
            'title' => $title,
            'content' => $content,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+48 hours'))
        ]);

        if ($noticeId) {
            $this->redirectWithMessage('/supervisor/review?id=' . $repoId, 'success', 'Notice posted successfully (expires in 48h).');
        } else {
            $this->redirectWithMessage('/supervisor/review?id=' . $repoId, 'error', 'Failed to post notice.');
        }
    }

    /**
     * Submit Final Project to HOD for Archiving
     */
    public function submitToHod() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $userId = Auth::id();

        // Check if repo belongs to supervisor
        $repoModel = new \Repository();
        $repo = $repoModel->find($repoId);

        if (!$repo || $repo['supervisor_id'] != $userId) {
            $this->redirectWithMessage('/supervisor/groups', 'error', 'Unauthorized.');
            return;
        }

        // Create submission to HOD
        $this->db->prepare("INSERT INTO project_submissions (repo_id, submitted_by, submission_type, status) VALUES (?, ?, ?, ?)")
                 ->execute([$repoId, $userId, 'to_hod', 'pending']);
        
        // Update repo status
        $this->db->prepare("UPDATE repositories SET status = 'submitted' WHERE id = ?")
                 ->execute([$repoId]);

        $this->redirectWithMessage('/supervisor/groups', 'success', 'Project successfully recommended to HOD for final defense/archiving.');
    }

    /**
     * View Group Logbook for Review
     */
    public function logbookReview($repoId) {
        $userId = Auth::id();
        $repoModel = new \Repository();
        $repo = $repoModel->find($repoId);

        if (!$repo || $repo['supervisor_id'] != $userId) {
            $this->redirectWithMessage('/supervisor/groups', 'error', 'Access denied.');
            return;
        }

        require_once BASE_PATH . '/models/LogbookEntry.php';
        $logbookModel = new \LogbookEntry();
        $entries = $logbookModel->getWithRemarks($repoId);

        $this->view('logbook/index', [
            'pageTitle' => 'Logbook Review: ' . $repo['title'],
            'repo' => $repo,
            'entries' => $entries
        ], 'app');
    }

    /**
     * Add Remark to Logbook Entry
     */
    public function addRemark() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $logEntryId = $this->postData('logbook_entry_id');
        $remark = $this->postData('remark');
        $userId = Auth::id();

        $this->db->prepare("INSERT INTO supervisor_remarks (logbook_entry_id, supervisor_id, remark) VALUES (?, ?, ?)")
                 ->execute([$logEntryId, $userId, $remark]);

        $this->redirectWithMessage('/supervisor/logbook/' . $repoId, 'success', 'Remark added to logbook.');
    }
}
