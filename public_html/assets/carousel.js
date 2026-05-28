/* MJ Cleaning Solutions — Our Work Carousel */
(function () {
  function initCarousel(root) {
    const track = root.querySelector('.carousel-track');
    const slides = Array.from(root.querySelectorAll('.carousel-slide'));
    const prevBtn = root.querySelector('[data-carousel-prev]');
    const nextBtn = root.querySelector('[data-carousel-next]');
    const dotsWrap = root.querySelector('.carousel-dots');

    if (!track || slides.length === 0) return;

    let index = 0;
    root.setAttribute('data-count', String(slides.length));

    function update() {
      track.style.transform = `translate3d(-${index * 100}%, 0, 0)`;

      if (dotsWrap) {
        dotsWrap.querySelectorAll('.carousel-dot').forEach((dot, i) => {
          dot.setAttribute('aria-current', i === index ? 'true' : 'false');
        });
      }
    }

    function goNext(event) {
      if (event) event.preventDefault();
      index = (index + 1) % slides.length;
      update();
    }

    function goPrev(event) {
      if (event) event.preventDefault();
      index = (index - 1 + slides.length) % slides.length;
      update();
    }

    if (prevBtn) prevBtn.addEventListener('click', goPrev);
    if (nextBtn) nextBtn.addEventListener('click', goNext);

    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'carousel-dot';
        dot.setAttribute('aria-label', `Go to image ${i + 1}`);
        dot.addEventListener('click', function () {
          index = i;
          update();
        });
        dotsWrap.appendChild(dot);
      });
    }

    update();
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-carousel]').forEach(initCarousel);
  });
})();
