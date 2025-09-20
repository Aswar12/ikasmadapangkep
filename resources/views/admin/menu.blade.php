@section('navigation')
<!-- Sidebar Navigation -->
<ul class="space-y-2 tracking-wide">
    <!-- Dashboard -->
    <li>
        <a href="{{ url('/admin/dashboard') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Pengguna -->
    <li>
        <a href="{{ url('/admin/users') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->is('admin/users*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-users"></i>
            <span>Manajemen Pengguna</span>
        </a>
    </li>
    
    <!-- Departemen & Program Kerja -->
    <li>
        <a href="{{ route('admin.departments.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 w-full {{ request()->routeIs('admin.departments.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-building"></i>
            <span>Departemen</span>
        </a>
    </li>
    
    <!-- Event -->
    <li>
        <a href="{{ route('admin.events.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-calendar-alt"></i>
            <span>Kelola Event</span>
        </a>
    </li>
    
    <!-- Lowongan Kerja -->
    <li>
        <a href="{{ route('admin.jobs.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.jobs.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-briefcase"></i>
            <span>Lowongan Kerja</span>
        </a>
    </li>
    
    <!-- Iuran Alumni -->
    <li>
        <a href="{{ route('admin.finance.dues') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.finance.dues') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-money-check-alt"></i>
            <span>Iuran Alumni</span>
        </a>
    </li>
    
    <!-- Arus Kas -->
    <li>
        <a href="{{ route('admin.finance.cashflow') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.finance.cashflow') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-cash-register"></i>
            <span>Arus Kas</span>
        </a>
    </li>
    
    <!-- Laporan Keuangan -->
    <li>
        <a href="{{ route('admin.finance.reports') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.finance.reports') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>
    
    <!-- Gallery -->
    <li>
        <a href="{{ route('admin.gallery.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.gallery.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-images"></i>
            <span>Gallery</span>
        </a>
    </li>
    
    <!-- Laporan & Analitik -->
    <li>
        <a href="{{ route('admin.reports.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan & Analitik</span>
        </a>
    </li>
    
    <!-- Pengaturan -->
    <li>
        <a href="{{ route('admin.settings.index') }}" 
           class="menu-link flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-600' : '' }}"
           style="cursor: pointer; position: relative; z-index: 30;">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </li>
</ul>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Memastikan semua link menu dapat diklik
    const menuLinks = document.querySelectorAll('.menu-link');
    
    menuLinks.forEach(link => {
        // Hapus event listener yang mungkin mencegah default behavior
        link.addEventListener('click', function(e) {
            // Jangan preventDefault - biarkan link bekerja normal
            console.log('Menu clicked:', this.href);
        });
        
        // Pastikan link memiliki pointer cursor
        link.style.cursor = 'pointer';
        
        // Hapus pointer-events: none jika ada
        link.style.pointerEvents = 'auto';
    });
    
    // Debug: Check jika ada element yang menutupi menu
    const sidebar = document.querySelector('aside');
    if (sidebar) {
        console.log('Sidebar z-index:', window.getComputedStyle(sidebar).zIndex);
    }
    
    // Add padding to bottom on mobile to account for bottom navigation
    if (window.innerWidth < 768) {
        const main = document.querySelector('main');
        if (main) {
            main.style.paddingBottom = '4rem';
        }
    }
});

// Fungsi untuk memastikan navigasi bekerja
function ensureNavigation() {
    const links = document.querySelectorAll('aside a');
    links.forEach(link => {
        // Remove any click event that might prevent navigation
        const newLink = link.cloneNode(true);
        link.parentNode.replaceChild(newLink, link);
    });
}

// Jalankan saat halaman dimuat
window.addEventListener('load', ensureNavigation);
</script>
@endpush

@push('styles')
<style>
/* Memastikan menu dapat diklik */
.menu-link {
    cursor: pointer !important;
    pointer-events: auto !important;
    position: relative !important;
    z-index: 30 !important;
    display: flex !important;
    text-decoration: none !important;
}

/* Hapus overlay yang mungkin menutupi */
aside::before,
aside::after {
    display: none !important;
}

/* Pastikan tidak ada elemen yang menutupi menu */
aside * {
    pointer-events: auto !important;
}

/* Active state untuk menu */
.menu-link.active,
.menu-link:hover {
    background-color: #e5e7eb !important;
}
</style>
@endpush