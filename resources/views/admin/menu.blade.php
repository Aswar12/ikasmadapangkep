@section('navigation')
{{--                                                                                                                                 --}}<!-- Sidebar Navigation -->
<ul class="space-y-2 tracking-wide">
    <!-- Dashboard -->
    <li>
        <a href="{{ url('/admin/dashboard') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Manajemen Pengguna (direct link, no dropdown) -->
    <li>
        <a href="{{ url('/admin/users') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-users"></i>
            <span>Manajemen Pengguna</span>
        </a>
    </li>
    
    <!-- Departemen & Program Kerja -->
    <li>
        <a href="{{ route('admin.departments.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
            <i class="fas fa-building"></i>
            <span>Departemen</span>
        </a>
    </li>
    
    <!-- Event & Lowongan - Refactored -->
    <li>
        <a href="{{ route('admin.events.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-calendar-alt"></i> {{-- Or fas fa-calendar-check --}}
            <span>Kelola Event</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.jobs.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-briefcase"></i>
            <span>Lowongan Kerja</span>
        </a>
    </li>
    
    <!-- Keuangan - Refactored -->
    <li>
        <a href="{{ route('admin.finance.dues') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-money-check-alt"></i>
            <span>Iuran Alumni</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.finance.cashflow') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-cash-register"></i>
            <span>Arus Kas</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.finance.reports') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>
    
    <!-- Gallery -->
    <li>
        <a href="{{ route('admin.gallery.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-images"></i>
            <span>Gallery</span>
        </a>
    </li>
    
    <!-- Laporan & Analitik -->
    <li>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan & Analitik</span>
        </a>
    </li>
    
    <!-- Pengaturan -->
    <li>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </li>
</ul>
@endsection

@push('scripts')
<script>
    // Toggle dropdown menu function removed to disable toggle functionality
    
    // Add padding to bottom on mobile to account for bottom navigation
    if (window.innerWidth < 768) {
        document.querySelector('main').style.paddingBottom = '4rem';
    }
</script>
@endpush
