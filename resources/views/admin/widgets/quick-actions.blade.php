@php
    // Get quick statistics for admin overview
    $quickStats = [
        'pending_users' => \App\Models\User::where('status', 'pending')->count(),
        'total_departments' => \App\Models\Department::count(),
        'active_programs' => \App\Models\ProgramKerja::where('status', 'ongoing')->count(),
        'pending_payments' => \App\Models\Payment::where('status', 'pending')->count(),
        'recent_registrations' => \App\Models\User::where('created_at', '>=', now()->subDays(7))->count(),
    ];
@endphp

<!-- Quick Admin Actions Widget -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i>
        Quick Actions & Alerts
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Pending User Approvals -->
        @if($quickStats['pending_users'] > 0)
        <a href="{{ route('admin.users.pending') }}" 
           class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-orange-500 text-white rounded-lg group-hover:bg-orange-600 transition-colors">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">{{ $quickStats['pending_users'] }} Pending Users</p>
                <p class="text-sm text-gray-600">Perlu approval</p>
            </div>
            <div class="ml-auto">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                    Urgent
                </span>
            </div>
        </a>
        @endif

        <!-- Pending Payments -->
        @if($quickStats['pending_payments'] > 0)
        <a href="{{ route('admin.payments') }}?status=pending" 
           class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-yellow-500 text-white rounded-lg group-hover:bg-yellow-600 transition-colors">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">{{ $quickStats['pending_payments'] }} Pending Payments</p>
                <p class="text-sm text-gray-600">Butuh verifikasi</p>
            </div>
        </a>
        @endif

        <!-- Active Programs -->
        <a href="{{ route('admin.program-kerja.index') }}?status=ongoing" 
           class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-blue-500 text-white rounded-lg group-hover:bg-blue-600 transition-colors">
                    <i class="fas fa-cogs"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">{{ $quickStats['active_programs'] }} Active Programs</p>
                <p class="text-sm text-gray-600">Sedang berjalan</p>
            </div>
        </a>

        <!-- Recent Registrations -->
        @if($quickStats['recent_registrations'] > 0)
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-green-500 text-white rounded-lg group-hover:bg-green-600 transition-colors">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">{{ $quickStats['recent_registrations'] }} New Users</p>
                <p class="text-sm text-gray-600">7 hari terakhir</p>
            </div>
        </a>
        @endif

        <!-- Department Overview -->
        <a href="{{ route('admin.departments.dashboard') }}" 
           class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-purple-500 text-white rounded-lg group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">{{ $quickStats['total_departments'] }} Departments</p>
                <p class="text-sm text-gray-600">Lihat dashboard</p>
            </div>
        </a>

        <!-- Program Kerja Dashboard -->
        <a href="{{ route('admin.program-kerja.dashboard') }}" 
           class="flex items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors group">
            <div class="flex-shrink-0">
                <div class="p-2 bg-indigo-500 text-white rounded-lg group-hover:bg-indigo-600 transition-colors">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-900">Program Analytics</p>
                <p class="text-sm text-gray-600">Lihat progress</p>
            </div>
        </a>
    </div>
</div>

<!-- System Health Overview -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        <i class="fas fa-heartbeat mr-2 text-red-600"></i>
        System Health
    </h3>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-2">
                <i class="fas fa-database text-green-600"></i>
            </div>
            <p class="text-sm font-medium text-gray-900">Database</p>
            <p class="text-xs text-green-600">Healthy</p>
        </div>
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-2">
                <i class="fas fa-users text-blue-600"></i>
            </div>
            <p class="text-sm font-medium text-gray-900">Active Users</p>
            <p class="text-xs text-blue-600">{{ \App\Models\User::where('is_active', true)->count() }}</p>
        </div>
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-full mb-2">
                <i class="fas fa-server text-yellow-600"></i>
            </div>
            <p class="text-sm font-medium text-gray-900">Storage</p>
            <p class="text-xs text-yellow-600">Normal</p>
        </div>
        
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mb-2">
                <i class="fas fa-shield-alt text-purple-600"></i>
            </div>
            <p class="text-sm font-medium text-gray-900">Security</p>
            <p class="text-xs text-purple-600">Active</p>
        </div>
    </div>
</div>