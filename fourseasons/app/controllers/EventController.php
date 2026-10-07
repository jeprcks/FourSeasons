<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Event;

final class EventController extends Controller
{
    public function index(): void
    {
        $season = $_GET['season'] ?? null;
        $model = new Event();
        $events = is_string($season) && $season !== ''
            ? $model->where("status = 'published' AND season = :s", ['s' => $season], 'event_date ASC')
            : $model->where("status = 'published'", [], 'event_date ASC');
        $this->view('events/index', [
            'seo' => seo_defaults(['title' => 'Events | Four Seasons Canada']),
            'events' => $events,
            'season' => $season,
        ]);
    }

    public function show(string $slug): void
    {
        $event = (new Event())->findBy('slug', $slug);
        if (!$event || $event['status'] !== 'published') {
            (new ErrorController())->notFound();
            return;
        }
        $this->view('events/show', [
            'seo' => seo_defaults(['title' => $event['title'] . ' | Four Seasons Canada', 'description' => excerpt((string) $event['description'])]),
            'event' => $event,
            'inquiryServices' => inquiry_services(),
        ]);
    }
}
