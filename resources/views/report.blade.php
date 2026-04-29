<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports - Church Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
 <style>
  body {
    font-family: 'Nunito', sans-serif;
  }

  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }

  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }

  @keyframes pageFadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes cardFadeUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes modalPop {
    from { opacity: 0; transform: translateY(8px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
  }

  @media (prefers-reduced-motion: no-preference) {
    .min-h-screen > .max-w-7xl { animation: pageFadeUp 260ms ease-out both; }
    .rounded-lg.shadow, .rounded-lg.shadow-sm { animation: cardFadeUp 240ms ease-out both; }
    .fixed:not(.hidden) > .bg-white { animation: modalPop 180ms ease-out both; }
    button, a.inline-flex { transition-property: transform, color, background-color, border-color, box-shadow, opacity; }
    button:hover, a.inline-flex:hover { transform: translateY(-1px); }
  }
</style>
</head>
<body class="bg-gray-50 bg-gradient-to-br from-blue-50 via-white to-purple-50">
  <div class="min-h-screen">
    <!-- Header with Navigation -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 py-4 sm:h-16 sm:flex-row sm:items-center sm:justify-between">
          <div class="flex items-center gap-3">
            <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
            <h1 class="text-xl font-semibold text-gray-900">Church Management</h1>
          </div>
          <div class="flex flex-wrap items-center gap-2 sm:gap-4">

    <!-- Logged-in User -->
    <div class="flex items-center gap-2 text-gray-700">
        <img src="{{ asset('images/icons/user-icon.png') }}" alt="User Icon" class="h-6 w-6">
        <div class="leading-tight">
          <div class="font-medium">{{ Auth::user()->username }}</div>
          <div class="text-xs text-gray-500">{{ $currentRoleLabel }}</div>
        </div>
    </div>

    <!-- Logout -->
    <form action="{{ route('auth.logout') }}" method="POST" onsubmit = "return confirmForm(this, 'Confirm Logout', 'Are you sure you want to logout?')">

        @csrf
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-[#111827] border border-gray-300 rounded-md bg-[#F2F8FF] hover:bg-[#e8f1fb] transition-colors duration-200">          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Logout
        </button>
    </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-4 overflow-x-auto whitespace-nowrap scrollbar-hide">
          <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 border-b-2 border-transparent py-4 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
          </a>
          @if(Auth::user()->role === 'super_admin')
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 border-b-2 border-transparent py-4 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              Members
            </a>
          @endif
          <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 border-b-2 border-transparent py-4 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Events
          </a>
          <a href="{{ route('attendance') }}" class="inline-flex items-center gap-2 border-b-2 border-transparent py-4 px-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Attendance
            @if(($navigationBadges['attendance_pending'] ?? 0) > 0)
              <span class="inline-flex min-w-[1.25rem] items-center justify-center rounded-full bg-amber-100 px-1.5 py-0.5 text-xs font-semibold leading-none text-amber-700">
                {{ $navigationBadges['attendance_pending'] }}
              </span>
            @endif
          </a>
          <a href="{{ route('report') }}" class="inline-flex items-center gap-2 border-b-2 border-blue-600 py-4 px-3 text-sm font-medium text-blue-600 duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Reports
          </a>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div>
            <h2 class="text-3xl font-semibold text-gray-900">Reports & Analytics</h2>
            <p class="text-gray-600 mt-2">Comprehensive insights into church attendance and member engagement</p>
          </div>
          <form method="GET" action="{{ route('report') }}" class="w-full sm:w-56">
          <select name="range" onchange="this.form.submit()"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="7days" {{ $range === '7days' ? 'selected' : '' }}>Last 7 Days</option>
              <option value="30days" {{ $range === '30days' ? 'selected' : '' }}>Last 30 Days</option>
              <option value="90days" {{ $range === '90days' ? 'selected' : '' }}>Last 90 Days</option>
              <option value="all" {{ $range === 'all' ? 'selected' : '' }}>All Time</option>
          </select>
          </form>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Members</p>
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalMembers }}</p>
                </div>
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Events</p>
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalEvents }}</p>
                </div>
                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm text-gray-600">Approved Attendance</p>
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalAttendance }}</p>
                </div>
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm text-gray-600">Avg. Attendance / Session</p>
                  <p class="text-3xl font-semibold text-gray-900">{{ $avgAttendance }}</p>
                </div>
                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Report History -->
<div class="bg-white rounded-lg shadow border">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold">Report History</h3>
    </div>

    <div class="px-6 py-4">
        <div class="space-y-2 max-h-[560px] overflow-y-auto pr-2">
    @forelse($reportHistory as $session)
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="flex-1">
                <div class="font-medium text-gray-900">{{ $session->attendance_name }}</div>
                <div class="flex items-center gap-4 mt-1 text-sm text-gray-600 flex-wrap">
                    <div class="text-gray-700">
                        {{ $session->event->event_name ?? 'No event' }}
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($session->attendance_date)->format('F d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>
                            {{ $session->time_in_start ? \Carbon\Carbon::parse($session->time_in_start)->format('h:i A') : 'No time in' }}
                            -
                            {{ $session->time_out_end ? \Carbon\Carbon::parse($session->time_out_end)->format('h:i A') : 'No time out' }}
                        </span>
                    </div>
                    <div class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700">
                        {{ $session->event->type->type_name ?? 'No Type' }}
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-semibold text-blue-600">{{ $session->approved_attendance_count }}</div>
                <div class="text-xs text-gray-500">members attended</div>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-500">No report history available.</p>
       @endforelse
    </div>
  </div>
</div>

        <!-- Attendance Trends Chart -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Attendance by Event</h3>
          </div>
          <div class="px-6 py-4 h-64">
          <canvas id="attendanceByEventChart"></canvas>
          </div>
        </div>

        <!-- Pie Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Attendance by Event Type -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h3 class="text-lg font-semibold">Attendance by Event Type</h3>
            </div>
            <div class="px-6 py-4 h-64">
            <canvas id="attendanceByTypeChart"></canvas>
            </div>
          </div>

          <!-- Member Status -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h3 class="text-lg font-semibold">Member Status</h3>
            </div>
            <div class="px-6 py-4 h-64">
            <canvas id="memberStatusChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script>
function showToast(message, type = 'success') {
    Toastify({
        text: message,
        duration: 3000,
        gravity: "top",
        position: "right",
        close: true,
        style: {
            background: type === 'error' ? "#7f1d1d" : "#030213",
            color: "#F2F8FF",
            borderRadius: "8px",
            padding: "12px 16px",
            fontFamily: "Nunito"
        }
    }).showToast();
}
</script>
  <script>
    const attendanceByEventLabels = @json($attendanceByEvent->pluck('label'));
    const attendanceByEventData = @json($attendanceByEvent->pluck('count'));

    const attendanceByTypeLabels = @json($attendanceByTypeQuery->pluck('type_name'));
    const attendanceByTypeData = @json($attendanceByTypeQuery->pluck('total'));

    const memberStatusLabels = ['Members Attended', 'Members Not Attended'];
    const memberStatusData = [{{ $memberStatus['attended'] }}, {{ $memberStatus['not_attended'] }}];

    new Chart(document.getElementById('attendanceByEventChart'), {
        type: 'bar',
        data: {
            labels: attendanceByEventLabels,
            datasets: [{
                label: 'Approved Attendance',
                data: attendanceByEventData
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('attendanceByTypeChart'), {
        type: 'pie',
        data: {
            labels: attendanceByTypeLabels,
            datasets: [{
                data: attendanceByTypeData
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    new Chart(document.getElementById('memberStatusChart'), {
        type: 'pie',
        data: {
            labels: memberStatusLabels,
            datasets: [{
                data: memberStatusData
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-[9999]">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">

        <h3 id="confirmTitle" class="text-xl font-semibold text-gray-900 mb-3">
            Confirm Action
        </h3>

        <p id="confirmMessage" class="text-sm text-gray-600 mb-6">
            Are you sure?
        </p>

        <div class="flex justify-end gap-3">

            <!-- Cancel -->
            <button type="button" onclick="closeConfirmModal()"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </button>

            <!-- Confirm (UPDATED COLOR) -->
            <button type="button" id="confirmButton"
                class="px-4 py-2 rounded-md text-sm font-medium bg-[#030213] text-[#F2F8FF] hover:bg-[#0a0920] transition">
                Confirm
            </button>

        </div>
    </div>
</div>
<script>
  let selectedForm = null;

function confirmForm(form, title, message) {
    selectedForm = form;

    document.getElementById('confirmTitle').innerText = title;
    document.getElementById('confirmMessage').innerText = message;
    document.getElementById('confirmModal').classList.remove('hidden');

    return false;
}
function closeConfirmModal() {
    selectedForm = null;
    document.getElementById('confirmModal').classList.add('hidden');
}

document.getElementById('confirmButton').addEventListener('click', function () {
    if (selectedForm) {
        selectedForm.submit();
    }
});

function dangerconfirmForm(form, title, message) {
    selectedForm = form;

    document.getElementById('dangerTitle').innerText = title;
    document.getElementById('dangerMessage').innerText = message;
    document.getElementById('dangerConfirmModal').classList.remove('hidden');
    document.getElementById('dangerConfirmButton').addEventListener('click', function () {
    if (selectedForm) {
        selectedForm.submit();
    }
});
    

    return false;
}

function closeDangerModal() {
    selectedForm = null;
    document.getElementById('dangerConfirmModal').classList.add('hidden');


    return false;
}
  
</script>
@if(session('success'))
<script>
    showToast("{{ session('success') }}", "success");
</script>
@endif

@if(session('error'))
<script>
    showToast("{{ session('error') }}", "error");
</script>
@endif

</body>

</html>
