<?php
/**
 * Program Model
 */
class Program extends \App\Core\Model {
    protected $table = 'programs';

    /**
     * Get programs by department
     */
    public function getByDepartment($departmentId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM programs WHERE department_id = :dept_id ORDER BY name"
        );
        $stmt->execute(['dept_id' => $departmentId]);
        return $stmt->fetchAll();
    }

    /**
     * Get program with department name
     */
    public function getWithDepartment($id) {
        $stmt = $this->db->prepare(
            "SELECT p.*, d.name as department_name 
             FROM programs p 
             JOIN departments d ON p.department_id = d.id 
             WHERE p.id = :id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
