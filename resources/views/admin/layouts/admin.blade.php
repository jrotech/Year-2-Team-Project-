<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        [x-cloak] { display: none !important; }
    </style>

    @yield('styles')
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden">

<aside class="w-64 bg-gray-800 text-white py-4 flex flex-col h-full" x-data="{ open: false }">
    <div class="px-4 py-4 flex items-center justify-between">
        <span class="text-2xl font-bold">Admin Panel</span>
        <button @click="open = !open" class="lg:hidden text-gray-400 hover:text-white">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <nav class="mt-8 flex-1 px-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </span>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.orders*') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Orders</span>
                </span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.products*') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </span>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.categories*') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Categories</span>
                </span>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.customers*') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Customers</span>
                </span>
        </a>

        <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users*') ? 'bg-gray-700' : '' }}">
                <span class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Administrators</span>
                </span>
        </a>

        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports*') ? 'bg-gray-700' : '' }}">
                    <span class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Reports</span>
                    </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{ 'transform rotate-180': open }">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open" x-cloak class="pl-6 mt-1 space-y-1">
                <a href="{{ route('admin.reports.sales') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports.sales') ? 'bg-gray-700' : '' }}">
                    Sales Report
                </a>
                <a href="{{ route('admin.reports.inventory') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports.inventory') ? 'bg-gray-700' : '' }}">
                    Inventory Report
                </a>
                <a href="{{ route('admin.reports.customers') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('admin.reports.customers') ? 'bg-gray-700' : '' }}">
                    Customer Report
                </a>
            </div>
        </div>
    </nav>

    <div class="mt-auto px-4 py-2">
        <div class="border-t border-gray-700 pt-4">
            <a href="{{ route('admin.profile') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">
                    <span class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Profile</span>
                    </span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-2 py-2.5 px-4 rounded hover:bg-gray-700 text-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>


<main class="flex-1 flex flex-col overflow-hidden">

    <header class="bg-white shadow">
        <div class="flex justify-between items-center py-4 px-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">@yield('header', 'Dashboard')</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-1 text-gray-700 hover:text-gray-900 focus:outline-none">
                        <span>{{ Auth::guard('admin')->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-lg z-10">
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('admin.change-password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Change Password</a>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="flex-1 overflow-auto p-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </div>
</main>

@yield('scripts')
</body>
</html>
