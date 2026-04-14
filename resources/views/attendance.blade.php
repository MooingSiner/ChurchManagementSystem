<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance - Church Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  <div class="min-h-screen">
    <!-- Header with Navigation -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center gap-3">
            <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
            <h1 class="text-xl font-semibold text-gray-900">Church Management</h1>
          </div>
          <div class="flex items-center gap-4">
            <button class="relative p-2 text-gray-600 hover:text-gray-900">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
              </svg>
              <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
            </button>
            <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Logout</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-8">
          <a href="{{ route('dashboard') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Dashboard</a>
          <a href="{{ route('member') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Members</a>
          <a href="{{ route('event') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Reports</a>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Header -->
        <div>
          <h2 class="text-3xl font-semibold text-gray-900">Attendance</h2>
          <p class="text-gray-600 mt-2">Manage attendance records and approve member submissions</p>
        </div>

        <!-- Event Selection -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Select Event</h3>
          </div>
          <div class="px-6 py-4">
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="">Choose an event...</option>
              <option value="1" selected>Sunday Worship Service - 04/13/2026</option>
              <option value="2">Wednesday Prayer Meeting - 04/16/2026</option>
              <option value="3">Easter Thanksgiving Service - 03/31/2026</option>
            </select>

            <!-- Selected Event Info -->
            <div class="mt-4 p-4 bg-gray-50 rounded-lg space-y-2">
              <div class="flex items-center gap-2 text-sm">
                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>04/13/2026 at 10:00 AM</span>
              </div>
              <div class="text-sm text-gray-600">Worship Service</div>
            </div>
          </div>
        </div>

        <!-- Attendance Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Approved</p>
                  <p class="text-3xl font-semibold text-gray-900">28</p>
                </div>
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Pending Approval</p>
                  <p class="text-3xl font-semibold text-gray-900">5</p>
                </div>
                <svg class="h-8 w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Records</p>
                  <p class="text-3xl font-semibold text-gray-900">33</p>
                </div>
                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Add Attendance Manually -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h3 class="text-lg font-semibold flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Add Attendance Manually
              </h3>
            </div>
            <div class="px-6 py-4">
              <div class="space-y-4">
                <!-- Search Bar -->
                <div class="relative">
                  <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                  <input
                    type="text"
                    placeholder="Search members by name or email..."
                    class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>

                <!-- Member List -->
                <div class="space-y-2 max-h-[400px] overflow-y-auto">
                  <!-- Member Item 1 -->
                  <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="flex-1">
                      <div class="font-medium">John Smith</div>
                      <div class="text-sm text-gray-600">john.smith@email.com</div>
                    </div>
                    <button class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
                      Add
                    </button>
                  </div>

                  <!-- Member Item 2 -->
                  <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="flex-1">
                      <div class="font-medium">Sarah Johnson</div>
                      <div class="text-sm text-gray-600">sarah.j@email.com</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded">
                      Added
                    </span>
                  </div>

                  <!-- Member Item 3 -->
                  <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                    <div class="flex-1">
                      <div class="font-medium">Michael Brown</div>
                      <div class="text-sm text-gray-600">m.brown@email.com</div>
                    </div>
                    <button class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
                      Add
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pending Attendance -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold flex items-center gap-2">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  Pending Attendance
                </h3>
                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded">
                  5
                </span>
              </div>
            </div>
            <div class="px-6 py-4">
              <div class="space-y-3 max-h-[400px] overflow-y-auto">
                <!-- Pending Item 1 -->
                <div class="p-3 border border-amber-200 bg-amber-50 rounded-lg space-y-3">
                  <div>
                    <div class="font-medium">Emily Davis</div>
                    <div class="text-sm text-gray-600">
                      Submitted: 04/13/2026, 9:45 AM
                    </div>
                  </div>
                  <div class="flex gap-2">
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Approve
                    </button>
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Reject
                    </button>
                  </div>
                </div>

                <!-- Pending Item 2 -->
                <div class="p-3 border border-amber-200 bg-amber-50 rounded-lg space-y-3">
                  <div>
                    <div class="font-medium">Robert Wilson</div>
                    <div class="text-sm text-gray-600">
                      Submitted: 04/13/2026, 9:52 AM
                    </div>
                  </div>
                  <div class="flex gap-2">
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Approve
                    </button>
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Reject
                    </button>
                  </div>
                </div>

                <!-- Pending Item 3 -->
                <div class="p-3 border border-amber-200 bg-amber-50 rounded-lg space-y-3">
                  <div>
                    <div class="font-medium">Linda Martinez</div>
                    <div class="text-sm text-gray-600">
                      Submitted: 04/13/2026, 10:02 AM
                    </div>
                  </div>
                  <div class="flex gap-2">
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Approve
                    </button>
                    <button class="flex-1 flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Reject
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Approved Attendance List -->
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Approved Attendance (28)</h3>
          </div>
          <div class="px-6 py-4">
            <div class="space-y-2">
              <!-- Approved Item 1 -->
              <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="font-medium">John Smith</div>
                    <div class="text-sm text-gray-600">04/13/2026, 9:30 AM</div>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>

              <!-- Approved Item 2 -->
              <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="font-medium">Sarah Johnson</div>
                    <div class="text-sm text-gray-600">04/13/2026, 9:35 AM</div>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>

              <!-- Approved Item 3 -->
              <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="font-medium">Michael Brown</div>
                    <div class="text-sm text-gray-600">04/13/2026, 9:38 AM</div>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>

              <!-- Approved Item 4 -->
              <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="font-medium">Jessica Anderson</div>
                    <div class="text-sm text-gray-600">04/13/2026, 9:40 AM</div>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>

              <!-- Approved Item 5 -->
              <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                <div class="flex items-center gap-3">
                  <div>
                    <div class="font-medium">David Thompson</div>
                    <div class="text-sm text-gray-600">04/13/2026, 9:42 AM</div>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>