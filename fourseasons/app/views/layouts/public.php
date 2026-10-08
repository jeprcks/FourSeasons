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
    <div class="utility-details">
      <span class="utility-detail"><span class="utility-icon" aria-hidden="true">◷</span>Mon–Sat: 9am to 6pm</span>
      <span class="utility-detail"><span class="utility-icon" aria-hidden="true">⌖</span>Houston, USA 485</span>
    </div>
    <div class="utility-contact">
      <a class="utility-detail" href="mailto:info@four-seasons.ca"><span class="utility-icon" aria-hidden="true">✉</span>info@four-seasons.ca</a>
      <nav class="utility-socials" aria-label="Social media">
        <a href="https://www.facebook.com/" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v2H6v4h3v6h4v-6h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg></a>
        <a href="https://www.instagram.com/" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.7" cy="6.5" r=".8" class="icon-fill"/></svg></a>
        <a href="https://twitter.com/" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 6.2c-.7.3-1.5.5-2.3.6a4 4 0 0 0 1.8-2.2 8 8 0 0 1-2.6 1 4 4 0 0 0-6.9 3.7A11.4 11.4 0 0 1 2.7 5a4 4 0 0 0 1.2 5.3c-.6 0-1.2-.2-1.8-.5v.1a4 4 0 0 0 3.2 3.9c-.6.2-1.2.2-1.8.1a4 4 0 0 0 3.7 2.8A8 8 0 0 1 2 18.3a11.3 11.3 0 0 0 17.4-9.5v-.5A8 8 0 0 0 21 6.2Z"/></svg></a>
      </nav>
      <a class="utility-phone" href="tel:+16477613002" aria-label="Call +1 647 761 3002"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 3.5h3l1.5 4-2 1.5a15 15 0 0 0 6 6l1.5-2 4 1.5v3c0 1.1-.9 2-2 2C10 19.5 4.5 14 4.5 5.5c0-1.1.9-2 2-2Z"/></svg></a>
    </div>
  </div>
</div>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url('/')) ?>" aria-label="Four Seasons Immigration Philippines home"><span class="brand-mark brand-mark-image"><img src="<?= e(asset('images/nobackgroundlogo.png')) ?>" alt=""></span><span class="brand-name">FOUR SEASONS<small>IMMIGRATION<br>PHILIPPINES</small></span></a>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav"><span></span><span></span><span></span><b class="sr-only">Open navigation</b></button>
    <nav class="primary-nav" id="primary-nav" aria-label="Main navigation">
      <?php foreach ($menu as $item): $children = $item['children'] ?? []; ?>
        <div class="nav-item<?= $children ? ' has-children' : '' ?><?= ($item['title'] ?? '') === 'Contact' ? ' nav-contact' : '' ?>">
          <a href="<?= e(url($item['url'] ?? '/')) ?>"<?= $children ? ' aria-haspopup="true" aria-expanded="false" aria-controls="nav-submenu-' . e($item['slug'] ?? '') . '"' : '' ?>><?= e($item['title'] ?? '') ?></a>
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
        <span class="brand-mark brand-mark-image"><img src="<?= e(asset('images/nobackgroundlogo.png')) ?>" alt="" loading="lazy"></span>
        <span class="brand-name">FOUR SEASONS<small>IMMIGRATION<br>PHILIPPINES</small></span>
      </a>
      <p>Explore. Dream. Discover.</p>
      <a href="mailto:info@four-seasons.ca">info@four-seasons.ca</a>
      <a href="tel:+16477613002">+1 647 761 3002</a>
    </div>
    <div><h3>Explore</h3><a href="<?= e(url('education')) ?>">Education</a><a href="<?= e(url('immigration')) ?>">Immigration</a><a href="<?= e(url('sponsorship')) ?>">Sponsorship</a><a href="<?= e(url('visit')) ?>">Visit Canada</a></div>
    <div><h3>Discover</h3><a href="<?= e(url('schools')) ?>">Canadian schools</a><a href="<?= e(url('team')) ?>">Our team</a><a href="<?= e(url('events')) ?>">Events</a><a href="<?= e(url('blog')) ?>">Insights</a></div>
    <div class="footer-social-connect">
      <span class="eyebrow">Connect with us</span>
      <h3>Follow Four Seasons Immigration Philippines</h3>
      <nav class="footer-socials" aria-label="Follow Four Seasons Immigration Philippines">
        <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v2H6v4h3v6h4v-6h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg></a>
        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle class="social-icon-fill" cx="17.7" cy="6.5" r=".8"/></svg></a>
        <a href="https://twitter.com/" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 6.2c-.7.3-1.5.5-2.3.6a4 4 0 0 0 1.8-2.2 8 8 0 0 1-2.6 1 4 4 0 0 0-6.9 3.7A11.4 11.4 0 0 1 2.7 5a4 4 0 0 0 1.2 5.3c-.6 0-1.2-.2-1.8-.5v.1a4 4 0 0 0 3.2 3.9c-.6.2-1.2.2-1.8.1a4 4 0 0 0 3.7 2.8A8 8 0 0 1 2 18.3a11.3 11.3 0 0 0 17.4-9.5v-.5A8 8 0 0 0 21 6.2Z"/></svg></a>
        <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19.7 7.4a5.8 5.8 0 0 1-4-1.6v8.1a5.7 5.7 0 1 1-5.7-5.7c.4 0 .8 0 1.2.1v3.2a2.5 2.5 0 1 0 1.3 2.2V3h3.3c.2 2 1.8 3.6 3.9 3.8v.6Z"/></svg></a>
      </nav>
    </div>
  </div>
  <div class="container footer-bottom"><span>© <?= date('Y') ?> Four Seasons Canada</span><span>Education and immigration guidance, thoughtfully delivered.</span><a href="<?= e(url('about/privacy-policy')) ?>">Privacy</a></div>
</footer>
<script src="<?= e(asset('js/site.js')) ?>?v=<?= (int) @filemtime(PUBLIC_PATH . '/assets/js/site.js') ?>" defer></script>
</body>
</html>
