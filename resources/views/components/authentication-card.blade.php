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

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
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
            
            <!-- Overlay untuk membuat background lebih gelap -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-900/70 to-gray-900/80"></div>
        </div>
        
        <!-- Slider Controls -->
        <div class="absolute inset-x-0 bottom-4 flex justify-center space-x-2 z-20">
            <button class="hero-control prev p-2 rounded-full bg-gray-800/50 hover:bg-gray-800/70 text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="hero-control next p-2 rounded-full bg-gray-800/50 hover:bg-gray-800/70 text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="relative z-10 mb-6">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-2xl mt-6 px-6 py-8 bg-white/90 backdrop-blur-md shadow-xl rounded-2xl relative z-10">
        {{ $slot }}
    </div>

    <!-- Footer Text -->
    <div class="mt-8 text-center relative z-10 space-y-1">
        <p class="text-sm font-medium text-white/90 drop-shadow-md">
            &copy; {{ date('Y') }} IKA SMADA Pangkep. All rights reserved.
        </p>
        <p class="text-xs text-white/80 drop-shadow-md">
            Developed by Departemen Humas dan Jaringan
        </p>
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
