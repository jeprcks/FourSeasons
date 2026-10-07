<?php
$heading = $post['title'];
$lead = ($post['author'] ?? 'Four Seasons Canada');

if (!empty($post['published_at'])) {
    $lead .= ' · ' . date('F j, Y', strtotime($post['published_at']));
}

$crumb = 'Insights / ' . $post['title'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<article class="section-pad">
    <div class="container prose-content">
        <?= $post['body'] ?>
    </div>
</article>
