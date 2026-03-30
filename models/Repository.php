<?php
/**
 * Repository Model
 */
class Repository extends \App\Core\Model {
    protected $table = 'repositories';

    /**
     * Get repositories by supervisor
     */
    public function getBySupervisor($supervisorId) {
        $stmt = $this->db->prepare(
            "SELECT r.*, g.name as group_name 
             FROM repositories r 
             JOIN `groups` g ON r.group_id = g.id 
             WHERE r.supervisor_id = :sid AND r.is_archived = 0"
        );
        $stmt->execute(['sid' => $supervisorId]);
        return $stmt->fetchAll();
    }

    /**
     * Get repository with group and supervisor details
     */
    public function getWithDetails($id) {
        $stmt = $this->db->prepare(
            "SELECT r.*, g.name as group_name, u.first_name as supervisor_first, u.last_name as supervisor_last
             FROM repositories r
             JOIN `groups` g ON r.group_id = g.id
             LEFT JOIN users u ON r.supervisor_id = u.id
             WHERE r.id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
