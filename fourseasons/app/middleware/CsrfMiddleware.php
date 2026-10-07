<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Csrf;

final class CsrfMiddleware
{
    public static function handle(): void
    {
        $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!Csrf::verify(is_string($token) ? $token : null)) {
            http_response_code(403);
            $ajax = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')
                || ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
            if ($ajax) {
                header('Content-Type: application/json');
                echo json_encode(['ok' => false, 'message' => 'Invalid security token.']);
                exit;
            }
            echo 'Forbidden';
            exit;
        }
    }
}
