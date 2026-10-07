<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;
use PDO;

class User extends Model
{
    protected string $table = 'users';

    public function findWithRole(int $id): ?array
    {
        $stmt = $this->db()->prepare(
            'SELECT u.*, r.slug AS role_slug, r.name AS role_name
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db()->prepare(
            'SELECT u.*, r.slug AS role_slug FROM users u JOIN roles r ON r.id = u.role_id WHERE u.email = :e LIMIT 1'
        );
        $stmt->execute(['e' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function isLocked(string $email, string $ip): bool
    {
        $stmt = $this->db()->prepare(
            'SELECT COUNT(*) FROM login_attempts
             WHERE (email = :e OR ip_address = :ip) AND success = 0 AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)'
        );
        $stmt->execute(['e' => $email, 'ip' => $ip]);
        return (int) $stmt->fetchColumn() >= 5;
    }

    public function recordAttempt(string $email, string $ip, bool $success): void
    {
        $stmt = $this->db()->prepare(
            'INSERT INTO login_attempts (email, ip_address, success, created_at) VALUES (:e, :ip, :s, NOW())'
        );
        $stmt->execute(['e' => $email, 'ip' => $ip, 's' => $success ? 1 : 0]);
    }

    public function allWithRoles(): array
    {
        return $this->db()->query(
            'SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id ORDER BY u.id DESC'
        )->fetchAll();
    }
}
