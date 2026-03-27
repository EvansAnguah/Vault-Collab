<?php
/**
 * Department Model
 */
class Department extends \App\Core\Model {
    protected $table = 'departments';

    /**
     * Get all departments with HOD info
     */
    public function getAllWithHod() {
        $stmt = $this->db->query(
            "SELECT d.*, u.first_name as hod_first_name, u.last_name as hod_last_name, u.email as hod_email
             FROM departments d
             LEFT JOIN users u ON d.hod_id = u.id
             ORDER BY d.name"
        );
        return $stmt->fetchAll();
    }

    /**
     * Get department by code
     */
    public function findByCode($code) {
        return $this->findOneBy('code', $code);
    }

    /**
     * Get department with student/group counts
     */
    public function getWithStats() {
        $stmt = $this->db->query(
            "SELECT d.*, 
                    (SELECT COUNT(*) FROM users u WHERE u.department_id = d.id AND u.role = 'student') as student_count,
                    (SELECT COUNT(*) FROM users u WHERE u.department_id = d.id AND u.role = 'supervisor') as supervisor_count,
                    (SELECT COUNT(*) FROM `groups` g WHERE g.department_id = d.id) as group_count
             FROM departments d
             ORDER BY d.name"
        );
        return $stmt->fetchAll();
    }
}
