<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Pending Approval Requests') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ __('These users have registered and verified their email but are awaiting your approval.') }}</p>
                    </div>

                    @if ($pendingUsers->count() > 0)
                        <form method="POST" action="{{ route('admin.users.batch-approve') }}">
                            @csrf
                            
                            <div class="mb-4 flex justify-end">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Approve Selected') }}
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="py-3 px-6 text-left">
                                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </th>
                                            <th class="py-3 px-6 text-left">{{ __('Name') }}</th>
                                            <th class="py-3 px-6 text-left">{{ __('Email') }}</th>
                                            <th class="py-3 px-6 text-left">{{ __('Graduation Year') }}</th>
                                            <th class="py-3 px-6 text-left">{{ __('Registered At') }}</th>
                                            <th class="py-3 px-6 text-left">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($pendingUsers as $user)
                                            <tr>
                                                <td class="py-4 px-6">
                                                    <input type="checkbox" name="users[]" value="{{ $user->id }}" class="user-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                </td>
                                                <td class="py-4 px-6">{{ $user->name }}</td>
                                                <td class="py-4 px-6">{{ $user->email }}</td>
                                                <td class="py-4 px-6">{{ $user->graduation_year }}</td>
                                                <td class="py-4 px-6">{{ $user->created_at->format('M d, Y H:i') }}</td>
                                                <td class="py-4 px-6">
                                                    <div class="flex space-x-2">
                                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                                {{ __('Approve') }}
                                                            </button>
                                                        </form>
                                                        
                                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="inline">
                                                            @csrf
                                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Are you sure you want to reject this user?')">
                                                                {{ __('Reject') }}
                                                            </button>
                                                        </form>
                                                        
                                                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                            {{ __('View Details') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        
                        <div class="mt-4">
                            {{ $pendingUsers->links() }}
                        </div>
                        
                        <!-- JavaScript for Select All functionality -->
                        <script>
                            document.getElementById('select-all').addEventListener('change', function() {
                                const checkboxes = document.querySelectorAll('.user-checkbox');
                                for (const checkbox of checkboxes) {
                                    checkbox.checked = this.checked;
                                }
                            });
                        </script>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-600">{{ __('No pending approval requests at this time.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
