<?php
$heading = 'Search Four Seasons Canada.';
$lead = 'Explore our services, schools, articles, and information pages.';
$crumb = 'Search';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container">
        <form class="blog-search" action="<?= e(url('search')) ?>" method="get">
            <label class="sr-only" for="site-search">Search</label>
            <input
                id="site-search"
                type="search"
                name="q"
                value="<?= e($q ?? '') ?>"
                placeholder="What would you like to know?"
            >
            <button class="button" type="submit">Search</button>
        </form>

        <?php if (mb_strlen($q ?? '') < 2): ?>
            <p>Enter at least two characters to search.</p>
        <?php else: ?>
            <div class="content-grid">
                <?php foreach (($services ?? []) as $item): ?>
                    <a class="content-card" href="<?= e(url(($item['category_slug'] ?? 'immigration') . '/' . $item['slug'])) ?>">
                        <span class="eyebrow">Service</span>
                        <h2><?= e($item['title']) ?></h2>
                        <p><?= e($item['excerpt'] ?? '') ?></p>
                    </a>
                <?php endforeach; ?>

                <?php foreach (($pages ?? []) as $item): ?>
                    <a class="content-card" href="<?= e(url('about/' . $item['slug'])) ?>">
                        <span class="eyebrow">Information</span>
                        <h2><?= e($item['title']) ?></h2>
                    </a>
                <?php endforeach; ?>

                <?php foreach (($posts ?? []) as $item): ?>
                    <a class="content-card" href="<?= e(url('blog/' . $item['slug'])) ?>">
                        <span class="eyebrow">Insight</span>
                        <h2><?= e($item['title']) ?></h2>
                        <p><?= e($item['excerpt'] ?? '') ?></p>
                    </a>
                <?php endforeach; ?>

                <?php foreach (($schools ?? []) as $item): ?>
                    <a class="content-card" href="<?= e(url('school/' . $item['slug'])) ?>">
                        <span class="eyebrow">School</span>
                        <h2><?= e($item['name']) ?></h2>
                        <p><?= e(trim(($item['city'] ?? '') . ', ' . ($item['province'] ?? ''), ', ')) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if (empty($services) && empty($pages) && empty($posts) && empty($schools)): ?>
                <p>
                    No results found. Try another search or
                    <a class="text-link" href="<?= e(url('contact')) ?>">contact our team</a>.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
