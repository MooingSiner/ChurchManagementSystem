<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Members - Church Management System</title>
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
        <button type="submit" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-[#111827] border border-gray-300 rounded-md bg-[#F2F8FF] hover:bg-[#e8f1fb] transition-colors duration-200">          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
          <a href="{{ route('members.index') }}" class="border-b-2 border-blue-600 py-4 px-1 text-sm font-medium text-blue-600 duration-200">Members</a>
          <a href="{{ route('events.index') }}" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 duration-200">Events</a>
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
            <h2 class="text-3xl font-semibold text-gray-900">Members</h2>
            <p class="text-gray-600 mt-2">Manage your church members</p>
          </div>
          <button onclick="openAddMemberModal()" class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-[#F2F8FF] bg-[#030213] rounded-md hover:bg-[#0a0920] transition-colors duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Add Member
          </button>
        </div>
    @if($members->isEmpty())
    <!-- Empty State -->
    <div class="bg-white border border-gray-200 rounded-lg p-12 mt-6">
        <div class="flex flex-col items-center justify-center py-12">
            
            <!-- Icon -->
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>

            <!-- Text -->
            <p class="text-gray-500 text-sm mb-4">
                No members yet. Add your first member to get started.
            </p>

            <!-- Button -->
            <button onclick="openAddMemberModal()"
                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4"/>
                </svg>

                Add Member
            </button>
        </div>
    </div>
@else
    <!-- Members List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($members as $member)
            <div class="bg-white rounded-lg shadow border w-full">
            <div class="px-6 py-4 border-b">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">
                            {{ $member->member_fname }} {{ $member->member_lname }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $member->gender }}
                        </p>
                    </div>

                    <div class="flex gap-1">
                        <button 
    onclick="openEditMemberModal(
        '{{ $member->member_id }}',
        '{{ $member->member_fname }}',
        '{{ $member->member_mname }}',
        '{{ $member->member_lname }}',
        '{{ $member->gender }}',
        '{{ $member->birth_date }}',
        '{{ $member->email }}',
        '{{ $member->phone_number }}',
        '{{ optional($member->address)->street }}',
        '{{ optional($member->address)->province }}',
        '{{ optional($member->address)->city }}'
    )"
    class="h-8 w-8 p-0 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded">
    <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
    </svg>
</button>

                        <form action="{{ route('members.destroy', $member->member_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="h-8 w-8 p-0 text-red-600 hover:text-red-700 hover:bg-red-50 rounded">
                                <svg class="h-4 w-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 space-y-2">
                <div class="text-sm text-gray-600">{{ $member->email }}</div>
                <div class="text-sm text-gray-600">{{ $member->phone_number }}</div>

                <div class="text-sm text-gray-600">
                    {{ optional($member->address)->street }},
                    {{ optional($member->address)->city }},
                    {{ optional($member->address)->province }}
                </div>

                <div class="text-sm text-gray-600">
                    {{ $member->birth_date }}
                </div>

                <div class="text-sm text-gray-600">
                    @forelse($member->ministries as $ministry)
                        <span class="inline-block px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-700">
                            {{ $ministry->ministry_name }}
                        </span>
                    @empty
                        <span class="text-gray-400">No ministry</span>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif

      </div>
    </div>
  </div>

  <!-- Add Member Modal -->
  <div id="memberModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-xl w-full max-h-[90vh] flex flex-col">
      <div class="px-6 py-3 border-b">
        <h3 class="text-xl font-semibold" id="modalTitle">Add New Member</h3>
        <p class="text-sm text-gray-600" id="modalDescription">Enter the details of the new member.</p>
      </div>
      <div class="px-6 py-2 overflow-y-auto">
        <form action="{{ route('members.store') }}" method="POST">
         @csrf
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex-col">
            <label for="member_fname" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
            <input
              id="member_fname"
              name="member_fname"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="John"
              required
            />
          </div>
          <div class="flex-col">
            <label for="member_mname" class="block text-sm font-medium text-gray-700 mb-2">Middle Name (Optional)</label>
            <input
              id="member_mname"
              name="member_mname"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Michael"
            />
          </div>
          <div>
            <label for="member_lname" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
            <input
              id="member_lname"
              name="member_lname"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Doe"
              required
            />
          </div>
          </div>
          

          <div>
  <label for="gender" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Gender</label>
  <div class="relative">
    <select id="gender" name="gender"
      class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>

    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </div>
  </div>
</div>

          <div>
            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Birth Date</label>
            <input
              id="birth_date"
              name="birth_date"
              type="date"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Email</label>
            <input
              id="email"
              name="email"

              type="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="john@example.com"
              required
            />
          </div>

          <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Phone Number</label>
            <input
              id="phone_number"
              name="phone_number"
              type="tel"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="+1234567890"
              required
            />
          </div>

          <div>
            <label for="street" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Street Address</label>
            <textarea
              id="street"
              name="street"
              rows="2"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
              placeholder="123 Main St"
            ></textarea>
          </div>

           <div class="flex items-end gap-24">
            <div class="flex-col">
            <label for="province" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Province</label>
            <input
              id="province"
              name="province"
              type="text"
              
              class=" px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2"
              placeholder="Anytown"
            />
            </div>
            <div class="flex-col">
              <label for="city" class="block text-sm font-medium text-gray-700 mb-2 mt-2">City</label>
              <input
                id="city"
                name="city"
                type="text"
               
                class=" px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2"
                placeholder="City"
              />
            </div>
          </div>

          <div>
  <label for="ministry" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Ministry</label>
  <div class="relative">
    <select id="ministry_id" name="ministry_id"
      class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
      <option value="">None</option>
      @foreach($ministries as $ministry)
        <option value="{{ $ministry->ministry_id }}">
          {{ $ministry->ministry_name }}
        </option>
      @endforeach
    </select>

    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500 mb-2">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </div>
  </div>
</div>

<div class="flex gap-3 pt-2">
  <button type="button" onclick="closeMemberModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mb-1">
    Cancel
  </button>
  <button type="submit" class="flex-1 px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
    Add Member
  </button>
</div>
        </form>
      </div>
    </div>
  </div>

  <div id="editMemberModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
  <div class="bg-white rounded-lg shadow-xl max-w-xl w-full max-h-[90vh] flex flex-col">
    <div class="px-6 py-3 border-b">
      <h3 class="text-xl font-semibold">Edit Member</h3>
      <p class="text-sm text-gray-600">Update the details of this member.</p>
    </div>

    <div class="px-6 py-2 overflow-y-auto">
      <form id="editMemberForm" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="flex-col">
            <label for="edit_member_fname" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
            <input id="edit_member_fname" name="member_fname" type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
          </div>

          <div class="flex-col">
            <label for="edit_member_mname" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
            <input id="edit_member_mname" name="member_mname" type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
          </div>

          <div>
            <label for="edit_member_lname" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
            <input id="edit_member_lname" name="member_lname" type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
          </div>
        </div>

        <div>
  <label for="edit_gender" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Gender</label>
  <div class="relative">
    <select id="edit_gender" name="gender"
      class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>

    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </div>
  </div>
</div>

        <div>
          <label for="edit_birth_date" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Birth Date</label>
          <input id="edit_birth_date" name="birth_date" type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>

        <div>
          <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Email</label>
          <input id="edit_email" name="email" type="email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>

        <div>
          <label for="edit_phone_number" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Phone Number</label>
          <input id="edit_phone_number" name="phone_number" type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required />
        </div>

        <div>
          <label for="edit_street" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Street Address</label>
          <textarea id="edit_street" name="street" rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
        </div>

        <div class="flex items-end gap-24">
          <div class="flex-col">
            <label for="edit_province" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Province</label>
            <input id="edit_province" name="province" type="text"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" />
          </div>

          <div class="flex-col">
            <label for="edit_city" class="block text-sm font-medium text-gray-700 mb-2 mt-2">City</label>
            <input id="edit_city" name="city" type="text"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" />
          </div>
        </div>

        <div>
            <label for="ministry" class="block text-sm font-medium text-gray-700 mb-2 mt-2">Ministry</label>
            <div class="relative">
    <select id="edit_ministry_id" name="ministry_id"
    class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
        
        <option value="">None</option>
        @foreach($ministries as $ministry)
            <option value="{{ $ministry->ministry_id }}">
                {{ $ministry->ministry_name }}
            </option>
        @endforeach
    </select>

    <!-- Custom arrow -->
    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</div>
      
          </div>

        <div class="flex gap-3 pt-2 mt-2">
          <button type="button" onclick="closeEditMemberModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mb-1">
            Cancel
          </button>
          <button type="submit" class="flex-1 px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
            Update Member
          </button>
        </div>
      </form>
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
  function openAddMemberModal() {
    const form = document.querySelector('#memberModal form');
    form.reset();

    document.getElementById('memberModal').classList.remove('hidden');
  }

  function closeMemberModal() {
    document.getElementById('memberModal').classList.add('hidden');
  }

  function openEditMemberModal(id, fname, mname, lname, gender, birthDate, email, phone, street, province, city, ministryId = '') {
    const form = document.getElementById('editMemberForm');
    form.action = `/members/${id}`;

    document.getElementById('edit_member_fname').value = fname;
    document.getElementById('edit_member_mname').value = mname;
    document.getElementById('edit_member_lname').value = lname;
    document.getElementById('edit_gender').value = gender;
    document.getElementById('edit_birth_date').value = birthDate;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_phone_number').value = phone;
    document.getElementById('edit_street').value = street;
    document.getElementById('edit_province').value = province;
    document.getElementById('edit_city').value = city;
    document.getElementById('edit_ministry_id').value = ministryId;

    document.getElementById('editMemberModal').classList.remove('hidden');
  }

  function closeEditMemberModal() {
    document.getElementById('editMemberModal').classList.add('hidden');
  }
  
</script>
</body>
</html>