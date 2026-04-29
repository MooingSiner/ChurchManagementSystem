<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Church Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-40 h-40 rounded-full mb-4 bg-blue-100">
          <img src="{{ asset('images/icons/LOGO.png') }}" alt="Church Icon" class="h-24 w-24">
        </div>
        <h1 class="text-3xl font-semibold text-gray-900">Grace Community Church</h1>
        <p class="text-gray-600 mt-2">Church Management System</p>
      </div>

      <div class="bg-white rounded-lg shadow border">
        <div class="px-6 py-4 border-b">
          <h2 class="text-2xl font-semibold text-center mb-2">Login</h2>
          <p class="text-sm text-gray-600 mt-1">Enter your credentials to access the dashboard</p>
        </div>

        <div class="px-6 py-4">
          @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
              {{ $errors->first() }}
            </div>
          @endif
      
          <form class="space-y-4" action="{{ route('auth.login.submit') }}" method="POST">
            @csrf

            <div>
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input
                id="username"
                name="username"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your username"
                required
              />
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input
                id="password"
                name="password"
                type="password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter your password"
                required
              />
            </div>

            <div class="flex gap-3 pt-2">
              <a href="{{route('home') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 text-center trasition-colors duration-200">
                Back
              </a>

              <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-[#F2F8FF] bg-[#030213] hover:bg-[#0a0920]">
                Continue
              </button>
            </div>
          </form>
        </div>
      </div>

      <p class="text-center text-sm text-gray-600 mt-6">
        Need help? Contact your church administrator
      </p>
    </div>
  </div>
</body>
</html>