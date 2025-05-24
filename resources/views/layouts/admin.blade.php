<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IKA SMADA Pangkep') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->        <aside class="fixed inset-y-0 left-0 z-50 lg:block bg-white shadow-lg max-h-screen w-64 transform transition-transform duration-200 ease-in-out lg:transform-none">
            <div class="flex flex-col justify-between h-full">
                <div class="flex-grow">
                    <div class="px-4 py-6 text-center border-b">
                        <img src="{{ asset('images/LOGO IKA SMAD PANGKEP.png') }}" alt="Logo" class="h-16 mx-auto mb-2">
                        <h1 class="text-xl font-bold leading-none"><span class="text-blue-700">Admin</span> Panel</h1>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center bg-blue-50 rounded-xl font-bold text-blue-900 py-3 px-4">
                                    <i class="fas fa-home w-6"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <!-- User Management -->
                            <li x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-users w-6"></i>
                                        <span>Manajemen Pengguna</span>
                                    </div>
                                    <span class="transform transition-transform" :class="{ 'rotate-180': open }">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                                <ul x-show="open" class="pl-10 pr-2 py-2 space-y-1">
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Alumni</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Koordinator Angkatan</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Koordinator Departemen</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Admin</a></li>
                                </ul>
                            </li>

                            <!-- Departments -->
                            <li x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-sitemap w-6"></i>
                                        <span>Departemen</span>
                                    </div>
                                    <span class="transform transition-transform" :class="{ 'rotate-180': open }">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                                <ul x-show="open" class="pl-10 pr-2 py-2 space-y-1">
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Program Kerja</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Laporan Progress</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Dokumentasi</a></li>
                                </ul>
                            </li>

                            <!-- Events -->
                            <li x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-calendar-alt w-6"></i>
                                        <span>Event & Lowongan</span>
                                    </div>
                                    <span class="transform transition-transform" :class="{ 'rotate-180': open }">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                                <ul x-show="open" class="pl-10 pr-2 py-2 space-y-1">
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Event</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Lowongan Kerja</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Pendaftaran Event</a></li>
                                </ul>
                            </li>

                            <!-- Finance -->
                            <li x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-wallet w-6"></i>
                                        <span>Keuangan</span>
                                    </div>
                                    <span class="transform transition-transform" :class="{ 'rotate-180': open }">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </button>
                                <ul x-show="open" class="pl-10 pr-2 py-2 space-y-1">
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Iuran</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Pemasukan</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Pengeluaran</a></li>
                                    <li><a href="#" class="block text-gray-600 hover:text-gray-900 py-2">Laporan</a></li>
                                </ul>
                            </li>

                            <!-- Gallery -->
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <i class="fas fa-images w-6"></i>
                                    <span>Galeri</span>
                                </a>
                            </li>

                            <!-- Feedback -->
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <i class="fas fa-comment-dots w-6"></i>
                                    <span>Feedback & Testimoni</span>
                                </a>
                            </li>

                            <!-- Settings -->
                            <li>
                                <a href="#" class="flex items-center text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl py-3 px-4">
                                    <i class="fas fa-cog w-6"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900 w-full rounded-xl py-2 px-4">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>        <!-- Main Content -->
        <div class="lg:pl-64">
            <div class="p-8">
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
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Profile" class="h-8 w-8 rounded-full">
                                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 py-2 w-48 bg-white rounded-lg shadow-xl">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>            <!-- Content -->
            <main class="bg-white shadow-sm rounded-xl p-6">
                @yield('content')
            </main>
            </div>
        </div>
    </div>

    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
