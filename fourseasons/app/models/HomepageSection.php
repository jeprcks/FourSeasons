<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class HomepageSection extends Model
{
    protected string $table = 'homepage_sections';

    public function keyed(): array
    {
        $rows = $this->where('status = 1', [], 'sort_order ASC');
        $out = [];
        foreach ($rows as $row) {
            $row['data'] = json_decode($row['content_json'] ?? '{}', true) ?: [];
            $out[$row['section_key']] = $row;
        }
        return $out;
    }
}
