<!-- resources/views/admin/users/index.blade.php -->
@extends('admin.layouts.admin')

@section('title', 'Admin Users')
@section('header', 'Admin Users')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">Admin User Management</h3>
                <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Admin
                </a>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $user->role->name ?? 'No Role' }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>

                                @if(auth()->guard('admin')->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">Current User</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No admin users found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
