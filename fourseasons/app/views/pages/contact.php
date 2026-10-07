<?php
$heading = 'Let’s start a conversation.';
$lead = 'Tell us a little about what brings you here. Our team will follow up with a thoughtful next step.';
$crumb = 'Contact';
require APP_PATH . '/views/Mission/Vision/page-hero.php';
?>

<section class="section-pad">
    <div class="container contact-layout">
        <div>
            <span class="eyebrow">We’re here to listen</span>
            <h2 class="contact-title">A good plan starts<br><em>with a question.</em></h2>
            <p>Reach our team by phone or email, or send a note using the form. We’ll get back to you as soon as we can.</p>
            <p>
                <a href="tel:+16477613002">+1 647 761 3002</a><br>
                <a href="mailto:info@four-seasons.ca">info@four-seasons.ca</a>
            </p>
        </div>

        <form
            class="form-panel"
            action="<?= e(url('inquiry')) ?>"
            method="post"
            data-inquiry-form
        >
            <?= csrf_field() ?>
            <input
                type="hidden"
                name="source_page"
                value="<?= e($_SERVER['REQUEST_URI'] ?? '/contact') ?>"
            >

            <div class="form-grid">
                <div class="form-field">
                    <label for="full_name">Full name *</label>
                    <input id="full_name" name="full_name" required maxlength="100" autocomplete="name">
                </div>
                <div class="form-field">
                    <label for="email">Email *</label>
                    <input id="email" name="email" type="email" required maxlength="190" autocomplete="email">
                </div>
                <div class="form-field">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" type="tel" maxlength="20" autocomplete="tel">
                </div>
                <div class="form-field">
                    <label for="whatsapp">WhatsApp or Viber</label>
                    <input id="whatsapp" name="whatsapp" type="tel" maxlength="20">
                </div>
                <div class="form-field">
                    <label for="location">City and country *</label>
                    <input id="location" name="location" required maxlength="180" placeholder="e.g. Manila, Philippines">
                </div>
                <div class="form-field">
                    <label for="service_id">I’m interested in *</label>
                    <select id="service_id" name="service_id" required>
                        <option value="">Choose a service</option>
                        <?php foreach (($inquiryServices ?? []) as $service): ?>
                            <option value="<?= (int) $service['id'] ?>">
                                <?= e($service['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="preferred_contact">Preferred contact</label>
                    <select id="preferred_contact" name="preferred_contact">
                        <option>Phone</option>
                        <option>Email</option>
                        <option>WhatsApp</option>
                        <option>Viber</option>
                    </select>
                </div>
                <div class="form-field wide">
                    <label for="message">How can we help?</label>
                    <textarea id="message" name="message" maxlength="2000"></textarea>
                </div>
                <div class="form-field wide consent-field">
                    <label>
                        <input type="checkbox" name="consent" value="1" required>
                        I agree that Four Seasons Canada may contact me about this inquiry.
                    </label>
                </div>
                <div class="form-field wide">
                    <button class="button" type="submit">
                        Send inquiry <span aria-hidden="true">↗</span>
                    </button>
                    <p class="form-feedback" aria-live="polite"></p>
                </div>
            </div>
        </form>
    </div>
</section>
