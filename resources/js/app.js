import './bootstrap';

document.querySelectorAll('[data-blog-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-carousel-track]');

    if (!(track instanceof HTMLElement)) {
        return;
    }

    carousel.querySelectorAll('[data-carousel-prev], [data-carousel-next]').forEach((button) => {
        button.addEventListener('click', () => {
            const direction = button.hasAttribute('data-carousel-next') ? 1 : -1;
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            track.scrollBy({
                left: direction * Math.min(track.clientWidth * 0.85, 640),
                behavior: reducedMotion ? 'auto' : 'smooth',
            });
        });
    });
});
