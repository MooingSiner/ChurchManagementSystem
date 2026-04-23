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
          <a href="{{ route('dashboard') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Dashboard</a>
          <a href="{{ route('members.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Members</a>
          <a href="{{ route('events.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600 duration-200">Reports</a>
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
          <div class="w-full sm:w-56">
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="7days">Last 7 Days</option>
              <option value="30days" selected>Last 30 Days</option>
              <option value="90days">Last 90 Days</option>
              <option value="all">All Time</option>
            </select>
          </div>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Members</p>
                  <p class="text-3xl font-semibold text-gray-900">45</p>
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
                  <p class="text-3xl font-semibold text-gray-900">12</p>
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
                  <p class="text-sm text-gray-600">Total Attendance</p>
                  <p class="text-3xl font-semibold text-gray-900">328</p>
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
                  <p class="text-sm text-gray-600">Avg. Attendance</p>
                  <p class="text-3xl font-semibold text-gray-900">27</p>
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
            <div class="space-y-2">
              <!-- Report Item 1 -->
              <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">Sunday Worship Service</div>
                  <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      <span>April 13, 2026</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      <span>10:00 AM</span>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-semibold text-blue-600">33</div>
                  <div class="text-xs text-gray-500">members attended</div>
                </div>
              </div>

              <!-- Report Item 2 -->
              <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">Wednesday Prayer Meeting</div>
                  <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      <span>April 9, 2026</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      <span>07:00 PM</span>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-semibold text-blue-600">18</div>
                  <div class="text-xs text-gray-500">members attended</div>
                </div>
              </div>

              <!-- Report Item 3 -->
              <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">Sunday Worship Service</div>
                  <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      <span>April 6, 2026</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      <span>10:00 AM</span>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-semibold text-blue-600">29</div>
                  <div class="text-xs text-gray-500">members attended</div>
                </div>
              </div>

              <!-- Report Item 4 -->
              <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="flex-1">
                  <div class="font-medium text-gray-900">Easter Thanksgiving Service</div>
                  <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      <span>March 31, 2026</span>
                    </div>
                    <div class="flex items-center gap-1">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      <span>09:00 AM</span>
                    </div>
                  </div>
                </div>
                <div class="text-right">
                  <div class="text-2xl font-semibold text-blue-600">42</div>
                  <div class="text-xs text-gray-500">members attended</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Attendance Trends Chart -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Attendance by Event</h3>
          </div>
          <div class="px-6 py-4">
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
              <p class="text-gray-500">Line chart placeholder - Attendance trends over time</p>
            </div>
          </div>
        </div>

        <!-- Pie Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Attendance by Event Type -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h3 class="text-lg font-semibold">Attendance by Event Type</h3>
            </div>
            <div class="px-6 py-4">
              <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
                <div class="text-center">
                  <p class="text-gray-500 mb-4">Pie chart placeholder</p>
                  <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 justify-center">
                      <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                      <span>Worship Service: 65%</span>
                    </div>
                    <div class="flex items-center gap-2 justify-center">
                      <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                      <span>Prayer Meeting: 25%</span>
                    </div>
                    <div class="flex items-center gap-2 justify-center">
                      <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                      <span>Thanksgiving: 10%</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Member Status -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h3 class="text-lg font-semibold">Member Status</h3>
            </div>
            <div class="px-6 py-4">
              <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
                <div class="text-center">
                  <p class="text-gray-500 mb-4">Pie chart placeholder</p>
                  <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 justify-center">
                      <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                      <span>Members Attended: 38</span>
                    </div>
                    <div class="flex items-center gap-2 justify-center">
                      <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                      <span>Members Not Attended: 7</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
    
</script>
</html>