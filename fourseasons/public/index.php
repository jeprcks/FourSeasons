<?php

declare(strict_types=1);

// When this file is used as PHP's built-in server router, let existing public
// assets be served directly instead of sending them through the MVC router.
$requestPath = rawurldecode((string) (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'));
$publicRoot = realpath(__DIR__);
$requestedFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . ltrim($requestPath, '/\\'));
if ($publicRoot && $requestedFile && is_file($requestedFile)
    && str_starts_with($requestedFile, $publicRoot . DIRECTORY_SEPARATOR)) {
    return false;
}

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', __DIR__);
define('STORAGE_PATH', BASE_PATH . '/storage');

require BASE_PATH . '/app/bootstrap.php';
