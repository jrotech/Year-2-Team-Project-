<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login - {{ config('app.name') }}</title>

    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Login</h1>
        <p class="text-gray-600 mt-2">Enter your credentials to access the admin panel</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex items-center mb-6">
            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600">
            <label for="remember" class="ml-2 text-gray-700">Remember me</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Login
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Back to Homepage</a>
    </div>
</div>
</body>
</html>
