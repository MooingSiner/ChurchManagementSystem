<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grace Community Church</title>
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
<body>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div class="flex items-center gap-3">
            <!-- Church Icon -->
            <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
            <div>
              <h1 class="text-2xl font-semibold text-gray-900">Grace Community Church</h1>
              <p class="text-sm text-gray-600">Welcome to our church family</p>
            </div>
          </div>
           <form action="{{ route('login') }}" method="GET">
          <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-1 rounded-md shadow-sm text-sm font-medium text-[#111827] bg-[#F2F8FF] hover:bg-[#e8f1fb]" ">
            <!-- Login Icon -->
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Login
          </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
      <div class="space-y-12">
        <!-- Hero Section -->
        <div class="text-center space-y-4">
          <h2 class="text-3xl sm:text-4xl font-semibold text-gray-900">Welcome Home</h2>
          <p class="text-base sm:text-xl text-gray-600 max-w-2xl mx-auto px-2">
            We're glad you're here! Members can mark their attendance for today's service using their member ID.
          </p>
        </div>

        <!-- Current Event Card -->
        <div class="max-w-2xl mx-auto">
          <div class="border-2 border-blue-100 rounded-lg bg-white shadow">
            <!-- Card Header -->
            <div class="text-center bg-blue-50 px-6 py-4 border-b">
              <h3 class="flex items-center justify-center gap-2 text-2xl font-semibold">
                <!-- Calendar Icon -->
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Current Event
              </h3>
            </div>
            <!-- Card Content -->
            <div class="px-6 pt-6 pb-6 space-y-4">
              <div class="text-center space-y-2">
                <h3 class="text-2xl font-semibold text-gray-900">Sunday Worship Service</h3>
                <div class="flex items-center justify-center gap-2 text-gray-600">
                  <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                    Worship Service
                  </span>
                </div>
                <div class="text-lg text-gray-700">
                  Sunday, April 10, 2026
                </div>
                <div class="text-lg text-gray-700">
                  10:00 AM
                </div>
                <p class="text-gray-600 mt-4">Join us for our weekly worship service with praise, prayer, and the Word of God.</p>
              </div>
              <div class="space-y-3">
                <!-- Scan ID Card Button -->
                <button class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
                  <!-- Scan Icon -->
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                  </svg>
                  Scan ID Card
                </button>
                <!-- Divider -->
                <div class="relative">
                  <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                  </div>
                  <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">OR</span>
                  </div>
                </div>
                <!-- Manual Entry Button -->
                <button class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50">
                  <!-- Users Icon -->
                  <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                  </svg>
                  Manual Entry
                </button>
              </div>
            </div>
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
</body>
</html>