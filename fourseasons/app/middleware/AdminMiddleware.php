<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Session;

final class AdminMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check() || !Auth::isAdmin()) {
            Session::flash('error', 'Please sign in to continue.');
            header('Location: ' . url('/admin/login'));
            exit;
        }
    }
}
