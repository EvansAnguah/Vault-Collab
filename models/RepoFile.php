<?php
/**
 * RepoFile Model
 */
class RepoFile extends \App\Core\Model {
    protected $table = 'repo_files';

    /**
     * Get file tree for repository
     */
    public function getTree($repoId) {
        $stmt = $this->db->prepare(
            "SELECT id, name, type, parent_id FROM repo_files WHERE repo_id = :rid ORDER BY type ASC, name ASC"
        );
        $stmt->execute(['rid' => $repoId]);
        return $stmt->fetchAll();
    }

    /**
     * Get file by ID with creator details
     */
    public function getWithDetails($id) {
        $stmt = $this->db->prepare(
            "SELECT rf.*, u.first_name, u.last_name 
             FROM repo_files rf
             JOIN users u ON rf.created_by = u.id
             WHERE rf.id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
