<section class="page-hero">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?= e(url('/')) ?>">Home</a>
            <span aria-hidden="true">/</span>
            <?= e($crumb ?? $heading ?? '') ?>
        </div>

        <span class="eyebrow">
            <?= e($eyebrow ?? 'Four Seasons Canada') ?>
        </span>
        <h1><?= e($heading ?? '') ?></h1>

        <?php if (!empty($lead)): ?>
            <p><?= e($lead) ?></p>
        <?php endif; ?>
    </div>
</section>
