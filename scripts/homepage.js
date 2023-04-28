document.addEventListener("DOMContentLoaded", () => {
    // Load data from data/services.html into services container
    $(".services-container").load('data/services.html');
});

function setHeroImageHeight() {
    $(".hero-image").css({
        "height": `${window.innerHeight * 0.60}px`
    });
}

setHeroImageHeight();

window.addEventListener('resize', () => {
    setHeroImageHeight();
});

function bookService(service) {
    window.location.href = `booking.html?service=${service}`;
}

