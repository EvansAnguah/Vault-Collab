<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class MeetingController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Meeting.php';
        require_once BASE_PATH . '/models/Repository.php';
        require_once BASE_PATH . '/models/User.php';
    }

    /**
     * Meeting Schedule View
     */
    public function index($repoId) {
        $repoModel = new \Repository();
        $repo = $repoModel->find($repoId);

        if (!$repo) {
            $this->redirectWithMessage('/dashboard', 'error', 'Invalid repository.');
            return;
        }

        $meetingModel = new \Meeting();
        $meetings = $meetingModel->getUpcoming($repoId);

        $this->view('meetings/index', [
            'pageTitle' => 'Project Meetings',
            'repo' => $repo,
            'meetings' => $meetings
        ], 'app');
    }

    /**
     * Schedule Meeting
     */
    public function schedule() {
        $this->validateCsrf();
        $repoId = $this->postData('repo_id');
        $title = $this->postData('title');
        $desc = $this->postData('description');
        $date = $this->postData('meeting_date');
        $time = $this->postData('meeting_time');
        $userId = Auth::id();

        if (empty($title) || empty($date) || empty($time)) {
            $this->redirectWithMessage('/meetings/' . $repoId, 'error', 'Missing meeting details.');
            return;
        }

        $meetingModel = new \Meeting();
        $meetingId = $meetingModel->create([
            'repo_id' => $repoId,
            'scheduled_by' => $userId,
            'title' => $title,
            'description' => $desc,
            'meeting_date' => $date,
            'meeting_time' => $time,
            'jitsi_room_id' => 'RMU-V-MEET-' . $repoId . '-' . time(),
            'status' => 'scheduled'
        ]);

        if ($meetingId) {
            $this->redirectWithMessage('/meetings/' . $repoId, 'success', 'Meeting scheduled successfully.');
        } else {
            $this->redirectWithMessage('/meetings/' . $repoId, 'error', 'Scheduling failed.');
        }
    }
}
