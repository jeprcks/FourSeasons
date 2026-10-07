<?php
$heading = $event['title'];
$lead = date('F j, Y', strtotime($event['event_date']));

if (!empty($event['location'])) {
    $lead .= ' · ' . $event['location'];
}

$crumb = 'Events / ' . $event['title'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container detail-layout">
        <article class="detail-copy">
            <?= $event['description'] ?>
        </article>
        <aside class="detail-aside">
            <span class="eyebrow">Save your place</span>
            <h2>Join the conversation.</h2>
            <p><?= e($event['registration_info'] ?? 'Contact our team for registration details.') ?></p>
            <a class="button" href="<?= e(url('contact')) ?>">
                Ask about this event <span aria-hidden="true">↗</span>
            </a>
        </aside>
    </div>
</section>
