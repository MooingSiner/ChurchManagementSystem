<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Church Management System</title>
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
    <div class="flex items-center gap-2 text-gray-700 font-medium">
        <img src="{{ asset('images/icons/user-icon.png') }}" alt="User Icon" class="h-6 w-6">

        {{ Auth::user()->username }}
    </div>

    <!-- Logout -->
    <form action="{{ route('auth.logout') }}" method="POST">
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
          <a href="{{ route('dashboard') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600">Dashboard</a>
          <a href="{{ route('members.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Members</a>
          <a href="{{ route('events.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Reports</a>
                  </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-8">
        <div>
          <h2 class="text-3xl font-semibold text-gray-900">Dashboard</h2>
          <p class="text-gray-600 mt-2">Welcome to your church management system</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Total Members Card -->
          <div class="bg-white rounded-lg shadow border">
  <div class="px-6 py-4 space-y-4">
    
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm text-gray-600">Total Members</p>
        <p class="text-xs text-gray-500 mt-1">42 approved <span class="text-amber-600">• 3 pending</span></p>
      </div>

      <div class="flex items-center gap-2">
        <span class="text-3xl font-semibold text-gray-900 leading-none">45</span>
        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
      </div>
    </div>

    <a href="#" class="text-sm text-blue-600 hover:underline inline-block">View all members</a>
  </div>
</div>

          <!-- Total Events Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-600">Total Events</h3>
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div class="text-3xl font-semibold text-gray-900 text-right">12</div>
              <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">View all events</a>
            </div>
          </div>

          <!-- Attendance Records Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-600">Attendance Records</h3>
                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
              </div>
              <div class="text-3xl font-semibold text-gray-900 text-right">328</div>
              <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Mark attendance</a>
            </div>
          </div>

          <!-- Average Attendance Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pb-2">
                <h3 class="text-sm font-medium text-gray-600">Average Attendance</h3>
                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
              </div>
              <div class="text-3xl font-semibold text-gray-900 text-right">27</div>
              <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">View reports</a>
            </div>
          </div>
        </div>

        <!-- Recent Events Chart (Placeholder) -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Recent Event Attendance</h3>
          </div>
          <div class="px-6 py-4">
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
              <p class="text-gray-500">Chart placeholder - Bar chart showing attendance data</p>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Quick Actions</h3>
          </div>
          <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <a href="#" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <div>
                  <div class="font-medium text-gray-900">Add New Member</div>
                  <div class="text-sm text-gray-600">Register a new church member</div>
                </div>
              </a>

              <a href="#" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div>
                  <div class="font-medium text-gray-900">Create Event</div>
                  <div class="text-sm text-gray-600">Schedule a new church event</div>
                </div>
              </a>

              <a href="#" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <div>
                  <div class="font-medium text-gray-900">Mark Attendance</div>
                  <div class="text-sm text-gray-600">Record attendance for an event</div>
                </div>
              </a>

              <a href="#" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <div>
                  <div class="font-medium text-gray-900">View Reports</div>
                  <div class="text-sm text-gray-600">Access analytics and insights</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
    function toggleNotifications(event) {
    event.stopPropagation();

    const dropdown = document.getElementById('notificationDropdown');
    const isHidden = dropdown.classList.contains('opacity-0');

    if (isHidden) {
        dropdown.classList.remove('opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
        dropdown.classList.add('opacity-100', 'scale-100', 'translate-y-0');
    } else {
        dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
    }
}

document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('notificationDropdown');

    if (!e.target.closest('#notificationDropdown') && !e.target.closest('button')) {
        dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
    }
});
</script>
</html>