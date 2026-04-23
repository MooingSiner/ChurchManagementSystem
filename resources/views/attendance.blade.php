<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance - Church Management System</title>
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
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 py-4 sm:h-16 sm:flex-row sm:items-center sm:justify-between">
          <div class="flex items-center gap-3">
            <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
            <h1 class="text-xl font-semibold text-gray-900">Church Management</h1>
          </div>

          <div class="flex flex-wrap items-center gap-2 sm:gap-4">
            <div class="flex items-center gap-2 text-gray-700 font-medium">
              <img src="{{ asset('images/icons/user-icon.png') }}" alt="User Icon" class="h-6 w-6">
              {{ Auth::user()->username }}
            </div>

            <form action="{{ route('auth.logout') }}" method="POST">
              @csrf
              <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-[#111827] border border-gray-300 rounded-md bg-[#F2F8FF] hover:bg-[#e8f1fb] transition-colors duration-200">
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

    <div class="bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-4 overflow-x-auto whitespace-nowrap scrollbar-hide">
          <a href="{{ route('dashboard') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Dashboard</a>
          <a href="{{ route('members.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Members</a>
          <a href="{{ route('events.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Events</a>
          <a href="{{ route('attendance') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600 duration-200">Attendance</a>
          <a href="{{ route('report') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Reports</a>
           </nav>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="space-y-6">
        <div>
          <h2 class="text-3xl font-semibold text-gray-900">Attendance</h2>
          <p class="text-gray-600 mt-2">Manage attendance records and approve member submissions</p>
        </div>

        @if(session('success'))
          <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm space-y-1">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Select Event</h3>
          </div>
          <div class="px-6 py-4">
            <form method="GET" action="{{ route('attendance') }}" class="space-y-4">
              <select name="event_id" onchange="this.form.submit()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Choose an event...</option>
                @foreach($events as $event)
                  <option value="{{ $event->event_id }}" {{ optional($selectedEvent)->event_id == $event->event_id ? 'selected' : '' }}>
                    {{ $event->event_name }} - {{ \Carbon\Carbon::parse($event->start_date)->format('m/d/Y') }}
                  </option>
                @endforeach
              </select>
            </form>

            @if($selectedEvent)
              <div class="mt-4 p-4 bg-gray-50 rounded-lg space-y-2">
                <div class="flex items-center gap-2 text-sm">
                  <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                  <span>{{ \Carbon\Carbon::parse($selectedEvent->start_date)->format('m/d/Y') }}</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                  <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>{{ \Carbon\Carbon::parse($selectedEvent->start_time)->format('h:i A') }}</span>
                </div>
                <div class="text-sm text-gray-600">{{ $selectedEvent->type->type_name ?? 'No Type' }}</div>
              </div>
            @endif
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Total Approved</p>
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalApproved }}</p>
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
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalPending }}</p>
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
                  <p class="text-3xl font-semibold text-gray-900">{{ $totalRecords }}</p>
                </div>
                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
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
              @if(!$selectedEvent)
                <p class="text-sm text-gray-500">Select an event first.</p>
              @else
                <div class="space-y-4">
                  <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                      type="text"
                      id="memberSearch"
                      placeholder="Search members by name or email..."
                      class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      onkeyup="filterMembers()"
                    />
                  </div>

                  <div id="memberList" class="space-y-2 max-h-[400px] overflow-y-auto">
                    @forelse($availableMembers as $member)
                      <div class="member-item flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50"
                           data-name="{{ strtolower($member->member_fname . ' ' . $member->member_lname) }}"
                           data-email="{{ strtolower($member->email) }}">
                        <div class="flex-1">
                          <div class="font-medium">{{ $member->member_fname }} {{ $member->member_lname }}</div>
                          <div class="text-sm text-gray-600">{{ $member->email }}</div>
                        </div>

                        <form action="{{ route('attendance.manual') }}" method="POST">
                          @csrf
                          <input type="hidden" name="event_id" value="{{ $selectedEvent->event_id }}">
                          <input type="hidden" name="member_id" value="{{ $member->member_id }}">
                          <button type="submit" class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
                            Add
                          </button>
                        </form>
                      </div>
                    @empty
                      <p class="text-sm text-gray-500">No available members to add.</p>
                    @endforelse
                  </div>
                </div>
              @endif
            </div>
          </div>

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
                  {{ $totalPending }}
                </span>
              </div>
            </div>

            <div class="px-6 py-4">
              <div class="space-y-3 max-h-[400px] overflow-y-auto">
                @forelse($pendingAttendances as $attendance)
                  <div class="p-3 border border-amber-200 bg-amber-50 rounded-lg space-y-3">
                    <div>
                      <div class="font-medium">
                        {{ $attendance->member->member_fname }} {{ $attendance->member->member_lname }}
                      </div>
                      <div class="text-sm text-gray-600">
                        Submitted: {{ \Carbon\Carbon::parse($attendance->attended_at)->format('m/d/Y, g:i A') }}
                      </div>
                    </div>

                    <div class="flex gap-2">
                      <form action="{{ route('attendance.approve', $attendance->attendance_id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="w-full flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded">
                          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          Approve
                        </button>
                      </form>

                      <form action="{{ route('attendance.reject', $attendance->attendance_id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-1 px-3 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                          Reject
                        </button>
                      </form>
                    </div>
                  </div>
                @empty
                  <p class="text-sm text-gray-500">No pending attendance submissions.</p>
                @endforelse
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Approved Attendance ({{ $totalApproved }})</h3>
          </div>
          <div class="px-6 py-4">
            <div class="space-y-2">
              @forelse($approvedAttendances as $attendance)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                  <div class="flex items-center gap-3">
                    <div>
                      <div class="font-medium">
                        {{ $attendance->member->member_fname }} {{ $attendance->member->member_lname }}
                      </div>
                      <div class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($attendance->attended_at)->format('m/d/Y, g:i A') }}
                      </div>
                    </div>
                  </div>

                  <form action="{{ route('attendance.destroy', $attendance->attendance_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                      <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </button>
                  </form>
                </div>
              @empty
                <p class="text-sm text-gray-500">No approved attendance records yet.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    

    document.addEventListener('click', function (e) {
      const dropdown = document.getElementById('notificationDropdown');

      if (!e.target.closest('#notificationDropdown') && !e.target.closest('button')) {
        dropdown.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
        dropdown.classList.add('opacity-0', 'scale-95', '-translate-y-2', 'pointer-events-none');
      }
    });

    function filterMembers() {
      const input = document.getElementById('memberSearch').value.toLowerCase();
      const items = document.querySelectorAll('.member-item');

      items.forEach(item => {
        const name = item.dataset.name;
        const email = item.dataset.email;

        if (name.includes(input) || email.includes(input)) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });
    }
  </script>
</body>
</html>