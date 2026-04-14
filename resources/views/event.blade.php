<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events - Church Management System</title>
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
          <a href="{{ route('event') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">Reports</a>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-3xl font-semibold text-gray-900">Events</h2>
            <p class="text-gray-600 mt-2">Manage church events and activities</p>
          </div>
          <button onclick="openEventModal()" class="inline-flex items-center gap-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Event
          </button>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Event Card 1 - Active -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <div class="flex items-start justify-between">
                <div class="space-y-1 flex-1">
                  <h3 class="text-lg font-semibold">Sunday Worship Service</h3>
                  <div>
                    <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">Worship Service</span>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="px-6 py-4 space-y-3">
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Sunday, April 13, 2026</span>
              </div>
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>10:00 AM - 12:00 PM</span>
              </div>
              <p class="text-sm text-gray-600 pt-2 border-t">Join us for our weekly worship service with praise, prayer, and the Word of God.</p>
              <div class="pt-2 border-t">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Finish Event
                </button>
              </div>
            </div>
          </div>

          <!-- Event Card 2 - Active -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <div class="flex items-start justify-between">
                <div class="space-y-1 flex-1">
                  <h3 class="text-lg font-semibold">Wednesday Prayer Meeting</h3>
                  <div>
                    <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-700" style="background-color: #F3E8FF;">Prayer Meeting</span>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="px-6 py-4 space-y-3">
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Wednesday, April 16, 2026</span>
              </div>
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>07:00 PM - 09:00 PM</span>
              </div>
              <p class="text-sm text-gray-600 pt-2 border-t">Mid-week prayer gathering for intercession and fellowship.</p>
              <div class="pt-2 border-t">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Finish Event
                </button>
              </div>
            </div>
          </div>

          <!-- Event Card 3 - Completed -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <div class="flex items-start justify-between">
                <div class="space-y-1 flex-1">
                  <h3 class="text-lg font-semibold">Easter Thanksgiving Service</h3>
                  <div>
                    <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-amber-100 text-amber-700">Thanksgiving</span>
                  </div>
                </div>
                <button class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                  <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
            <div class="px-6 py-4 space-y-3">
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Sunday, March 31, 2026</span>
              </div>
              <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>09:00 AM - 01:00 PM</span>
              </div>
              <p class="text-sm text-gray-600 pt-2 border-t">Special Easter celebration with communion and praise.</p>
              <div class="pt-2 border-t">
                <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                  Completed
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Event Modal -->
  <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="px-6 py-4 border-b">
        <h3 class="text-xl font-semibold">Create New Event</h3>
        <p class="text-sm text-gray-600 mt-1">Enter the details of the new event.</p>
      </div>
      <div class="px-6 py-4">
        <form class="space-y-4">
          <div>
            <label for="eventName" class="block text-sm font-medium text-gray-700 mb-1">Event Name</label>
            <input
              id="eventName"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Sunday Worship Service"
              required
            />
          </div>

          <div>
            <label for="eventType" class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
            <select id="eventType" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="Worship Service">Worship Service</option>
              <option value="Prayer Meeting">Prayer Meeting</option>
              <option value="Thanksgiving">Thanksgiving</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
              <input
                id="startDate"
                type="date"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
            <div>
              <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
              <input
                id="startTime"
                type="time"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
              <input
                id="endDate"
                type="date"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
            <div>
              <label for="endTime" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
              <input
                id="endTime"
                type="time"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
          </div>

          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              id="description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Event details and information..."
            ></textarea>
          </div>

          <div class="flex gap-3 pt-2">
            <button type="button" onclick="closeEventModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              Cancel
            </button>
            <button type="submit" class="flex-1 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
              Create Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function openEventModal() {
      document.getElementById('eventModal').classList.remove('hidden');
    }

    function closeEventModal() {
      document.getElementById('eventModal').classList.add('hidden');
    }
  </script>
</body>
</html>