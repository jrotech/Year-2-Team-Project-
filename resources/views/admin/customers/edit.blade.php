<!-- Developer: Abdullah Alharbi
    University ID: 230046409  -->
@extends('admin.layouts.admin')

@section('title', 'Edit Customer')

@section('header', 'Edit Customer')

@section('content')
    <div class="max-w-3xl mx-auto">

        <div class="bg-white shadow-md rounded-lg overflow-hidden">

            <div class="p-6">

                <h3 class="text-lg font-medium text-gray-900 mb-6">Edit Customer Information</h3>

                @if ($errors->any())

                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">

                        <ul class="list-disc pl-5">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>
                    </div>

                @endif

                <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-6">

                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>

                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $customer->customer_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">

                    </div>

                    <div class="mb-6">

                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>

                        <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">

                    </div>

                    <div class="mb-6">

                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>

                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $customer->phone_number) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">

                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password (leave blank to keep current)</label>

                        <input type="password" name="password" id="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>

                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Customer
                        </button>


                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-indigo-600 hover:text-indigo-800">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
