@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">User Dashboard</h1>

    <div class="bg-green-50 p-6 rounded-lg mb-6">
        <h2 class="text-2xl font-semibold text-green-800 mb-4">Welcome, {{ auth()->user()->name }}!</h2>
        <p class="text-green-700">This is your personal dashboard where you can manage your account and access user-specific features.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-gray-200 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Profile Information</h3>
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
        </div>

        <div class="border border-gray-200 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">User Features</h3>
            <ul class="list-disc list-inside space-y-2">
                <li>Profile Management</li>
                <li>Personal Settings</li>
                <li>User Activities</li>
                <li>Account Preferences</li>
            </ul>
        </div>
    </div>
</div>
@endsection