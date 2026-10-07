<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class ErrorController extends Controller
{
    public function notFound(): void
    {
        http_response_code(404);
        $this->view('errors/404', ['seo' => seo_defaults(['title' => 'Page not found'])]);
    }

    public function forbidden(): void
    {
        http_response_code(403);
        $this->view('errors/403', ['seo' => seo_defaults(['title' => 'Forbidden'])]);
    }

    public function server(): void
    {
        http_response_code(500);
        $this->view('errors/500', ['seo' => seo_defaults(['title' => 'Server error'])]);
    }
}
