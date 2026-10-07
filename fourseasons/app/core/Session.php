<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(array $app): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        session_name($app['session_name']);
        session_set_cookie_params([
            'lifetime' => (int) $app['session_lifetime'],
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        ]);
        session_start();
        if (!isset($_SESSION['_created'])) {
            $_SESSION['_created'] = time();
        } elseif (time() - (int) $_SESSION['_created'] > (int) $app['session_lifetime']) {
            session_regenerate_id(true);
            $_SESSION['_created'] = time();
        }
        if (isset($_SESSION['_last_activity']) && (time() - (int) $_SESSION['_last_activity']) > (int) $app['session_lifetime']) {
            self::destroy();
            session_start();
        }
        $_SESSION['_last_activity'] = time();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function flash(string $key, mixed $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return $value;
        }
        $val = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
        $_SESSION['_created'] = time();
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'] ?? '', $p['secure'], $p['httponly']);
        }
        session_destroy();
    }
}
