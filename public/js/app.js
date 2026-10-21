(() => {
  const nav = document.getElementById('siteNav');
  const navToggle = document.getElementById('navToggle');

  const setNavOpen = (open) => {
    nav?.classList.toggle('open', open);
    navToggle?.setAttribute('aria-expanded', String(open));
  };

  navToggle?.addEventListener('click', () => setNavOpen(!nav?.classList.contains('open')));
  nav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setNavOpen(false)));
  window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') setNavOpen(false);
  });

  const revealItems = [...document.querySelectorAll('.reveal')];
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const scrollCards = [...document.querySelectorAll('[data-scroll-spin]')];
  let refreshScrollCards = () => {};
  if (scrollCards.length && !reducedMotion) {
    let scrollFrame = 0;
    const updateScrollCards = () => {
      const viewportHeight = window.innerHeight || document.documentElement.clientHeight;
      scrollCards.forEach((card) => {
        const rect = card.getBoundingClientRect();
        const rawProgress = card.dataset.scrollSpin === 'hero'
          ? window.scrollY / Math.min(viewportHeight * 0.72, 560)
          : (viewportHeight - rect.top) / (viewportHeight + rect.height);
        const progress = Math.max(0, Math.min(1, rawProgress));
        const easedProgress = (1 - Math.cos(progress * Math.PI)) / 2;
        const smoothStep = (value) => value * value * (3 - 2 * value);
        let spin = easedProgress * 18;
        if (card.dataset.scrollSpin !== 'hero') {
          if (progress < 0.15) spin = 180 * (1 - smoothStep(progress / 0.15));
          else if (progress > 0.85) spin = -180 * smoothStep((progress - 0.85) / 0.15);
          else spin = 0;
        }
        const depth = Math.sin(progress * Math.PI) * 30;
        const tilt = (0.5 - progress) * 8;
        const roll = Math.sin(progress * Math.PI * 2) * 2;
        card.style.setProperty('--scroll-spin', `${spin.toFixed(2)}deg`);
        card.style.setProperty('--scroll-depth', `${depth.toFixed(2)}px`);
        card.style.setProperty('--scroll-tilt', `${tilt.toFixed(2)}deg`);
        card.style.setProperty('--scroll-roll', `${roll.toFixed(2)}deg`);
      });
      scrollFrame = 0;
    };
    const requestScrollUpdate = () => {
      if (scrollFrame) return;
      scrollFrame = window.requestAnimationFrame(updateScrollCards);
    };

    refreshScrollCards = requestScrollUpdate;
    updateScrollCards();
    window.addEventListener('scroll', requestScrollUpdate, { passive: true });
    window.addEventListener('resize', requestScrollUpdate, { passive: true });

    if (window.matchMedia('(hover: hover)').matches) {
      scrollCards.forEach((card) => {
        card.addEventListener('pointermove', (event) => {
          if (event.pointerType !== 'mouse') return;
          const rect = card.getBoundingClientRect();
          const x = (event.clientX - rect.left) / rect.width - 0.5;
          const y = (event.clientY - rect.top) / rect.height - 0.5;
          card.style.setProperty('--pointer-tilt-x', `${(-y * 10).toFixed(2)}deg`);
          card.style.setProperty('--pointer-tilt-y', `${(x * 12).toFixed(2)}deg`);
        });
        card.addEventListener('pointerleave', () => {
          card.style.setProperty('--pointer-tilt-x', '0deg');
          card.style.setProperty('--pointer-tilt-y', '0deg');
        });
      });
    }
  }

  document.querySelectorAll('[data-skill-carousel]').forEach((carousel) => {
    const slides = [...carousel.querySelectorAll('[data-skill-slide]')];
    if (!slides.length) return;

    const currentLabel = carousel.querySelector('[data-skill-current]');
    const progressBar = carousel.querySelector('[data-skill-progress]');
    const previousButton = carousel.querySelector('[data-skill-prev]');
    const nextButton = carousel.querySelector('[data-skill-next]');
    const toggleButton = carousel.querySelector('[data-skill-toggle]');
    const interval = Math.max(1000, Number(carousel.dataset.interval || 3000));
    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-orbit-top')));
    let timer = null;
    let paused = false;

    const updateOrbit = () => {
      slides.forEach((slide, index) => {
        const offset = (index - activeIndex + slides.length) % slides.length;
        const position = offset === 0 ? 'top' : offset === 1 ? 'right' : offset === slides.length - 1 && slides.length > 2 ? 'left' : 'hidden';
        slide.classList.remove('is-orbit-top', 'is-orbit-right', 'is-orbit-left', 'is-orbit-hidden');
        slide.classList.add(`is-orbit-${position}`);
        slide.setAttribute('aria-hidden', String(position === 'hidden'));
      });
      if (currentLabel) currentLabel.textContent = String(activeIndex + 1).padStart(2, '0');
      if (progressBar) progressBar.style.transform = `scaleX(${(activeIndex + 1) / slides.length})`;
    };

    const showSlide = (requestedIndex) => {
      activeIndex = ((requestedIndex % slides.length) + slides.length) % slides.length;
      updateOrbit();
    };

    const stopTimer = () => {
      if (timer) window.clearInterval(timer);
      timer = null;
    };
    const startTimer = () => {
      stopTimer();
      if (paused || reducedMotion || slides.length < 2) return;
      timer = window.setInterval(() => showSlide(activeIndex + 1), interval);
    };

    updateOrbit();
    previousButton?.addEventListener('click', () => { showSlide(activeIndex - 1); startTimer(); });
    nextButton?.addEventListener('click', () => { showSlide(activeIndex + 1); startTimer(); });
    toggleButton?.addEventListener('click', () => {
      paused = !paused;
      toggleButton.setAttribute('aria-pressed', String(paused));
      toggleButton.setAttribute('aria-label', paused ? 'Resume skill rotation' : 'Pause skill rotation');
      toggleButton.textContent = paused ? '▶' : 'Ⅱ';
      startTimer();
    });
    startTimer();
  });

  if (reducedMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach((item) => item.classList.add('is-visible'));
  } else {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const delay = Math.max(0, Math.min(Number(entry.target.dataset.delay || 0), 400));
        window.setTimeout(() => entry.target.classList.add('is-visible'), delay);
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealItems.forEach((item) => observer.observe(item));
  }

  const typewriter = document.querySelector('.typewriter[data-roles]');
  if (typewriter && !reducedMotion) {
    let roles = [];
    try {
      roles = JSON.parse(typewriter.dataset.roles || '[]').filter(Boolean);
    } catch (_) {
      roles = [];
    }

    if (roles.length > 1) {
      let roleIndex = 0;
      let deleting = true;
      const animateRole = () => {
        const nextRole = roles[roleIndex % roles.length];
        const currentText = typewriter.textContent || '';

        if (deleting && currentText.length > 0) {
          typewriter.textContent = currentText.slice(0, -1);
          window.setTimeout(animateRole, 32);
          return;
        }

        if (deleting) {
          roleIndex = (roleIndex + 1) % roles.length;
          deleting = false;
        }

        const targetRole = roles[roleIndex];
        const typedText = typewriter.textContent || '';
        if (typedText.length < targetRole.length) {
          typewriter.textContent = targetRole.slice(0, typedText.length + 1);
          window.setTimeout(animateRole, 74);
          return;
        }

        deleting = true;
        window.setTimeout(animateRole, 1550);
      };
      window.setTimeout(animateRole, 1800);
    }
  }

  const filterButtons = [...document.querySelectorAll('[data-filter]')];
  const projectCards = [...document.querySelectorAll('.portfolio-card[data-project]')];
  filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter || 'all';
      filterButtons.forEach((item) => {
        const selected = item === button;
        item.classList.toggle('active', selected);
        item.setAttribute('aria-pressed', String(selected));
      });
      projectCards.forEach((card) => {
        const matches = filter === 'all' || (card.dataset.project || '').includes(filter);
        card.classList.toggle('filtered-out', !matches);
      });
      refreshScrollCards();
    });
  });
})();
