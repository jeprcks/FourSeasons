<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Middleware\AdminMiddleware;
use App\Middleware\CsrfMiddleware;

abstract class BaseAdminController extends Controller
{
    protected function guard(): void
    {
        AdminMiddleware::handle();
    }

    protected function csrf(): void
    {
        CsrfMiddleware::handle();
    }

    protected function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
        return trim($text, '-') ?: 'item';
    }
}
