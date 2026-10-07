<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

final class SearchController extends Controller
{
    public function index(): void
    {
        $q = trim((string) ($_GET['q'] ?? ''));
        $services = $pages = $posts = $schools = [];
        if (mb_strlen($q) >= 2) {
            $like = '%' . $q . '%';
            $pdo = Database::pdo();
            $s = $pdo->prepare('SELECT s.*, c.slug AS category_slug FROM services s JOIN service_categories c ON c.id = s.category_id WHERE s.status = 1 AND (s.title LIKE :q OR s.excerpt LIKE :q2) LIMIT 20');
            $s->execute(['q' => $like, 'q2' => $like]);
            $services = $s->fetchAll();
            $p = $pdo->prepare('SELECT * FROM pages WHERE status = 1 AND (title LIKE :q OR body LIKE :q2) LIMIT 10');
            $p->execute(['q' => $like, 'q2' => $like]);
            $pages = $p->fetchAll();
            $b = $pdo->prepare("SELECT * FROM blog_posts WHERE status = 'published' AND (title LIKE :q OR excerpt LIKE :q2) LIMIT 10");
            $b->execute(['q' => $like, 'q2' => $like]);
            $posts = $b->fetchAll();
            $sc = $pdo->prepare('SELECT * FROM schools WHERE status = 1 AND (name LIKE :q OR description LIKE :q2) LIMIT 10');
            $sc->execute(['q' => $like, 'q2' => $like]);
            $schools = $sc->fetchAll();
        }
        $this->view('pages/search', [
            'seo' => seo_defaults(['title' => 'Search | Four Seasons Canada']),
            'q' => $q,
            'services' => $services,
            'pages' => $pages,
            'posts' => $posts,
            'schools' => $schools,
        ]);
    }
}
