<?php

declare(strict_types=1);

namespace App\Core;

final class Logger
{
    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    private static function write(string $level, string $message): void
    {
        $dir = STORAGE_PATH . '/logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $line = sprintf("[%s] %s %s\n", date('Y-m-d H:i:s'), $level, $message);
        file_put_contents($dir . '/app.log', $line, FILE_APPEND | LOCK_EX);
    }
}
