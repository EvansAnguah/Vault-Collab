<?php
namespace App\Core;

/**
 * Session Manager
 * Handles session operations, flash messages, and CSRF tokens
 */
class Session {

    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Generate CSRF token if not exists
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
    }

    /**
     * Set a session value
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session value
     */
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if a session key exists
     */
    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a session value
     */
    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the entire session
     */
    public static function destroy() {
        session_unset();
        session_destroy();
    }

    /**
     * Set a flash message (available only for next request)
     */
    public static function setFlash($type, $message) {
        $_SESSION['flash_messages'][$type] = $message;
    }

    /**
     * Get and clear flash messages
     */
    public static function getFlash($type = null) {
        if ($type) {
            $message = $_SESSION['flash_messages'][$type] ?? null;
            unset($_SESSION['flash_messages'][$type]);
            return $message;
        }

        $messages = $_SESSION['flash_messages'] ?? [];
        unset($_SESSION['flash_messages']);
        return $messages;
    }

    /**
     * Check if a flash message exists
     */
    public static function hasFlash($type) {
        return isset($_SESSION['flash_messages'][$type]);
    }

    /**
     * Get the CSRF token
     */
    public static function getCsrfToken() {
        return $_SESSION[CSRF_TOKEN_NAME] ?? '';
    }

    /**
     * Generate CSRF hidden input field
     */
    public static function csrfField() {
        return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . self::getCsrfToken() . '">';
    }

    /**
     * Validate CSRF token
     */
    public static function validateCsrfToken($token) {
        return hash_equals(self::getCsrfToken(), $token);
    }

    /**
     * Regenerate CSRF token
     */
    public static function regenerateCsrfToken() {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    /**
     * Get the logged-in user data
     */
    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Set user session data on login
     */
    public static function login($userData) {
        session_regenerate_id(true);
        $_SESSION['user'] = $userData;
    }

    /**
     * Clear user session on logout
     */
    public static function logout() {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }
}
