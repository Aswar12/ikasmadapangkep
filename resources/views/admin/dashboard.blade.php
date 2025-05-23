{{-- Admin Dashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- User Management Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-users mr-3 text-gray-500"></i>
                                    User Management
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Total Users: <span class="font-semibold">{{ \App\Models\User::count() }}</span></p>
                                    <p class="mb-4">Pending Approvals: 
                                        <span class="font-semibold">
                                            {{ \App\Models\User::where('approved', false)->where('email_verified_at', '!=', null)->count() }}
                                        </span>
                                    </p>
                                </div>
                                <a href="{{ route('admin.users.approval') }}" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Manage Users
                                </a>
                            </div>
                        </div>

                        {{-- Departments Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-building mr-3 text-gray-500"></i>
                                    Departments
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Total Departments: 
                                        <span class="font-semibold">{{ \App\Models\Department::count() }}</span>
                                    </p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Manage Departments
                                </a>
                            </div>
                        </div>

                        {{-- Reports Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-chart-bar mr-3 text-gray-500"></i>
                                    Reports
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Active Alumni: 
                                        <span class="font-semibold">
                                            {{ \App\Models\User::where('role', 'alumni')->where('active', true)->count() }}
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
