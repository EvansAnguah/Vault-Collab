<?php
/**
 * GroupMember Model
 */
class GroupMember extends \App\Core\Model {
    protected $table = 'group_members';

    /**
     * Check if user is in any group
     */
    public function isUserInGroup($userId) {
        $stmt = $this->db->prepare(
            "SELECT id FROM `group_members` WHERE user_id = :uid LIMIT 1"
        );
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetch();
    }
}
