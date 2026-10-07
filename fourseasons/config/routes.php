<?php

declare(strict_types=1);

use App\Controllers\Admin as Admin;
use App\Controllers\BlogController;
use App\Controllers\ContactController;
use App\Controllers\ErrorController;
use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\InquiryController;
use App\Controllers\PageController;
use App\Controllers\SchoolController;
use App\Controllers\SearchController;
use App\Controllers\ServiceController;
use App\Controllers\SitemapController;
use App\Controllers\TeamController;

/** @var App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('education', [ServiceController::class, 'category']);
$router->get('immigration', [ServiceController::class, 'category']);
$router->get('sponsorship', [ServiceController::class, 'category']);
$router->get('visit', [ServiceController::class, 'category']);
$router->get('others', [ServiceController::class, 'category']);
$router->get('education/{slug}', [ServiceController::class, 'show']);
$router->get('immigration/{slug}', [ServiceController::class, 'show']);
$router->get('sponsorship/{slug}', [ServiceController::class, 'show']);
$router->get('visit/{slug}', [ServiceController::class, 'show']);
$router->get('others/{slug}', [ServiceController::class, 'show']);
$router->get('about/{slug}', [PageController::class, 'show']);
$router->get('schools', [SchoolController::class, 'index']);
$router->get('school/{slug}', [SchoolController::class, 'show']);
$router->get('team', [TeamController::class, 'index']);
$router->get('team/{slug}', [TeamController::class, 'show']);
$router->get('events', [EventController::class, 'index']);
$router->get('event/{slug}', [EventController::class, 'show']);
$router->get('blog', [BlogController::class, 'index']);
$router->get('blog/{slug}', [BlogController::class, 'show']);
$router->get('contact', [ContactController::class, 'index']);
$router->get('search', [SearchController::class, 'index']);
$router->post('inquiry', [InquiryController::class, 'store']);
$router->get('sitemap.xml', [SitemapController::class, 'index']);
$router->get('robots.txt', [SitemapController::class, 'robots']);

$router->get('admin', [Admin\AuthController::class, 'redirect']);
$router->get('admin/login', [Admin\AuthController::class, 'showLogin']);
$router->post('admin/login', [Admin\AuthController::class, 'login']);
$router->get('admin/logout', [Admin\AuthController::class, 'logout']);
$router->get('admin/dashboard', [Admin\DashboardController::class, 'index']);

$router->get('admin/leads', [Admin\LeadController::class, 'index']);
$router->get('admin/leads/{id}', [Admin\LeadController::class, 'show']);
$router->post('admin/leads/{id}', [Admin\LeadController::class, 'update']);

$router->get('admin/pages', [Admin\PageAdminController::class, 'index']);
$router->get('admin/pages/create', [Admin\PageAdminController::class, 'create']);
$router->post('admin/pages', [Admin\PageAdminController::class, 'store']);
$router->get('admin/pages/{id}/edit', [Admin\PageAdminController::class, 'edit']);
$router->post('admin/pages/{id}', [Admin\PageAdminController::class, 'update']);
$router->post('admin/pages/{id}/delete', [Admin\PageAdminController::class, 'destroy']);

$router->get('admin/services', [Admin\ServiceAdminController::class, 'index']);
$router->get('admin/services/create', [Admin\ServiceAdminController::class, 'create']);
$router->post('admin/services', [Admin\ServiceAdminController::class, 'store']);
$router->get('admin/services/{id}/edit', [Admin\ServiceAdminController::class, 'edit']);
$router->post('admin/services/{id}', [Admin\ServiceAdminController::class, 'update']);
$router->post('admin/services/{id}/delete', [Admin\ServiceAdminController::class, 'destroy']);
$router->get('admin/categories', [Admin\CategoryAdminController::class, 'index']);
$router->post('admin/categories', [Admin\CategoryAdminController::class, 'store']);
$router->post('admin/categories/{id}', [Admin\CategoryAdminController::class, 'update']);
$router->post('admin/categories/{id}/delete', [Admin\CategoryAdminController::class, 'destroy']);

$router->get('admin/schools', [Admin\SchoolAdminController::class, 'index']);
$router->get('admin/schools/create', [Admin\SchoolAdminController::class, 'create']);
$router->post('admin/schools', [Admin\SchoolAdminController::class, 'store']);
$router->get('admin/schools/{id}/edit', [Admin\SchoolAdminController::class, 'edit']);
$router->post('admin/schools/{id}', [Admin\SchoolAdminController::class, 'update']);
$router->post('admin/schools/{id}/delete', [Admin\SchoolAdminController::class, 'destroy']);

$router->get('admin/team', [Admin\TeamAdminController::class, 'index']);
$router->post('admin/team', [Admin\TeamAdminController::class, 'store']);
$router->post('admin/team/{id}', [Admin\TeamAdminController::class, 'update']);
$router->post('admin/team/{id}/delete', [Admin\TeamAdminController::class, 'destroy']);

$router->get('admin/events', [Admin\EventAdminController::class, 'index']);
$router->post('admin/events', [Admin\EventAdminController::class, 'store']);
$router->post('admin/events/{id}', [Admin\EventAdminController::class, 'update']);
$router->post('admin/events/{id}/delete', [Admin\EventAdminController::class, 'destroy']);

$router->get('admin/blog', [Admin\BlogAdminController::class, 'index']);
$router->post('admin/blog', [Admin\BlogAdminController::class, 'store']);
$router->post('admin/blog/{id}', [Admin\BlogAdminController::class, 'update']);
$router->post('admin/blog/{id}/delete', [Admin\BlogAdminController::class, 'destroy']);
$router->get('admin/blog-categories', [Admin\BlogAdminController::class, 'categories']);
$router->post('admin/blog-categories', [Admin\BlogAdminController::class, 'storeCategory']);

$router->get('admin/testimonials', [Admin\TestimonialAdminController::class, 'index']);
$router->post('admin/testimonials', [Admin\TestimonialAdminController::class, 'store']);
$router->post('admin/testimonials/{id}', [Admin\TestimonialAdminController::class, 'update']);
$router->post('admin/testimonials/{id}/delete', [Admin\TestimonialAdminController::class, 'destroy']);

$router->get('admin/faqs', [Admin\FaqAdminController::class, 'index']);
$router->post('admin/faqs', [Admin\FaqAdminController::class, 'store']);
$router->post('admin/faqs/{id}', [Admin\FaqAdminController::class, 'update']);
$router->post('admin/faqs/{id}/delete', [Admin\FaqAdminController::class, 'destroy']);

$router->get('admin/media', [Admin\MediaAdminController::class, 'index']);
$router->post('admin/media', [Admin\MediaAdminController::class, 'store']);
$router->post('admin/media/{id}/delete', [Admin\MediaAdminController::class, 'destroy']);

$router->get('admin/homepage', [Admin\HomepageAdminController::class, 'index']);
$router->post('admin/homepage/{id}', [Admin\HomepageAdminController::class, 'update']);

$router->get('admin/navigation', [Admin\NavigationAdminController::class, 'index']);
$router->post('admin/navigation', [Admin\NavigationAdminController::class, 'store']);
$router->post('admin/navigation/{id}', [Admin\NavigationAdminController::class, 'update']);
$router->post('admin/navigation/{id}/delete', [Admin\NavigationAdminController::class, 'destroy']);

$router->get('admin/settings', [Admin\SettingAdminController::class, 'index']);
$router->post('admin/settings', [Admin\SettingAdminController::class, 'update']);

$router->get('admin/users', [Admin\UserAdminController::class, 'index']);
$router->post('admin/users', [Admin\UserAdminController::class, 'store']);
$router->post('admin/users/{id}', [Admin\UserAdminController::class, 'update']);

$router->get('admin/audit', [Admin\AuditAdminController::class, 'index']);
