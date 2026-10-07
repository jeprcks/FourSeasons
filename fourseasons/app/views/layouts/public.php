<?php
$seo = $seo ?? [];
$menu = $menu ?? [];
$menu = $menu ?: [
    ['title' => 'Home', 'url' => '/', 'children' => []],
    [
        'title' => 'Education', 'url' => 'education', 'children' => [
            ['title' => 'Canadian Schools', 'url' => 'schools'],
            ['title' => 'Study Permit', 'url' => 'education/study-permit'],
            ['title' => 'Post Graduation Work Permit', 'url' => 'education/post-graduation-work-permit'],
            ['title' => 'Spouse Open Work Permit', 'url' => 'education/spouse-open-work-permit'],
            ['title' => 'Status Extension', 'url' => 'education/status-extension'],
        ],
    ],
    [
        'title' => 'Immigration', 'url' => 'immigration', 'children' => [
            ['title' => 'Express Entry', 'url' => 'immigration/express-entry'],
            ['title' => 'Canadian Experience Class', 'url' => 'immigration/canadian-experience-class'],
            ['title' => 'Federal Skilled Worker', 'url' => 'immigration/federal-skilled-worker'],
            ['title' => 'Provincial Nominee Programs', 'url' => 'immigration/provincial-nominee-programs'],
            ['title' => 'Pilot Programs', 'url' => 'immigration/pilot-programs'],
        ],
    ],
    [
        'title' => 'Sponsorship', 'url' => 'sponsorship', 'children' => [
            ['title' => 'Family Sponsorship', 'url' => 'sponsorship/family-sponsorship'],
            ['title' => 'Parents and Grandparents', 'url' => 'sponsorship/parents-and-grandparents'],
            ['title' => 'Other Relatives', 'url' => 'sponsorship/other-relatives'],
        ],
    ],
    [
        'title' => 'Visit', 'url' => 'visit', 'children' => [
            ['title' => 'Family or Leisure', 'url' => 'visit/family-or-leisure'],
            ['title' => 'Super Visa', 'url' => 'visit/super-visa'],
            ['title' => 'Business or Exploratory', 'url' => 'visit/business-or-exploratory'],
        ],
    ],
    [
        'title' => 'Others', 'url' => 'others', 'children' => [
            ['title' => 'Citizenship', 'url' => 'others/citizenship'],
            ['title' => 'PR Renewal', 'url' => 'others/pr-renewal'],
            ['title' => 'Status Restoration', 'url' => 'others/status-restoration'],
            ['title' => 'LMIA', 'url' => 'others/lmia'],
            ['title' => 'Work Permit', 'url' => 'others/work-permit'],
            ['title' => 'Visa Refusals', 'url' => 'others/visa-refusals'],
        ],
    ],
    [
        'title' => 'About Us', 'url' => 'about/who-we-are', 'children' => [
            ['title' => 'Who We Are', 'url' => 'about/who-we-are'],
            ['title' => 'What We Do', 'url' => 'about/what-we-do'],
            ['title' => 'Where We Are', 'url' => 'about/where-we-are'],
        ],
    ],
    ['title' => 'Events', 'url' => 'events', 'children' => []],
    ['title' => 'Blog / News', 'url' => 'blog', 'children' => []],
    ['title' => 'Contact', 'url' => 'contact', 'children' => []],
];
$menuHasUrl = static function (string $path) use ($menu): bool {
    return (bool) array_filter(
        $menu,
        static fn (array $item): bool => trim((string) ($item['url'] ?? ''), '/') === $path
    );
};
if (!$menuHasUrl('')) {
    array_unshift($menu, ['title' => 'Home', 'url' => '/', 'children' => []]);
}
foreach ([['Events', 'events'], ['Blog / News', 'blog'], ['Contact', 'contact']] as [$label, $path]) {
    if (!$menuHasUrl($path)) {
        $menu[] = ['title' => $label, 'url' => $path, 'children' => []];
    }
}
foreach ($menu as &$item) {
    if (strtolower((string) ($item['title'] ?? '')) !== 'education') {
        continue;
    }
    $children = $item['children'] ?? [];
    $hasSchools = (bool) array_filter(
        $children,
        static fn (array $child): bool => trim((string) ($child['url'] ?? ''), '/') === 'schools'
    );
    if (!$hasSchools) {
        array_unshift($children, ['title' => 'Canadian Schools', 'url' => 'schools']);
        $item['children'] = $children;
    }
}
unset($item);
$title = $seo['title'] ?? 'Four Seasons Canada';
$description = $seo['description'] ?? 'Canadian education and immigration guidance, with clear support at every step.';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>">
  <meta property="og:title" content="<?= e($seo['og_title'] ?? $title) ?>">
  <meta property="og:description" content="<?= e($seo['og_description'] ?? $description) ?>">
  <meta property="og:image" content="<?= e($seo['og_image'] ?? asset('images/og.jpg')) ?>">
  <link rel="canonical" href="<?= e($seo['canonical'] ?? url('/')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>?v=<?= (int) @filemtime(PUBLIC_PATH . '/assets/css/site.css') ?>">
</head>
<body>
<div class="utility-bar">
  <div class="container utility-inner">
    <span>Thoughtful guidance for your next chapter in Canada</span>
    <div>
      <a href="tel:+16477613002">+1 647 761 3002</a>
      <a href="mailto:info@four-seasons.ca">info@four-seasons.ca</a>
    </div>
  </div>
</div>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url('/')) ?>" aria-label="Four Seasons Canada home"><span class="brand-mark">FS</span><span class="brand-name">FOUR SEASONS<small>CANADA</small></span></a>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav"><span></span><span></span><span></span><b class="sr-only">Open navigation</b></button>
    <nav class="primary-nav" id="primary-nav" aria-label="Main navigation">
      <?php foreach ($menu as $item): $children = $item['children'] ?? []; ?>
        <div class="nav-item<?= $children ? ' has-children' : '' ?><?= ($item['title'] ?? '') === 'Contact' ? ' nav-contact' : '' ?>">
          <a href="<?= e(url($item['url'] ?? '/')) ?>"<?= $children ? ' aria-haspopup="true" aria-expanded="false" aria-controls="nav-submenu-' . e($item['slug'] ?? '') . '"' : '' ?>><?= e($item['title'] ?? '') ?><?php if ($children): ?><span class="nav-caret" aria-hidden="true">⌄</span><?php endif; ?></a>
          <?php if ($children): ?><div class="dropdown-menu" id="nav-submenu-<?= e($item['slug'] ?? '') ?>"><?php foreach ($children as $child): ?><a href="<?= e(url($child['url'] ?? '/')) ?>"><?= e($child['title'] ?? '') ?></a><?php endforeach; ?></div><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </nav>
  </div>
</header>
<main><?= $content ?></main>
<footer class="site-footer">
  <div class="container footer-main">
    <div class="footer-about">
      <a class="brand brand-light" href="<?= e(url('/')) ?>">
        <span class="brand-mark">FS</span>
        <span class="brand-name">FOUR SEASONS<small>CANADA</small></span>
      </a>
      <p>Clear, considered support for Canadian education and immigration pathways.</p>
      <a href="mailto:info@four-seasons.ca">info@four-seasons.ca</a>
      <a href="tel:+16477613002">+1 647 761 3002</a>
    </div>
    <div><h3>Explore</h3><a href="<?= e(url('education')) ?>">Education</a><a href="<?= e(url('immigration')) ?>">Immigration</a><a href="<?= e(url('sponsorship')) ?>">Sponsorship</a><a href="<?= e(url('visit')) ?>">Visit Canada</a></div>
    <div><h3>Discover</h3><a href="<?= e(url('schools')) ?>">Canadian schools</a><a href="<?= e(url('team')) ?>">Our team</a><a href="<?= e(url('events')) ?>">Events</a><a href="<?= e(url('blog')) ?>">Insights</a></div>
    <div class="footer-cta"><span class="eyebrow">A good first step</span><h3>Tell us where you hope to go.</h3><a class="button button-light" href="<?= e(url('contact')) ?>">Start a conversation <span aria-hidden="true">↗</span></a></div>
  </div>
  <div class="container footer-bottom"><span>© <?= date('Y') ?> Four Seasons Canada</span><span>Education and immigration guidance, thoughtfully delivered.</span><a href="<?= e(url('about/privacy-policy')) ?>">Privacy</a></div>
</footer>
<script src="<?= e(asset('js/site.js')) ?>?v=<?= (int) @filemtime(PUBLIC_PATH . '/assets/js/site.js') ?>" defer></script>
</body>
</html>
