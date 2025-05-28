<style>
    .hero-slide {
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }
    
    .hero-slide.active {
        opacity: 1;
    }

    .hero-control {
        transition: all 0.3s ease;
    }

    .hero-control:hover {
        transform: scale(1.1);
    }

    .hero-control:active {
        transform: scale(0.95);
    }
</style>

<div class="min-h-screen flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 relative overflow-hidden">
    <!-- Background Slider -->
    <div class="absolute inset-0 z-0">
        <div class="hero-slider relative w-full h-full">
            <!-- Background Images -->
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000 active" 
                style="background-image: url('{{ asset('images/DSC03084.JPG') }}');"></div>
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000" 
                style="background-image: url('{{ asset('images/DSC03207.JPG') }}');"></div>
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000" 
                style="background-image: url('{{ asset('images/DSC03216.JPG') }}');"></div>
            <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-1000" 
                style="background-image: url('{{ asset('images/DSC03049.JPG') }}');"></div>
            
            <!-- Dark overlay with gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-900/70 to-gray-900/80"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md mx-auto space-y-6">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            {{ $logo }}
        </div>

        <!-- Content Card -->
        <div class="auth-card p-6 sm:p-8 lg:p-10 w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">IKA SMADA Pangkep</h1>
                <p class="text-gray-600 text-sm sm:text-base">Sistem Informasi Organisasi Alumni</p>
            </div>
            
            {{ $slot }}
        </div>

        <!-- Footer Text -->
        <div class="text-center space-y-2 mt-6">
            <p class="text-sm font-medium text-white/90 drop-shadow-md">
                &copy; {{ date('Y') }} IKA SMADA Pangkep. All rights reserved.
            </p>
            <p class="text-xs text-white/80 drop-shadow-md">
                Developed by Departemen Humas dan Jaringan
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero slider functionality
    const slides = document.querySelectorAll('.hero-slide');
    const prevBtn = document.querySelector('.hero-control.prev');
    const nextBtn = document.querySelector('.hero-control.next');
    let currentSlide = 0;
    let slideInterval;

    // Initialize slider
    function startSlider() {
        slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }

    // Show a specific slide
    function showSlide(n) {
        // Remove active class from all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Show the current slide
        slides[n].classList.add('active');
    }

    // Next slide function
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Previous slide function
    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    }

    // Event listeners for manual navigation
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            clearInterval(slideInterval);
            prevSlide();
            startSlider();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            clearInterval(slideInterval);
            nextSlide();
            startSlider();
        });
    }

    // Start the slider automatically
    if (slides.length > 0) {
        startSlider();
    }
});
</script>
