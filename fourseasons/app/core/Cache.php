<?php

declare(strict_types=1);

namespace App\Core;

final class Cache
{
    public static function get(string $key): mixed
    {
        $file = STORAGE_PATH . '/cache/' . sha1($key) . '.json';
        if (!is_file($file)) {
            return null;
        }
        $payload = json_decode((string) file_get_contents($file), true);
        if (!is_array($payload) || ($payload['exp'] ?? 0) < time()) {
            @unlink($file);
            return null;
        }
        return $payload['data'] ?? null;
    }

    public static function set(string $key, mixed $data, int $ttl = 120): void
    {
        $file = STORAGE_PATH . '/cache/' . sha1($key) . '.json';
        file_put_contents($file, json_encode(['exp' => time() + $ttl, 'data' => $data]));
    }

    public static function forget(string $key): void
    {
        $file = STORAGE_PATH . '/cache/' . sha1($key) . '.json';
        if (is_file($file)) {
            @unlink($file);
        }
    }
}
