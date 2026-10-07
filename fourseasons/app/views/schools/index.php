<?php
$heading = 'Find your place in Canada.';
$lead = 'Explore Canadian colleges and universities and discover where your next chapter could begin.';
$crumb = 'Schools';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container">
        <div class="school-grid school-directory">
            <?php foreach (($schools ?? []) as $school): ?>
                <a class="school-card" href="<?= e(url('school/' . $school['slug'])) ?>">
                    <span class="school-province"><?= e($school['province'] ?? 'Canada') ?></span>
                    <span class="school-monogram">
                        <?= e(strtoupper(substr($school['name'], 0, 1))) ?>
                    </span>
                    <h3><?= e($school['name']) ?></h3>
                    <p>
                        <?= e(trim(
                            ($school['city'] ?? '') . ', ' . ($school['province'] ?? ''),
                            ', '
                        )) ?>
                    </p>
                    <span class="card-link">View institution <span aria-hidden="true">→</span></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
