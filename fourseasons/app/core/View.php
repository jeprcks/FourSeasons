<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = [], ?string $layout = 'layouts/public'): void
    {
        $content = self::fetch($template, $data);
        if ($layout === null) {
            echo $content;
            return;
        }
        $data['content'] = $content;
        echo self::fetch($layout, $data);
    }

    public static function fetch(string $template, array $data = []): string
    {
        $path = APP_PATH . '/views/' . $template . '.php';
        if (!is_file($path)) {
            throw new \RuntimeException('View not found: ' . $template);
        }
        extract($data, EXTR_SKIP);
        ob_start();
        require $path;
        return (string) ob_get_clean();
    }

    public static function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    }
}
