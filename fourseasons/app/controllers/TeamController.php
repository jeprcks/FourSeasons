<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TeamMember;

final class TeamController extends Controller
{
    public function index(): void
    {
        $this->view('team/index', [
            'seo' => seo_defaults(['title' => 'Our Team | Four Seasons Canada']),
            'team' => (new TeamMember())->where('status = 1', [], 'sort_order ASC'),
        ]);
    }

    public function show(string $slug): void
    {
        $member = (new TeamMember())->findBy('slug', $slug);
        if (!$member || !(int) $member['status']) {
            (new ErrorController())->notFound();
            return;
        }
        $this->view('team/show', [
            'seo' => seo_defaults(['title' => $member['full_name'] . ' | Four Seasons Canada', 'description' => excerpt((string) $member['biography'])]),
            'member' => $member,
        ]);
    }
}
