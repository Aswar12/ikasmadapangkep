<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.bunny.net;">

    <title>{{ config('app.name', 'IKA SMADA Pangkep') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    
    <!-- Fix untuk memastikan menu dapat diklik -->
    <style>
        /* Reset untuk sidebar */
        aside {
            z-index: 40 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            overflow-y: auto !important;
        }

        /* Desktop sidebar */
        aside:not(#mobileSidebar) {
            transform: none !important;
        }

        /* Mobile sidebar */
        #mobileSidebar {
            transform: translateX(-100%) !important;
        }

        #mobileSidebar.show {
            transform: translateX(0) !important;
        }

        /* Pastikan link dapat diklik */
        aside a {
            cursor: pointer !important;
            pointer-events: auto !important;
            position: relative !important;
            z-index: 50 !important;
        }

        /* Main content positioning */
        .md\:ml-64 {
            margin-left: 16rem !important; /* 256px = 16rem */
            position: relative !important;
            z-index: 10 !important;
            min-height: 100vh !important;
        }

        /* Mobile content */
        @media (max-width: 768px) {
            .md\:ml-64 {
                margin-left: 0 !important;
            }

            aside:not(#mobileSidebar) {
                display: none !important;
            }
        }

        /* Sidebar overlay */
        #sidebarOverlay {
            z-index: 30 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background-color: rgba(0, 0, 0, 0.5) !important;
            opacity: 0 !important;
            visibility: hidden !important;
            transition: opacity 0.3s ease, visibility 0.3s ease !important;
        }

        #sidebarOverlay.show {
            opacity: 1 !important;
            visibility: visible !important;
        }

        /* Ensure content is not covered */
        main {
            min-height: calc(100vh - 200px);
        }

        /* Better spacing for dashboard content */
        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        /* Fix for any potential overflow */
        body {
            overflow-x: hidden;
        }

        /* Dashboard specific improvements */
        .dashboard-grid {
            display: grid;
            gap: 1.5rem;
        }

        /* Statistics cards responsive */
        @media (max-width: 640px) {
            .grid-cols-6 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
        }

        @media (max-width: 480px) {
            .grid-cols-6 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }

        /* Chart containers */
        .chart-container {
            position: relative;
            height: 250px;
        }

        /* Better table styling */
        .dashboard-table th {
            background-color: #f9fafb;
            font-weight: 600;
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dashboard-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .dashboard-table tr:hover {
            background-color: #f9fafb;
        }

        /* Quick action cards */
        .quick-action-card {
            transition: all 0.2s ease;
        }

        .quick-action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 bg-white shadow-lg max-h-screen w-64 hidden md:flex flex-col" style="z-index: 40;">
            <div class="flex flex-col justify-between h-full">
                <div class="flex-grow">
                    <div class="px-4 py-6 text-center border-b">
                        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" class="h-16 mx-auto mb-2">
                        <h1 class="text-xl font-semibold text-gray-800">IKA SMADA Pangkep</h1>
                    </div>
                    <div class="p-4 overflow-y-auto">
                        <!-- Navigation items will be defined in extending layouts -->
                        @yield('navigation')
                    </div>
                </div>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900 hover:bg-gray-100 w-full rounded-xl py-2 px-4 transition-all duration-200">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span class="ml-2">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar (untuk mobile) -->
        <aside id="mobileSidebar" class="fixed inset-y-0 left-0 bg-white shadow-lg max-h-screen w-64 flex flex-col transform -translate-x-full transition-transform duration-300 md:hidden" style="z-index: 40;">
            <div class="flex flex-col justify-between h-full">
                <div class="flex-grow">
                    <div class="px-4 py-6 text-center border-b">
                        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" class="h-16 mx-auto mb-2">
                        <h1 class="text-xl font-semibold text-gray-800">IKA SMADA Pangkep</h1>
                    </div>
                    <div class="p-4 overflow-y-auto">
                        @yield('navigation')
                    </div>
                </div>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900 hover:bg-gray-100 w-full rounded-xl py-2 px-4 transition-all duration-200">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span class="ml-2">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900 opacity-50 hidden transition-opacity duration-300" style="z-index: 30;"></div>
        
        <!-- Mobile Menu Toggle Button -->
        <div class="fixed bottom-4 right-4 md:hidden" style="z-index: 50;">
            <button onclick="toggleSidebar()" class="bg-blue-600 text-white rounded-full p-3 shadow-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="md:ml-64 p-4 md:p-6 min-h-screen" style="position: relative; z-index: 10;">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                            <button class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full">
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <main class="space-y-6">
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts

    <script>
    function toggleSidebar() {
        const mobileSidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (mobileSidebar.classList.contains('show')) {
            // Hide sidebar
            mobileSidebar.classList.remove('show');
            overlay.classList.remove('show');
        } else {
            // Show sidebar
            mobileSidebar.classList.add('show');
            overlay.classList.add('show');
        }
    }

    // Close sidebar when clicking overlay
    document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

    // Close sidebar when clicking a menu item (mobile)
    document.querySelectorAll('#mobileSidebar a').forEach(link => {
        link.addEventListener('click', toggleSidebar);
    });

    // Debug function untuk check clickability
    function debugMenuClicks() {
        const links = document.querySelectorAll('aside a');
        console.log('Total menu links found:', links.length);

        links.forEach((link, index) => {
            console.log(`Link ${index}:`, {
                href: link.href,
                clickable: window.getComputedStyle(link).pointerEvents !== 'none',
                zIndex: window.getComputedStyle(link).zIndex
            });
        });
    }

    // Run debug on page load
    window.addEventListener('load', debugMenuClicks);
    </script>
    
    @stack('scripts')
</body>
</html>