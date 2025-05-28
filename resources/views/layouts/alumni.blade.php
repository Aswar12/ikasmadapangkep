<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IKA SMADA Pangkep') }} - @yield('page-title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 72px;
            --transition-speed: 0.3s;
        }

        body {
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: white;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            z-index: 40;
            transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Mobile Sidebar */
        @media (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform var(--transition-speed) ease;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }

        /* Main Content Wrapper */
        .main-content-wrapper {
            min-height: 100vh;
            transition: margin-left var(--transition-speed) ease;
        }

        @media (min-width: 1024px) {
            .main-content-wrapper {
                margin-left: var(--sidebar-width);
            }

            .sidebar.collapsed ~ .main-content-wrapper {
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        /* Content Area */
        .content-area {
            padding-top: var(--header-height);
            min-height: 100vh;
            background: #f8fafc;
        }

        /* Fixed Header */
        .top-header {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: var(--header-height);
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            z-index: 30;
            transition: left var(--transition-speed) ease;
        }

        @media (min-width: 1024px) {
            .top-header {
                left: var(--sidebar-width);
            }

            .sidebar.collapsed ~ .main-content-wrapper .top-header {
                left: var(--sidebar-collapsed-width);
            }
        }

        /* Sidebar Header Gradient */
        .sidebar-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.25rem;
            border-radius: 0 0 20px 20px;
        }

        /* Nav Items */
        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            margin: 0.25rem 0.75rem;
            border-radius: 12px;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .nav-link:hover {
            background: #f3f4f6;
            color: #1f2937;
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            color: #4338ca;
            font-weight: 600;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 70%;
            background: #4338ca;
            border-radius: 0 4px 4px 0;
        }

        /* Collapsed Sidebar Styles */
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .logo-text {
            opacity: 0;
            visibility: hidden;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 1rem;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 35;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* User Dropdown */
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 280px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Responsive Padding */
        @media (max-width: 1023px) {
            .main-content-wrapper {
                margin-left: 0;
            }

            .top-header {
                left: 0;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease forwards;
        }
    </style>

    <!-- Styles -->
    @livewireStyles
    @stack('styles')
</head>
<body class="font-['Inter'] antialiased bg-gray-50">
    <div class="min-h-screen relative">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <!-- Header -->
            <div class="sidebar-header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" 
                             class="h-10 w-10 p-1 bg-white rounded-lg shadow-md">
                        <div class="logo-text transition-all duration-300">
                            <h1 class="text-white font-bold">IKA SMADA</h1>
                            <p class="text-xs text-purple-100">Alumni Dashboard</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()" class="hidden lg:block text-white hover:bg-white/20 p-2 rounded-lg transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- User Info -->
            <div class="px-4 py-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full border-2 border-purple-200">
                    </div>
                    <div class="user-info flex-1 transition-all duration-300">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Alumni {{ Auth::user()->graduation_year }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 py-4 overflow-y-auto">
                <a href="{{ route('alumni.dashboard') }}" 
                   class="nav-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Dashboard</span>
                </a>

                <a href="{{ route('alumni.profile.edit') }}" 
                   class="nav-link {{ request()->routeIs('alumni.profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Profile Saya</span>
                </a>

                <a href="{{ route('alumni.events') }}" 
                   class="nav-link {{ request()->routeIs('alumni.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Event</span>
                </a>

                <a href="{{ route('alumni.directory') }}" 
                   class="nav-link {{ request()->routeIs('alumni.directory.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Direktori Alumni</span>
                </a>

                <a href="{{ route('alumni.gallery') }}" 
                   class="nav-link {{ request()->routeIs('alumni.gallery.*') ? 'active' : '' }}">
                    <i class="fas fa-images w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Galeri</span>
                </a>

                <a href="{{ route('alumni.payments') }}" 
                   class="nav-link {{ request()->routeIs('alumni.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-wallet w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Keuangan</span>
                </a>

                <a href="{{ route('alumni.jobs') }}" 
                   class="nav-link {{ request()->routeIs('alumni.jobs.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Lowongan Kerja</span>
                </a>

                <a href="{{ route('alumni.news') }}" 
                   class="nav-link {{ request()->routeIs('alumni.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Berita</span>
                </a>

                <a href="{{ route('alumni.documents') }}" 
                   class="nav-link {{ request()->routeIs('alumni.documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt w-6 text-center flex-shrink-0"></i>
                    <span class="nav-text ml-3 transition-all duration-300">Dokumen</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-6 text-center flex-shrink-0"></i>
                        <span class="nav-text ml-3 transition-all duration-300">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div id="mobileOverlay" class="mobile-overlay lg:hidden" onclick="closeMobileSidebar()"></div>

        <!-- Main Content -->
        <div class="main-content-wrapper">
            <!-- Top Header -->
            <header class="top-header">
                <div class="h-full px-6 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleMobileSidebar()" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <input type="text" placeholder="Cari..." 
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <button class="relative text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            @if(isset($unread_notifications) && $unread_notifications > 0)
                            <span class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 rounded-full flex items-center justify-center text-xs text-white">
                                {{ $unread_notifications }}
                            </span>
                            @endif
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <button onclick="toggleUserDropdown()" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" 
                                     class="h-9 w-9 rounded-full border-2 border-gray-200">
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown -->
                            <div id="userDropdown" class="user-dropdown">
                                <div class="p-4 border-b border-gray-100">
                                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('alumni.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                                        <i class="fas fa-user mr-3"></i> Profile
                                    </a>
                                    <a href="{{ route('alumni.settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                                        <i class="fas fa-cog mr-3"></i> Pengaturan
                                    </a>
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                                            <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <main class="p-6">
                    @yield('content')
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 py-6 mt-12">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} IKA SMADA Pangkep. All rights reserved.
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    @livewireScripts

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('collapsed');
            
            if (isCollapsed) {
                sidebar.classList.remove('collapsed');
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                sidebar.classList.add('collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        }

        // Mobile Sidebar
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        }

        // User Dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button[onclick="toggleUserDropdown()"]');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Restore sidebar state
            const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (sidebarCollapsed && window.innerWidth >= 1024) {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>