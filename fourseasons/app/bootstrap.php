<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $parts = explode('\\', $relative);
    // Application directories are lowercase on disk; class filenames retain
    // their declared capitalization. This matters on Linux hosting.
    $className = array_pop($parts);
    $directory = $parts === [] ? '' : implode('/', array_map('strtolower', $parts)) . '/';
    $path = APP_PATH . '/' . $directory . $className . '.php';
    if (is_file($path)) {
        require $path;
    }
});

$config = [
    'app' => require BASE_PATH . '/config/app.php',
    'db' => require BASE_PATH . '/config/database.php',
];

date_default_timezone_set($config['app']['timezone']);

if ($config['app']['debug']) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL);
}

set_exception_handler(static function (Throwable $e) use ($config): void {
    try {
        App\Core\Logger::error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    } catch (Throwable $loggingError) {
        error_log('Application exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
        error_log('Application logger failure: ' . $loggingError->getMessage());
    }
    http_response_code(500);
    if ($config['app']['debug']) {
        echo '<pre>' . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString()) . '</pre>';
        return;
    }
    $viewFile = APP_PATH . '/views/errors/500.php';
    if (is_file($viewFile)) {
        require $viewFile;
    } else {
        echo 'Server error';
    }
});

App\Core\Database::init($config['db']);
App\Core\Session::start($config['app']);

require APP_PATH . '/helpers/functions.php';

$router = new App\Core\Router();
require BASE_PATH . '/config/routes.php';
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_GET['url'] ?? '');
