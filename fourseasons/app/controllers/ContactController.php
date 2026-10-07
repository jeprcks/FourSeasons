<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('pages/contact', [
            'seo' => seo_defaults(['title' => 'Contact | Four Seasons Canada', 'description' => 'Send an inquiry to Four Seasons Canada.']),
            'inquiryServices' => inquiry_services(),
        ]);
    }
}
