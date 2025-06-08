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
    
    <!-- Event & Lowongan -->
    <li>
        <div class="relative">
            <a href="{{ route('admin.events.index') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-calendar-alt"></i>
                <span>Event & Lowongan</span>
            </a>
            <ul id="eventMenu" class="pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.events.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Kelola Event</a></li>
                <li><a href="{{ route('admin.jobs.index') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Lowongan Kerja</a></li>
            </ul>
        </div>
    </li>
    
    <!-- Keuangan -->
    <li>
        <div class="relative">
            <a href="{{ route('admin.finance.dues') }}" class="flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-600 hover:bg-gray-100 w-full">
                <i class="fas fa-coins"></i>
                <span>Keuangan</span>
            </a>
            <ul id="financeMenu" class="pl-8 mt-2 space-y-2">
                <li><a href="{{ route('admin.finance.dues') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Iuran Alumni</a></li>
                <li><a href="{{ route('admin.finance.cashflow') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Arus Kas</a></li>
                <li><a href="{{ route('admin.finance.reports') }}" class="block rounded-lg px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Laporan</a></li>
            </ul>
        </div>
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
