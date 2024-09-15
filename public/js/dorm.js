function nextImage(dormId) {
    const carousel = document.getElementById('carousel-' + dormId);
    const images = JSON.parse(carousel.getAttribute('data-images'));
    let currentImage = parseInt(carousel.getAttribute('data-current-image'));

    currentImage = (currentImage + 1) % images.length;

    updateCarousel(carousel, dormId, currentImage);
}

function prevImage(dormId) {
    const carousel = document.getElementById('carousel-' + dormId);
    const images = JSON.parse(carousel.getAttribute('data-images'));
    let currentImage = parseInt(carousel.getAttribute('data-current-image'));

    currentImage = (currentImage - 1 + images.length) % images.length;

    updateCarousel(carousel, dormId, currentImage);
}

function setImage(dormId, index) {
    const carousel = document.getElementById('carousel-' + dormId);
    updateCarousel(carousel, dormId, index);
}

function updateCarousel(carousel, dormId, currentImage) {
    const images = JSON.parse(carousel.getAttribute('data-images'));

    // Update the background image
    carousel.style.backgroundImage = 'url(/storage/dorm_pictures/' + images[currentImage] + ')';
    carousel.setAttribute('data-current-image', currentImage);

    // Update dots
    const dotsContainer = document.getElementById('dots-' + dormId);
    const dots = dotsContainer.getElementsByClassName('dot');
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active');
    }
    dots[currentImage].classList.add('active');
}
function updateCarousel(carousel, dormId, currentImage) {
    const images = JSON.parse(carousel.getAttribute('data-images'));

    // Add fade-out effect
    carousel.classList.add('fade');

    setTimeout(() => {
        // Update the background image after fade-out
        carousel.style.backgroundImage = 'url(/storage/dorm_pictures/' + images[currentImage] + ')';
        carousel.setAttribute('data-current-image', currentImage);

        // After changing the image, add fade-in effect
        carousel.classList.remove('fade');
    }, 100);  // Matches the transition duration in CSS (0.5s)

    // Update dots
    const dotsContainer = document.getElementById('dots-' + dormId);
    const dots = dotsContainer.getElementsByClassName('dot');
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active');
    }
    dots[currentImage].classList.add('active');
}