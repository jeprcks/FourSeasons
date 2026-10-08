<?php
$hero = json_decode($sections['hero']['content_json'] ?? '{}', true) ?: [];
$stats = json_decode($sections['stats']['content_json'] ?? '[]', true) ?: [];
?>

<section class="hero hero-home" style="height: calc(100vh - 36px); height: calc(100svh - 36px); min-height: 0;" data-hero-carousel aria-label="Canadian destination highlights">
    <div class="hero-image hero-slide is-active" role="img" aria-label="Traveler with a Canadian flag overlooking Lake Louise" data-hero-slide="lake-louise-journey" aria-hidden="false"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Toronto skyline at sunset" data-hero-slide="toronto-sunset" aria-hidden="true"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Toronto skyline in autumn" data-hero-slide="toronto" aria-hidden="true"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Immigration consultation in Canada" data-hero-slide="consultation" aria-hidden="true"></div>
    <div class="hero-image hero-slide" role="img" aria-label="Family beside a Canadian flag and city skyline" data-hero-slide="family-canada" aria-hidden="true"></div>
    <div class="container hero-content">
        <p class="eyebrow eyebrow-light">Four Seasons Canada · Immigration &amp; Education</p>
        <h1 class="hero-tagline"><span>Turning Visa Dreams</span><span class="hero-tagline-accent">Into New Beginnings!</span></h1>
        <p class="hero-copy hero-subtagline">Your Future Abroad Starts With Us!</p>
        <div class="hero-actions">
            <a class="button button-canada" href="<?= e(url('contact')) ?>">Get started <span aria-hidden="true">→</span></a>
            <a class="text-link text-link-light" href="<?= e(url('contact')) ?>">Book a consultation <span>→</span></a>
        </div>
    </div>
    <div class="hero-carousel-controls" aria-label="Homepage image carousel controls">
        <button class="hero-control" type="button" data-hero-prev aria-label="Previous image">←</button>
        <div class="hero-dots" aria-label="Choose an image">
            <button type="button" data-hero-dot="0" aria-label="Show Lake Louise journey image" aria-pressed="true"></button>
            <button type="button" data-hero-dot="1" aria-label="Show Toronto at sunset" aria-pressed="false"></button>
            <button type="button" data-hero-dot="2" aria-label="Show Toronto in autumn" aria-pressed="false"></button>
            <button type="button" data-hero-dot="3" aria-label="Show Canada consultation image" aria-pressed="false"></button>
            <button type="button" data-hero-dot="4" aria-label="Show Canadian family image" aria-pressed="false"></button>
        </div>
        <span class="hero-count" aria-hidden="true"><span data-hero-current>01</span> / 05</span>
        <button class="hero-control" type="button" data-hero-next aria-label="Next image">→</button>
    </div>
</section>

<div class="journey-mission-wrap">
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
            <img class="intro-aside-airplane" src="<?= e(asset('images/airplane.png')) ?>" alt="Air Canada airplane with the Four Seasons name" loading="lazy">
        </div>
    </div>
</section>

<?php require APP_PATH . '/views/Mission/Vision/mission-credibility.php'; ?>
</div>

<section class="services-section section-pad services-showcase">
    <div class="container">
        <div class="services-heading">
            <span class="eyebrow">Where can we help?</span>
            <h2>Guidance for the<br><em>road ahead.</em></h2>
            <p>Explore our education and immigration services to find the support that fits your next step.</p>
            <a class="services-all-link" href="<?= e(url('immigration')) ?>">View all services <span aria-hidden="true">→</span></a>
        </div>
        <div class="service-grid">
            <?php foreach (array_slice($services ?? [], 0, 9) as $service): ?>
                <a class="service-card" href="<?= e(url(($service['category_slug'] ?? 'immigration') . '/' . $service['slug'])) ?>">
                    <?php if (($service['slug'] ?? '') === 'study-permit' && is_file(PUBLIC_PATH . '/assets/images/study-permit.jpg')): ?>
                        <img class="service-card-image" src="<?= e(asset('images/study-permit.jpg')) ?>" alt="Students studying together outside a Canadian campus" loading="lazy">
                    <?php else: ?>
                        <span class="service-image-placeholder" aria-hidden="true"></span>
                    <?php endif; ?>
                    <span class="service-title-badge"><?= e($service['title']) ?></span>
                    <span class="service-hover-panel" aria-hidden="true">
                        <strong><?= e($service['title']) ?></strong>
                        <span class="service-hover-description"><?= e($service['excerpt'] ?? 'Personalized guidance to help you understand your next steps.') ?></span>
                        <span class="service-hover-cta">Explore More</span>
                    </span>
                    <span class="service-explore">Explore more <span aria-hidden="true">→</span></span>
                </a>
            <?php endforeach; ?>

            <?php if (empty($services)): ?>
                <a class="service-card" href="<?= e(url('education')) ?>">
                    <span class="service-image-placeholder" aria-hidden="true"></span>
                    <span class="service-title-badge">Study in Canada</span>
                    <span class="service-hover-panel" aria-hidden="true">
                        <strong>Study in Canada</strong>
                        <span class="service-hover-description">Find a school and plan a study permit application with thoughtful guidance.</span>
                        <span class="service-hover-cta">Explore More</span>
                    </span>
                    <span class="service-explore">Explore more <span aria-hidden="true">→</span></span>
                </a>
                <a class="service-card" href="<?= e(url('immigration')) ?>">
                    <span class="service-image-placeholder" aria-hidden="true"></span>
                    <span class="service-title-badge">Make Canada home</span>
                    <span class="service-hover-panel" aria-hidden="true">
                        <strong>Make Canada home</strong>
                        <span class="service-hover-description">Explore possible pathways and get clarity on the process ahead.</span>
                        <span class="service-hover-cta">Explore More</span>
                    </span>
                    <span class="service-explore">Explore more <span aria-hidden="true">→</span></span>
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
    <svg class="schools-flight-accent schools-flight-accent-left" viewBox="0 0 220 150" aria-hidden="true" focusable="false">
        <path class="schools-flight-trail" d="M12 132c35-16 31-52 68-56 26-3 37 19 63 9 19-7 28-22 36-43" />
        <path class="schools-flight-plane" d="m179 13 8 29 25 17c3 2 2 6-2 6l-28-5-15 45c-1 4-7 4-8 0l-6-47-25-12c-4-2-3-7 1-7l25 3 19-30c2-4 6-3 6 1Z" />
    </svg>
    <svg class="schools-flight-accent" viewBox="0 0 220 150" aria-hidden="true" focusable="false">
        <path class="schools-flight-trail" d="M12 132c35-16 31-52 68-56 26-3 37 19 63 9 19-7 28-22 36-43" />
        <path class="schools-flight-plane" d="m179 13 8 29 25 17c3 2 2 6-2 6l-28-5-15 45c-1 4-7 4-8 0l-6-47-25-12c-4-2-3-7 1-7l25 3 19-30c2-4 6-3 6 1Z" />
    </svg>
    <div class="container">
        <?php
            $featuredSchools = array_slice($schools ?? [], 0, 8);
            usort($featuredSchools, static function ($a, $b) {
                $provinceOrder = strnatcasecmp($a['province'] ?? '', $b['province'] ?? '');
                if ($provinceOrder !== 0) {
                    return $provinceOrder;
                }

                $cityOrder = strnatcasecmp($a['city'] ?? '', $b['city'] ?? '');
                return $cityOrder !== 0
                    ? $cityOrder
                    : strnatcasecmp($a['name'] ?? '', $b['name'] ?? '');
            });
            $schoolLocations = [];
            foreach ($featuredSchools as $featuredSchool) {
                $location = trim($featuredSchool['province'] ?? '') ?: 'Canada';
                $schoolLocations[strtolower($location)] = $location;
            }
        ?>
        <div class="section-heading">
            <div><span class="eyebrow">Find your place</span><h2>Canadian schools,<br><em>closer to home.</em></h2></div>
            <a class="text-link" href="<?= e(url('schools')) ?>">Explore schools <span>→</span></a>
        </div>
        <?php if (!empty($featuredSchools)): ?>
            <div class="school-location-filters" role="group" aria-label="Filter schools by province">
                <button class="school-location-filter is-active" type="button" data-school-filter="all" aria-pressed="true">All locations</button>
                <?php foreach ($schoolLocations as $locationKey => $location): ?>
                    <button class="school-location-filter" type="button" data-school-filter="<?= e($locationKey) ?>" aria-pressed="false"><?= e($location) ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="school-grid" data-school-grid>
            <?php foreach ($featuredSchools as $school): ?>
                <?php $schoolLocationKey = strtolower(trim($school['province'] ?? '') ?: 'Canada'); ?>
                <a class="school-card" data-school-location="<?= e($schoolLocationKey) ?>" href="<?= e(url('school/' . $school['slug'])) ?>">
                    <span class="school-province"><?= e($school['province'] ?? 'Canada') ?></span>
                    <?php if (!empty($school['image'])): ?>
                        <img class="school-card-image" src="<?= e(upload_url($school['image'])) ?>" alt="<?= e($school['name']) ?> campus" loading="lazy">
                    <?php else: ?>
                        <div class="school-card-image school-card-image-placeholder" aria-hidden="true"><span>STUDY IN CANADA</span></div>
                    <?php endif; ?>
                    <h3><?= e($school['name'] ?? '') ?></h3>
                    <p><?= e(trim(($school['city'] ?? '') . ', ' . ($school['province'] ?? ''), ', ')) ?></p>
                    <span class="card-link">View institution <span>→</span></span>
                    <span class="school-hover-panel" aria-hidden="true">
                        <strong><?= e($school['name'] ?? '') ?></strong>
                        <span>Explore programs and admissions details at this Canadian institution.</span>
                        <span class="school-hover-action">View institution <span>→</span></span>
                    </span>
                </a>
            <?php endforeach; ?>
            <?php if (empty($featuredSchools)): ?>
                <a class="school-card" href="<?= e(url('schools')) ?>">
                    <span class="school-province">Your possibilities</span><span class="school-monogram">CA</span>
                    <h3>Find the right fit</h3><p>Explore Canadian colleges and universities.</p>
                    <span class="card-link">Browse schools <span>→</span></span>
                    <span class="school-hover-panel" aria-hidden="true">
                        <strong>Find the right fit</strong>
                        <span>Explore Canadian colleges and universities.</span>
                        <span class="school-hover-action">Browse schools <span>→</span></span>
                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($team)): ?>
    <?php
        $teamSpotlight = array_values($team);
        usort($teamSpotlight, static function ($a, $b) {
            $aIsJanine = ($a['slug'] ?? '') === 'janine-tumulak';
            $bIsJanine = ($b['slug'] ?? '') === 'janine-tumulak';
            if ($aIsJanine !== $bIsJanine) {
                return $aIsJanine ? -1 : 1;
            }
            return (int) ($a['sort_order'] ?? 0) <=> (int) ($b['sort_order'] ?? 0);
        });
        $spotlightMember = $teamSpotlight[0];
        $spotlightPhoto = ($spotlightMember['slug'] ?? '') === 'janine-tumulak'
            ? asset('images/janine.png')
            : (!empty($spotlightMember['photo']) ? upload_url($spotlightMember['photo']) : '');
    ?>
    <section class="team-section team-showcase" data-team-showcase>
        <div class="team-showcase-inner">
            <div class="team-feature-visual">
                <?php if ($spotlightPhoto !== ''): ?>
                    <img class="team-feature-image" data-team-feature-image src="<?= e($spotlightPhoto) ?>" alt="<?= e($spotlightMember['full_name']) ?>" loading="lazy">
                <?php else: ?>
                    <div class="team-feature-initial" data-team-feature-initial><?= e(strtoupper(substr($spotlightMember['full_name'], 0, 1))) ?></div>
                <?php endif; ?>
            </div>
            <div class="team-showcase-content">
                <div class="team-showcase-topline">
                    <span class="eyebrow">Meet the team</span>
                    <a class="team-all-link" href="<?= e(url('team')) ?>">Meet our team <span aria-hidden="true">→</span></a>
                </div>
                <h2>We’re here to help you <em>move forward.</em></h2>
                <div class="team-feature-copy" aria-live="polite">
                    <h3 data-team-feature-name><?= e($spotlightMember['full_name']) ?></h3>
                    <p class="team-feature-role" data-team-feature-role><?= e($spotlightMember['position']) ?></p>
                    <p class="team-feature-bio" data-team-feature-bio><?= e($spotlightMember['biography'] ?? 'Our team is here to support your next step.') ?></p>
                </div>
                <div class="team-picker-viewport">
                    <div class="team-member-picker" role="group" aria-label="Meet each team member">
                    <?php foreach ($teamSpotlight as $index => $member): ?>
                        <?php
                            $memberPhoto = ($member['slug'] ?? '') === 'janine-tumulak'
                                ? asset('images/janine.png')
                                : (!empty($member['photo']) ? upload_url($member['photo']) : '');
                        ?>
                        <button class="team-member-choice<?= $index === 0 ? ' is-active' : '' ?>" type="button"
                            data-team-choice
                            data-name="<?= e($member['full_name']) ?>"
                            data-role="<?= e($member['position']) ?>"
                            data-bio="<?= e($member['biography'] ?? 'Our team is here to support your next step.') ?>"
                            data-photo="<?= e($memberPhoto) ?>"
                            aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>">
                            <span class="team-choice-avatar">
                                <?php if ($memberPhoto !== ''): ?>
                                    <img src="<?= e($memberPhoto) ?>" alt="" loading="lazy">
                                <?php else: ?>
                                    <span><?= e(strtoupper(substr($member['full_name'], 0, 1))) ?></span>
                                <?php endif; ?>
                            </span>
                            <span class="team-choice-name"><?= e($member['full_name']) ?></span>
                            <span class="team-choice-role"><?= e($member['position']) ?></span>
                        </button>
                    <?php endforeach; ?>
                    </div>
                </div>
                <div class="team-picker-controls" aria-label="Team carousel controls">
                    <button class="team-picker-arrow" type="button" data-team-prev aria-label="Previous team member">←</button>
                    <div class="team-picker-dots" role="group" aria-label="Choose a team member">
                        <?php foreach ($teamSpotlight as $index => $member): ?>
                            <button type="button" data-team-dot="<?= $index ?>" aria-label="Show <?= e($member['full_name']) ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>" class="<?= $index === 0 ? 'is-active' : '' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <button class="team-picker-arrow" type="button" data-team-next aria-label="Next team member">→</button>
                </div>
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
                <?php foreach (array_slice($events, 0, 3) as $eventIndex => $event): ?>
                    <?php
                        $eventImage = $eventIndex === 0 || empty($event['image'])
                            ? asset('images/event1.jpg')
                            : upload_url($event['image']);
                    ?>
                    <a class="event-row has-image" href="<?= e(url('event/' . $event['slug'])) ?>">
                        <img class="event-thumb" src="<?= e($eventImage) ?>" alt="" loading="lazy">
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
                <?php foreach (array_slice($posts, 0, 3) as $postIndex => $post): ?>
                    <a class="news-card" href="<?= e(url('blog/' . $post['slug'])) ?>">
                        <?php $newsImage = $postIndex === 0 || empty($post['featured_image']) ? asset('images/fscanadaph.png') : upload_url($post['featured_image']); ?>
                        <img src="<?= e($newsImage) ?>" alt="" loading="lazy">
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
            <span class="eyebrow">Client stories</span>
            <div class="testimonial-carousel" data-testimonial-carousel aria-label="Client stories carousel">
                <span class="quote-mark" aria-hidden="true">“</span>
                <div class="testimonial-slides" aria-live="off">
                    <?php foreach (array_slice($testimonials, 0, 5) as $index => $testimonial): ?>
                        <article class="testimonial-slide<?= $index === 0 ? ' is-active' : '' ?>" data-testimonial-slide aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>">
                            <blockquote><?= e($testimonial['quote']) ?></blockquote>
                            <span class="testimonial-attribution">
                                <strong><?= e($testimonial['client_name']) ?></strong>
                                <?php if (!empty($testimonial['service_label'])): ?><span><?= e($testimonial['service_label']) ?></span><?php endif; ?>
                            </span>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="testimonial-controls" aria-label="Client story controls">
                    <button type="button" data-testimonial-prev aria-label="Previous client story">←</button>
                    <div class="testimonial-dots" role="group" aria-label="Choose a client story">
                        <?php foreach (array_slice($testimonials, 0, 5) as $index => $testimonial): ?>
                            <button type="button" data-testimonial-dot="<?= $index ?>" aria-label="Show client story <?= $index + 1 ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>" class="<?= $index === 0 ? 'is-active' : '' ?>"></button>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" data-testimonial-next aria-label="Next client story">→</button>
                </div>
            </div>
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
