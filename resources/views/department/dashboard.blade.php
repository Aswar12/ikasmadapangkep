{{-- Department Coordinator Dashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Department Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Programs Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-tasks mr-3 text-gray-500"></i>
                                    Department Programs
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Active Programs: 
                                        <span class="font-semibold">
                                            {{ \App\Models\ProgramKerja::where('department_id', auth()->user()->department_id)->count() }}
                                        </span>
                                    </p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Manage Programs
                                </a>
                            </div>
                        </div>

                        {{-- Members Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-users mr-3 text-gray-500"></i>
                                    Department Members
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Total Members: 
                                        <span class="font-semibold">
                                            {{ \App\Models\User::whereHas('departments', function($q) {
                                                $q->where('department_id', auth()->user()->department_id);
                                            })->count() }}
                                        </span>
                                    </p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Members
                                </a>
                            </div>
                        </div>

                        {{-- Reports Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-chart-pie mr-3 text-gray-500"></i>
                                    Program Reports
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Programs in Progress: 
                                        <span class="font-semibold">
                                            {{ \App\Models\ProgramKerja::where('department_id', auth()->user()->department_id)
                                                ->where('status', 'in_progress')->count() }}
                                        </span>
                                    </p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
