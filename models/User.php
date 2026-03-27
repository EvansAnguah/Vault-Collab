<?php
/**
 * User Model
 */
class User extends \App\Core\Model {
    protected $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail($email) {
        return $this->findOneBy('email', $email);
    }

    /**
     * Find user by index number
     */
    public function findByIndexNumber($indexNumber) {
        return $this->findOneBy('index_number', $indexNumber);
    }

    /**
     * Find user by verification token
     */
    public function findByVerificationToken($token) {
        return $this->findOneBy('verification_token', $token);
    }

    /**
     * Find user by reset token (check expiry)
     */
    public function findByResetToken($token) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE reset_token = :token AND reset_token_expires > NOW() LIMIT 1"
        );
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }

    /**
     * Get users by role
     */
    public function findByRole($role) {
        return $this->findBy('role', $role);
    }

    /**
     * Get users by department
     */
    public function findByDepartment($departmentId) {
        return $this->findBy('department_id', $departmentId);
    }

    /**
     * Get students by department
     */
    public function getStudentsByDepartment($departmentId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE role = 'student' AND department_id = :dept_id ORDER BY first_name"
        );
        $stmt->execute(['dept_id' => $departmentId]);
        return $stmt->fetchAll();
    }

    /**
     * Get supervisors by department
     */
    public function getSupervisorsByDepartment($departmentId) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE role = 'supervisor' AND department_id = :dept_id ORDER BY first_name"
        );
        $stmt->execute(['dept_id' => $departmentId]);
        return $stmt->fetchAll();
    }

    /**
     * Search students by name or index number
     */
    public function searchStudents($query, $departmentId = null) {
        $sql = "SELECT id, first_name, last_name, email, index_number, department_id 
                FROM users WHERE role = 'student' AND is_active = 1 
                AND (first_name LIKE :q OR last_name LIKE :q2 OR index_number LIKE :q3 OR email LIKE :q4)";
        $params = [
            'q' => "%{$query}%", 'q2' => "%{$query}%", 
            'q3' => "%{$query}%", 'q4' => "%{$query}%"
        ];
        
        if ($departmentId) {
            $sql .= " AND department_id = :dept_id";
            $params['dept_id'] = $departmentId;
        }
        
        $sql .= " LIMIT 20";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Count users by role
     */
    public function countByRole($role) {
        return $this->count("role = :role", ['role' => $role]);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStats() {
        $stmt = $this->db->query(
            "SELECT role, COUNT(*) as total FROM users GROUP BY role"
        );
        $results = $stmt->fetchAll();
        $stats = ['admin' => 0, 'hod' => 0, 'supervisor' => 0, 'student' => 0, 'total' => 0];
        foreach ($results as $row) {
            $stats[$row['role']] = $row['total'];
            $stats['total'] += $row['total'];
        }
        return $stats;
    }

    /**
     * Create a student from CSV upload
     */
    public function createUploadedStudent($data) {
        $data['is_uploaded'] = 1;
        $data['is_verified'] = 0;
        $data['role'] = 'student';
        return $this->create($data);
    }

    /**
     * Check if student exists (for uploaded student verification)
     */
    public function verifyUploadedStudent($email, $indexNumber) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = :email AND index_number = :index_no AND is_uploaded = 1 AND password_hash IS NULL LIMIT 1"
        );
        $stmt->execute(['email' => $email, 'index_no' => $indexNumber]);
        return $stmt->fetch();
    }

    /**
     * Get recent users
     */
    public function getRecent($limit = 10) {
        $stmt = $this->db->prepare(
            "SELECT * FROM users ORDER BY created_at DESC LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
