document.addEventListener('DOMContentLoaded', function () {
    // Stagger card animations
    const cards = document.querySelectorAll('.mr-card');
    cards.forEach((card, i) => {
        card.style.animationDelay = (0.15 + i * 0.06) + 's';
    });
});

// Delete modal
function confirmDelete(reportCode) {
    const overlay = document.getElementById('deleteOverlay');
    const codeSpan = document.getElementById('modalReportCode');
    const link = document.getElementById('modalDeleteLink');

    if (overlay && codeSpan && link) {
        codeSpan.textContent = reportCode;
        link.href = window.URLROOT + '/disease/deleteReport/' + reportCode;
        overlay.classList.add('active');
    }
}

function closeDeleteModal() {
    const overlay = document.getElementById('deleteOverlay');
    if (overlay) overlay.classList.remove('active');
}

// Close on overlay click
document.addEventListener('click', function (e) {
    if (e.target && e.target.id === 'deleteOverlay') {
        closeDeleteModal();
    }
});
