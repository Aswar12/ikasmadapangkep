@php
    $priority = $program->prioritas ?? 'medium';
    $priorityClass = [
        'high' => 'priority-high',
        'medium' => 'priority-medium', 
        'low' => 'priority-low'
    ][$priority] ?? 'priority-medium';
    
    $departmentColors = [
        'Pendidikan & Pengembangan Karir' => 'bg-blue-100 text-blue-700',
        'Humas & Pengembangan Jaringan' => 'bg-green-100 text-green-700',
        'Agama, Budaya & Kemasyarakatan' => 'bg-purple-100 text-purple-700',
        'Pembinaan Aparatur Organisasi' => 'bg-orange-100 text-orange-700',
        'Keuangan & Kewirausahaan' => 'bg-yellow-100 text-yellow-700'
    ];
    
    $deptName = $program->department->name ?? 'N/A';
    $deptColor = $departmentColors[$deptName] ?? 'bg-gray-100 text-gray-700';
    
    $progress = $program->progress ?? 0;
    $isOverdue = $program->end_date && \Carbon\Carbon::parse($program->end_date)->isPast() && $program->status !== 'completed';
@endphp

<div class="kanban-card {{ $priorityClass }}" 
     data-program-id="{{ $program->id }}" 
     data-department="{{ $program->department_id }}"
     data-priority="{{ $priority }}">
    
    <!-- Drag Handle -->
    <div class="drag-handle">
        <i class="fas fa-grip-vertical"></i>
    </div>
    
    <!-- Status Indicator -->
    <div class="status-indicator status-{{ $program->status }}"></div>
    
    <!-- Card Header -->
    <div class="flex items-start justify-between mb-3">
        <h4 class="font-semibold text-gray-900 text-sm leading-tight pr-6">
            {{ Str::limit($program->name, 40) }}
        </h4>
        <div class="flex space-x-1 ml-2">
            @if($isOverdue)
                <i class="fas fa-exclamation-triangle text-red-500 text-xs" title="Program Terlambat"></i>
            @endif
            <button onclick="openProgramDetail({{ $program->id }})" 
                    class="text-gray-400 hover:text-gray-600 text-xs transition-colors"
                    title="Lihat Detail Program">
                <i class="fas fa-external-link-alt"></i>
            </button>
        </div>
    </div>
    
    <!-- Department Badge -->
    <div class="mb-3">
        <span class="department-badge {{ $deptColor }}">
            {{ Str::limit($deptName, 20) }}
        </span>
    </div>
    
    <!-- Progress Section -->
    <div class="mb-3">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs font-medium text-gray-600">Progress</span>
            <span class="text-xs font-bold text-gray-900 progress-text">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            @php
                $progressColor = $progress == 100 ? 'bg-green-500' : ($progress >= 50 ? 'bg-blue-500' : 'bg-yellow-500');
            @endphp
            <div class="progress-bar {{ $progressColor }} h-2 rounded-full transition-all duration-300" 
                 style="width: {{ $progress }}%"></div>
        </div>
    </div>
    
    <!-- PIC & Deadline -->
    <div class="flex items-center justify-between text-xs text-gray-600 mb-3">
        <div class="flex items-center">
            <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center mr-2">
                <span class="text-xs font-medium text-gray-700">
                    {{ substr($program->pic->name ?? 'N/A', 0, 1) }}
                </span>
            </div>
            <span>{{ Str::limit($program->pic->name ?? 'N/A', 15) }}</span>
        </div>
        @if($program->end_date)
            <span class="flex items-center {{ $isOverdue ? 'text-red-600 font-medium' : '' }}">
                <i class="fas fa-calendar mr-1"></i>
                {{ \Carbon\Carbon::parse($program->end_date)->format('M d') }}
            </span>
        @endif
    </div>
    
    <!-- Budget Info -->
    @if($program->budget)
    <div class="mb-3 p-2 bg-gray-50 rounded text-xs">
        <div class="flex justify-between">
            <span class="text-gray-600">Budget:</span>
            <span class="font-medium">Rp {{ number_format($program->budget) }}</span>
        </div>
        @if($program->realization)
        <div class="flex justify-between mt-1">
            <span class="text-gray-600">Used:</span>
            <span class="font-medium text-red-600">Rp {{ number_format($program->realization) }}</span>
        </div>
        @endif
    </div>
    @endif
    
    <!-- Tags/Labels -->
    <div class="flex flex-wrap gap-1 mb-3">
        @if($priority === 'high')
            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded">High Priority</span>
        @endif
        @if($program->is_strategic ?? false)
            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded">Strategic</span>
        @endif
        @if($program->deadline && \Carbon\Carbon::parse($program->deadline)->diffInDays(now()) <= 7 && $program->status !== 'completed')
            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded">Due Soon</span>
        @endif
    </div>
    
    <!-- Action Buttons -->
    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
        <div class="flex space-x-2">
            <button onclick="editProgram({{ $program->id }})" 
                    class="text-blue-600 hover:text-blue-800 text-xs" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            <button onclick="updateProgress({{ $program->id }})" 
                    class="text-green-600 hover:text-green-800 text-xs" title="Update Progress">
                <i class="fas fa-chart-line"></i>
            </button>
            <button onclick="addNote({{ $program->id }})" 
                    class="text-purple-600 hover:text-purple-800 text-xs" title="Add Note">
                <i class="fas fa-sticky-note"></i>
            </button>
        </div>
        
        @if($program->updates && $program->updates->count() > 0)
            <div class="flex items-center text-xs text-gray-500">
                <i class="fas fa-comment mr-1"></i>
                <span>{{ $program->updates->count() }}</span>
            </div>
        @endif
    </div>
</div>

<script>
function openProgramDetail(programId) {
    window.open(`/admin/program-kerja/${programId}`, '_blank');
}

function editProgram(programId) {
    window.location.href = `/admin/program-kerja/${programId}/edit`;
}

function updateProgress(programId) {
    const newProgress = prompt('Enter new progress percentage (0-100):');
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

function addNote(programId) {
    const note = prompt('Add a note for this program:');
    if (note) {
        fetch(`/admin/program-kerja/${programId}/add-note`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                note: note
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Note added successfully!', 'success');
            } else {
                showNotification('Failed to add note', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding note', 'error');
        });
    }
}
</script>