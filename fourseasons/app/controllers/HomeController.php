<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\HomepageSection;
use App\Models\Page;
use App\Models\School;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\BlogPost;

final class HomeController extends Controller
{
    public function index(): void
    {
        $sections = (new HomepageSection())->keyed();
        $this->view('pages/home', [
            'seo' => seo_defaults(['title' => setting('seo_title')]),
            'sections' => $sections,
            'services' => (new Service())->featured(16),
            'schools' => (new School())->byProvince(),
            'team' => (new TeamMember())->where('status = 1', [], 'sort_order ASC'),
            'events' => (new Event())->where("status = 'published'", [], 'event_date ASC'),
            'testimonials' => (new Testimonial())->where('status = 1', [], 'sort_order ASC'),
            'gallery' => (new GalleryItem())->where('status = 1', [], 'sort_order ASC'),
            'posts' => (new BlogPost())->where("status = 'published'", [], 'published_at DESC'),
            'aboutPage' => (new Page())->findBy('slug', 'who-we-are'),
            'inquiryServices' => inquiry_services(),
        ]);
    }
}
