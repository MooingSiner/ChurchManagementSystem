<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grace Community Church</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <!-- Church Icon -->
            <img src="{{ asset('images/icons/church-icon.png') }}" alt="Church Icon" class="h-10 w-10">
            <div>
              <h1 class="text-2xl font-semibold text-gray-900">Grace Community Church</h1>
              <p class="text-sm text-gray-600">Welcome to our church family</p>
            </div>
          </div>
          <form action="{{ route('login') }}" method="GET">
          <button class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
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
          <h2 class="text-4xl font-semibold text-gray-900">Welcome Home</h2>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            We're glad you're here! Members can mark their attendance for today's service using their member ID.
          </p>
        </div>

        <!-- See Events Section (Replacing Info Cards) -->
        <div class="max-w-2xl mx-auto mt-12">
          <div class="bg-white rounded-lg shadow-lg border-2 border-purple-100">
            <div class="px-6 py-8 text-center space-y-6">
              <!-- Calendar Icon -->
              <div class="flex justify-center">
                <div class="bg-blue-100 rounded-full p-4">
                  <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>
              
              <div class="space-y-2">
                <h3 class="text-2xl font-semibold text-gray-900">See Events</h3>
                <p class="text-gray-600 max-w-md mx-auto">
                  Explore our upcoming church events, services, and special gatherings. Stay connected with what's happening in our community.
                </p>
              </div>

              <!-- View Events Button -->
               <form action="{{ route('homeevent') }}" method="GET">
              <button class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                View Available Events
              </button>
              </form>
              <!-- Additional Info -->
              <p class="text-sm text-gray-500">
                Check schedules, locations, and event details
              </p>
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