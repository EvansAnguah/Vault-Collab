<?php
namespace App\Core;

/**
 * Helper Functions
 */

/**
 * Generate the full URL for an asset
 */
function asset($path) {
    return APP_URL . '/public/' . ltrim($path, '/');
}

/**
 * Generate a URL
 */
function url($path = '') {
    return APP_URL . '/' . ltrim($path, '/');
}

/**
 * Escape HTML output to prevent XSS
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Get the CSRF hidden field
 */
function csrf_field() {
    return Session::csrfField();
}

/**
 * Get the CSRF token value
 */
function csrf_token() {
    return Session::getCsrfToken();
}

/**
 * Check if user is logged in
 */
function auth() {
    return Auth::check();
}

/**
 * Get the current user
 */
function current_user() {
    return Auth::user();
}

/**
 * Get flash message
 */
function flash($type) {
    return Session::getFlash($type);
}

/**
 * Format a date for display
 */
function format_date($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Format a datetime for display
 */
function format_datetime($datetime, $format = 'M d, Y h:i A') {
    return date($format, strtotime($datetime));
}

/**
 * Time ago format
 */
function time_ago($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Just now';
    if ($time < 3600) return floor($time / 60) . 'm ago';
    if ($time < 86400) return floor($time / 3600) . 'h ago';
    if ($time < 604800) return floor($time / 86400) . 'd ago';
    if ($time < 2592000) return floor($time / 604800) . 'w ago';
    
    return format_date($datetime);
}

/**
 * Truncate a string
 */
function str_truncate($string, $length = 100, $append = '...') {
    if (strlen($string) <= $length) return $string;
    return substr($string, 0, $length) . $append;
}

/**
 * Generate a random color for avatars
 */
function avatar_color($name) {
    $colors = [
        '#0ea5e9', '#14b8a6', '#8b5cf6', '#f43f5e', 
        '#f59e0b', '#10b981', '#6366f1', '#ec4899',
        '#3b82f6', '#06b6d4', '#84cc16', '#ef4444'
    ];
    $index = crc32($name) % count($colors);
    return $colors[abs($index)];
}

/**
 * Get initials from a name
 */
function get_initials($firstName, $lastName = '') {
    $initials = strtoupper(substr($firstName, 0, 1));
    if ($lastName) {
        $initials .= strtoupper(substr($lastName, 0, 1));
    }
    return $initials;
}

/**
 * Format file size
 */
function format_file_size($bytes) {
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
    if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
    if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
    return $bytes . ' B';
}

/**
 * Get file extension
 */
function get_file_extension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Detect programming language from file extension
 */
function detect_language($filename) {
    $ext = get_file_extension($filename);
    $map = [
        'html' => 'html', 'htm' => 'html',
        'css' => 'css', 'scss' => 'css', 'less' => 'css',
        'js' => 'javascript', 'jsx' => 'javascript', 'mjs' => 'javascript',
        'ts' => 'typescript', 'tsx' => 'typescript',
        'php' => 'php', 'phtml' => 'php',
        'py' => 'python', 'pyw' => 'python',
        'java' => 'java',
        'c' => 'c', 'h' => 'c',
        'cpp' => 'cpp', 'cc' => 'cpp', 'cxx' => 'cpp', 'hpp' => 'cpp',
        'cs' => 'csharp',
        'rb' => 'ruby',
        'go' => 'go',
        'rs' => 'rust',
        'sql' => 'sql',
        'md' => 'markdown', 'markdown' => 'markdown',
        'json' => 'json',
        'xml' => 'xml', 'svg' => 'xml',
        'yaml' => 'yaml', 'yml' => 'yaml',
        'sh' => 'shell', 'bash' => 'shell',
        'r' => 'r',
        'ino' => 'cpp', // Arduino
        'dart' => 'dart',
        'swift' => 'swift',
        'kt' => 'kotlin',
        'lua' => 'lua',
        'txt' => 'text',
        'log' => 'text',
        'env' => 'text',
        'gitignore' => 'text',
    ];
    return $map[$ext] ?? 'text';
}

/**
 * Get file icon class based on extension
 */
function file_icon($filename) {
    $ext = get_file_extension($filename);
    $icons = [
        'html' => 'file-code', 'htm' => 'file-code',
        'css' => 'file-code', 'js' => 'file-code',
        'php' => 'file-code', 'py' => 'file-code',
        'java' => 'file-code', 'c' => 'file-code',
        'cpp' => 'file-code', 'cs' => 'file-code',
        'pdf' => 'file-text', 'doc' => 'file-text', 'docx' => 'file-text',
        'png' => 'image', 'jpg' => 'image', 'jpeg' => 'image', 'gif' => 'image',
        'zip' => 'archive', 'rar' => 'archive', '7z' => 'archive',
        'mp3' => 'music', 'wav' => 'music',
        'mp4' => 'video', 'avi' => 'video',
    ];
    return $icons[$ext] ?? 'file';
}

/**
 * Check if the request is AJAX
 */
function is_ajax() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Generate a slug from a string
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}
