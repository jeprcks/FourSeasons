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
    if (!slides.length || dots.length !== slides.length || !previous || !next) return;

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
    const track = carousel.querySelector('.credibility-track');
    const cards = [...carousel.querySelectorAll('.credibility-card')];
    if (!viewport || !track || !cards.length) return;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const originals = cards.map((card) => card.cloneNode(true));
    originals.forEach((card) => {
      card.setAttribute('aria-hidden', 'true');
      card.querySelectorAll('[id]').forEach((element) => element.removeAttribute('id'));
      track.append(card);
    });
    let frameId;
    let previousFrameTime = 0;
    let isHovered = false;
    let hasFocus = false;
    const loopWidth = () => track.scrollWidth / 2;
    const stopAnimation = () => {
      window.cancelAnimationFrame(frameId);
      frameId = undefined;
      previousFrameTime = 0;
    };
    const animate = (time) => {
      if (!previousFrameTime) previousFrameTime = time;
      const elapsed = Math.min(time - previousFrameTime, 40);
      previousFrameTime = time;
      const width = loopWidth();
      if (width > 0) {
        viewport.scrollLeft += elapsed * .045;
        if (viewport.scrollLeft >= width) viewport.scrollLeft -= width;
      }
      frameId = window.requestAnimationFrame(animate);
    };
    const startAnimation = () => {
      stopAnimation();
      if (document.hidden || isHovered || hasFocus || reducedMotion.matches) return;
      frameId = window.requestAnimationFrame(animate);
    };
    carousel.addEventListener('pointerenter', () => {
      isHovered = true;
      stopAnimation();
    });
    carousel.addEventListener('pointerleave', () => {
      isHovered = false;
      startAnimation();
    });
    carousel.addEventListener('focusin', () => {
      hasFocus = true;
      stopAnimation();
    });
    carousel.addEventListener('focusout', (event) => {
      if (carousel.contains(event.relatedTarget)) return;
      hasFocus = false;
      startAnimation();
    });
    document.addEventListener('visibilitychange', startAnimation);
    reducedMotion.addEventListener?.('change', startAnimation);
    startAnimation();
  });

  const revealTargets = document.querySelectorAll(
    '.intro-grid > *, .mission-grid > *, .section-heading > div, .services-heading, .credibility-heading, .service-card, .school-card, .team-feature-visual, .team-showcase-content, .event-row, .news-card, .stat-item, .credibility-card, .quote-inner, .contact-band-inner > *'
  );
  if ('IntersectionObserver' in window && revealTargets.length) {
    document.documentElement.classList.add('has-reveal');
    revealTargets.forEach((element, index) => {
      const bounds = element.getBoundingClientRect();
      const elementCenter = bounds.left + bounds.width / 2;
      const sideThreshold = window.innerWidth * 0.46;
      const direction = elementCenter < sideThreshold
        ? 'left'
        : elementCenter > window.innerWidth - sideThreshold
          ? 'right'
          : 'up';
      element.setAttribute('data-reveal', direction);
      element.style.transitionDelay = `${Math.min(index % 4, 3) * 100}ms`;
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

  document.querySelectorAll('.schools-section').forEach((section) => {
    const filters = [...section.querySelectorAll('[data-school-filter]')];
    const cards = [...section.querySelectorAll('[data-school-location]')];
    if (!filters.length || !cards.length) return;

    filters.forEach((filter) => {
      filter.addEventListener('click', () => {
        const selectedLocation = filter.dataset.schoolFilter;
        filters.forEach((button) => {
          const active = button === filter;
          button.classList.toggle('is-active', active);
          button.setAttribute('aria-pressed', String(active));
        });
        cards.forEach((card) => {
          const visible = selectedLocation === 'all' || card.dataset.schoolLocation === selectedLocation;
          card.hidden = !visible;
          if (visible) card.classList.add('is-visible');
        });
      });
    });
  });

  document.querySelectorAll('[data-team-showcase]').forEach((showcase) => {
    const choices = [...showcase.querySelectorAll('[data-team-choice]')];
    const visual = showcase.querySelector('.team-feature-visual');
    const picker = showcase.querySelector('.team-member-picker');
    const pickerViewport = showcase.querySelector('.team-picker-viewport');
    const name = showcase.querySelector('[data-team-feature-name]');
    const role = showcase.querySelector('[data-team-feature-role]');
    const bio = showcase.querySelector('[data-team-feature-bio]');
    const dots = [...showcase.querySelectorAll('[data-team-dot]')];
    const previous = showcase.querySelector('[data-team-prev]');
    const next = showcase.querySelector('[data-team-next]');
    if (!choices.length || !visual || !name || !role || !bio || !picker || !pickerViewport) return;

    let activeIndex = Math.max(0, choices.findIndex((choice) => choice.classList.contains('is-active')));
    const showMember = (index) => {
      activeIndex = (index + choices.length) % choices.length;
      const choice = choices[activeIndex];
      const fullName = choice.dataset.name || '';
      const photo = choice.dataset.photo || '';
      let image = visual.querySelector('[data-team-feature-image]');
      let initial = visual.querySelector('[data-team-feature-initial]');

      name.textContent = fullName;
      role.textContent = choice.dataset.role || '';
      bio.textContent = choice.dataset.bio || '';
      if (photo) {
        if (!image) {
          image = document.createElement('img');
          image.className = 'team-feature-image';
          image.dataset.teamFeatureImage = '';
          visual.prepend(image);
        }
        image.src = photo;
        image.alt = fullName;
        image.hidden = false;
        if (initial) initial.hidden = true;
      } else {
        if (!initial) {
          initial = document.createElement('div');
          initial.className = 'team-feature-initial';
          initial.dataset.teamFeatureInitial = '';
          visual.append(initial);
        }
        initial.textContent = fullName.charAt(0).toUpperCase();
        initial.hidden = false;
        if (image) image.hidden = true;
      }

      choices.forEach((button, buttonIndex) => {
        const active = buttonIndex === activeIndex;
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', String(active));
      });
      dots.forEach((dot, dotIndex) => {
        const active = dotIndex === activeIndex;
        dot.classList.toggle('is-active', active);
        dot.setAttribute('aria-pressed', String(active));
      });

      const visibleCount = Math.max(1, Math.floor(pickerViewport.clientWidth / (choices[0].getBoundingClientRect().width + 12)));
      const maxStart = Math.max(0, choices.length - visibleCount);
      const start = Math.max(0, Math.min(activeIndex, maxStart));
      const cardGap = Number.parseFloat(getComputedStyle(picker).gap) || 12;
      const cardWidth = choices[0].getBoundingClientRect().width;
      picker.style.transform = `translateX(-${start * (cardWidth + cardGap)}px)`;
    };

    choices.forEach((choice, index) => choice.addEventListener('click', () => showMember(index)));
    dots.forEach((dot, index) => dot.addEventListener('click', () => showMember(index)));
    previous?.addEventListener('click', () => showMember(activeIndex - 1));
    next?.addEventListener('click', () => showMember(activeIndex + 1));
    window.addEventListener('resize', () => showMember(activeIndex));

    window.setInterval(() => {
      const bounds = showcase.getBoundingClientRect();
      const inView = bounds.top < window.innerHeight && bounds.bottom > 0;
      if (!inView || document.hidden || showcase.matches(':hover') || showcase.contains(document.activeElement) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      showMember(activeIndex + 1);
    }, 6500);
    showMember(activeIndex);
  });

  document.querySelectorAll('[data-testimonial-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-testimonial-slide]')];
    const dots = [...carousel.querySelectorAll('[data-testimonial-dot]')];
    const previous = carousel.querySelector('[data-testimonial-prev]');
    const next = carousel.querySelector('[data-testimonial-next]');
    if (slides.length < 2 || dots.length !== slides.length) return;

    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    const showSlide = (index) => {
      activeIndex = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const active = slideIndex === activeIndex;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', String(!active));
      });
      dots.forEach((dot, dotIndex) => {
        const active = dotIndex === activeIndex;
        dot.classList.toggle('is-active', active);
        dot.setAttribute('aria-pressed', String(active));
      });
    };

    dots.forEach((dot, index) => dot.addEventListener('click', () => showSlide(index)));
    previous?.addEventListener('click', () => showSlide(activeIndex - 1));
    next?.addEventListener('click', () => showSlide(activeIndex + 1));
    window.setInterval(() => {
      const bounds = carousel.getBoundingClientRect();
      const visible = bounds.top < window.innerHeight && bounds.bottom > 0;
      if (!visible || document.hidden || carousel.matches(':hover') || carousel.contains(document.activeElement) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      showSlide(activeIndex + 1);
    }, 3000);
  });
})();
