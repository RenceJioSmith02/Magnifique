// Open lightbox function
function openLightbox(index) {
    currentImageIndex = index;
    document.getElementById("lightboxImg").src = images[index].src;
    document.getElementById("lightbox").style.display = "block";
}

// Close lightbox function
function closeLightbox() {
    document.getElementById("lightbox").style.display = "none";
}

// Navigate to previous image
function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    document.getElementById("lightboxImg").src = images[currentImageIndex].src;
}

// Navigate to next image
function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    document.getElementById("lightboxImg").src = images[currentImageIndex].src;
}

// Get all images and add event listener
var images = document.querySelectorAll('.img img');
images.forEach(function(img, index) {
    img.addEventListener('click', function() {
        openLightbox(index);
    });
});
