<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events - Church Management System</title>
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
        <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-[#111827] border border-gray-300 rounded-md bg-[#F2F8FF] hover:bg-[#e8f1fb] transition-colors duration-200">        
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
          <a href="{{ route('events.index') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600 duration-200">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Reports</a>
                  </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-3xl font-semibold text-gray-900">Events</h2>
            <p class="text-gray-600 mt-2">Manage church events and activities</p>
          </div>
          <button onclick="openEventModal()" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-[#F2F8FF] bg-[#030213] rounded-md hover:bg-[#0a0920] transition-colors duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Event
          </button>
        </div>

        <!-- Events Grid -->
        
          @if($events->isEmpty())
    <div class="bg-white border border-gray-200 rounded-lg p-12 mt-6">
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>

            <p class="text-gray-500 text-sm mb-4">
                No events yet. Create your first event to get started.
            </p>

            <button onclick="openEventModal()"
                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Event
            </button>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($events as $event)
            <div class="bg-white rounded-lg shadow border">
                <div class="px-6 py-4 border-b">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div class="space-y-1 flex-1">
                            <h3 class="text-lg font-semibold">{{ $event->event_name }}</h3>
                            <div>
                                <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">
                                    {{ $event->type->type_name ?? 'No Type' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-1">
                            <button
                                onclick="openEditEventModal(
                                    '{{ $event->event_id }}',
                                    '{{ $event->event_name }}',
                                    '{{ $event->type_id }}',
                                    '{{ $event->start_date }}',
                                    '{{ $event->end_date }}',
                                    '{{ $event->start_time }}',
                                    '{{ $event->end_time }}',
                                    `{{ $event->description }}`
                                )"
                                class="h-8 w-8 p-0 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded">
                                <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>

                            <form action="{{ route('events.destroy', $event->event_id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                                    <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 space-y-3">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 pt-2 border-t">
                        {{ $event->description ?? 'No description available.' }}
                    </p>
        @if($event->status !== 'finished')
            <div class="pt-3 border-t">
                <form action="{{ route('events.finish', $event->event_id) }}" method="POST"
                    onsubmit="return confirm('Mark this event as finished?');">
                    @csrf
                    @method('PUT')

                    <button type="submit"
                        class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                        Complete Event
                    </button>
                </form>
            </div>
        @else
            <div class="pt-3 border-t">
                <span class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-gray-400 rounded-md">
                    Event Finished
                </span>
            </div>
        @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
          
        </div>
      </div>
    </div>
  </div>

  <!-- Create Event Modal -->
  <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
      <div class="px-6 py-4 border-b">
        <h3 class="text-xl font-semibold">Create New Event</h3>
        <p class="text-sm text-gray-600 mt-1">Enter the details of the new event.</p>
      </div>
      <div class="px-6 py-4">
        <form class="space-y-4" action="{{ route('events.store') }}" method="POST">
    @csrf
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
            <select id="eventType" name="type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    @foreach($types as $type)
        <option value="{{ $type->type_id }}">{{ $type->type_name }}</option>
    @endforeach
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
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
              placeholder="Event details and information..."
            ></textarea>
          </div>

          <div class="flex gap-3 pt-2">
            <button type="button" onclick="closeEventModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              Cancel
            </button>
            <button type="submit" class="flex-1 px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
              Create Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <!-- Edit Event Modal -->
    <div id="editEventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
        <div class="px-6 py-4 border-b">
            <h3 class="text-xl font-semibold">Edit Event</h3>
            <p class="text-sm text-gray-600 mt-1">Update the event details.</p>
        </div>

        <div class="px-6 py-4">
            <form id="editEventForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit_event_name" class="block text-sm font-medium text-gray-700 mb-1">Event Name</label>
                    <input id="edit_event_name" name="event_name" type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="edit_type_id" class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                    <select id="edit_type_id" name="type_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($types as $type)
                            <option value="{{ $type->type_id }}">{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input id="edit_start_date" name="start_date" type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="edit_start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input id="edit_start_time" name="start_time" type="time"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input id="edit_end_date" name="end_date" type="date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="edit_end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input id="edit_end_time" name="end_time" type="time"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="edit_description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeEditEventModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
                        Update Event
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

    function openEventModal() {
        document.getElementById('eventModal').classList.remove('hidden');
    }

    function closeEventModal() {
        document.getElementById('eventModal').classList.add('hidden');
    }

    function openEditEventModal(id, eventName, typeId, startDate, endDate, startTime, endTime, description) {
        const form = document.getElementById('editEventForm');
        form.action = `/events/${id}`;

        document.getElementById('edit_event_name').value = eventName;
        document.getElementById('edit_type_id').value = typeId;
        document.getElementById('edit_start_date').value = startDate;
        document.getElementById('edit_end_date').value = endDate;
        document.getElementById('edit_start_time').value = startTime;
        document.getElementById('edit_end_time').value = endTime;
        document.getElementById('edit_description').value = description ?? '';

        document.getElementById('editEventModal').classList.remove('hidden');
    }

    function closeEditEventModal() {
        document.getElementById('editEventModal').classList.add('hidden');
    }

</script>
</body>
</html>