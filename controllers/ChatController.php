<?php

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;

class ChatController extends Controller {

    public function __construct() {
        parent::__construct();
        require_once BASE_PATH . '/models/Group.php';
        require_once BASE_PATH . '/models/Message.php';
        require_once BASE_PATH . '/models/User.php';
    }

    /**
     * Group Chat Main View
     */
    public function index($groupId) {
        $userId = Auth::id();
        $groupModel = new \Group();
        $group = $groupModel->find($groupId);

        if (!$group) {
            $this->redirectWithMessage('/dashboard', 'error', 'Group not found.');
            return;
        }

        // Access check: Is user in the group or assigned supervisor?
        $members = $groupModel->getMembers($groupId);
        $isInGroup = false;
        foreach ($members as $m) if ($m['id'] == $userId) $isInGroup = true;

        // Check if supervisor
        $stmt = $this->db->prepare("SELECT id FROM repositories WHERE group_id = :gid AND supervisor_id = :sid LIMIT 1");
        $stmt->execute(['gid' => $groupId, 'sid' => $userId]);
        $isSupervisor = $stmt->fetch();

        if (!$isInGroup && !$isSupervisor && Auth::role() != 'admin' && Auth::role() != 'hod') {
            $this->redirectWithMessage('/dashboard', 'error', 'Unauthorized chat access.');
            return;
        }

        $messageModel = new \Message();
        $messages = $messageModel->getRecent($groupId);

        $this->view('chat/index', [
            'pageTitle' => 'Group Chat: ' . $group['name'],
            'group' => $group,
            'messages' => $messages,
            'members' => $members
        ], 'app');
    }

    /**
     * Send Message (AJAX)
     */
    public function sendMessage() {
        $this->validateCsrf();
        $groupId = $this->postData('group_id');
        $text = $this->postData('message');
        $userId = Auth::id();

        if (empty($text)) {
            $this->json(['success' => false, 'message' => 'Empty message.']);
            return;
        }

        $messageModel = new \Message();
        $msgId = $messageModel->create([
            'group_id' => $groupId,
            'sender_id' => $userId,
            'message' => $text,
            'type' => 'text'
        ]);

        if ($msgId) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false, 'message' => 'Send failed.']);
        }
    }

    /**
     * Get New Messages (AJAX Polling)
     */
    public function getMessages() {
        $groupId = $this->getData('group_id');
        $lastId = $this->getData('last_id', 0);
        
        $stmt = $this->db->prepare(
            "SELECT m.*, u.first_name, u.last_name, u.profile_photo 
             FROM messages m
             JOIN users u ON m.sender_id = u.id
             WHERE m.group_id = :gid AND m.id > :lid
             ORDER BY m.created_at ASC"
        );
        $stmt->execute(['gid' => $groupId, 'lid' => $lastId]);
        $newMessages = $stmt->fetchAll();

        $this->json([
            'success' => true,
            'messages' => $newMessages
        ]);
    }

    /**
     * Video Call Page
     */
    public function videoCall($groupId) {
        $groupModel = new \Group();
        $group = $groupModel->find($groupId);

        if (!$group) {
            $this->redirectWithMessage('/dashboard', 'error', 'Invalid group.');
            return;
        }

        $this->view('chat/video_call', [
            'pageTitle' => 'Video Discussion: ' . $group['name'],
            'group' => $group,
            'roomId' => 'RMU-VAULT-' . $groupId
        ], 'app');
    }
}
