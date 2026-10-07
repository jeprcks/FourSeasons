<?php
$heading = $category['title'];
$lead = $category['intro'] ?? '';
$crumb = $category['title'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container">
        <div class="content-grid">
            <?php foreach ($services as $service): ?>
                <a
                    class="content-card"
                    href="<?= e(url($category['slug'] . '/' . $service['slug'])) ?>"
                >
                    <span class="eyebrow"><?= e($category['title']) ?></span>
                    <h2><?= e($service['title']) ?></h2>
                    <p><?= e($service['excerpt'] ?? '') ?></p>
                    <span class="card-link">Explore service <span aria-hidden="true">→</span></span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (!$services): ?>
            <p>Service information is being prepared. Contact our team to discuss your plans.</p>
            <a class="button" href="<?= e(url('contact')) ?>">Talk to an advisor</a>
        <?php endif; ?>
    </div>
</section>
