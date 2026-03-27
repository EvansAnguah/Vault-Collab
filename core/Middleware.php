<?php
namespace App\Core;

/**
 * Middleware
 * Role-based access control for routes
 */
class Middleware {

    /**
     * Run a middleware check
     * Returns true if allowed, false if blocked
     */
    public static function run($middleware) {
        switch ($middleware) {
            case 'auth':
                return self::authCheck();
            case 'admin':
                return self::roleCheck('admin');
            case 'hod':
                return self::roleCheck('hod');
            case 'supervisor':
                return self::roleCheck('supervisor');
            case 'student':
                return self::roleCheck('student');
            case 'guest':
                return self::guestCheck();
            default:
                return true;
        }
    }

    /**
     * Check if user is authenticated
     */
    private static function authCheck() {
        if (!Auth::check()) {
            Session::setFlash('error', 'Please log in to access this page.');
            header('Location: ' . APP_URL . '/login');
            exit;
        }
        return true;
    }

    /**
     * Check if user has a specific role
     */
    private static function roleCheck($role) {
        // First check auth
        if (!self::authCheck()) {
            return false;
        }

        if (!Auth::hasRole($role)) {
            Session::setFlash('error', 'You do not have permission to access this page.');
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
        return true;
    }

    /**
     * Check if user is NOT logged in (for login/register pages)
     */
    private static function guestCheck() {
        if (Auth::check()) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
        return true;
    }
}
