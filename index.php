<?php
/**
 * Proxy to Laravel Application in source/public
 * 
 * This file acts as a front controller for the Laravel application
 * located in the source/public directory, allowing access via /sibudi/
 */

// Get the public directory path
$public_dir = __DIR__ . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR . 'public';

// Check if the request is for a real file in the public directory
if (is_file($public_dir . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'])) {
    // Serve the file directly
    require $public_dir . DIRECTORY_SEPARATOR . $_SERVER['REQUEST_URI'];
    exit;
}

// Adjust $_SERVER variables to work with Laravel in a subdirectory
$_SERVER['DOCUMENT_ROOT'] = $public_dir;
$_SERVER['SCRIPT_FILENAME'] = $public_dir . DIRECTORY_SEPARATOR . 'index.php';
$_SERVER['SCRIPT_NAME'] = '/sibudi/index.php';
$_SERVER['PHP_SELF'] = '/sibudi/index.php';

// Include Laravel's public index.php
require $public_dir . DIRECTORY_SEPARATOR . 'index.php';






