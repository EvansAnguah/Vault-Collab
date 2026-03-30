<?php
/**
 * Message Model (Chat)
 */
class Message extends \App\Core\Model {
    protected $table = 'messages';

    /**
     * Get recent messages for a group
     */
    public function getRecent($groupId, $limit = 50) {
        $stmt = $this->db->prepare(
            "SELECT m.*, u.first_name, u.last_name, u.profile_photo 
             FROM messages m
             JOIN users u ON m.sender_id = u.id
             WHERE m.group_id = :gid
             ORDER BY m.created_at ASC LIMIT :limit"
        );
        $stmt->bindValue(':gid', $groupId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
