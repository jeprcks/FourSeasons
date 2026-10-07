<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;

final class BlogController extends Controller
{
    public function index(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $cat = isset($_GET['category']) && is_string($_GET['category']) ? $_GET['category'] : null;
        $q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : null;
        $result = (new BlogPost())->published($page, 9, $cat, $q);
        $this->view('blog/index', [
            'seo' => seo_defaults(['title' => 'News | Four Seasons Canada']),
            'posts' => $result,
            'categories' => (new BlogCategory())->all('title ASC'),
            'q' => $q,
            'category' => $cat,
        ]);
    }

    public function show(string $slug): void
    {
        $post = (new BlogPost())->findBy('slug', $slug);
        if (!$post || $post['status'] !== 'published') {
            (new ErrorController())->notFound();
            return;
        }
        if ($post['published_at'] && strtotime((string) $post['published_at']) > time()) {
            (new ErrorController())->notFound();
            return;
        }
        $related = (new BlogPost())->where(
            "status = 'published' AND id <> :id",
            ['id' => $post['id']],
            'published_at DESC'
        );
        $this->view('blog/show', [
            'seo' => seo_defaults([
                'title' => $post['seo_title'] ?: $post['title'],
                'description' => $post['seo_description'] ?: excerpt((string) ($post['excerpt'] ?: $post['body'])),
                'og_image' => $post['og_image'] ?: upload_url($post['featured_image']),
            ]),
            'post' => $post,
            'related' => array_slice($related, 0, 3),
        ]);
    }
}
