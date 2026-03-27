<?php
namespace App\Core;

/**
 * Router - URL routing engine
 * Matches incoming requests to controller methods with middleware support
 */
class Router {
    private static $instance = null;
    private $routes = [];
    private $params = [];

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register a route
     */
    public function add($method, $path, $action, $middleware = []) {
        // Convert route params like {id} to regex patterns
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[] = [
            'method'     => strtoupper($method),
            'pattern'    => $pattern,
            'path'       => $path,
            'action'     => $action,
            'middleware'  => $middleware
        ];
    }

    /**
     * Dispatch the current request to the appropriate controller
     */
    public function dispatch() {
        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $url, $matches)) {
                // Extract named parameters
                $this->params = array_filter($matches, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                // Run middleware
                foreach ($route['middleware'] as $mw) {
                    if (!Middleware::run($mw)) {
                        return;
                    }
                }

                // Parse controller@method
                list($controllerName, $methodName) = explode('@', $route['action']);
                $controllerClass = "\\App\\Controllers\\{$controllerName}";
                
                // Load the controller file
                $controllerFile = BASE_PATH . '/controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    $this->error(404, "Controller not found: {$controllerName}");
                    return;
                }

                require_once $controllerFile;

                if (!class_exists($controllerClass)) {
                    // Try without namespace
                    $controllerClass = $controllerName;
                    if (!class_exists($controllerClass)) {
                        $this->error(404, "Controller class not found: {$controllerName}");
                        return;
                    }
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $methodName)) {
                    $this->error(404, "Method not found: {$methodName}");
                    return;
                }

                // Call the method with parameters
                call_user_func_array([$controller, $methodName], $this->params);
                return;
            }
        }

        // No route matched
        $this->error(404);
    }

    /**
     * Get the cleaned URL path
     */
    private function getUrl() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        // Ensure it starts with /
        if (empty($url)) {
            return '/';
        }
        
        return '/' . $url;
    }

    /**
     * Show error page
     */
    private function error($code, $message = '') {
        http_response_code($code);
        
        if ($code === 404) {
            // Check if a 404 view exists
            $errorView = BASE_PATH . '/views/errors/404.php';
            if (file_exists($errorView)) {
                include $errorView;
            } else {
                echo '<div style="text-align:center;padding:50px;font-family:Inter,sans-serif;">';
                echo '<h1 style="font-size:72px;color:#0ea5e9;">404</h1>';
                echo '<p style="font-size:20px;color:#64748b;">Page not found</p>';
                echo '<a href="/" style="color:#0ea5e9;text-decoration:none;">← Back to Home</a>';
                echo '</div>';
            }
        }
    }

    /**
     * Get route parameters
     */
    public function getParams() {
        return $this->params;
    }
}
