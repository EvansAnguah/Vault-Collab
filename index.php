<?php
/**
 * Project Vault & Collaboration Hub
 * Regional Maritime University
 * 
 * Main Entry Point / Front Controller
 */

session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path
define('BASE_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

// Autoload composer dependencies (PHPMailer, etc.)
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

// Load configuration
require_once BASE_PATH . '/config/app.php';
require_once BASE_PATH . '/config/database.php';

// Load core classes
require_once BASE_PATH . '/core/helpers.php';
require_once BASE_PATH . '/core/Session.php';
require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Model.php';
require_once BASE_PATH . '/core/Auth.php';
require_once BASE_PATH . '/core/Middleware.php';
require_once BASE_PATH . '/core/Mailer.php';

// Initialize session handler
App\Core\Session::init();

// Load routes and dispatch
require_once BASE_PATH . '/config/routes.php';

$router = new App\Core\Router();
$router->dispatch();
