{{-- Alumni Dashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Profile Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-3 text-gray-500"></i>
                                    My Profile
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-2">Name: <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                                    <p class="mb-2">Batch: <span class="font-semibold">{{ auth()->user()->graduation_year }}</span></p>
                                    <p class="mb-2">Email: <span class="font-semibold">{{ auth()->user()->email }}</span></p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Update Profile
                                </a>
                            </div>
                        </div>

                        {{-- Events Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-calendar-alt mr-3 text-gray-500"></i>
                                    Upcoming Events
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">No upcoming events</p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View All Events
                                </a>
                            </div>
                        </div>

                        {{-- Alumni Directory Card --}}
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center">
                                    <i class="fas fa-users mr-3 text-gray-500"></i>
                                    Alumni Directory
                                </h3>
                                <div class="text-gray-600">
                                    <p class="mb-4">Connect with your fellow alumni</p>
                                </div>
                                <a href="#" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Search Directory
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
