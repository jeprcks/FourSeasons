<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Page;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\HomepageSection;

final class PageController extends Controller
{
    public function show(string $slug): void
    {
        $page = (new Page())->findBy('slug', $slug);
        if (!$page || !(int) $page['status']) {
            (new ErrorController())->notFound();
            return;
        }
        $extra = [];
        if ($slug === 'who-we-are') {
            $extra['team'] = (new TeamMember())->where('status = 1', [], 'sort_order ASC');
            $extra['testimonials'] = (new Testimonial())->where('status = 1', [], 'sort_order ASC');
            $statsRow = (new HomepageSection())->findBy('section_key', 'stats');
            $extra['stats'] = json_decode($statsRow['content_json'] ?? '[]', true) ?: [];
        }
        $this->view('pages/show', array_merge([
            'seo' => seo_defaults([
                'title' => $page['seo_title'] ?: $page['title'] . ' | Four Seasons Canada',
                'description' => $page['seo_description'] ?: excerpt((string) $page['body']),
            ]),
            'page' => $page,
        ], $extra));
    }
}
