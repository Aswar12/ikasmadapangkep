<div class="space-y-6">
    <!-- Program Header -->
    <div class="border-b border-gray-200 pb-4">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-semibold text-gray-900">{{ $programKerja->nama_program }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ $programKerja->department->nama ?? 'N/A' }}</p>
            </div>
            <div class="text-right">
                @php
                    $statusColors = [
                        'planning' => 'bg-gray-100 text-gray-800',
                        'ongoing' => 'bg-yellow-100 text-yellow-800',
                        'review' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'delayed' => 'bg-red-100 text-red-800'
                    ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$programKerja->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($programKerja->status) }}
                </span>
                <div class="text-sm text-gray-600 mt-1">
                    Progress: {{ $programKerja->progress_percentage ?? 0 }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Program Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                <div class="flex items-center mt-1">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-sm font-medium text-gray-700">
                            {{ substr($programKerja->penanggungJawab->name ?? 'N/A', 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $programKerja->penanggungJawab->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $programKerja->penanggungJawab->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $programKerja->tanggal_mulai ? \Carbon\Carbon::parse($programKerja->tanggal_mulai)->format('d F Y') : 'Belum ditentukan' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deadline</label>
                <p class="mt-1 text-sm text-gray-900">
                    {{ $programKerja->deadline ? \Carbon\Carbon::parse($programKerja->deadline)->format('d F Y') : 'Belum ditentukan' }}
                </p>
            </div>

            @if($programKerja->anggaran)
            <div>
                <label class="block text-sm font-medium text-gray-700">Anggaran</label>
                <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($programKerja->anggaran) }}</p>
                @if($programKerja->anggaran_terpakai)
                    <p class="text-sm text-red-600">Terpakai: Rp {{ number_format($programKerja->anggaran_terpakai) }}</p>
                @endif
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="space-y-4">
            <!-- Progress Circle -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full">
                    <span class="text-2xl font-bold text-gray-900">{{ $programKerja->progress_percentage ?? 0 }}%</span>
                </div>
                <p class="text-sm text-gray-600 mt-2">Progress Completion</p>
            </div>

            <!-- Time Remaining -->
            @if($programKerja->deadline)
                @php
                    $deadline = \Carbon\Carbon::parse($programKerja->deadline);
                    $now = \Carbon\Carbon::now();
                    $isOverdue = $deadline->isPast() && $programKerja->status !== 'completed';
                    $daysRemaining = $isOverdue ? $now->diffInDays($deadline) : $deadline->diffInDays($now);
                @endphp
                <div class="text-center p-3 {{ $isOverdue ? 'bg-red-50' : 'bg-blue-50' }} rounded-lg">
                    <div class="text-lg font-semibold {{ $isOverdue ? 'text-red-700' : 'text-blue-700' }}">
                        {{ $daysRemaining }} Days
                    </div>
                    <div class="text-sm {{ $isOverdue ? 'text-red-600' : 'text-blue-600' }}">
                        {{ $isOverdue ? 'Overdue' : 'Remaining' }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Description -->
    @if($programKerja->deskripsi)
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
        <div class="p-3 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-700">{{ $programKerja->deskripsi }}</p>
        </div>
    </div>
    @endif

    <!-- Recent Updates -->
    @if($programKerja->updates && $programKerja->updates->count() > 0)
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Recent Updates</label>
        <div class="space-y-3 max-h-40 overflow-y-auto">
            @foreach($programKerja->updates->take(5) as $update)
            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-xs font-medium text-white">
                            {{ substr($update->user->name ?? 'U', 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">{{ $update->description }}</p>
                    <p class="text-xs text-gray-500">
                        {{ $update->created_at->diffForHumans() }} by {{ $update->user->name ?? 'Unknown' }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
            Close
        </button>
        <a href="{{ route('admin.program-kerja.edit', $programKerja->id) }}" 
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
            Edit Program
        </a>
        @if($programKerja->status !== 'completed')
        <button onclick="updateProgramProgress({{ $programKerja->id }})" 
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
            Update Progress
        </button>
        @endif
    </div>
</div>

<script>
function updateProgramProgress(programId) {
    const currentProgress = {{ $programKerja->progress_percentage ?? 0 }};
    const newProgress = prompt(`Current progress: ${currentProgress}%\nEnter new progress (0-100):`, currentProgress);
    
    if (newProgress !== null && !isNaN(newProgress) && newProgress >= 0 && newProgress <= 100) {
        fetch(`/admin/program-kerja/${programId}/update-progress`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                progress_percentage: parseInt(newProgress)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                location.reload();
            } else {
                alert('Failed to update progress');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating progress');
        });
    }
}
</script>