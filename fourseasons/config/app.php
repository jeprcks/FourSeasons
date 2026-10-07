<?php

$configuredUrl = getenv('APP_URL');
$environment = getenv('APP_ENV') ?: 'development';
$debugSetting = getenv('APP_DEBUG');
$httpHost = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
if (!preg_match('/^[a-zA-Z0-9.-]+(?::\d{1,5})?$/D', $httpHost)) {
    $httpHost = 'localhost';
}
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$scriptDirectory = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/')));
$scriptDirectory = ($scriptDirectory === '/' || $scriptDirectory === '.') ? '' : '/' . trim($scriptDirectory, '/');
$defaultUrl = $scheme . '://' . $httpHost . $scriptDirectory;

return [
    'name' => 'Four Seasons Canada',
    'tagline' => 'Immigration & Study Services',
    'env' => $environment,
    'debug' => $debugSetting === false
        ? $environment !== 'production'
        : filter_var($debugSetting, FILTER_VALIDATE_BOOL),
    'url' => $configuredUrl ?: $defaultUrl,
    'timezone' => 'America/Toronto',
    'session_name' => 'fsc_session',
    'session_lifetime' => 7200,
    'csrf_key' => 'fsc_csrf',
    'login_max_attempts' => 5,
    'login_lockout_minutes' => 15,
    'upload_max_bytes' => 5 * 1024 * 1024,
    'allowed_image_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
    'allowed_image_ext' => ['jpg', 'jpeg', 'png', 'webp'],
];
