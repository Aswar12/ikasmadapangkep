@extends('layouts.dashboard')

@section('page-title', 'Kalender Program Kerja 5 Tahun')

@section('navigation')
    @include('admin.menu')
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
.timeline-container {
    background: white;
    border-radius: 0.75rem;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.year-timeline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 2rem;
    position: relative;
}

.year-timeline::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(to right, #3b82f6, #8b5cf6, #06b6d4, #10b981, #f59e0b);
    z-index: 1;
}

.year-marker {
    background: white;
    border: 3px solid #3b82f6;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    position: relative;
    z-index: 2;
    cursor: pointer;
    transition: all 0.3s;
}

.year-marker:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.year-marker.active {
    background: #3b82f6;
    color: white;
}

.year-marker .year-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.year-marker.active .year-label {
    color: #bfdbfe;
}

.calendar-container {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.fc-theme-standard .fc-scrollgrid {
    border: 1px solid #e5e7eb;
}

.fc-theme-standard td, .fc-theme-standard th {
    border-color: #e5e7eb;
}

.program-event {
    cursor: pointer;
    border-radius: 4px;
    font-size: 0.75rem;
    padding: 2px 4px;
}

.program-event.dept-pendidikan { background-color: #3b82f6; }
.program-event.dept-humas { background-color: #10b981; }
.program-event.dept-agama { background-color: #8b5cf6; }
.program-event.dept-aparatur { background-color: #f59e0b; }
.program-event.dept-keuangan { background-color: #ef4444; }

.milestone-marker {
    position: absolute;
    width: 12px;
    height: 12px;
    background: #dc2626;
    border-radius: 50%;
    top: -6px;
    left: 50%;
    transform: translateX(-50%);
}

.statistics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
}

.legend {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
}
</style>
@endpush

@section('content')
<div class="dashboard-container space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kalender Program Kerja 5 Tahun</h1>
            <p class="text-gray-600 mt-2">Timeline lengkap masa jabatan pengurus {{ $termPeriod['start'] }} - {{ $termPeriod['end'] }}</p>
        </div>
        <div class="mt-6 md:mt-0 flex space-x-4">
            <select id="departmentFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Departemen</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->nama }}</option>
                @endforeach
            </select>
            
            <select id="viewMode" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="dayGridMonth">Month View</option>
                <option value="dayGridYear">Year View</option>
                <option value="listYear">List View</option>
                <option value="timelineYear">Timeline</option>
            </select>
            
            <button onclick="exportCalendar()" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Calendar
            </button>
        </div>
    </div>

    <!-- 5-Year Timeline Navigation -->
    <div class="timeline-container">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Masa Jabatan Pengurus</h3>
        <div class="year-timeline">
            @for($i = 0; $i < 5; $i++)
                @php
                    $year = $termPeriod['start'] + $i;
                    $isCurrentYear = $year == date('Y');
                @endphp
                <div class="year-marker {{ $isCurrentYear ? 'active' : '' }}" 
                     data-year="{{ $year }}" 
                     onclick="navigateToYear({{ $year }})">
                    <div class="text-lg font-bold">{{ $year }}</div>
                    <div class="year-label">Tahun {{ $i + 1 }}</div>
                </div>
            @endfor
        </div>
        
        <!-- Key Milestones -->
        <div class="mt-6">
            <h4 class="font-semibold text-gray-800 mb-3">Key Milestones</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                    <div>
                        <div class="font-medium text-blue-900">Periode 1-2</div>
                        <div class="text-sm text-blue-700">Foundation & Setup</div>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <div class="font-medium text-green-900">Periode 3-4</div>
                        <div class="text-sm text-green-700">Growth & Expansion</div>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                    <div>
                        <div class="font-medium text-purple-900">Periode 5</div>
                        <div class="text-sm text-purple-700">Legacy & Transition</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="statistics-grid">
        <div class="stat-card">
            <div class="text-3xl font-bold text-blue-600">{{ $statistics['total_programs'] }}</div>
            <div class="text-sm text-gray-600">Total Program</div>
            <div class="text-xs text-gray-500 mt-1">5 Tahun</div>
        </div>
        
        <div class="stat-card">
            <div class="text-3xl font-bold text-green-600">{{ $statistics['completed'] }}</div>
            <div class="text-sm text-gray-600">Completed</div>
            <div class="text-xs text-gray-500 mt-1">{{ number_format($statistics['completion_rate'], 1) }}%</div>
        </div>
        
        <div class="stat-card">
            <div class="text-3xl font-bold text-yellow-600">{{ $statistics['ongoing'] }}</div>
            <div class="text-sm text-gray-600">In Progress</div>
            <div class="text-xs text-gray-500 mt-1">Active</div>
        </div>
        
        <div class="stat-card">
            <div class="text-3xl font-bold text-purple-600">{{ $statistics['upcoming'] }}</div>
            <div class="text-sm text-gray-600">Upcoming</div>
            <div class="text-xs text-gray-500 mt-1">Next Quarter</div>
        </div>
        
        <div class="stat-card">
            <div class="text-3xl font-bold text-red-600">Rp {{ number_format($statistics['total_budget'] / 1000000, 1) }}M</div>
            <div class="text-sm text-gray-600">Total Budget</div>
            <div class="text-xs text-gray-500 mt-1">5 Tahun</div>
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Legend</h3>
        <div class="legend">
            <div class="legend-item">
                <div class="legend-color bg-blue-500"></div>
                <span class="text-sm">Pendidikan & Karir</span>
            </div>
            <div class="legend-item">
                <div class="legend-color bg-green-500"></div>
                <span class="text-sm">Humas & Jaringan</span>
            </div>
            <div class="legend-item">
                <div class="legend-color bg-purple-500"></div>
                <span class="text-sm">Agama & Budaya</span>
            </div>
            <div class="legend-item">
                <div class="legend-color bg-yellow-500"></div>
                <span class="text-sm">Pembinaan Aparatur</span>
            </div>
            <div class="legend-item">
                <div class="legend-color bg-red-500"></div>
                <span class="text-sm">Keuangan & Wirausaha</span>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    <!-- Program Details Modal -->
    <div id="programModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Program Details</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="programModalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
let calendar;
let currentYear = {{ date('Y') }};

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridYear,listYear'
        },
        height: 'auto',
        events: {!! json_encode($calendarEvents) !!},
        eventClick: function(info) {
            showProgramDetails(info.event.extendedProps.program_id);
        },
        eventDidMount: function(info) {
            // Add department-specific styling
            const dept = info.event.extendedProps.department;
            if (dept) {
                info.el.classList.add(`dept-${dept.toLowerCase().replace(/\s+/g, '-')}`);
            }
        },
        dateClick: function(info) {
            // Handle date click for adding new programs
            console.log('Date clicked:', info.dateStr);
        }
    });
    
    calendar.render();
    
    // Event listeners
    document.getElementById('departmentFilter').addEventListener('change', filterCalendar);
    document.getElementById('viewMode').addEventListener('change', changeView);
});

function navigateToYear(year) {
    currentYear = year;
    calendar.gotoDate(year + '-01-01');
    
    // Update active year marker
    document.querySelectorAll('.year-marker').forEach(marker => {
        marker.classList.remove('active');
    });
    document.querySelector(`[data-year="${year}"]`).classList.add('active');
    
    // Filter events for the selected year
    filterCalendarByYear(year);
}

function filterCalendar() {
    const departmentId = document.getElementById('departmentFilter').value;
    
    // Filter events based on department
    const allEvents = {!! json_encode($calendarEvents) !!};
    let filteredEvents = allEvents;
    
    if (departmentId) {
        filteredEvents = allEvents.filter(event => 
            event.extendedProps.department_id == departmentId
        );
    }
    
    // Remove all events and add filtered ones
    calendar.removeAllEvents();
    calendar.addEventSource(filteredEvents);
}

function filterCalendarByYear(year) {
    const startDate = year + '-01-01';
    const endDate = year + '-12-31';
    
    const allEvents = {!! json_encode($calendarEvents) !!};
    const yearEvents = allEvents.filter(event => {
        const eventDate = new Date(event.start);
        const eventYear = eventDate.getFullYear();
        return eventYear === year;
    });
    
    calendar.removeAllEvents();
    calendar.addEventSource(yearEvents);
}

function changeView() {
    const viewMode = document.getElementById('viewMode').value;
    calendar.changeView(viewMode);
}

function showProgramDetails(programId) {
    fetch(`/admin/program-kerja/${programId}/details`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('programModalContent').innerHTML = data.html;
            document.getElementById('programModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load program details');
        });
}

function closeModal() {
    document.getElementById('programModal').classList.add('hidden');
}

function exportCalendar() {
    const year = currentYear;
    const department = document.getElementById('departmentFilter').value;
    
    let exportUrl = `/admin/program-kerja/export-calendar?year=${year}`;
    if (department) {
        exportUrl += `&department_id=${department}`;
    }
    
    window.open(exportUrl, '_blank');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('programModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
@endpush
@endsection