// Custom JavaScript for IKA SMADA Pangkep Landing Page

$(document).ready(function() {
    // Initialize AOS
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });
    
    // Add scrolled class to navbar when page is scrolled
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#mainNav').addClass('navbar-scrolled');
            $('.back-to-top').addClass('active');
        } else {
            $('#mainNav').removeClass('navbar-scrolled');
            $('.back-to-top').removeClass('active');
        }
        
        // Update scroll progress
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height) * 100;
        
        if (document.getElementById("scrollProgress")) {
            document.getElementById("scrollProgress").style.width = scrolled + "%";
        }
    });
    
    // Check scroll position on page load
    if ($(window).scrollTop() > 50) {
        $('#mainNav').addClass('navbar-scrolled');
    }
    
    // Smooth scrolling for navbar links
    $('a.nav-link').on('click', function(e) {
        if (this.hash !== '') {
            e.preventDefault();
            
            const hash = this.hash;
            
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 70
            }, 800);
        }
    });
    
    // Back to top button
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    // Preloader
    $(window).on('load', function() {
        // Hide preloader after page load
        $('.preloader').addClass('fade-out');
        setTimeout(function() {
            $('.preloader').hide();
        }, 500);
        
        // Init page loading bar
        $('.page-loading-bar').css('width', '100%');
        setTimeout(function() {
            $('.page-loading-bar').css('opacity', '0');
        }, 1000);
    });
    
    // Flip cards for departments
    $('.flip-back-btn').on('click', function(e) {
        e.stopPropagation();
        $(this).closest('.dept-card-inner').css('transform', 'rotateY(0deg)');
    });
    
    // Stop propagation when clicking on the back card
    $('.dept-card-back').on('click', function(e) {
        e.stopPropagation();
    });
    
    // Flip card when clicking anywhere on the card front
    $('.dept-card-front').on('click', function() {
        $(this).parent('.dept-card-inner').css('transform', 'rotateY(180deg)');
    });
    
    // Lazy Load Images
    $('.img-lazy').each(function() {
        var img = $(this);
        var imgSrc = img.data('src');
        
        // Create a new image object
        var tmpImg = new Image();
        tmpImg.src = imgSrc;
        
        // When the image has loaded
        tmpImg.onload = function() {
            // Set the src and add the loaded class
            img.attr('src', imgSrc);
            img.addClass('loaded');
        };
    });
    
    // Initialize particles.js
    if (typeof particlesJS !== 'undefined' && document.getElementById('particles-js')) {
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#FCDF03"
                },
                shape: {
                    type: "circle",
                },
                opacity: {
                    value: 0.5,
                    random: true,
                },
                size: {
                    value: 3,
                    random: true,
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#FCDF03",
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "grab"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 140,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    push: {
                        particles_nb: 4
                    }
                }
            },
            retina_detect: true
        });
    }
    
    // Hero Background Slideshow
    if ($('.hero-bg').length) {
        // Get the asset URL from the data attribute
        const backgroundImages = [
            $('.hero-bg').data('image1'),
            $('.hero-bg').data('image2'),
            $('.hero-bg').data('image3'),
            $('.hero-bg').data('image4')
        ];
        
        let currentImageIndex = 0;
        
        // Fungsi untuk mengubah background
        function changeBackground() {
            currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
            const newImage = backgroundImages[currentImageIndex];
            
            // Fade transition
            $('.hero-bg').css({
                'opacity': 0.8,
                'background-image': 'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' + newImage + ')'
            }).animate({opacity: 1}, 1000);
        }
        
        // Set initial background
        $('.hero-bg').css({
            'background-image': 'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' + backgroundImages[0] + ')'
        });
        
        // Set interval untuk mengubah background setiap 5 detik
        setInterval(changeBackground, 5000);
    }
    
    // Counter Animation
    $('.counter').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    
    // Initialize any tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Initialize any popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });
    
    // Mobile nav toggle
    $('.navbar-toggler').on('click', function() {
        if ($('#mainNav').hasClass('navbar-mobile')) {
            $('#mainNav').removeClass('navbar-mobile');
        } else {
            $('#mainNav').addClass('navbar-mobile');
        }
    });

    // Placeholder for the alumni map
    if (document.getElementById('alumniMap')) {
        // This is a simple placeholder for the map
        // In a real implementation, you would use Leaflet, Google Maps, or another mapping API
        let mapElement = document.getElementById('alumniMap');
        
        // Create a simple placeholder with some text
        mapElement.innerHTML = `
            <div style="display: flex; justify-content: center; align-items: center; height: 100%; background: #1e1e1e; color: #ddd; flex-direction: column;">
                <div style="font-size: 3rem; margin-bottom: 10px; color: var(--primary-color);">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="text-center">Peta Sebaran Alumni</h3>
                <p class="text-center mb-0">Dalam implementasi sebenarnya, ini akan menampilkan peta interaktif dengan lokasi alumni.<br>Gunakan Google Maps, Leaflet, atau API peta lainnya.</p>
            </div>
        `;
    }
});
