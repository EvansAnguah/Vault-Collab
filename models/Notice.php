<?php
/**
 * Notice Model
 */
class Notice extends \App\Core\Model {
    protected $table = 'notices';

    /**
     * Get active notices for a repository
     */
    public function getActiveByRepo($repoId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM notices WHERE repo_id = :rid AND expires_at > NOW() ORDER BY created_at DESC"
        );
        $stmt->execute(['rid' => $repoId]);
        return $stmt->fetchAll();
    }
}
