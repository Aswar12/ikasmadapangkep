<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Ikatan Alumni SMA Negeri 2 Pangkep - Membangun kolaborasi dan memberikan kontribusi nyata untuk almamater dan masyarakat">

        <title>{{ config('app.name', 'IKA SMADA Pangkep') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        <!-- Custom Theme -->
        <link href="{{ asset('css/theme-2025.css') }}" rel="stylesheet">
        
        <!-- Page specific styles -->
        @stack('styles')
    </head>
    <body class="antialiased">
        <!-- Main Content -->
        @yield('content')
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize AOS
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });

                // Navbar scroll behavior
                const navbar = document.querySelector('.navbar-glass');
                if (navbar) {
                    window.addEventListener('scroll', () => {
                        if (window.scrollY > 50) {
                            navbar.classList.add('navbar-scrolled');
                        } else {
                            navbar.classList.remove('navbar-scrolled');
                        }
                    });
                }

                // Back to top button
                const backToTop = document.querySelector('.back-to-top');
                if (backToTop) {
                    window.addEventListener('scroll', () => {
                        if (window.scrollY > 100) {
                            backToTop.classList.add('active');
                        } else {
                            backToTop.classList.remove('active');
                        }
                    });

                    backToTop.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    });
                }

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            });
        </script>
        
        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>
