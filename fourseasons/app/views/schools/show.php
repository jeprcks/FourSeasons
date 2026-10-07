<?php
$heading = $school['name'];
$lead = trim(($school['city'] ?? '') . ', ' . ($school['province'] ?? ''), ', ');
$crumb = 'Schools / ' . $school['name'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container detail-layout">
        <article class="detail-copy">
            <?= $school['description'] ?? '' ?>

            <h2>Programs to explore</h2>
            <?php foreach (($programs ?? []) as $program): ?>
                <div class="content-card">
                    <h3><?= e($program['title']) ?></h3>
                    <p><?= e($program['description'] ?? '') ?></p>
                </div>
            <?php endforeach; ?>
        </article>

        <aside class="detail-aside">
            <span class="eyebrow">Education advising</span>
            <h2>Find a program that fits.</h2>
            <a class="button" href="<?= e(url('contact')) ?>">
                Ask us about this school <span aria-hidden="true">↗</span>
            </a>
        </aside>
    </div>
</section>
