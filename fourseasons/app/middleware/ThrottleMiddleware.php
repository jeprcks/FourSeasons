<?php

declare(strict_types=1);

namespace App\Middleware;

final class ThrottleMiddleware
{
    public static function tooMany(string $key, int $max, int $minutes): bool
    {
        $file = STORAGE_PATH . '/cache/throttle_' . sha1($key) . '.json';
        $now = time();
        $hits = [];
        if (is_file($file)) {
            $hits = json_decode((string) file_get_contents($file), true) ?: [];
        }
        $hits = array_values(array_filter($hits, fn ($t) => $t > $now - ($minutes * 60)));
        if (count($hits) >= $max) {
            return true;
        }
        $hits[] = $now;
        file_put_contents($file, json_encode($hits));
        return false;
    }
}
