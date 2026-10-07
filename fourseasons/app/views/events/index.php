<?php
$heading = 'Gather, learn, and look ahead.';
$lead = 'Join a conversation about education and immigration pathways to Canada.';
$crumb = 'Events';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container content-grid">
        <?php foreach (($events ?? []) as $event): ?>
            <a class="content-card" href="<?= e(url('event/' . $event['slug'])) ?>">
                <span class="eyebrow">
                    <?= e(date('F j, Y', strtotime($event['event_date']))) ?>
                    <?php if (!empty($event['location'])): ?>
                        · <?= e($event['location']) ?>
                    <?php endif; ?>
                </span>
                <h2><?= e($event['title']) ?></h2>
                <p><?= e(excerpt((string) $event['description'])) ?></p>
                <span class="card-link">Event details <span aria-hidden="true">→</span></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
