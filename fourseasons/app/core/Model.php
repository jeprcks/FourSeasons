<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Model
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    protected function db(): PDO
    {
        return Database::pdo();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findBy(string $column, mixed $value): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$column} = :v LIMIT 1");
        $stmt->execute(['v' => $value]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function all(string $order = 'id DESC'): array
    {
        return $this->db()->query("SELECT * FROM {$this->table} ORDER BY {$order}")->fetchAll();
    }

    public function where(string $sql, array $params = [], string $order = 'id DESC'): array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$sql} ORDER BY {$order}");
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function insert(array $data): int
    {
        $cols = array_keys($data);
        $fields = implode(',', array_map(fn ($c) => "`$c`", $cols));
        $place = implode(',', array_map(fn ($c) => ':' . $c, $cols));
        $stmt = $this->db()->prepare("INSERT INTO {$this->table} ({$fields}) VALUES ({$place})");
        $stmt->execute($data);
        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sets = implode(',', array_map(fn ($c) => "`$c` = :$c", array_keys($data)));
        $data['id'] = $id;
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = :id");
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function paginate(int $page, int $perPage, string $where = '1=1', array $params = [], string $order = 'id DESC'): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;
        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$where}");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$order} LIMIT :lim OFFSET :off");
        foreach ($params as $k => $v) {
            $stmt->bindValue(is_int($k) ? $k + 1 : $k, $v);
        }
        $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'pages' => (int) ceil($total / $perPage),
        ];
    }
}
