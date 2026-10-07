<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\School;

final class SchoolController extends Controller
{
    public function index(): void
    {
        $province = $_GET['province'] ?? null;
        $province = is_string($province) && $province !== '' ? $province : null;
        $schools = (new School())->byProvince($province);
        $this->view('schools/index', [
            'seo' => seo_defaults(['title' => 'Canadian Schools | Four Seasons Canada', 'description' => 'Browse featured Canadian colleges and universities.']),
            'schools' => $schools,
            'province' => $province,
        ]);
    }

    public function show(string $slug): void
    {
        $model = new School();
        $school = $model->findBy('slug', $slug);
        if (!$school || !(int) $school['status']) {
            (new ErrorController())->notFound();
            return;
        }
        $this->view('schools/show', [
            'seo' => seo_defaults([
                'title' => ($school['seo_title'] ?: $school['name']) . ' | Four Seasons Canada',
                'description' => $school['seo_description'] ?: excerpt((string) $school['description']),
            ]),
            'school' => $school,
            'programs' => $model->programs((int) $school['id']),
            'inquiryServices' => inquiry_services(),
        ]);
    }
}
