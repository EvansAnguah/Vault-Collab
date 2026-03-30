<?php
/**
 * LogbookEntry Model
 */
class LogbookEntry extends \App\Core\Model {
    protected $table = 'logbook_entries';

    /**
     * Get logbook for repository with remarks
     */
    public function getWithRemarks($repoId) {
        $stmt = $this->db->prepare(
            "SELECT le.*, u.first_name, u.last_name, sr.remark, sr.created_at as remark_at, u2.first_name as sup_first, u2.last_name as sup_last
             FROM logbook_entries le
             JOIN users u ON le.student_id = u.id
             LEFT JOIN supervisor_remarks sr ON le.id = sr.logbook_entry_id
             LEFT JOIN users u2 ON sr.supervisor_id = u2.id
             WHERE le.repo_id = :rid
             ORDER BY le.serial_no ASC"
        );
        $stmt->execute(['rid' => $repoId]);
        return $stmt->fetchAll();
    }
}
