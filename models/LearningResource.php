<?php

use App\Core\Model;

class LearningResource extends Model {
    protected $table = 'learning_resources';

    /**
     * Get resources for a specific department (including general 'NULL' dept ones)
     */
    public function getResourcesForDepartment($departmentId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE department_id = ? OR department_id IS NULL ORDER BY created_at DESC");
        $stmt->execute([$departmentId]);
        return $stmt->fetchAll();
    }
}
