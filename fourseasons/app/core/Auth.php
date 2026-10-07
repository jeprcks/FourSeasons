<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function attempt(string $email, string $password, string $ip): bool
    {
        $userModel = new User();
        if ($userModel->isLocked($email, $ip)) {
            return false;
        }
        $user = $userModel->findByEmail($email);
        if (!$user || (int) $user['status'] !== 1 || !password_verify($password, $user['password_hash'])) {
            $userModel->recordAttempt($email, $ip, false);
            return false;
        }
        $userModel->recordAttempt($email, $ip, true);
        Session::regenerate();
        Session::set('user_id', (int) $user['id']);
        Session::set('user_role', $user['role_slug'] ?? 'admin');
        return true;
    }

    public static function check(): bool
    {
        return (int) Session::get('user_id', 0) > 0;
    }

    public static function user(): ?array
    {
        $id = (int) Session::get('user_id', 0);
        if ($id < 1) {
            return null;
        }
        return (new User())->findWithRole($id);
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function id(): int
    {
        return (int) Session::get('user_id', 0);
    }

    public static function isAdmin(): bool
    {
        return in_array(Session::get('user_role'), ['admin', 'super_admin'], true);
    }
}
