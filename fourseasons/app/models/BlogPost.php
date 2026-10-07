<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class BlogPost extends Model
{
    protected string $table = 'blog_posts';

    public function published(int $page = 1, int $per = 9, ?string $category = null, ?string $q = null): array
    {
        $where = 'status = :st AND (published_at IS NULL OR published_at <= NOW())';
        $params = ['st' => 'published'];
        if ($category) {
            $where .= ' AND category_id = (SELECT id FROM blog_categories WHERE slug = :cs LIMIT 1)';
            $params['cs'] = $category;
        }
        if ($q) {
            $where .= ' AND (title LIKE :q OR excerpt LIKE :q2 OR body LIKE :q3)';
            $params['q'] = '%' . $q . '%';
            $params['q2'] = '%' . $q . '%';
            $params['q3'] = '%' . $q . '%';
        }
        return $this->paginate($page, $per, $where, $params, 'published_at DESC, id DESC');
    }

    public function withCategory(int $id): ?array
    {
        $stmt = $this->db()->prepare(
            'SELECT p.*, c.title AS category_title, c.slug AS category_slug
             FROM blog_posts p LEFT JOIN blog_categories c ON c.id = p.category_id WHERE p.id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
