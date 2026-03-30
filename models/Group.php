<?php
/**
 * Group Model
 */
class Group extends \App\Core\Model {
    protected $table = 'groups';

    /**
     * Get user's active group
     */
    public function getByUser($userId) {
        $stmt = $this->db->prepare(
            "SELECT g.* 
             FROM `groups` g
             JOIN group_members gm ON g.id = gm.group_id
             WHERE gm.user_id = :uid AND g.status != 'completed' LIMIT 1"
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetch();
    }

    /**
     * Get group members
     */
    public function getMembers($groupId) {
        $stmt = $this->db->prepare(
            "SELECT gm.*, u.first_name, u.last_name, u.email, u.index_number, u.profile_photo
             FROM group_members gm
             JOIN users u ON gm.user_id = u.id
             WHERE gm.group_id = :gid"
        );
        $stmt->execute(['gid' => $groupId]);
        return $stmt->fetchAll();
    }
}
