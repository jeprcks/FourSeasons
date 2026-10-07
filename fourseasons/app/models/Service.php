<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Service extends Model
{
    protected string $table = 'services';

    public function byCategorySlug(string $slug): array
    {
        $stmt = $this->db()->prepare(
            'SELECT s.*, c.slug AS category_slug, c.title AS category_title
             FROM services s
             JOIN service_categories c ON c.id = s.category_id
             WHERE c.slug = :slug AND s.status = 1
             ORDER BY s.sort_order ASC, s.title ASC'
        );
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetchAll();
    }

    public function findPublic(string $categorySlug, string $slug): ?array
    {
        $stmt = $this->db()->prepare(
            'SELECT s.*, c.slug AS category_slug, c.title AS category_title
             FROM services s
             JOIN service_categories c ON c.id = s.category_id
             WHERE c.slug = :c AND s.slug = :s AND s.status = 1
             LIMIT 1'
        );
        $stmt->execute(['c' => $categorySlug, 's' => $slug]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function faqs(int $serviceId): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM service_faqs WHERE service_id = :id ORDER BY sort_order ASC');
        $stmt->execute(['id' => $serviceId]);
        return $stmt->fetchAll();
    }

    public function packages(int $serviceId): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM service_packages WHERE service_id = :id ORDER BY sort_order ASC');
        $stmt->execute(['id' => $serviceId]);
        return $stmt->fetchAll();
    }

    public function related(int $id, int $categoryId): array
    {
        $stmt = $this->db()->prepare(
            'SELECT s.*, c.slug AS category_slug FROM services s
             JOIN service_categories c ON c.id = s.category_id
             WHERE s.category_id = :c AND s.id <> :id AND s.status = 1
             ORDER BY s.sort_order LIMIT 4'
        );
        $stmt->execute(['c' => $categoryId, 'id' => $id]);
        return $stmt->fetchAll();
    }

    public function featured(int $limit = 12): array
    {
        $stmt = $this->db()->prepare(
            'SELECT s.*, c.slug AS category_slug FROM services s
             JOIN service_categories c ON c.id = s.category_id
             WHERE s.status = 1 ORDER BY s.sort_order ASC LIMIT :lim'
        );
        $stmt->bindValue(':lim', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function allJoined(): array
    {
        return $this->db()->query(
            'SELECT s.*, c.title AS category_title FROM services s
             JOIN service_categories c ON c.id = s.category_id
             ORDER BY c.sort_order, s.sort_order'
        )->fetchAll();
    }
}
