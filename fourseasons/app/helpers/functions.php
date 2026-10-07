<?php

declare(strict_types=1);

use App\Core\Cache;
use App\Core\Csrf;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\Service;

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = '/'): string
{
    $app = require BASE_PATH . '/config/app.php';
    $base = rtrim((string) $app['url'], '/');
    if ($path === '' || $path === '/') {
        return $base . '/';
    }
    return $base . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function upload_url(?string $path): string
{
    if (!$path) {
        return asset('images/placeholder.svg');
    }
    if (str_starts_with($path, 'http')) {
        return $path;
    }
    return url($path);
}

function csrf_field(): string
{
    return Csrf::field();
}

function old(string $key, string $default = ''): string
{
    $flash = App\Core\Session::get('_old', []);
    return e((string) ($flash[$key] ?? ($_POST[$key] ?? $default)));
}

function app_settings(): array
{
    $cached = Cache::get('settings');
    if (is_array($cached)) {
        return $cached;
    }
    try {
        $rows = (new Setting())->all('id ASC');
    } catch (Throwable) {
        return [];
    }
    $out = [];
    foreach ($rows as $row) {
        $out[$row['setting_key']] = $row['setting_value'];
    }
    Cache::set('settings', $out, 60);
    return $out;
}

function setting(string $key, string $default = ''): string
{
    return (string) (app_settings()[$key] ?? $default);
}

function public_menu(): array
{
    $cached = Cache::get('menu');
    if (is_array($cached)) {
        return $cached;
    }
    try {
        $items = (new MenuItem())->where('status = :s', ['s' => 1], 'sort_order ASC, id ASC');
    } catch (Throwable) {
        return [];
    }
    $tree = [];
    foreach ($items as $item) {
        if ((int) $item['parent_id'] === 0) {
            $item['children'] = [];
            $tree[$item['id']] = $item;
        }
    }
    foreach ($items as $item) {
        $pid = (int) $item['parent_id'];
        if ($pid && isset($tree[$pid])) {
            $tree[$pid]['children'][] = $item;
        }
    }
    $menu = array_values($tree);
    Cache::set('menu', $menu, 60);
    return $menu;
}

function inquiry_services(): array
{
    try {
        return (new Service())->where('status = :s', ['s' => 1], 'title ASC');
    } catch (Throwable) {
        return [];
    }
}

function seo_defaults(array $override = []): array
{
    return array_merge([
        'title' => setting('seo_title', 'Four Seasons Canada'),
        'description' => setting('seo_description', 'Canadian immigration and international education consultancy.'),
        'canonical' => url($_SERVER['REQUEST_URI'] ?? '/'),
        'og_image' => setting('og_image', asset('images/og.jpg')),
        'og_title' => $override['title'] ?? setting('seo_title', 'Four Seasons Canada'),
        'og_description' => $override['description'] ?? setting('seo_description', ''),
    ], $override);
}

function excerpt(string $html, int $len = 160): string
{
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
    if (mb_strlen($text) <= $len) {
        return $text;
    }
    return mb_substr($text, 0, $len - 1) . '…';
}

function active_path(string $needle): bool
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    return str_contains($path, $needle);
}

function paginate_links(array $p, string $base): string
{
    if (($p['pages'] ?? 1) <= 1) {
        return '';
    }
    $html = '<nav class="pager" aria-label="Pagination">';
    for ($i = 1; $i <= $p['pages']; $i++) {
        $cls = $i === $p['page'] ? ' class="is-active"' : '';
        $html .= '<a' . $cls . ' href="' . e($base . (str_contains($base, '?') ? '&' : '?') . 'page=' . $i) . '">' . $i . '</a>';
    }
    return $html . '</nav>';
}

function audit(string $action, string $entity, ?int $entityId = null, ?string $details = null): void
{
    try {
        (new App\Models\AuditLog())->insert([
            'user_id' => App\Core\Auth::id() ?: null,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'details' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    } catch (Throwable) {
        // ignore
    }
}
