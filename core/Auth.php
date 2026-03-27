<?php
namespace App\Core;

/**
 * Auth Helper
 * Handles password hashing, verification, and token generation
 */
class Auth {

    /**
     * Hash a password using bcrypt
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verify a password against a hash
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Generate a random token (for email verification, password reset)
     */
    public static function generateToken($length = 64) {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Check if the current user is authenticated
     */
    public static function check() {
        return Session::isLoggedIn();
    }

    /**
     * Get the current authenticated user
     */
    public static function user() {
        return Session::user();
    }

    /**
     * Get user ID
     */
    public static function id() {
        $user = self::user();
        return $user ? $user['id'] : null;
    }

    /**
     * Get user role
     */
    public static function role() {
        $user = self::user();
        return $user ? $user['role'] : null;
    }

    /**
     * Check if user has a specific role
     */
    public static function hasRole($role) {
        return self::role() === $role;
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return self::hasRole('admin');
    }

    /**
     * Check if user is HOD
     */
    public static function isHod() {
        return self::hasRole('hod');
    }

    /**
     * Check if user is supervisor
     */
    public static function isSupervisor() {
        return self::hasRole('supervisor');
    }

    /**
     * Check if user is student
     */
    public static function isStudent() {
        return self::hasRole('student');
    }

    /**
     * Validate email format for RMU students
     */
    public static function isValidStudentEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $domain = substr(strrchr($email, "@"), 1);
        return strtolower($domain) === strtolower(STUDENT_EMAIL_DOMAIN);
    }

    /**
     * Check password strength
     * Returns: 0 = weak, 1 = fair, 2 = strong, 3 = very strong
     */
    public static function passwordStrength($password) {
        $strength = 0;
        
        if (strlen($password) >= MIN_PASSWORD_LENGTH) $strength++;
        if (preg_match('/[A-Z]/', $password)) $strength++;
        if (preg_match('/[0-9]/', $password)) $strength++;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $strength++;
        
        // Bonus for length
        if (strlen($password) >= 12) $strength++;
        
        // Cap at 4
        return min($strength, 4);
    }

    /**
     * Validate password meets minimum requirements
     */
    public static function isValidPassword($password) {
        return strlen($password) >= MIN_PASSWORD_LENGTH;
    }
}
