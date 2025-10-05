@extends('layouts.dashboard')

@section('page-title', 'Kanban Board Program Kerja')

@section('navigation')
    @include('admin.menu')
@endsection

@push('styles')
<style>
/* Enhanced Kanban Board Styles */
.kanban-board {
    display: flex;
    gap: 1.5rem;
    overflow-x: auto;
    padding: 1.5rem 0;
    min-height: calc(100vh - 300px);
    position: relative;
}

.kanban-board::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #10b981, #f59e0b, #ef4444, #6b7280);
    border-radius: 2px;
    z-index: 1;
}

.kanban-column {
    background: #f8fafc;
    border-radius: 0.75rem;
    padding: 1.25rem;
    min-height: 70vh;
    width: 320px;
    flex-shrink: 0;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
    position: relative;
}

.kanban-column:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.kanban-column.drag-over {
    background: #e0f2fe;
    border-color: #0ea5e9;
    box-shadow: 0 0 20px rgba(14, 165, 233, 0.3);
}

.kanban-column.drag-over::after {
    content: 'Lepaskan di sini';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #0ea5e9;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    z-index: 10;
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.kanban-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
    background: linear-gradient(135deg, rgba(255,255,255,0.8) 0%, rgba(248,250,252,0.8) 100%);
    padding: 1rem 1.25rem;
    margin: -1.25rem -1.25rem 1.25rem -1.25rem;
    border-radius: 0.75rem 0.75rem 0 0;
    border-bottom: 2px solid #e2e8f0;
}

.kanban-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.kanban-header .help-icon {
    color: #6b7280;
    cursor: help;
    font-size: 0.875rem;
    margin-left: 0.25rem;
}

.kanban-header .help-icon:hover {
    color: #374151;
}

.count-badge {
    background: rgba(0,0,0,0.1);
    color: rgba(0,0,0,0.8);
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    min-width: 2rem;
    text-align: center;
}

.kanban-cards {
    max-height: calc(70vh - 80px);
    overflow-y: auto;
    padding-right: 0.5rem;
}

.kanban-cards::-webkit-scrollbar {
    width: 6px;
}

.kanban-cards::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.kanban-cards::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.kanban-cards::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.kanban-card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
    cursor: move;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    position: relative;
}

.kanban-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
    border-color: #cbd5e1;
}

.kanban-card.dragging {
    opacity: 0.8;
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    z-index: 1000;
}

.kanban-card:last-child {
    margin-bottom: 0;
}

.kanban-card.drag-placeholder {
    background: #f1f5f9;
    border: 2px dashed #cbd5e1;
    opacity: 0.5;
}

/* Status indicators */
.status-indicator {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
}

.status-planning { background: #6b7280; }
.status-ongoing { background: #f59e0b; }
.status-completed { background: #10b981; }
.status-delayed { background: #ef4444; }
.status-cancelled { background: #6b7280; }

/* Priority indicators */
.priority-high { border-left: 4px solid #ef4444; }
.priority-medium { border-left: 4px solid #f59e0b; }
.priority-low { border-left: 4px solid #10b981; }

/* Progress bar enhancements */
.progress-bar {
    transition: all 0.3s ease;
}

.progress-text {
    font-weight: 600;
}

/* Drag handle */
.drag-handle {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    color: #9ca3af;
    cursor: grab;
    font-size: 0.75rem;
}

.drag-handle:active {
    cursor: grabbing;
}

.kanban-card.dragging .drag-handle {
    color: #6b7280;
}

/* Tooltips */
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 200px;
    background-color: #374151;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 12px;
    position: absolute;
    z-index: 1000;
    bottom: 125%;
    left: 50%;
    margin-left: -100px;
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 0.75rem;
    line-height: 1.4;
}

.tooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #374151 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

/* Welcome guide */
.welcome-guide {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    text-align: center;
}

.welcome-guide h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.welcome-guide p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.guide-steps {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 1.5rem;
}

.guide-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.guide-step i {
    font-size: 2rem;
    color: rgba(255,255,255,0.8);
}

.guide-step span {
    font-size: 0.875rem;
    font-weight: 500;
}

/* Quick actions enhancement */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.quick-action-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1rem;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
}

.quick-action-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.quick-action-card i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

.quick-action-card h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.quick-action-card p {
    font-size: 0.75rem;
    color: #6b7280;
}

/* Empty states enhancement */
.empty-state {
    color: #9ca3af;
    user-select: none;
    padding: 2rem 1rem;
}

.empty-state i {
    opacity: 0.5;
    margin-bottom: 1rem;
    display: block;
}

.empty-state p {
    font-size: 0.875rem;
    margin: 0;
    font-weight: 500;
}

.empty-state .empty-action {
    margin-top: 1rem;
}

.empty-state .empty-action a {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

.empty-state .empty-action a:hover {
    text-decoration: underline;
}

/* Loading states */
.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.75rem;
    z-index: 10;
}

.loading-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid #e2e8f0;
    border-top: 3px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Drag and Drop Enhancements */
.kanban-card-ghost {
    opacity: 0.4;
    transform: rotate(5deg) scale(1.05);
}

.kanban-card-dragging {
    transform: rotate(2deg) scale(1.02);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.kanban-card-chosen {
    cursor: grabbing;
}

/* Notification System */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.notification.success { background: #10b981; }
.notification.error { background: #ef4444; }
.notification.info { background: #3b82f6; }
.notification.warning { background: #f59e0b; }

/* Responsive Design */
@media (max-width: 768px) {
    .kanban-board {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem 0;
    }

    .kanban-column {
        width: 100%;
        min-height: 400px;
        margin-bottom: 1rem;
    }

    .kanban-cards {
        max-height: 300px;
    }

    .dashboard-container {
        padding: 1rem;
    }

    .guide-steps {
        flex-direction: column;
        gap: 1rem;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .kanban-card {
        padding: 1rem;
    }

    .kanban-header {
        padding: 0.75rem 1rem;
    }

    .kanban-header h3 {
        font-size: 1rem;
    }
}

/* Loading states */
.kanban-column.loading {
    opacity: 0.7;
    pointer-events: none;
}

.kanban-column.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 24px;
    height: 24px;
    margin: -12px 0 0 -12px;
    border: 2px solid #e2e8f0;
    border-top: 2px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Welcome Guide -->
    <div class="welcome-guide">
        <h2>🎯 Panduan Menggunakan Kanban Board</h2>
        <p>Kelola program kerja dengan mudah menggunakan sistem kanban interaktif ini</p>

        <div class="guide-steps">
            <div class="guide-step">
                <i class="fas fa-hand-paper"></i>
                <span>Drag & Drop</span>
            </div>
            <div class="guide-step">
                <i class="fas fa-eye"></i>
                <span>Lihat Progress</span>
            </div>
            <div class="guide-step">
                <i class="fas fa-filter"></i>
                <span>Filter Program</span>
            </div>
            <div class="guide-step">
                <i class="fas fa-external-link-alt"></i>
                <span>Detail Program</span>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kanban Board Program Kerja</h1>
            <p class="text-gray-600 mt-2">Visualisasi progress program kerja dalam bentuk board interaktif</p>
            <div class="mt-2 text-sm text-gray-500">
                💡 <strong>Tip:</strong> Seret kartu program ke kolom yang sesuai untuk mengubah statusnya
            </div>
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <!-- Filter Departemen -->
            <div class="relative">
                <select id="departmentFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                <div class="tooltip">
                    <i class="fas fa-info-circle text-gray-400 ml-2 cursor-help"></i>
                    <span class="tooltiptext">Filter program berdasarkan departemen</span>
                </div>
            </div>

            <!-- Filter Prioritas -->
            <div class="relative">
                <select id="priorityFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Prioritas</option>
                    <option value="high">🔴 High Priority</option>
                    <option value="medium">🟡 Medium Priority</option>
                    <option value="low">🟢 Low Priority</option>
                </select>
                <div class="tooltip">
                    <i class="fas fa-info-circle text-gray-400 ml-2 cursor-help"></i>
                    <span class="tooltiptext">Filter program berdasarkan tingkat prioritas</span>
                </div>
            </div>

            <a href="{{ route('admin.program-kerja.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Tambah Program
            </a>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-gray-100 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-gray-700">{{ $statistics['planning'] }}</div>
            <div class="text-sm text-gray-600">Planning</div>
        </div>
        <div class="bg-yellow-100 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-yellow-700">{{ $statistics['ongoing'] }}</div>
            <div class="text-sm text-yellow-600">Ongoing</div>
        </div>
        <div class="bg-green-100 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-700">{{ $statistics['completed'] }}</div>
            <div class="text-sm text-green-600">Completed</div>
        </div>
        <div class="bg-red-100 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-red-700">{{ $statistics['delayed'] }}</div>
            <div class="text-sm text-red-600">Delayed</div>
        </div>
        <div class="bg-gray-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-gray-700">{{ $statistics['cancelled'] }}</div>
            <div class="text-sm text-gray-600">Cancelled</div>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="kanban-board" id="kanbanBoard">
        <!-- Planning Column -->
        <div class="kanban-column status-planning" data-status="planning">
            <div class="kanban-header">
                <h3 class="font-semibold text-gray-700 flex items-center">
                    <i class="fas fa-clipboard-list mr-2 text-gray-500"></i>
                    Planning
                    <div class="tooltip">
                        <i class="fas fa-question-circle help-icon"></i>
                        <span class="tooltiptext">Program yang sedang direncanakan dan belum dimulai</span>
                    </div>
                </h3>
                <span class="count-badge">{{ $programsByStatus['planning']->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="planning">
                @if($programsByStatus['planning']->count() > 0)
                    @foreach($programsByStatus['planning'] as $program)
                        @include('admin.program-kerja.partials.kanban-card', ['program' => $program])
                    @endforeach
                @else
                    <div class="empty-state text-center py-8 text-gray-400">
                        <i class="fas fa-clipboard-list text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada program dalam perencanaan</p>
                        <div class="empty-action">
                            <a href="{{ route('admin.program-kerja.create') }}">+ Buat Program Baru</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ongoing Column -->
        <div class="kanban-column status-ongoing" data-status="ongoing">
            <div class="kanban-header">
                <h3 class="font-semibold text-yellow-700 flex items-center">
                    <i class="fas fa-cogs mr-2 text-yellow-600"></i>
                    Sedang Berjalan
                    <div class="tooltip">
                        <i class="fas fa-question-circle help-icon"></i>
                        <span class="tooltiptext">Program yang sedang dalam pelaksanaan aktif</span>
                    </div>
                </h3>
                <span class="count-badge">{{ $programsByStatus['ongoing']->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="ongoing">
                @if($programsByStatus['ongoing']->count() > 0)
                    @foreach($programsByStatus['ongoing'] as $program)
                        @include('admin.program-kerja.partials.kanban-card', ['program' => $program])
                    @endforeach
                @else
                    <div class="empty-state text-center py-8 text-gray-400">
                        <i class="fas fa-cogs text-3xl mb-2"></i>
                        <p class="text-sm">Tidak ada program yang sedang berjalan</p>
                        <div class="empty-action">
                            <small class="text-gray-500">Seret program dari kolom Planning ke sini</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Completed Column -->
        <div class="kanban-column status-completed" data-status="completed">
            <div class="kanban-header">
                <h3 class="font-semibold text-green-700 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                    Selesai
                    <div class="tooltip">
                        <i class="fas fa-question-circle help-icon"></i>
                        <span class="tooltiptext">Program yang telah selesai 100% dan berhasil</span>
                    </div>
                </h3>
                <span class="count-badge">{{ $programsByStatus['completed']->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="completed">
                @if($programsByStatus['completed']->count() > 0)
                    @foreach($programsByStatus['completed'] as $program)
                        @include('admin.program-kerja.partials.kanban-card', ['program' => $program])
                    @endforeach
                @else
                    <div class="empty-state text-center py-8 text-gray-400">
                        <i class="fas fa-check-circle text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada program yang selesai</p>
                        <div class="empty-action">
                            <small class="text-gray-500">Program akan otomatis pindah ke sini saat progress 100%</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Delayed Column -->
        <div class="kanban-column status-delayed" data-status="delayed">
            <div class="kanban-header">
                <h3 class="font-semibold text-red-700 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2 text-red-600"></i>
                    Tertunda
                    <div class="tooltip">
                        <i class="fas fa-question-circle help-icon"></i>
                        <span class="tooltiptext">Program yang mengalami keterlambatan atau masalah</span>
                    </div>
                </h3>
                <span class="count-badge">{{ $programsByStatus['delayed']->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="delayed">
                @if($programsByStatus['delayed']->count() > 0)
                    @foreach($programsByStatus['delayed'] as $program)
                        @include('admin.program-kerja.partials.kanban-card', ['program' => $program])
                    @endforeach
                @else
                    <div class="empty-state text-center py-8 text-gray-400">
                        <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                        <p class="text-sm">Tidak ada program yang tertunda</p>
                        <div class="empty-action">
                            <small class="text-gray-500">Program akan otomatis pindah ke sini jika melewati deadline</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cancelled Column -->
        <div class="kanban-column status-cancelled" data-status="cancelled">
            <div class="kanban-header">
                <h3 class="font-semibold text-gray-700 flex items-center">
                    <i class="fas fa-times-circle mr-2 text-gray-500"></i>
                    Dibatalkan
                    <div class="tooltip">
                        <i class="fas fa-question-circle help-icon"></i>
                        <span class="tooltiptext">Program yang telah dibatalkan atau dihentikan</span>
                    </div>
                </h3>
                <span class="count-badge">{{ $programsByStatus['cancelled']->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="cancelled">
                @if($programsByStatus['cancelled']->count() > 0)
                    @foreach($programsByStatus['cancelled'] as $program)
                        @include('admin.program-kerja.partials.kanban-card', ['program' => $program])
                    @endforeach
                @else
                    <div class="empty-state text-center py-8 text-gray-400">
                        <i class="fas fa-times-circle text-3xl mb-2"></i>
                        <p class="text-sm">Tidak ada program yang dibatalkan</p>
                        <div class="empty-action">
                            <small class="text-gray-500">Program yang dibatalkan akan muncul di sini</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
            Quick Actions
        </h3>

        <div class="quick-actions-grid">
            <div class="quick-action-card" onclick="refreshBoard()">
                <i class="fas fa-sync-alt text-blue-500"></i>
                <h4>Refresh Board</h4>
                <p>Perbarui tampilan board dengan data terbaru</p>
            </div>

            <div class="quick-action-card" onclick="exportBoard()">
                <i class="fas fa-download text-green-500"></i>
                <h4>Export Board</h4>
                <p>Unduh laporan board dalam format PDF</p>
            </div>

            <a href="{{ route('admin.program-kerja.calendar') }}" class="quick-action-card">
                <i class="fas fa-calendar text-purple-500"></i>
                <h4>View Calendar</h4>
                <p>Lihat timeline program dalam kalender 5 tahun</p>
            </a>

            <a href="{{ route('admin.program-kerja.index') }}" class="quick-action-card">
                <i class="fas fa-list text-gray-500"></i>
                <h4>Table View</h4>
                <p>Lihat program dalam format tabel detail</p>
            </a>

            <div class="quick-action-card" onclick="showHelp()">
                <i class="fas fa-question-circle text-indigo-500"></i>
                <h4>Bantuan</h4>
                <p>Panduan lengkap penggunaan kanban board</p>
            </div>

            <div class="quick-action-card" onclick="showKeyboardShortcuts()">
                <i class="fas fa-keyboard text-orange-500"></i>
                <h4>Shortcut Keys</h4>
                <p>Tampilkan pintasan keyboard yang tersedia</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let draggedElement = null;
    let placeholder = null;
    let originalColumn = null;

    // Initialize Sortable for each column
    document.querySelectorAll('.kanban-cards').forEach(column => {
        new Sortable(column, {
            group: 'kanban-cards',
            animation: 150,
            ghostClass: 'kanban-card-ghost',
            dragClass: 'kanban-card-dragging',
            chosenClass: 'kanban-card-chosen',
            filter: '.empty-state',
            
            onStart: function(evt) {
                draggedElement = evt.item;
                originalColumn = evt.from;
                
                // Add visual feedback
                draggedElement.classList.add('dragging');
                document.body.style.cursor = 'grabbing';
                
                // Create placeholder
                placeholder = document.createElement('div');
                placeholder.className = 'kanban-card drag-placeholder';
                placeholder.innerHTML = '<div class="text-center text-gray-400 py-4"><i class="fas fa-plus-circle text-2xl mb-2"></i><p class="text-sm">Letakkan program di sini</p></div>';
                
                // Show drag feedback on all columns
                document.querySelectorAll('.kanban-column').forEach(col => {
                    if (col !== originalColumn.closest('.kanban-column')) {
                        col.classList.add('drag-over');
                    }
                });
            },
            
            onEnd: function(evt) {
                draggedElement.classList.remove('dragging');
                document.body.style.cursor = 'default';
                
                // Remove drag feedback
                document.querySelectorAll('.kanban-column').forEach(col => {
                    col.classList.remove('drag-over');
                });
                
                // Check if item was moved to different column
                if (evt.from !== evt.to) {
                    const programId = evt.item.dataset.programId;
                    const newStatus = evt.to.dataset.status;
                    
                    // Show loading state
                    showLoading(evt.to.closest('.kanban-column'));
                    
                    // Update status via AJAX
                    updateProgramStatus(programId, newStatus, evt.to.closest('.kanban-column'));
                }
            },
            
            onMove: function(evt) {
                // Remove placeholder from old position
                if (placeholder && placeholder.parentNode) {
                    placeholder.parentNode.removeChild(placeholder);
                }
                
                // Add placeholder to new position
                if (evt.related) {
                    evt.related.parentNode.insertBefore(placeholder, evt.related);
                } else {
                    evt.to.appendChild(placeholder);
                }
            }
        });
    });

    // Filter functionality
    document.getElementById('departmentFilter').addEventListener('change', filterPrograms);
    document.getElementById('priorityFilter').addEventListener('change', filterPrograms);

    // Auto-refresh every 30 seconds
    setInterval(refreshBoard, 30000);
});

function showLoading(column) {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = '<div class="loading-spinner"></div>';
    column.style.position = 'relative';
    column.appendChild(overlay);
    
    setTimeout(() => {
        if (overlay.parentNode) {
            overlay.parentNode.removeChild(overlay);
        }
    }, 2000);
}

function updateProgramStatus(programId, newStatus, targetColumn) {
    fetch(`/admin/program-kerja/${programId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update statistics
            updateStatistics();
            
            // Show success message
            showNotification('Status program berhasil diperbarui!', 'success');
            
            // Remove loading state
            const overlay = targetColumn.querySelector('.loading-overlay');
            if (overlay) {
                overlay.remove();
            }
        } else {
            throw new Error(data.message || 'Gagal memperbarui status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Gagal memperbarui status program', 'error');
        
        // Revert the move
        location.reload();
    });
}

function updateStatistics() {
    fetch('/admin/program-kerja/statistics')
        .then(response => response.json())
        .then(data => {
            // Update statistics display
            document.querySelector('.bg-gray-100 .text-2xl').textContent = data.planning;
            document.querySelector('.bg-yellow-100 .text-2xl').textContent = data.ongoing;
            document.querySelector('.bg-green-100 .text-2xl').textContent = data.completed;
            document.querySelector('.bg-red-100 .text-2xl').textContent = data.delayed;
            document.querySelector('.bg-gray-200 .text-2xl').textContent = data.cancelled;
            
            // Update column headers
            updateColumnCounts(data);
        })
        .catch(error => console.error('Error updating statistics:', error));
}

function updateColumnCounts(data) {
    const columns = {
        'planning': data.planning,
        'ongoing': data.ongoing,
        'completed': data.completed,
        'delayed': data.delayed,
        'cancelled': data.cancelled
    };
    
    Object.keys(columns).forEach(status => {
        const badge = document.querySelector(`[data-status="${status}"] .count-badge`);
        if (badge) {
            badge.textContent = columns[status];
        }
    });
}

function filterPrograms() {
    const departmentId = document.getElementById('departmentFilter').value;
    const priority = document.getElementById('priorityFilter').value;
    
    const url = new URL(window.location);
    if (departmentId) url.searchParams.set('department_id', departmentId);
    else url.searchParams.delete('department_id');
    
    if (priority) url.searchParams.set('priority', priority);
    else url.searchParams.delete('priority');
    
    window.location.href = url.href;
}

function refreshBoard() {
    showNotification('Memperbarui board...', 'info');
    location.reload();
}

function exportBoard() {
    const departmentId = document.getElementById('departmentFilter').value;
    let exportUrl = '/admin/program-kerja/export-calendar?format=pdf';
    
    if (departmentId) {
        exportUrl += `&department_id=${departmentId}`;
    }
    
    window.open(exportUrl, '_blank');
}

function openProgramDetail(programId) {
    window.open(`/admin/program-kerja/${programId}`, '_blank');
}

function showNotification(message, type = 'info') {
    // Simple notification system
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
        type === 'info' ? 'bg-blue-500' : 'bg-gray-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function showHelp() {
    const helpContent = `
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                <h3 class="text-xl font-bold mb-4">Panduan Kanban Board</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <h4 class="font-semibold">🎯 Cara Menggunakan:</h4>
                        <ul class="list-disc list-inside ml-4 mt-2">
                            <li>Seret kartu program dari kolom satu ke kolom lainnya</li>
                            <li>Klik ikon detail untuk melihat informasi lengkap program</li>
                            <li>Gunakan filter untuk mencari program tertentu</li>
                            <li>Progress otomatis terupdate saat status berubah</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold">📊 Status Program:</h4>
                        <ul class="list-disc list-inside ml-4 mt-2">
                            <li><strong>Planning:</strong> Program dalam tahap perencanaan</li>
                            <li><strong>Sedang Berjalan:</strong> Program aktif dikerjakan</li>
                            <li><strong>Selesai:</strong> Program telah selesai 100%</li>
                            <li><strong>Tertunda:</strong> Program mengalami keterlambatan</li>
                            <li><strong>Dibatalkan:</strong> Program dihentikan</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-blue-500 text-white rounded">Tutup</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', helpContent);
}

function showKeyboardShortcuts() {
    const shortcuts = `
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-xl font-bold mb-4">Keyboard Shortcuts</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>R:</span><span>Refresh Board</span></div>
                    <div class="flex justify-between"><span>F:</span><span>Focus Search</span></div>
                    <div class="flex justify-between"><span>1-5:</span><span>Pindah ke Kolom (Planning-Ongoing-Completed-Delayed-Cancelled)</span></div>
                    <div class="flex justify-between"><span>Esc:</span><span>Tutup Modal/Help</span></div>
                </div>
                <div class="mt-6 text-right">
                    <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-blue-500 text-white rounded">Tutup</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', shortcuts);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') return;
    
    switch(e.key.toLowerCase()) {
        case 'r':
            e.preventDefault();
            refreshBoard();
            break;
        case 'f':
            e.preventDefault();
            document.getElementById('departmentFilter').focus();
            break;
        case '?':
            e.preventDefault();
            showHelp();
            break;
    }
});
</script>
@endpush
@endsection