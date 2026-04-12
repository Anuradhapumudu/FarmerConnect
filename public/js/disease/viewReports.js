document.addEventListener('DOMContentLoaded', function () {
    // Stagger card animations
    const cards = document.querySelectorAll('.mr-card');
    cards.forEach((card, i) => {
        card.style.animationDelay = (0.15 + i * 0.06) + 's';
    });
});
