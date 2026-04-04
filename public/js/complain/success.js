// Countdown with circular progress ring
(function () {
    const total = 10;
    let remaining = total;
    const circumference = 2 * Math.PI * 11;
    const ring = document.getElementById('progressRing');
    const countEl = document.getElementById('countdown');
    const redirectBar = document.querySelector('.redirect-bar');

    if (!ring || !countEl) return;

    // Read redirect URL from data attribute
    const redirectUrl = redirectBar ? redirectBar.dataset.redirectUrl : null;

    ring.style.strokeDasharray = circumference;
    ring.style.strokeDashoffset = '0';

    const timer = setInterval(() => {
        remaining--;
        countEl.textContent = remaining;
        const offset = circumference * (1 - remaining / total);
        ring.style.strokeDashoffset = offset;

        if (remaining <= 0) {
            clearInterval(timer);
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }
    }, 1000);
})();
