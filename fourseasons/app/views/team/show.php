<?php
$heading = $member['full_name'];
$lead = $member['position'];
$crumb = 'Our team / ' . $member['full_name'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container prose-content">
        <div class="person-avatar person-avatar-large">
            <?= e(strtoupper(substr($member['full_name'], 0, 1))) ?>
        </div>
        <p><?= e($member['biography'] ?? '') ?></p>

        <?php if (!empty($member['email'])): ?>
            <a class="text-link" href="mailto:<?= e($member['email']) ?>">
                Contact our team <span aria-hidden="true">→</span>
            </a>
        <?php endif; ?>
    </div>
</section>
