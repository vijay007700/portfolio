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
  const canTilt = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
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

  if (!reducedMotion && canTilt) {
    document.querySelectorAll('.project-card[data-tilt]').forEach((card) => {
      card.addEventListener('pointermove', (event) => {
        const bounds = card.getBoundingClientRect();
        const x = (event.clientX - bounds.left) / bounds.width;
        const y = (event.clientY - bounds.top) / bounds.height;
        card.style.setProperty('--tilt-x', `${(0.5 - y) * 5}deg`);
        card.style.setProperty('--tilt-y', `${(x - 0.5) * 7}deg`);
      });
      const resetTilt = () => {
        card.style.setProperty('--tilt-x', '0deg');
        card.style.setProperty('--tilt-y', '0deg');
      };
      card.addEventListener('pointerleave', resetTilt);
      card.addEventListener('pointercancel', resetTilt);
    });
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
    });
  });
})();
