const toTopBtn = document.getElementById("toTopBtn");

window.addEventListener("scroll", function () {
    if (window.pageYOffset > 150) {
        toTopBtn.style.display = "flex";
    } else {
        toTopBtn.style.display = "none";
    }
});

toTopBtn.addEventListener("click", function () {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});