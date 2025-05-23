{{-- Sub Admin Dashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Batch Coordinator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Batch Members Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-user-graduate mr-3 text-gray-500"></i>
                                    Batch Members
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Total Members: <span class="font-semibold">{{ \App\Models\User::where('graduation_year', auth()->user()->graduation_year)->count() }}</span></p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Members
                                </a>
                            </div>
                        </div>

                        {{-- Events Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-calendar-alt mr-3 text-gray-500"></i>
                                    Batch Events
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Upcoming Events: <span class="font-semibold">0</span></p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Manage Events
                                </a>
                            </div>
                        </div>

                        {{-- Announcements Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-bullhorn mr-3 text-gray-500"></i>
                                    Batch Announcements
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Latest Updates: <span class="font-semibold">0</span></p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Post Announcement
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
