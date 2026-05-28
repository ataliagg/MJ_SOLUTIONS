(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav-links');
  if (!toggle || !nav) return;

  const mq = window.matchMedia('(max-width: 768px)');
  const isMobile = () => mq.matches;

  function closeDropdowns() {
    document.querySelectorAll('.dropdown').forEach((dd) => {
      dd.classList.remove('is-open');
      const btn = dd.querySelector('.dropdown-toggle');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    });
  }

  function closeMenu() {
    nav.classList.remove('active');
    toggle.setAttribute('aria-expanded', 'false');
    closeDropdowns();
  }

  function openMenu() {
    nav.classList.add('active');
    toggle.setAttribute('aria-expanded', 'true');
  }

  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    if (!isMobile()) return;
    if (nav.classList.contains('active')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  // Dropdown toggles on mobile (click-to-open)
  document.querySelectorAll('.dropdown-toggle').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      if (!isMobile()) return;
      e.preventDefault();
      e.stopPropagation();

      const parent = btn.closest('.dropdown');
      if (!parent) return;

      const nowOpen = parent.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', nowOpen ? 'true' : 'false');

      // Close other dropdowns
      document.querySelectorAll('.dropdown').forEach((dd) => {
        if (dd !== parent) {
          dd.classList.remove('is-open');
          const otherBtn = dd.querySelector('.dropdown-toggle');
          if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        }
      });
    });
  });

  // Close menu after selecting a link (mobile)
  nav.querySelectorAll('a').forEach((a) => {
    a.addEventListener('click', () => {
      if (isMobile()) closeMenu();
    });
  });

  // Close on outside click (mobile)
  document.addEventListener('click', () => {
    if (isMobile()) closeMenu();
  });

  // Reset when switching to desktop
  mq.addEventListener('change', () => {
    if (!isMobile()) {
      nav.classList.remove('active');
      toggle.setAttribute('aria-expanded', 'false');
      closeDropdowns();
    }
  });
})();
