<?php

use App\Core\Controller;
use App\Core\Auth;

class NotificationController extends Controller {

    /**
     * Get user notifications (AJAX)
     */
    public function getNotifications() {
        $userId = Auth::id();
        $stmt = $this->db->prepare(
            "SELECT * FROM notifications WHERE user_id = :uid ORDER BY created_at DESC LIMIT 20"
        );
        $stmt->execute(['uid' => $userId]);
        $notifications = $stmt->fetchAll();

        // Get count of unread
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM notifications WHERE user_id = :uid AND is_read = 0");
        $stmt->execute(['uid' => $userId]);
        $unreadCount = $stmt->fetch()['total'];

        $this->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markRead() {
        $this->validateCsrf();
        $id = $this->postData('id');
        $userId = Auth::id();

        if ($id === 'all') {
            $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :uid");
            $stmt->execute(['uid' => $userId]);
        } else {
            $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id AND user_id = :uid");
            $stmt->execute(['id' => $id, 'uid' => $userId]);
        }

        $this->json(['success' => true]);
    }
}
