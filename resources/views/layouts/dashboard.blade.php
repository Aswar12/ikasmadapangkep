<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 bg-white shadow-lg max-h-screen w-64 hidden md:flex flex-col z-20">
            <div class="flex flex-col justify-between h-full">
                <div class="flex-grow">
                    <div class="px-4 py-6 text-center border-b">
                        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" class="h-16 mx-auto mb-2">
                        <h1 class="text-xl font-semibold text-gray-800">IKA SMADA Pangkep</h1>
                    </div>
                    <div class="p-4">
                    <!-- Navigation items will be defined in extending layouts -->
                    @yield('navigation')
                    </div>
                </div>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900 w-full rounded-xl py-2 px-4">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span class="ml-2">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle -->
        <div class="fixed inset-0 bg-gray-900 opacity-50 z-10 hidden" id="sidebarOverlay"></div>
        
        <div class="fixed bottom-4 right-4 md:hidden z-30">
            <button onclick="toggleSidebar()" class="bg-blue-600 text-white rounded-full p-3 shadow-lg">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="md:ml-64 p-8">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm rounded-xl p-4 mb-6">
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
            <main class="bg-white shadow-sm rounded-xl p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts

    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebar.classList.contains('hidden')) {
            // Show sidebar
            sidebar.classList.remove('hidden');
            overlay.classList.remove('hidden');
            sidebar.classList.add('flex');
        } else {
            // Hide sidebar
            sidebar.classList.add('hidden');
            overlay.classList.add('hidden');
            sidebar.classList.remove('flex');
        }
    }

    // Close sidebar when clicking overlay
    document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
