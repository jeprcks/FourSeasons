<?php
$heading = 'People who are here for your journey.';
$lead = 'Meet the team behind your Canada plans.';
$crumb = 'Our team';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container content-grid">
        <?php foreach (($team ?? []) as $member): ?>
            <a class="content-card person-card" href="<?= e(url('team/' . $member['slug'])) ?>">
                <div class="person-avatar">
                    <?= e(strtoupper(substr($member['full_name'], 0, 1))) ?>
                </div>
                <h2><?= e($member['full_name']) ?></h2>
                <span class="eyebrow"><?= e($member['position']) ?></span>
                <p><?= e(excerpt((string) ($member['biography'] ?? ''), 100)) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>
