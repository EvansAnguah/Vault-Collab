<?php

/**
 * Check if current route matches path
 */
function active_route($path) {
    $uri = $_SERVER['REQUEST_URI'];
    $basePath = parse_url(APP_URL, PHP_URL_PATH) ?: '';
    $currentPath = str_replace($basePath, '', $uri);
    $currentPath = strtok($currentPath, '?');
    
    return $currentPath === $path;
}

/**
 * Get full asset URL
 */
function asset($path) {
    return APP_URL . '/public/' . ltrim($path, '/');
}

/**
 * Escape HTML for output
 */
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a consistent color for a name
 */
function avatar_color($name) {
    if (empty($name)) return '#888';
    $hash = md5($name);
    return '#' . substr($hash, 0, 6);
}

/**
 * Get initials from a name
 */
function get_initials($name) {
    if (empty($name)) return 'U';
    $parts = explode(' ', $name);
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper(substr($part, 0, 1));
    }
    return substr($initials, 0, 2);
}
