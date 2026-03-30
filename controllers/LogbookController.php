<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class LogbookController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Repository.php';
        require_once BASE_PATH . '/models/LogbookEntry.php';
        require_once BASE_PATH . '/models/User.php';
    }

    /**
     * Logbook Main View
     */
    public function index($repoId) {
        $repoModel = new \Repository();
        $repo = $repoModel->getWithDetails($repoId);

        if (!$repo) {
            $this->redirectWithMessage('/dashboard', 'error', 'Invalid repository.');
            return;
        }

        $logbookModel = new \LogbookEntry();
        $entries = $logbookModel->getWithRemarks($repoId);

        $this->view('logbook/index', [
            'pageTitle' => 'Project Logbook: ' . $repo['title'],
            'repo' => $repo,
            'entries' => $entries
        ], 'app');
    }

    /**
     * Add Logbook Entry
     */
    public function addEntry() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $activity = $this->postData('activity');
        $userId = Auth::id();

        if (empty($activity)) {
            $this->redirectWithMessage('/workspace/' . $repoId . '/logbook', 'error', 'Activity description required.');
            return;
        }

        $logbookModel = new \LogbookEntry();
        
        // Get next serial no
        $stmt = $this->db->prepare("SELECT MAX(serial_no) as max_s FROM logbook_entries WHERE repo_id = :rid");
        $stmt->execute(['rid' => $repoId]);
        $max = $stmt->fetch();
        $nextSerial = ($max['max_s'] ?? 0) + 1;

        $id = $logbookModel->create([
            'repo_id' => $repoId,
            'serial_no' => $nextSerial,
            'activity' => $activity,
            'student_id' => $userId,
            'date_time' => date('Y-m-d H:i:s')
        ]);

        if ($id) {
            $this->redirectWithMessage('/workspace/' . $repoId . '/logbook', 'success', 'Activity added to logbook.');
        } else {
            $this->redirectWithMessage('/workspace/' . $repoId . '/logbook', 'error', 'Entry failed.');
        }
    }

    /**
     * Add Supervisor Remark
     */
    public function addRemark() {
        $this->validateCsrf();
        $logbookId = $this->postData('logbook_entry_id');
        $repoId = $this->postData('repo_id');
        $remark = $this->postData('remark');
        $userId = Auth::id();

        if (Auth::role() != 'supervisor') {
            $this->redirectWithMessage('/dashboard', 'error', 'Unauthorized.');
            return;
        }

        $this->db->prepare("INSERT INTO supervisor_remarks (logbook_entry_id, supervisor_id, remark) VALUES (?, ?, ?)")
                 ->execute([$logbookId, $userId, $remark]);
        
        $this->redirectWithMessage('/workspace/' . $repoId . '/logbook', 'success', 'Remark added successfully.');
    }
}
