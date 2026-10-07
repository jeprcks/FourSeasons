<?php
$heading = 'Ideas and insights for the road ahead.';
$lead = 'Helpful perspectives on studying, visiting, working and making a life in Canada.';
$crumb = 'Insights';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container">
        <form class="blog-search" action="<?= e(url('blog')) ?>" method="get">
            <label class="sr-only" for="blog-search">Search articles</label>
            <input
                id="blog-search"
                type="search"
                name="q"
                value="<?= e($q ?? '') ?>"
                placeholder="Search articles"
            >
            <button class="button" type="submit">Search</button>
        </form>

        <div class="content-grid">
            <?php foreach (($posts['items'] ?? $posts ?? []) as $post): ?>
                <a class="content-card" href="<?= e(url('blog/' . $post['slug'])) ?>">
                    <span class="eyebrow">
                        <?= e(!empty($post['published_at'])
                            ? date('F j, Y', strtotime($post['published_at']))
                            : 'Insights') ?>
                    </span>
                    <h2><?= e($post['title']) ?></h2>
                    <p><?= e($post['excerpt'] ?? '') ?></p>
                    <span class="card-link">Read article <span aria-hidden="true">→</span></span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (isset($posts['pages'])): ?>
            <?= paginate_links($posts, url('blog')) ?>
        <?php endif; ?>
    </div>
</section>
