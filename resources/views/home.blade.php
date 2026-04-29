<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grace Community Church</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Nunito', sans-serif; }
  </style>
</head>

<body>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">

  <!-- Header -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
      <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Grace Community Church</h1>
            <p class="text-sm text-gray-600">Welcome to our church family</p>
          </div>
        </div>

        <form action="{{ route('login') }}" method="GET">
          <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 border rounded-md text-sm font-medium text-[#111827] bg-[#F2F8FF] hover:bg-[#e8f1fb]">
            Login
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Main -->
  <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="space-y-12">

      <!-- Hero -->
      <div class="text-center space-y-4">
        <h2 class="text-3xl sm:text-4xl font-semibold text-gray-900">Welcome Home</h2>
        <p class="text-base sm:text-xl text-gray-600 max-w-2xl mx-auto px-2">
          We're glad you're here! Members can mark their attendance for today's service using their member ID.
        </p>
      </div>

      <div class="max-w-2xl mx-auto space-y-4">

        @if($events->isEmpty())

          <!-- No Events -->
          <div class="bg-white rounded-lg shadow border-2 border-gray-200">
            <div class="px-6 py-10 text-center space-y-4">
              <svg class="h-16 w-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>

              <h3 class="text-xl font-semibold text-gray-900">No Events Ongoing</h3>
              <p class="text-gray-600">
                There are currently no events scheduled. Please check back later or contact the church office.
              </p>
            </div>
          </div>

        @else

          <!-- Event Dropdown if 2 or more events -->
          @if($events->count() >= 2)
            <div>
              <label for="eventSelector" class="block text-center text-sm font-semibold text-gray-900 mb-2">
                Select Event
              </label>

                              <select id="eventSelector"
    onchange="changeSelectedEvent()"
    class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100">

    @foreach($events as $event)
        <option value="{{ $event->event_id }}">
            {{ $event->event_name }} -
            {{ \Carbon\Carbon::parse($event->start_date)->format('n/j/Y') }}
            at
            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
        </option>
    @endforeach

</select>
            </div>
          @endif

          <!-- Event Cards Hidden/Shown by JS -->
          @foreach($events as $index => $event)
            <div id="event-card-{{ $event->event_id }}"
              class="event-card {{ $index !== 0 ? 'hidden' : '' }} border-2 border-blue-100 rounded-lg bg-white shadow overflow-hidden">

              <div class="text-center bg-blue-50 px-6 py-4 border-b">
                <h3 class="flex items-center justify-center gap-2 text-2xl font-semibold">
                  <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  {{ $events->count() >= 2 ? 'Selected Event' : 'Current Event' }}
                </h3>
              </div>

              <div class="px-6 pt-6 pb-6 space-y-4">
                <div class="text-center space-y-2">
                  <h3 class="text-2xl font-semibold text-gray-900">{{ $event->event_name }}</h3>

                  <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                    {{ $event->type->type_name ?? 'No Type' }}
                  </span>

                  <div class="text-lg text-gray-700">
                    {{ \Carbon\Carbon::parse($event->start_date)->format('l, F d, Y') }}
                  </div>

                  <div class="text-lg text-gray-700">
                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                  </div>
                </div>

                <div class="space-y-3">
                  <button onclick="showScanner()"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
                    Scan ID Card
                  </button>

                  <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                      <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                      <span class="px-2 bg-white text-gray-500">OR</span>
                    </div>
                  </div>

                  <button onclick="showManualEntry('{{ $event->event_id }}')"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-md text-base font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Manual Entry
                  </button>
                </div>
              </div>
            </div>
          @endforeach

        @endif
      </div>

      <!-- Manual Entry -->
      <div id="manualEntryView" class="hidden max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow border">
          <div class="px-6 py-4 border-b">
            <h3 class="text-2xl font-semibold flex items-center gap-2">
              Mark Your Attendance
            </h3>
          </div>

          <div class="p-6">
            <form action="{{ route('home.attendance.submit') }}" method="POST" class="space-y-6">
              @csrf

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Event</label>
                <select id="manualEventId" name="event_id" required
                  class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100">
                  @foreach($events as $event)
                    <option value="{{ $event->event_id }}">
                      {{ $event->event_name }} - {{ \Carbon\Carbon::parse($event->start_date)->format('n/j/Y') }} at {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Your Name</label>
                <select name="member_id" required
                  class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100">
                  <option value="">Choose your name</option>
                 @foreach($members as $member)
    <option value="{{ $member->member_id }}"
        data-member="{{ $member->member_id }}">
        {{ $member->member_fname }} {{ $member->member_lname }}
    </option>
@endforeach
                </select>
              </div>

              <div class="flex gap-3">
                <button type="button" onclick="hideManualEntry()"
                  class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium bg-white hover:bg-gray-50">
                  Cancel
                </button>

                <button type="submit"
                  class="flex-1 px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
                  Submit Attendance
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Scanner Error View -->
      <div id="scannerView" class="hidden max-w-xl mx-auto">
        <div class="bg-white rounded-lg shadow border p-8 text-center space-y-6">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">Scan Member ID</h3>
            <button onclick="hideScanner()" class="text-xl">&times;</button>
          </div>

          <p class="text-red-600">
            Unable to access camera. Please check permissions and try again.
          </p>

          <button onclick="hideScanner()"
            class="px-4 py-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
            Go Back
          </button>
        </div>
      </div>

      <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
          <!-- Mission Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h4 class="text-lg font-semibold">Our Mission</h4>
            </div>
            <div class="px-6 py-4">
              <p class="text-gray-600">
                To glorify God by making disciples who love God and love others.
              </p>
            </div>
          </div>

          <!-- Join Us Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h4 class="text-lg font-semibold">Join Us</h4>
            </div>
            <div class="px-6 py-4">
              <p class="text-gray-600">
                Everyone is welcome to worship with us. Come as you are and experience God's love.
              </p>
            </div>
          </div>

          <!-- Get Involved Card -->
          <div class="bg-white rounded-lg shadow border">
            <div class="px-6 py-4 border-b">
              <h4 class="text-lg font-semibold">Get Involved</h4>
            </div>
            <div class="px-6 py-4">
              <p class="text-gray-600">
                Discover ministries and opportunities to serve and grow in your faith journey.
              </p>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>

<script>
function changeSelectedEvent() {
    const selectedId = document.getElementById('eventSelector').value;

    document.querySelectorAll('.event-card').forEach(card => {
        card.classList.add('hidden');
    });

    document.getElementById('event-card-' + selectedId).classList.remove('hidden');

    // sync manual form
    document.getElementById('manualEventId').value = selectedId;
    filterMembersByEvent(selectedId);
}

function showManualEntry(eventId) {
    document.getElementById('manualEntryView').classList.remove('hidden');

    if (eventId) {
        document.getElementById('manualEventId').value = eventId;
        filterMembersByEvent(eventId);
    }

    window.scrollTo({
        top: document.getElementById('manualEntryView').offsetTop - 40,
        behavior: 'smooth'
    });
}

function hideManualEntry() {
    document.getElementById('manualEntryView').classList.add('hidden');
}

function showScanner() {
    document.getElementById('scannerView').classList.remove('hidden');
    window.scrollTo({
        top: document.getElementById('scannerView').offsetTop - 40,
        behavior: 'smooth'
    });
}

function hideScanner() {
    document.getElementById('scannerView').classList.add('hidden');
}
</script>
<script>
  const attendanceRecords = @json($attendanceMemberIds);

function filterMembersByEvent(eventId) {
    const memberSelect = document.querySelector('select[name="member_id"]');
    const options = memberSelect.querySelectorAll('option[data-member]');

    options.forEach(option => {
        const memberId = option.getAttribute('data-member');

        const alreadySubmitted = attendanceRecords.some(record =>
            record.event_id == eventId && record.member_id == memberId
        );

        option.hidden = alreadySubmitted;
    });

    memberSelect.value = '';
}
</script>
</body>
</html>