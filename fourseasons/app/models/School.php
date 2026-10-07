<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class School extends Model
{
    protected string $table = 'schools';

    public function programs(int $id): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM school_programs WHERE school_id = :id ORDER BY title ASC');
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function byProvince(?string $province = null): array
    {
        if ($province) {
            return $this->where('status = 1 AND province = :p', ['p' => $province], 'name ASC');
        }
        return $this->where('status = 1', [], 'province ASC, name ASC');
    }
}
