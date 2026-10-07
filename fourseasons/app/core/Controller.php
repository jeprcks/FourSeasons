<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $data = [], ?string $layout = 'layouts/public'): void
    {
        $data['settings'] = $data['settings'] ?? app_settings();
        $data['menu'] = $data['menu'] ?? public_menu();
        $data['csrf'] = \App\Core\Csrf::token();
        View::render($template, $data, $layout);
    }

    protected function adminView(string $template, array $data = []): void
    {
        $data['authUser'] = Auth::user();
        $data['csrf'] = Csrf::token();
        $data['flash'] = Session::flash('message');
        $data['flashError'] = Session::flash('error');
        View::render($template, $data, 'layouts/admin');
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function back(): void
    {
        $ref = $_SERVER['HTTP_REFERER'] ?? url('/');
        header('Location: ' . $ref);
        exit;
    }

    protected function json(array $payload, int $status = 200): void
    {
        View::json($payload, $status);
        exit;
    }

    protected function input(): array
    {
        return array_merge($_GET, $_POST);
    }
}
