<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IKA SMADA PANGKEP') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing-page.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <style>
            :root {
                --primary-color: #8E1920;
                --primary-light: #B83038;
                --primary-dark: #5E1014;
                --secondary-color: #1A3A6A;
                --secondary-light: #2C5699;
                --secondary-dark: #122744;
                --accent-color: #D4AF37;
                --accent-light: #E9C767;
                --accent-dark: #A88A29;
            }

            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
            }
            
            .auth-card {
                backdrop-filter: blur(15px);
                background-color: rgba(255, 255, 255, 0.95);
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.15),
                    0 10px 20px rgba(0, 0, 0, 0.1);
                border-radius: 24px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .auth-input {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 16px;
                border-width: 2px;
                padding: 16px 20px 16px 48px;
                font-size: 16px;
                background-color: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                box-shadow: 
                    0 2px 8px rgba(0, 0, 0, 0.05),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
                border-color: rgba(142, 25, 32, 0.2);
            }

            .auth-input:focus {
                border-color: var(--primary-color);
                background-color: rgba(255, 255, 255, 0.95);
                box-shadow: 
                    0 0 0 4px rgba(142, 25, 32, 0.15),
                    0 8px 25px rgba(142, 25, 32, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
                transform: translateY(-2px) scale(1.02);
                outline: none;
            }

            .auth-input:hover:not(:focus) {
                border-color: rgba(142, 25, 32, 0.4);
                box-shadow: 
                    0 4px 12px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15);
                transform: translateY(-1px);
            }

            .auth-input::placeholder {
                color: rgba(107, 114, 128, 0.7);
                font-weight: 400;
                transition: all 0.3s ease;
            }

            .auth-input:focus::placeholder {
                color: rgba(107, 114, 128, 0.5);
                transform: translateX(4px);
            }

            /* Input Container dengan Icon */
            .input-container {
                position: relative;
                display: flex;
                align-items: center;
            }

            .input-icon {
                position: absolute;
                left: 16px;
                z-index: 10;
                transition: all 0.3s ease;
                color: rgba(142, 25, 32, 0.6);
                font-size: 18px;
            }

            .input-container:focus-within .input-icon {
                color: var(--primary-color);
                transform: scale(1.1);
            }

            .input-container:hover .input-icon {
                color: rgba(142, 25, 32, 0.8);
            }

            /* Toggle Password Button */
            .toggle-password {
                position: absolute;
                right: 16px;
                z-index: 10;
                color: rgba(107, 114, 128, 0.6);
                transition: all 0.3s ease;
                cursor: pointer;
                padding: 4px;
                border-radius: 8px;
            }

            .toggle-password:hover {
                color: var(--primary-color);
                background-color: rgba(142, 25, 32, 0.1);
                transform: scale(1.1);
            }

            /* Label Styling */
            .auth-label {
                font-weight: 600;
                color: #374151;
                margin-bottom: 8px;
                display: block;
                font-size: 14px;
                letter-spacing: 0.025em;
            }

            .auth-button {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 12px;
                padding: 14px 24px;
                font-weight: 600;
                letter-spacing: 0.025em;
            }

            .auth-button:hover {
                transform: translateY(-2px);
                box-shadow: 
                    0 10px 25px rgba(142, 25, 32, 0.25),
                    0 4px 10px rgba(0, 0, 0, 0.1);
                background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            }

            .auth-button:active {
                transform: translateY(0);
                box-shadow: 0 4px 10px rgba(142, 25, 32, 0.2);
            }

            .auth-link {
                color: var(--primary-color);
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .auth-link:hover {
                color: var(--primary-light);
                text-decoration: underline;
                text-underline-offset: 4px;
            }

            .logo-container img {
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
            }

            .logo-container:hover img {
                transform: scale(1.05) rotate(1deg);
            }

            /* Mobile Optimizations */
            @media (max-width: 640px) {
                .auth-card {
                    margin: 16px;
                    border-radius: 20px;
                    padding: 24px 20px;
                }
                
                .auth-input {
                    font-size: 16px; /* Prevents zoom on iOS */
                    padding: 14px 16px 14px 44px;
                    border-radius: 14px;
                }
                
                .auth-button {
                    padding: 16px 24px;
                    font-size: 16px;
                    border-radius: 14px;
                }
                
                .input-icon {
                    left: 14px;
                    font-size: 16px;
                }
                
                .toggle-password {
                    right: 14px;
                }
                
                .auth-input:focus {
                    transform: translateY(-1px) scale(1.01);
                }
                
                .input-container:focus-within .input-icon {
                    transform: scale(1.05);
                }
            }

            /* Dark mode support */
            @media (prefers-color-scheme: dark) {
                .auth-card {
                    background-color: rgba(255, 255, 255, 0.95);
                }
            }

            /* Reduce motion for accessibility */
            @media (prefers-reduced-motion: reduce) {
                .auth-input,
                .auth-button,
                .auth-link,
                .logo-container img {
                    transition: none;
                }
                
                .auth-button:hover,
                .logo-container:hover img {
                    transform: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased min-h-screen relative overflow-hidden">
            {{ $slot }}
        </div>

        @livewireScripts
        
        <!-- Background Slider Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slides = document.querySelectorAll('.hero-slide');
                if (!slides.length) return;

                let currentSlide = 0;
                let slideInterval;

                function startSlider() {
                    slideInterval = setInterval(nextSlide, 5000);
                }

                function showSlide(n) {
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[n].classList.add('active');
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }

                function prevSlide() {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(currentSlide);
                }

                // Start the slider
                startSlider();

                // Optional: Pause on hover
                slides.forEach(slide => {
                    slide.addEventListener('mouseenter', () => clearInterval(slideInterval));
                    slide.addEventListener('mouseleave', startSlider);
                });
            });
        </script>
    </body>
</html>
