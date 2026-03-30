<?php
/**
 * Meeting Model
 */
class Meeting extends \App\Core\Model {
    protected $table = 'meetings';

    /**
     * Get upcoming meetings for a repo
     */
    public function getUpcoming($repoId) {
        $stmt = $this->db->prepare(
            "SELECT m.*, u.first_name as scheduler_first, u.last_name as scheduler_last
             FROM meetings m
             JOIN users u ON m.scheduled_by = u.id
             WHERE m.repo_id = :rid AND m.meeting_date >= CURDATE() AND m.status = 'scheduled'
             ORDER BY m.meeting_date ASC, m.meeting_time ASC"
        );
        $stmt->execute(['rid' => $repoId]);
        return $stmt->fetchAll();
    }
}
