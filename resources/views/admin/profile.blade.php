@extends('admin.layouts.admin')

@section('title', 'My Profile')
@section('header', 'My Profile')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- User Profile Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Profile Information</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <p class="text-gray-800">{{ $user->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <p class="text-gray-800">{{ $user->email }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <p class="text-gray-800">{{ $user->role->name ?? 'No Role Assigned' }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Member Since</label>
                <p class="text-gray-800">{{ $user->created_at->format('F d, Y') }}</p>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.change-password') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Change Password
                </a>
            </div>
        </div>

        <!-- Recent Activity (Example) -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Recent Activity</h2>

            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 bg-blue-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-800 font-medium">Logged in</p>
                        <p class="text-gray-500 text-sm">{{ now()->format('F d, Y h:i A') }}</p>
                    </div>
                </div>

                <!-- Add more activity items as needed -->

                <div class="pt-4 text-center">
                    <p class="text-gray-500 text-sm">Activity tracking is just a placeholder. You can implement actual activity tracking if needed.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
