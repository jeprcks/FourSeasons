<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Lead extends Model
{
    protected string $table = 'leads';

    public function withService(?string $status = null, int $page = 1): array
    {
        $where = '1=1';
        $params = [];
        if ($status) {
            $where = 'l.status = :st';
            $params['st'] = $status;
        }
        $page = max(1, $page);
        $per = 20;
        $offset = ($page - 1) * $per;
        $count = $this->db()->prepare("SELECT COUNT(*) FROM leads l WHERE {$where}");
        $count->execute($params);
        $total = (int) $count->fetchColumn();
        $sql = "SELECT l.*, s.title AS service_title FROM leads l
                LEFT JOIN services s ON s.id = l.service_id
                WHERE {$where} ORDER BY l.created_at DESC LIMIT {$per} OFFSET {$offset}";
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);
        return ['data' => $stmt->fetchAll(), 'total' => $total, 'page' => $page, 'pages' => (int) ceil($total / $per), 'per_page' => $per];
    }

    public function counts(): array
    {
        $rows = $this->db()->query('SELECT status, COUNT(*) AS c FROM leads GROUP BY status')->fetchAll();
        $out = ['all' => 0];
        foreach ($rows as $row) {
            $out[$row['status']] = (int) $row['c'];
            $out['all'] += (int) $row['c'];
        }
        return $out;
    }
}
