<?php
namespace App\Core;

/**
 * Base Controller
 * All controllers extend this class
 */
class Controller {
    protected $db;

    public function __construct() {
        $this->db = \Database::getInstance()->getConnection();
    }

    /**
     * Render a view with data
     */
    protected function view($viewPath, $data = [], $layout = null) {
        // Automatically inject authenticated user data into all views
        if (!isset($data['user'])) {
            $data['user'] = Auth::user();
        }

        // Extract data to make variables available in the view
        extract($data);

        // Store the view content path
        $viewFile = BASE_PATH . '/views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($viewFile)) {
            die("View not found: {$viewPath}");
        }

        if ($layout) {
            // Render with layout
            $layoutFile = BASE_PATH . '/views/layouts/' . $layout . '.php';
            if (!file_exists($layoutFile)) {
                die("Layout not found: {$layout}");
            }

            // Start output buffering for the view content
            ob_start();
            include $viewFile;
            $content = ob_get_clean();

            // Include the layout which will use $content
            include $layoutFile;
        } else {
            include $viewFile;
        }
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect($url) {
        header("Location: " . APP_URL . $url);
        exit;
    }

    /**
     * Get POST data
     */
    protected function postData($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    /**
     * Get GET data
     */
    protected function getData($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrf() {
        $token = $this->postData(CSRF_TOKEN_NAME);
        if (!$token || !Session::validateCsrfToken($token)) {
            Session::setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }
    }

    /**
     * Set flash message and redirect
     */
    protected function redirectWithMessage($url, $type, $message) {
        Session::setFlash($type, $message);
        $this->redirect($url);
    }

    /**
     * Get the authenticated user
     */
    protected function user() {
        return Session::get('user');
    }

    /**
     * Check if user has a specific role
     */
    protected function hasRole($role) {
        $user = $this->user();
        return $user && $user['role'] === $role;
    }

    /**
     * Load a model
     */
    protected function model($modelName) {
        $modelFile = BASE_PATH . '/models/' . $modelName . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $modelName();
        }
        die("Model not found: {$modelName}");
    }
}
