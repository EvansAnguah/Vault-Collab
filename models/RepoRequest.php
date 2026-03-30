<?php
/**
 * RepoRequest Model
 */
class RepoRequest extends \App\Core\Model {
    protected $table = 'repo_requests';

    /**
     * Get pending requests for HOD
     */
    public function getPendingByDepartment($deptId) {
        $stmt = $this->db->prepare(
            "SELECT rr.*, g.name as group_name, u.first_name as leader_first, u.last_name as leader_last
             FROM `repo_requests` rr
             JOIN `groups` g ON rr.group_id = g.id
             JOIN `group_members` gm ON g.id = gm.group_id AND gm.role = 'leader'
             JOIN `users` u ON gm.user_id = u.id
             WHERE g.department_id = :dept AND rr.status = 'pending'"
        );
        $stmt->execute(['dept' => $deptId]);
        return $stmt->fetchAll();
    }
}
