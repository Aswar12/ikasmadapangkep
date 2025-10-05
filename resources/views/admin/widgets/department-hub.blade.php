<!-- Department Management Shortcuts -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">
        <i class="fas fa-building mr-2 text-blue-600"></i>
        Department Management Hub
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Departemen Pendidikan & Pengembangan Karir -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-graduation-cap text-blue-600"></i>
                </div>
                <h4 class="ml-3 font-medium text-gray-900">Pendidikan & Karir</h4>
            </div>
            @php
                $pendidikanDept = \App\Models\Department::where('name', 'like', '%Pendidikan%')->first();
                $pendidikanPrograms = $pendidikanDept ? \App\Models\ProgramKerja::where('department_id', $pendidikanDept->id)->count() : 0;
                $pendidikanActive = $pendidikanDept ? \App\Models\ProgramKerja::where('department_id', $pendidikanDept->id)->where('status', 'ongoing')->count() : 0;
            @endphp
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Total Program:</span>
                    <span class="font-medium">{{ $pendidikanPrograms }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Aktif:</span>
                    <span class="font-medium text-green-600">{{ $pendidikanActive }}</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                @if($pendidikanDept)
                <a href="{{ route('admin.program-kerja.index') }}?department_id={{ $pendidikanDept->id }}" 
                   class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200">
                    Lihat Program
                </a>
                @endif
            </div>
        </div>

        <!-- Departemen Humas & Pengembangan Jaringan -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-network-wired text-green-600"></i>
                </div>
                <h4 class="ml-3 font-medium text-gray-900">Humas & Jaringan</h4>
            </div>
            @php
                $humasDept = \App\Models\Department::where('name', 'like', '%Humas%')->first();
                $humasPrograms = $humasDept ? \App\Models\ProgramKerja::where('department_id', $humasDept->id)->count() : 0;
                $humasActive = $humasDept ? \App\Models\ProgramKerja::where('department_id', $humasDept->id)->where('status', 'ongoing')->count() : 0;
            @endphp
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Total Program:</span>
                    <span class="font-medium">{{ $humasPrograms }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Aktif:</span>
                    <span class="font-medium text-green-600">{{ $humasActive }}</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                @if($humasDept)
                <a href="{{ route('admin.program-kerja.index') }}?department_id={{ $humasDept->id }}" 
                   class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">
                    Lihat Program
                </a>
                @endif
            </div>
        </div>

        <!-- Departemen Agama, Budaya & Kemasyarakatan -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-mosque text-purple-600"></i>
                </div>
                <h4 class="ml-3 font-medium text-gray-900">Agama & Budaya</h4>
            </div>
            @php
                $agamaDept = \App\Models\Department::where('name', 'like', '%Agama%')->first();
                $agamaPrograms = $agamaDept ? \App\Models\ProgramKerja::where('department_id', $agamaDept->id)->count() : 0;
                $agamaActive = $agamaDept ? \App\Models\ProgramKerja::where('department_id', $agamaDept->id)->where('status', 'ongoing')->count() : 0;
            @endphp
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Total Program:</span>
                    <span class="font-medium">{{ $agamaPrograms }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Aktif:</span>
                    <span class="font-medium text-green-600">{{ $agamaActive }}</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                @if($agamaDept)
                <a href="{{ route('admin.program-kerja.index') }}?department_id={{ $agamaDept->id }}" 
                   class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded hover:bg-purple-200">
                    Lihat Program
                </a>
                @endif
            </div>
        </div>

        <!-- Departemen Pembinaan Aparatur Organisasi -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-users-cog text-orange-600"></i>
                </div>
                <h4 class="ml-3 font-medium text-gray-900">Pembinaan Aparatur</h4>
            </div>
            @php
                $aparaturDept = \App\Models\Department::where('name', 'like', '%Aparatur%')->first();
                $aparaturPrograms = $aparaturDept ? \App\Models\ProgramKerja::where('department_id', $aparaturDept->id)->count() : 0;
                $aparaturActive = $aparaturDept ? \App\Models\ProgramKerja::where('department_id', $aparaturDept->id)->where('status', 'ongoing')->count() : 0;
            @endphp
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Total Program:</span>
                    <span class="font-medium">{{ $aparaturPrograms }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Aktif:</span>
                    <span class="font-medium text-green-600">{{ $aparaturActive }}</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                @if($aparaturDept)
                <a href="{{ route('admin.program-kerja.index') }}?department_id={{ $aparaturDept->id }}" 
                   class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded hover:bg-orange-200">
                    Lihat Program
                </a>
                @endif
            </div>
        </div>

        <!-- Departemen Keuangan & Kewirausahaan -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-coins text-yellow-600"></i>
                </div>
                <h4 class="ml-3 font-medium text-gray-900">Keuangan & Wirausaha</h4>
            </div>
            @php
                $keuanganDept = \App\Models\Department::where('name', 'like', '%Keuangan%')->first();
                $keuanganPrograms = $keuanganDept ? \App\Models\ProgramKerja::where('department_id', $keuanganDept->id)->count() : 0;
                $keuanganActive = $keuanganDept ? \App\Models\ProgramKerja::where('department_id', $keuanganDept->id)->where('status', 'ongoing')->count() : 0;
            @endphp
            <div class="space-y-2 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Total Program:</span>
                    <span class="font-medium">{{ $keuanganPrograms }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Aktif:</span>
                    <span class="font-medium text-green-600">{{ $keuanganActive }}</span>
                </div>
            </div>
            <div class="mt-3 flex space-x-2">
                @if($keuanganDept)
                <a href="{{ route('admin.program-kerja.index') }}?department_id={{ $keuanganDept->id }}" 
                   class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">
                    Lihat Program
                </a>
                @endif
                <a href="{{ route('admin.payments') }}" 
                   class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">
                    Pembayaran
                </a>
            </div>
        </div>

        <!-- Quick Add Program -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors">
            <div class="text-center">
                <div class="p-3 bg-gray-100 rounded-lg inline-block mb-3">
                    <i class="fas fa-plus text-2xl text-gray-600"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">Tambah Program Baru</h4>
                <p class="text-sm text-gray-600 mb-4">Buat program kerja untuk departemen</p>
                <a href="{{ route('admin.program-kerja.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Program
                </a>
            </div>
        </div>
    </div>

    <!-- Department Actions -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.departments.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-chart-pie mr-2"></i>
                Dashboard Departemen
            </a>
            <a href="{{ route('admin.program-kerja.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>
                Analytics Program
            </a>
            <a href="{{ route('admin.reports.department') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-file-alt mr-2"></i>
                Laporan Departemen
            </a>
        </div>
    </div>
</div>