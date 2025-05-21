<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom Scripts -->
<script>
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
    });
    
    // Check scroll position on page load
    $(document).ready(function() {
        if ($(window).scrollTop() > 50) {
            $('#mainNav').addClass('navbar-scrolled');
        }
        
        // Animate elements on scroll
        $(window).scroll(function() {
            $('.fade-up').each(function() {
                var elementTop = $(this).offset().top;
                var viewportTop = $(window).scrollTop();
                
                if (elementTop - viewportTop < $(window).height() - 100) {
                    $(this).addClass('show');
                }
            });
        });
        
        // Trigger the scroll event once to check for visible elements
        $(window).trigger('scroll');
        
        // Back to top button
        $('.back-to-top').click(function() {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
        
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
    });
</script>
