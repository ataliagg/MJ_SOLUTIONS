/*
  MJ Cleaning Solutions — Our Work Carousel
  Lightweight, dependency-free carousel for project image galleries.
*/

(function () {
  function clamp(n, min, max) {
    return Math.max(min, Math.min(max, n));
  }

  function initCarousel(root) {
    const track = root.querySelector('.carousel-track');
    const slides = Array.from(root.querySelectorAll('.carousel-slide'));
    const prevBtn = root.querySelector('[data-carousel-prev]');
    const nextBtn = root.querySelector('[data-carousel-next]');
    const dotsWrap = root.querySelector('.carousel-dots');
    if (!track || slides.length === 0) return;

    root.setAttribute('data-count', String(slides.length));

    let index = 0;

    function renderDots() {
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      slides.forEach((_, i) => {
        const b = document.createElement('button');
        b.className = 'carousel-dot';
        b.type = 'button';
        b.setAttribute('aria-label', `Go to image ${i + 1}`);
        b.setAttribute('aria-current', i === index ? 'true' : 'false');
        b.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(b);
      });
    }

    function update() {
      track.style.transform = `translateX(-${index * 100}%)`;
      if (dotsWrap) {
        const dots = Array.from(dotsWrap.querySelectorAll('.carousel-dot'));
        dots.forEach((d, i) => d.setAttribute('aria-current', i === index ? 'true' : 'false'));
      }
      if (prevBtn) prevBtn.disabled = slides.length <= 1;
      if (nextBtn) nextBtn.disabled = slides.length <= 1;
    }

    function goTo(i) {
      index = clamp(i, 0, slides.length - 1);
      update();
    }

    function next() {
      index = (index + 1) % slides.length;
      update();
    }

    function prev() {
      index = (index - 1 + slides.length) % slides.length;
      update();
    }

    // Buttons
    if (prevBtn) prevBtn.addEventListener('click', prev);
    if (nextBtn) nextBtn.addEventListener('click', next);

    // Keyboard
    root.addEventListener('keydown', (e) => {
      if (slides.length <= 1) return;
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        prev();
      }
      if (e.key === 'ArrowRight') {
        e.preventDefault();
        next();
      }
    });

    // Swipe (touch/pointer)
    let startX = 0;
    let dragging = false;

    root.addEventListener('pointerdown', (e) => {
      if (slides.length <= 1) return;
      dragging = true;
      startX = e.clientX;
      root.setPointerCapture(e.pointerId);
    });

    root.addEventListener('pointerup', (e) => {
      if (!dragging) return;
      dragging = false;
      const dx = e.clientX - startX;
      if (Math.abs(dx) > 40) {
        dx < 0 ? next() : prev();
      }
    });

    root.addEventListener('pointercancel', () => { dragging = false; });

    // Init
    renderDots();
    update();
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-carousel]').forEach(initCarousel);
  });
})();
