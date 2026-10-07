<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

final class SitemapController extends Controller
{
    public function index(): void
    {
        $pdo = Database::pdo();
        $urls = [url('/')];
        foreach ($pdo->query('SELECT c.slug AS cs, s.slug AS ss FROM services s JOIN service_categories c ON c.id = s.category_id WHERE s.status = 1') as $row) {
            $urls[] = url($row['cs'] . '/' . $row['ss']);
        }
        foreach (['education', 'immigration', 'sponsorship', 'visit', 'others'] as $c) {
            $urls[] = url($c);
        }
        foreach ($pdo->query('SELECT slug FROM pages WHERE status = 1') as $row) {
            $urls[] = url('about/' . $row['slug']);
        }
        foreach ($pdo->query('SELECT slug FROM schools WHERE status = 1') as $row) {
            $urls[] = url('school/' . $row['slug']);
        }
        foreach ($pdo->query("SELECT slug FROM events WHERE status = 'published'") as $row) {
            $urls[] = url('event/' . $row['slug']);
        }
        foreach ($pdo->query("SELECT slug FROM blog_posts WHERE status = 'published'") as $row) {
            $urls[] = url('blog/' . $row['slug']);
        }
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach (array_unique($urls) as $u) {
            echo '<url><loc>' . e($u) . '</loc></url>';
        }
        echo '</urlset>';
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo "User-agent: *\nDisallow: /admin\nSitemap: " . url('sitemap.xml') . "\n";
    }
}
