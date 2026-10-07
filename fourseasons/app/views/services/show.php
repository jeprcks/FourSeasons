<?php
$heading = $service['title'];
$lead = $service['excerpt'] ?? '';
$crumb = $service['title'];
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container detail-layout">
        <article class="detail-copy">
            <?= $service['body'] ?? '<p>Every situation is different. Our team can help you understand the steps and documents relevant to your circumstances.</p>' ?>

            <h2>How we can help</h2>
            <p>
                We’ll take time to understand your goals, explain relevant options,
                and help you prepare for the next step.
            </p>

            <?php if (!empty($faqs)): ?>
                <h2>Questions to consider</h2>
                <?php foreach ($faqs as $faq): ?>
                    <details class="faq">
                        <summary><?= e($faq['question']) ?></summary>
                        <p><?= e($faq['answer']) ?></p>
                    </details>
                <?php endforeach; ?>
            <?php endif; ?>
        </article>

        <aside class="detail-aside">
            <span class="eyebrow">Start a conversation</span>
            <h2>Let’s talk through your options.</h2>
            <p>Share a little about your plans. Our team will be in touch.</p>
            <a class="button" href="<?= e(url('contact')) ?>">
                Contact an advisor <span aria-hidden="true">↗</span>
            </a>
        </aside>
    </div>
</section>
