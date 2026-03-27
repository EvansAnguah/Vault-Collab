<?php

use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Department.php';
    }

    /**
     * Route to role-specific dashboard
     */
    public function index() {
        $role = Auth::role();

        switch ($role) {
            case 'admin':
                $this->adminDashboard();
                break;
            case 'hod':
                $this->hodDashboard();
                break;
            case 'supervisor':
                $this->supervisorDashboard();
                break;
            case 'student':
                $this->studentDashboard();
                break;
            default:
                $this->redirect('/login');
        }
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard() {
        $userModel = new \User();
        $departmentModel = new \Department();

        $stats = $userModel->getStats();
        $recentUsers = $userModel->getRecent(8);
        $departmentCount = $departmentModel->count();

        // Count repos
        $repoStmt = $this->db->query("SELECT COUNT(*) as total FROM repositories WHERE is_archived = 0");
        $repoCount = $repoStmt->fetch()['total'] ?? 0;

        $this->view('dashboard/admin', [
            'pageTitle' => 'Admin Dashboard',
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'departmentCount' => $departmentCount,
            'repoCount' => $repoCount,
        ], 'app');
    }

    /**
     * HOD Dashboard
     */
    private function hodDashboard() {
        $user = Auth::user();
        $deptId = $user['department_id'];

        // Students in department
        $studentStmt = $this->db->prepare("SELECT COUNT(*) as total FROM users WHERE role = 'student' AND department_id = :dept");
        $studentStmt->execute(['dept' => $deptId]);
        $studentCount = $studentStmt->fetch()['total'] ?? 0;

        // Groups in department
        $groupStmt = $this->db->prepare("SELECT COUNT(*) as total FROM `groups` WHERE department_id = :dept AND status = 'active'");
        $groupStmt->execute(['dept' => $deptId]);
        $groupCount = $groupStmt->fetch()['total'] ?? 0;

        // Pending requests
        $reqStmt = $this->db->prepare(
            "SELECT rr.* FROM repo_requests rr 
             JOIN `groups` g ON rr.group_id = g.id 
             WHERE g.department_id = :dept AND rr.status = 'pending'
             ORDER BY rr.created_at DESC"
        );
        $reqStmt->execute(['dept' => $deptId]);
        $recentRequests = $reqStmt->fetchAll();
        $pendingRequests = count($recentRequests);

        // Archived count
        $archStmt = $this->db->prepare("SELECT COUNT(*) as total FROM archived_projects WHERE department_id = :dept");
        $archStmt->execute(['dept' => $deptId]);
        $archivedCount = $archStmt->fetch()['total'] ?? 0;

        $this->view('dashboard/hod', [
            'pageTitle' => 'HOD Dashboard',
            'studentCount' => $studentCount,
            'groupCount' => $groupCount,
            'pendingRequests' => $pendingRequests,
            'recentRequests' => array_slice($recentRequests, 0, 5),
            'archivedCount' => $archivedCount,
        ], 'app');
    }

    /**
     * Supervisor Dashboard
     */
    private function supervisorDashboard() {
        $userId = Auth::id();

        // Assigned groups
        $groupStmt = $this->db->prepare(
            "SELECT r.*, g.name, g.status,
                    (SELECT COUNT(*) FROM group_members gm WHERE gm.group_id = g.id) as member_count
             FROM repositories r
             JOIN `groups` g ON r.group_id = g.id
             WHERE r.supervisor_id = :uid AND r.is_archived = 0
             ORDER BY r.created_at DESC"
        );
        $groupStmt->execute(['uid' => $userId]);
        $groups = $groupStmt->fetchAll();
        $assignedGroups = count($groups);

        // Pending reviews
        $reviewStmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM project_submissions 
             WHERE reviewed_by IS NULL AND submission_type = 'to_supervisor'
             AND repo_id IN (SELECT id FROM repositories WHERE supervisor_id = :uid)"
        );
        $reviewStmt->execute(['uid' => $userId]);
        $pendingReviews = $reviewStmt->fetch()['total'] ?? 0;

        // Upcoming meetings
        $meetStmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM meetings m
             WHERE m.scheduled_by = :uid AND m.meeting_date >= CURDATE() AND m.status = 'scheduled'"
        );
        $meetStmt->execute(['uid' => $userId]);
        $upcomingMeetings = $meetStmt->fetch()['total'] ?? 0;

        // Completed projects
        $compStmt = $this->db->prepare(
            "SELECT COUNT(*) as total FROM repositories WHERE supervisor_id = :uid AND status = 'completed'"
        );
        $compStmt->execute(['uid' => $userId]);
        $completedProjects = $compStmt->fetch()['total'] ?? 0;

        $this->view('dashboard/supervisor', [
            'pageTitle' => 'Supervisor Dashboard',
            'groups' => $groups,
            'assignedGroups' => $assignedGroups,
            'pendingReviews' => $pendingReviews,
            'upcomingMeetings' => $upcomingMeetings,
            'completedProjects' => $completedProjects,
        ], 'app');
    }

    /**
     * Student Dashboard
     */
    private function studentDashboard() {
        $userId = Auth::id();
        $user = Auth::user();

        // Get student's group
        $groupStmt = $this->db->prepare(
            "SELECT g.* FROM `groups` g
             JOIN group_members gm ON g.id = gm.group_id
             WHERE gm.user_id = :uid LIMIT 1"
        );
        $groupStmt->execute(['uid' => $userId]);
        $group = $groupStmt->fetch();

        $repo = null;
        $supervisor = null;
        $groupMembers = 0;
        $hasRepo = false;
        $notices = [];
        $unreadMessages = 0;
        $upcomingMeetings = 0;

        if ($group) {
            // Group member count
            $memberStmt = $this->db->prepare("SELECT COUNT(*) as total FROM group_members WHERE group_id = :gid");
            $memberStmt->execute(['gid' => $group['id']]);
            $groupMembers = $memberStmt->fetch()['total'] ?? 0;

            // Get repository
            $repoStmt = $this->db->prepare("SELECT * FROM repositories WHERE group_id = :gid LIMIT 1");
            $repoStmt->execute(['gid' => $group['id']]);
            $repo = $repoStmt->fetch();

            if ($repo) {
                $hasRepo = true;

                // Get supervisor
                if ($repo['supervisor_id']) {
                    $supStmt = $this->db->prepare("SELECT first_name, last_name, email FROM users WHERE id = :uid");
                    $supStmt->execute(['uid' => $repo['supervisor_id']]);
                    $supervisor = $supStmt->fetch();
                }

                // Active notices
                $noticeStmt = $this->db->prepare(
                    "SELECT * FROM notices WHERE repo_id = :rid AND expires_at > NOW() ORDER BY created_at DESC LIMIT 3"
                );
                $noticeStmt->execute(['rid' => $repo['id']]);
                $notices = $noticeStmt->fetchAll();

                // Upcoming meetings
                $meetStmt = $this->db->prepare(
                    "SELECT COUNT(*) as total FROM meetings WHERE repo_id = :rid AND meeting_date >= CURDATE() AND status = 'scheduled'"
                );
                $meetStmt->execute(['rid' => $repo['id']]);
                $upcomingMeetings = $meetStmt->fetch()['total'] ?? 0;
            }

            // Unread messages
            $msgStmt = $this->db->prepare(
                "SELECT COUNT(*) as total FROM messages WHERE group_id = :gid AND sender_id != :uid AND is_read = 0"
            );
            $msgStmt->execute(['gid' => $group['id'], 'uid' => $userId]);
            $unreadMessages = $msgStmt->fetch()['total'] ?? 0;
        }

        $this->view('dashboard/student', [
            'pageTitle' => 'Student Dashboard',
            'group' => $group,
            'repo' => $repo,
            'supervisor' => $supervisor,
            'groupMembers' => $groupMembers,
            'hasRepo' => $hasRepo,
            'notices' => $notices,
            'unreadMessages' => $unreadMessages,
            'upcomingMeetings' => $upcomingMeetings,
        ], 'app');
    }
}
