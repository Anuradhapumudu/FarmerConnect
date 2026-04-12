// Stagger card animation delays
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.mc-card');
    cards.forEach((card, i) => {
        card.style.animationDelay = (0.15 + i * 0.06) + 's';
    });
});
