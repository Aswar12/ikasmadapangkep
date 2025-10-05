@section('navigation')
<!-- Sidebar Navigation -->
<div class="px-2 py-4">
    <!-- Navigation Menu -->
    <nav class="space-y-2">
        <!-- Dashboard -->
        <a href="{{ url('/admin/dashboard') }}"
           class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fas fa-home menu-icon"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <!-- Manajemen Pengguna -->
        <a href="{{ url('/admin/users') }}"
           class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}">
            <i class="fas fa-users menu-icon"></i>
            <span class="menu-text">Manajemen Pengguna</span>
        </a>

        <!-- Departemen Dropdown -->
        <div class="menu-dropdown" data-dropdown="departments">
            <button class="menu-item dropdown-toggle {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="fas fa-building menu-icon"></i>
                <span class="menu-text">Departemen</span>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('admin.departments.dashboard') }}"
                   class="dropdown-item {{ request()->routeIs('admin.departments.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie menu-icon"></i>
                    <span class="menu-text">Dashboard Departemen</span>
                </a>
                <a href="{{ route('admin.departments.index') }}"
                   class="dropdown-item {{ request()->routeIs('admin.departments.index') ? 'active' : '' }}">
                    <i class="fas fa-list menu-icon"></i>
                    <span class="menu-text">Daftar Departemen</span>
                </a>
                <a href="{{ route('admin.departments.create') }}"
                   class="dropdown-item {{ request()->routeIs('admin.departments.create') ? 'active' : '' }}">
                    <i class="fas fa-plus menu-icon"></i>
                    <span class="menu-text">Tambah Departemen</span>
                </a>
            </div>
        </div>

        <!-- Program Kerja Dropdown -->
        <div class="menu-dropdown" data-dropdown="program-kerja">
            <button class="menu-item dropdown-toggle {{ request()->routeIs('admin.program-kerja.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list menu-icon"></i>
                <span class="menu-text">Program Kerja</span>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('admin.program-kerja.dashboard') }}"
                   class="dropdown-item {{ request()->routeIs('admin.program-kerja.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar menu-icon"></i>
                    <span class="menu-text">Dashboard Program</span>
                </a>
                <a href="{{ route('admin.program-kerja.kanban') }}"
                   class="dropdown-item {{ request()->routeIs('admin.program-kerja.kanban') ? 'active' : '' }}">
                    <i class="fas fa-columns menu-icon"></i>
                    <span class="menu-text">Kanban Board</span>
                </a>
                <a href="{{ route('admin.program-kerja.calendar') }}"
                   class="dropdown-item {{ request()->routeIs('admin.program-kerja.calendar') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt menu-icon"></i>
                    <span class="menu-text">Calendar 5 Tahun</span>
                </a>
                <a href="{{ route('admin.program-kerja.index') }}"
                   class="dropdown-item {{ request()->routeIs('admin.program-kerja.index') ? 'active' : '' }}">
                    <i class="fas fa-list menu-icon"></i>
                    <span class="menu-text">Daftar Program</span>
                </a>
                <a href="{{ route('admin.program-kerja.create') }}"
                   class="dropdown-item {{ request()->routeIs('admin.program-kerja.create') ? 'active' : '' }}">
                    <i class="fas fa-plus menu-icon"></i>
                    <span class="menu-text">Tambah Program</span>
                </a>
            </div>
        </div>

        <!-- Event -->
        <a href="{{ route('admin.events.index') }}"
           class="menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt menu-icon"></i>
            <span class="menu-text">Kelola Event</span>
        </a>

        <!-- Pembayaran -->
        <a href="{{ route('admin.payments') }}"
           class="menu-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
            <i class="fas fa-credit-card menu-icon"></i>
            <span class="menu-text">Pembayaran</span>
        </a>

        <!-- Laporan & Analitik -->
        <a href="{{ route('admin.reports.index') }}"
           class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar menu-icon"></i>
            <span class="menu-text">Laporan & Analitik</span>
        </a>
    </nav>
</div>
@endsection

@push('styles')
<style>
/* Menu Container */
.px-2.py-4 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

/* Menu Items */
.menu-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    margin: 0.125rem 0;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #6b7280;
    transition: all 0.2s ease;
    position: relative;
}

.menu-item:hover {
    background-color: #f3f4f6;
    color: #374151;
    transform: translateX(2px);
}

.menu-item.active {
    background-color: #eff6ff;
    color: #2563eb;
    border-right: 3px solid #2563eb;
}

/* Menu Icons */
.menu-icon {
    width: 1.25rem;
    height: 1.25rem;
    margin-right: 0.75rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Menu Text */
.menu-text {
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.025em;
}

/* Active indicator */
.menu-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background-color: #2563eb;
    border-radius: 0 2px 2px 0;
}

/* Space between items */
.space-y-2 > * + * {
    margin-top: 0.5rem;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .menu-item {
        padding: 1rem 1.25rem;
        margin: 0.25rem 0;
    }

    .menu-icon {
        margin-right: 1rem;
    }

    .menu-text {
        font-size: 1rem;
    }
}

/* Dropdown Menu Styles */
.menu-dropdown {
    position: relative;
}

.dropdown-toggle {
    justify-content: space-between !important;
    width: 100%;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
}

.dropdown-arrow {
    transition: transform 0.2s ease;
    margin-left: auto;
    font-size: 0.75rem;
}

.dropdown-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    background-color: #f8fafc;
    border-radius: 0.375rem;
    margin: 0.25rem 0 0.5rem 1rem;
}

.menu-dropdown.open .dropdown-content {
    max-height: 200px;
    transition: max-height 0.3s ease-in;
}

.menu-dropdown.open .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
    text-decoration: none;
    color: #6b7280;
    transition: all 0.2s ease;
    border-radius: 0.25rem;
    margin: 0.125rem;
}

.dropdown-item:hover {
    background-color: #e5e7eb;
    color: #374151;
    transform: translateX(2px);
}

.dropdown-item.active {
    background-color: #dbeafe;
    color: #1d4ed8;
}

.dropdown-item .menu-icon {
    font-size: 0.875rem;
    margin-right: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced menu interactions
    const menuItems = document.querySelectorAll('.menu-item:not(.dropdown-toggle)');
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    menuItems.forEach(item => {
        // Add subtle animation on click
        item.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
    });

    // Handle dropdown functionality
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.closest('.menu-dropdown');
            const isOpen = dropdown.classList.contains('open');
            
            // Close all other dropdowns
            document.querySelectorAll('.menu-dropdown.open').forEach(openDropdown => {
                if (openDropdown !== dropdown) {
                    openDropdown.classList.remove('open');
                }
            });
            
            // Toggle current dropdown
            if (isOpen) {
                dropdown.classList.remove('open');
            } else {
                dropdown.classList.add('open');
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-dropdown')) {
            document.querySelectorAll('.menu-dropdown.open').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        }
    });

    // Auto-open dropdown if current page is in dropdown
    const activeDropdownItem = document.querySelector('.dropdown-item.active');
    if (activeDropdownItem) {
        const dropdown = activeDropdownItem.closest('.menu-dropdown');
        if (dropdown) {
            dropdown.classList.add('open');
        }
    }
});
</script>
@endpush