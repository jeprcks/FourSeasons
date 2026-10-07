(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.primary-nav');
  if (!toggle || !nav) return;
  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(open));
    nav.classList.toggle('is-open', open);
  });
  nav.querySelectorAll('.has-children > a').forEach((link) => {
    link.addEventListener('click', (event) => {
      if (window.matchMedia('(min-width: 1151px)').matches) return;
      const item = link.parentElement;
      if (!item.classList.contains('is-open')) {
        event.preventDefault();
        nav.querySelectorAll('.has-children.is-open').forEach((openItem) => {
          openItem.classList.remove('is-open');
          openItem.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
        });
        item.classList.add('is-open');
        link.setAttribute('aria-expanded', 'true');
      } else {
        item.classList.remove('is-open');
        link.setAttribute('aria-expanded', 'false');
      }
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    toggle.setAttribute('aria-expanded', 'false');
    nav.classList.remove('is-open');
    nav.querySelectorAll('.has-children.is-open').forEach((item) => {
      item.classList.remove('is-open');
      item.querySelector(':scope > a')?.setAttribute('aria-expanded', 'false');
    });
  });

  window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 1151px)').matches) {
      toggle.setAttribute('aria-expanded', 'false');
      nav.classList.remove('is-open');
      nav.querySelectorAll('.has-children.is-open').forEach((item) => item.classList.remove('is-open'));
    }
  });

  document.querySelectorAll('[data-hero-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-hero-slide]')];
    const dots = [...carousel.querySelectorAll('[data-hero-dot]')];
    const previous = carousel.querySelector('[data-hero-prev]');
    const next = carousel.querySelector('[data-hero-next]');
    const current = carousel.querySelector('[data-hero-current]');
    if (slides.length !== 3 || dots.length !== slides.length || !previous || !next) return;

    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    let rotationTimer;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    const showSlide = (index) => {
      activeIndex = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const active = slideIndex === activeIndex;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => {
        dot.setAttribute('aria-pressed', String(dotIndex === activeIndex));
      });
      if (current) current.textContent = String(activeIndex + 1).padStart(2, '0');
    };

    const stopRotation = () => {
      window.clearInterval(rotationTimer);
    };
    const startRotation = () => {
      stopRotation();
      if (reducedMotion.matches || document.hidden) return;
      rotationTimer = window.setInterval(() => showSlide(activeIndex + 1), 3000);
    };

    previous.addEventListener('click', () => {
      showSlide(activeIndex - 1);
      startRotation();
    });
    next.addEventListener('click', () => {
      showSlide(activeIndex + 1);
      startRotation();
    });
    dots.forEach((dot) => {
      dot.addEventListener('click', () => {
        showSlide(Number(dot.dataset.heroDot));
        startRotation();
      });
    });

    carousel.addEventListener('pointerenter', stopRotation);
    carousel.addEventListener('pointerleave', startRotation);
    carousel.addEventListener('focusin', stopRotation);
    carousel.addEventListener('focusout', (event) => {
      if (!carousel.contains(event.relatedTarget)) startRotation();
    });
    document.addEventListener('visibilitychange', startRotation);
    reducedMotion.addEventListener?.('change', startRotation);
    showSlide(activeIndex);
    startRotation();
  });

  document.querySelectorAll('[data-journey-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-journey-slide]')];
    const dots = [...carousel.querySelectorAll('[data-journey-dot]')];
    const current = carousel.querySelector('[data-journey-current]');
    if (!slides.length || dots.length !== slides.length) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    let rotationTimer;
    let isHovered = false;
    let hasFocus = false;

    const showSlide = (index) => {
      activeIndex = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const active = slideIndex === activeIndex;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => {
        dot.setAttribute('aria-pressed', String(dotIndex === activeIndex));
      });
      if (current) current.textContent = String(activeIndex + 1).padStart(2, '0');
    };

    const stopRotation = () => window.clearInterval(rotationTimer);
    const startRotation = () => {
      stopRotation();
      if (reducedMotion.matches || document.hidden || isHovered || hasFocus) return;
      rotationTimer = window.setInterval(() => showSlide(activeIndex + 1), 5000);
    };

    dots.forEach((dot) => {
      dot.addEventListener('click', () => {
        showSlide(Number(dot.dataset.journeyDot));
        startRotation();
      });
    });
    carousel.addEventListener('pointerenter', () => {
      isHovered = true;
      stopRotation();
    });
    carousel.addEventListener('pointerleave', () => {
      isHovered = false;
      startRotation();
    });
    carousel.addEventListener('focusin', () => {
      hasFocus = true;
      stopRotation();
    });
    carousel.addEventListener('focusout', (event) => {
      if (carousel.contains(event.relatedTarget)) return;
      hasFocus = false;
      startRotation();
    });
    document.addEventListener('visibilitychange', startRotation);
    reducedMotion.addEventListener?.('change', startRotation);
    showSlide(activeIndex);
    startRotation();
  });

  document.querySelectorAll('[data-inquiry-form]').forEach((form) => {
    const feedback = form.querySelector('.form-feedback');
    form.querySelectorAll('input,select,textarea').forEach((field) => {
      if (field.type === 'hidden' || field.type === 'checkbox') return;
      field.addEventListener('blur', () => {
        field.classList.toggle('field-invalid', !field.checkValidity());
        field.classList.toggle('field-valid', field.checkValidity() && field.value.trim() !== '');
      });
      field.addEventListener('input', () => {
        if (field.classList.contains('field-invalid') || field.classList.contains('field-valid')) {
          field.classList.toggle('field-invalid', !field.checkValidity());
          field.classList.toggle('field-valid', field.checkValidity() && field.value.trim() !== '');
        }
      });
    });
    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      if (!form.reportValidity()) return;
      if (feedback) feedback.textContent = 'Sending your message…';
      try {
        const response = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
        const result = await response.json();
        if (!response.ok || !result.ok) throw new Error(result.message || 'Please check the information and try again.');
        form.reset();
        form.querySelectorAll('.field-valid,.field-invalid').forEach((field) => field.classList.remove('field-valid','field-invalid'));
        if (feedback) feedback.textContent = result.message || 'Thank you. We’ll be in touch soon.';
      } catch (error) {
        if (feedback) feedback.textContent = error.message || 'We could not send your message. Please try again.';
      }
    });
  });

  document.querySelectorAll('[data-credibility-carousel]').forEach((carousel) => {
    const viewport = carousel.querySelector('[data-credibility-viewport]');
    const cards = carousel.querySelectorAll('.credibility-card');
    const previous = carousel.querySelector('[data-credibility-prev]');
    const next = carousel.querySelector('[data-credibility-next]');
    if (!viewport || !cards.length || !previous || !next) return;
    const step = () => {
      const styles = window.getComputedStyle(viewport.querySelector('.credibility-track'));
      const gap = parseFloat(styles.columnGap || styles.gap) || 0;
      return cards[0].getBoundingClientRect().width + gap;
    };
    previous.addEventListener('click', () => {
      if (viewport.scrollLeft <= 1) viewport.scrollTo({ left: viewport.scrollWidth, behavior: 'smooth' });
      else viewport.scrollBy({ left: -step(), behavior: 'smooth' });
    });
    next.addEventListener('click', () => {
      if (viewport.scrollLeft + viewport.clientWidth >= viewport.scrollWidth - 2) viewport.scrollTo({ left: 0, behavior: 'smooth' });
      else viewport.scrollBy({ left: step(), behavior: 'smooth' });
    });
  });

  const revealTargets = document.querySelectorAll(
    '.mission-grid > *, .service-card, .school-card, .team-card, .event-row, .news-card, .stat-item, .credibility-card'
  );
  if ('IntersectionObserver' in window && revealTargets.length) {
    document.documentElement.classList.add('has-reveal');
    revealTargets.forEach((element, index) => {
      element.setAttribute('data-reveal', '');
      element.style.transitionDelay = `${Math.min(index % 4, 3) * 70}ms`;
    });
    const revealObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        const stat = entry.target.querySelector('.stat-item strong');
        if (stat && !stat.dataset.counterDone) {
          stat.dataset.counterDone = 'true';
          const original = stat.textContent.trim();
          const match = original.match(/^(\D*)([\d,]+)(.*)$/);
          if (match) {
            const target = Number(match[2].replaceAll(',', ''));
            const prefix = match[1];
            const suffix = match[3];
            const started = performance.now();
            const duration = 850;
            const tick = (now) => {
              const progress = Math.min((now - started) / duration, 1);
              const eased = 1 - Math.pow(1 - progress, 3);
              const value = Math.round(target * eased).toLocaleString('en-CA');
              stat.textContent = `${prefix}${value}${suffix}`;
              if (progress < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
          }
        }
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12 });
    revealTargets.forEach((element) => revealObserver.observe(element));
  }
})();
