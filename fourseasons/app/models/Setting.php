<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected string $table = 'settings';

    public function upsert(string $key, string $value): void
    {
        $existing = $this->findBy('setting_key', $key);
        if ($existing) {
            $this->update((int) $existing['id'], ['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
            return;
        }
        $this->insert(['setting_key' => $key, 'setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
