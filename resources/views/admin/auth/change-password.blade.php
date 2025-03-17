@extends('admin.layouts.admin')
<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->

@section('title', 'Change Password')
@section('header', 'Change Password')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Change Your Password</h2>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <ul>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.change-password') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>



                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>

                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-gray-500 text-xs mt-1">Password must be at least 8 characters.</p>
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>

                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Password

                    </button>

                    <a href="{{ route('admin.profile') }}" class="text-blue-500 hover:underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
