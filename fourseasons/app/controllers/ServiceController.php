<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use App\Models\Faq;

final class ServiceController extends Controller
{
    public function category(): void
    {
        $slug = $this->currentSegment();
        $category = (new ServiceCategory())->findBy('slug', $slug);
        if (!$category) {
            (new ErrorController())->notFound();
            return;
        }
        $services = (new Service())->byCategorySlug($slug);
        $this->view('services/category', [
            'seo' => seo_defaults([
                'title' => $category['seo_title'] ?: $category['title'] . ' | Four Seasons Canada',
                'description' => $category['seo_description'] ?: excerpt((string) $category['intro']),
            ]),
            'category' => $category,
            'services' => $services,
        ]);
    }

    public function show(string $slug): void
    {
        $categorySlug = $this->currentSegment();
        $model = new Service();
        $service = $model->findPublic($categorySlug, $slug);
        if (!$service) {
            (new ErrorController())->notFound();
            return;
        }
        $this->view('services/show', [
            'seo' => seo_defaults([
                'title' => $service['seo_title'] ?: $service['title'] . ' | Four Seasons Canada',
                'description' => $service['seo_description'] ?: excerpt((string) $service['excerpt']),
                'og_image' => $service['og_image'] ?: upload_url($service['image']),
            ]),
            'service' => $service,
            'faqs' => $model->faqs((int) $service['id']),
            'packages' => $model->packages((int) $service['id']),
            'related' => $model->related((int) $service['id'], (int) $service['category_id']),
            'testimonials' => (new Testimonial())->where('status = 1', [], 'sort_order ASC'),
            'globalFaqs' => (new Faq())->where('status = 1', [], 'sort_order ASC'),
            'inquiryServices' => inquiry_services(),
        ]);
    }

    private function currentSegment(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $parts = array_values(array_filter(explode('/', $path)));
        $known = ['education', 'immigration', 'sponsorship', 'visit', 'others'];
        foreach ($parts as $p) {
            if (in_array($p, $known, true)) {
                return $p;
            }
        }
        return $parts[0] ?? '';
    }
}
