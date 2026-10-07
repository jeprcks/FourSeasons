<?php
$hero = json_decode($sections['hero']['content_json'] ?? '{}', true) ?: [];
$stats = json_decode($sections['stats']['content_json'] ?? '[]', true) ?: [];
?>

<section class="hero hero-home" data-hero-carousel aria-label="Canadian destination highlights">
    <div class="hero-image hero-slide is-active" role="img" aria-label="Toronto skyline in autumn" data-hero-slide="toronto" aria-hidden="false"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Immigration consultation in Canada" data-hero-slide="consultation" aria-hidden="true"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Family beside a Canadian flag and city skyline" data-hero-slide="family-canada" aria-hidden="true"></div>
    <div class="container hero-content">
        <p class="eyebrow eyebrow-light">Four Seasons Canada · Immigration &amp; Education</p>
        <h1><?= e($hero['headline'] ?? 'Your journey to Canada starts here.') ?></h1>
        <p class="hero-copy">
            <?= e($hero['subhead'] ?? 'Professional immigration and education guidance to help you move toward your Canadian goals with confidence.') ?>
        </p>
        <div class="hero-actions">
            <a class="button button-canada" href="<?= e(url('contact')) ?>">Get started <span aria-hidden="true">→</span></a>
            <a class="text-link text-link-light" href="<?= e(url('contact')) ?>">Book a consultation <span>→</span></a>
        </div>
        <div class="hero-note"><span class="note-dot"></span>Education and immigration guidance, made personal</div>
    </div>
    <div class="hero-carousel-controls" aria-label="Homepage image carousel controls">
        <button class="hero-control" type="button" data-hero-prev aria-label="Previous image">←</button>
        <div class="hero-dots" aria-label="Choose an image">
            <button type="button" data-hero-dot="0" aria-label="Show Canada consultation image" aria-pressed="true"></button>
            <button type="button" data-hero-dot="1" aria-label="Show Canadian family image" aria-pressed="false"></button>
            <button type="button" data-hero-dot="2" aria-label="Show Vancouver image" aria-pressed="false"></button>
        </div>
        <span class="hero-count" aria-hidden="true"><span data-hero-current>01</span> / 03</span>
        <button class="hero-control" type="button" data-hero-next aria-label="Next image">→</button>
    </div>
</section>

<section class="intro-section section-pad">
    <div class="container intro-grid">
        <div class="intro-label">
            <span class="eyebrow">Your Canadian journey</span>
            <figure class="intro-visual" data-journey-carousel aria-label="Highlights from Canada">
                <div class="intro-visual-slides">
                    <div class="intro-visual-slide is-active" data-journey-slide aria-hidden="false">
                        <img src="<?= e(asset('images/lake-louise-hero.jpg')) ?>" alt="Lake Louise and the Canadian Rockies" loading="lazy">
                    </div>
                    <div class="intro-visual-slide" data-journey-slide aria-hidden="true">
                        <img src="<?= e(asset('images/toronto-autumn-hero.jpg')) ?>" alt="Toronto skyline framed by autumn colours" loading="lazy">
                    </div>
                    <div class="intro-visual-slide" data-journey-slide aria-hidden="true">
                        <img src="<?= e(asset('images/vancouver-harbour-hero.jpg')) ?>" alt="Vancouver harbour and mountain views" loading="lazy">
                    </div>
                </div>
                <figcaption><span data-journey-current>01</span> Explore &middot; Prepare &middot; Begin</figcaption>
                <div class="intro-visual-dots" role="group" aria-label="Choose a Canadian destination">
                    <button type="button" data-journey-dot="0" aria-label="Show Lake Louise" aria-pressed="true"></button>
                    <button type="button" data-journey-dot="1" aria-label="Show Toronto" aria-pressed="false"></button>
                    <button type="button" data-journey-dot="2" aria-label="Show Vancouver" aria-pressed="false"></button>
                </div>
            </figure>
        </div>
        <div class="intro-copy">
            <h2>Your Canada plans start with<br><em class="intro-emphasis">one thoughtful step.</em></h2>
            <p>Whether you’re exploring Canadian schools or an immigration pathway, we’ll help you understand your options and decide what to do next.</p>
            <a class="text-link intro-cta" href="<?= e(url('contact')) ?>">Explore your options <span>→</span></a>
        </div>
        <div class="intro-aside">
            <div class="round-seal"><span>CANADA</span><b>FS</b><span>YOUR NEXT CHAPTER</span></div>
            <p>Clear advice. Human support. A plan made around you.</p>
        </div>
    </div>
</section>

<?php require APP_PATH . '/views/Mission/Vision/mission-credibility.php'; ?>

<section class="services-section section-pad">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Where can we help?</span>
                <h2>Guidance for the<br><em>road ahead.</em></h2>
            </div>
            <a class="text-link" href="<?= e(url('immigration')) ?>">View all services <span>→</span></a>
        </div>
        <div class="service-grid">
            <?php foreach (array_slice($services ?? [], 0, 9) as $i => $service): ?>
                <a class="service-card" href="<?= e(url(($service['category_slug'] ?? 'immigration') . '/' . $service['slug'])) ?>">
                    <span class="card-number">0<?= $i + 1 ?></span>
                    <span class="card-arrow">↗</span>
                    <span class="service-icon" aria-hidden="true">✦</span>
                    <h3><?= e($service['title']) ?></h3>
                    <p><?= e($service['excerpt'] ?? 'Personalized guidance to help you understand your next steps.') ?></p>
                    <span class="card-link">Discover this service <span>→</span></span>
                </a>
            <?php endforeach; ?>

            <?php if (empty($services)): ?>
                <a class="service-card" href="<?= e(url('education')) ?>">
                    <span class="card-number">01</span><span class="card-arrow">↗</span>
                    <span class="service-icon">✳</span><h3>Study in Canada</h3>
                    <p>Find a school and plan a study permit application with thoughtful guidance.</p>
                    <span class="card-link">Discover this service <span>→</span></span>
                </a>
                <a class="service-card" href="<?= e(url('immigration')) ?>">
                    <span class="card-number">02</span><span class="card-arrow">↗</span>
                    <span class="service-icon">◇</span><h3>Make Canada home</h3>
                    <p>Explore possible pathways and get clarity on the process ahead.</p>
                    <span class="card-link">Discover this service <span>→</span></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="story-band">
    <div class="story-photo" role="img" aria-label="Toronto skyline and waterfront in Canada"></div>
    <div class="story-content">
        <span class="eyebrow eyebrow-light">The Four Seasons approach</span>
        <h2>Big decisions feel easier with someone in your corner.</h2>
        <p>We listen first, explain your options in plain language, and help you prepare one considered step at a time.</p>
        <a class="button button-outline-light" href="<?= e(url('about/who-we-are')) ?>">Who we are <span>↗</span></a>
    </div>
</section>

<?php if (!empty($stats)): ?>
    <section class="stats-section section-pad">
        <div class="container stats-grid">
            <?php foreach ($stats as $stat): ?>
                <div class="stat-item">
                    <strong><?= e((string) ($stat['value'] ?? '')) ?></strong>
                    <span><?= e((string) ($stat['label'] ?? '')) ?></span>
                    <small><?= e((string) ($stat['note'] ?? '')) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

<section class="schools-section section-pad">
    <div class="container">
        <div class="section-heading">
            <div><span class="eyebrow">Find your place</span><h2>Canadian schools,<br><em>closer to home.</em></h2></div>
            <a class="text-link" href="<?= e(url('schools')) ?>">Explore schools <span>→</span></a>
        </div>
        <div class="school-grid">
            <?php $featuredSchools = array_slice($schools ?? [], 0, 8); ?>
            <?php foreach ($featuredSchools as $school): ?>
                <a class="school-card" href="<?= e(url('school/' . $school['slug'])) ?>">
                    <span class="school-province"><?= e($school['province'] ?? 'Canada') ?></span>
                    <?php if (!empty($school['image'])): ?>
                        <img class="school-card-image" src="<?= e(upload_url($school['image'])) ?>" alt="<?= e($school['name']) ?> campus" loading="lazy">
                    <?php else: ?>
                        <div class="school-card-image school-card-image-placeholder" aria-hidden="true"><span>STUDY IN CANADA</span></div>
                    <?php endif; ?>
                    <h3><?= e($school['name'] ?? '') ?></h3>
                    <p><?= e(trim(($school['city'] ?? '') . ', ' . ($school['province'] ?? ''), ', ')) ?></p>
                    <span class="card-link">View institution <span>→</span></span>
                </a>
            <?php endforeach; ?>
            <?php if (empty($featuredSchools)): ?>
                <a class="school-card" href="<?= e(url('schools')) ?>">
                    <span class="school-province">Your possibilities</span><span class="school-monogram">CA</span>
                    <h3>Find the right fit</h3><p>Explore Canadian colleges and universities.</p>
                    <span class="card-link">Browse schools <span>→</span></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($team)): ?>
    <section class="team-section section-pad">
        <div class="container">
            <div class="section-heading">
                <div><span class="eyebrow">Meet the people behind the process</span><h2>Here to help you<br><em>move forward.</em></h2></div>
                <a class="text-link" href="<?= e(url('team')) ?>">Meet our team <span>→</span></a>
            </div>
            <div class="team-grid">
                <?php foreach (array_slice($team, 0, 4) as $member): ?>
                    <a class="team-card" href="<?= e(url('team/' . $member['slug'])) ?>">
                        <div class="team-portrait">
                            <?php if (!empty($member['photo'])): ?>
                                <img src="<?= e(upload_url($member['photo'])) ?>" alt="<?= e($member['full_name']) ?>" loading="lazy">
                            <?php else: ?>
                                <span><?= e(strtoupper(substr($member['full_name'], 0, 1))) ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><?= e($member['full_name']) ?></h3><p><?= e($member['position']) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($events)): ?>
    <section class="events-section section-pad">
        <div class="container">
            <div class="section-heading">
                <div><span class="eyebrow">Come learn with us</span><h2>Good conversations.<br><em>Useful next steps.</em></h2></div>
                <a class="text-link" href="<?= e(url('events')) ?>">All events <span>→</span></a>
            </div>
            <div class="event-list">
                <?php foreach (array_slice($events, 0, 3) as $event): ?>
                    <a class="event-row<?= !empty($event['image']) ? ' has-image' : '' ?>" href="<?= e(url('event/' . $event['slug'])) ?>">
                        <?php if (!empty($event['image'])): ?><img class="event-thumb" src="<?= e(upload_url($event['image'])) ?>" alt="" loading="lazy"><?php endif; ?>
                        <span class="event-date"><?= e(date('M', strtotime($event['event_date']))) ?><strong><?= e(date('d', strtotime($event['event_date']))) ?></strong></span>
                        <span class="event-title"><small><?= e($event['location'] ?? 'Four Seasons Canada') ?></small><b><?= e($event['title']) ?></b></span>
                        <span class="event-arrow">↗</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (!empty($posts)): ?>
    <section class="news-section section-pad">
        <div class="container">
            <div class="section-heading">
                <div><span class="eyebrow">Helpful notes for your next step</span><h2>News &amp; <em>insights.</em></h2></div>
                <a class="text-link" href="<?= e(url('blog')) ?>">All articles <span aria-hidden="true">→</span></a>
            </div>
            <div class="news-grid">
                <?php foreach (array_slice($posts, 0, 3) as $post): ?>
                    <a class="news-card" href="<?= e(url('blog/' . $post['slug'])) ?>">
                        <?php if (!empty($post['featured_image'])): ?>
                            <img src="<?= e(upload_url($post['featured_image'])) ?>" alt="" loading="lazy">
                        <?php else: ?>
                            <div class="news-card-placeholder" aria-hidden="true"><span>FOUR SEASONS CANADA</span></div>
                        <?php endif; ?>
                        <div class="news-card-copy">
                            <span class="eyebrow"><?= e(!empty($post['published_at']) ? date('F j, Y', strtotime($post['published_at'])) : 'Canada insights') ?></span>
                            <h3><?= e($post['title']) ?></h3>
                            <p><?= e(excerpt((string) ($post['excerpt'] ?? ''), 130)) ?></p>
                            <span class="card-link">Read more <span aria-hidden="true">→</span></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="quote-section">
    <div class="container quote-inner">
        <?php if (!empty($testimonials)): ?>
            <span class="eyebrow">Client stories</span><span class="quote-mark">“</span>
            <blockquote><?= e($testimonials[0]['quote']) ?></blockquote>
            <span class="eyebrow">
                <?= e($testimonials[0]['client_name']) ?>
                <?= !empty($testimonials[0]['service_label']) ? ' · ' . e($testimonials[0]['service_label']) : '' ?>
            </span>
        <?php else: ?>
            <span class="quote-mark">“</span>
            <blockquote>Every journey begins with a question. We’re here to help you find a clear and considered answer.</blockquote>
            <span class="eyebrow">Here for your next chapter</span>
        <?php endif; ?>
    </div>
</section>

<section class="contact-band">
    <div class="container contact-band-inner">
        <div><span class="eyebrow eyebrow-light">Let’s make a plan</span><h2>Where would you like<br>your story to go?</h2></div>
        <a class="button button-light" href="<?= e(url('contact')) ?>">Talk with our team <span>↗</span></a>
    </div>
</section>
