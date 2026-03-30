<?php
/**
 * ProjectSubmission Model
 */
class ProjectSubmission extends \App\Core\Model {
    protected $table = 'project_submissions';

    /**
     * Get pending submissions for supervisor
     */
    public function getPendingBySupervisor($supervisorId) {
        $stmt = $this->db->prepare(
            "SELECT ps.*, r.title as repo_title, g.name as group_name
             FROM project_submissions ps
             JOIN repositories r ON ps.repo_id = r.id
             JOIN `groups` g ON r.group_id = g.id
             WHERE r.supervisor_id = :sid AND ps.status = 'pending' AND ps.submission_type = 'to_supervisor'"
        );
        $stmt->execute(['sid' => $supervisorId]);
        return $stmt->fetchAll();
    }
}
