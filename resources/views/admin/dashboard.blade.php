@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-100 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-blue-800">Total Users</h3>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ \App\Models\User::count() }}</p>
        </div>

        <div class="bg-green-100 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-green-800">Admins</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
        </div>

        <div class="bg-purple-100 p-6 rounded-lg">
            <h3 class="text-xl font-semibold text-purple-800">Regular Users</h3>
            <p class="text-3xl font-bold text-purple-600 mt-2">{{ \App\Models\User::where('role', 'user')->count() }}</p>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-semibold mb-4">Admin Only Features</h3>
        <ul class="list-disc list-inside space-y-2">
            <li>User Management</li>
            <li>System Configuration</li>
            <li>Reports and Analytics</li>
            <li>Admin Settings</li>
        </ul>
    </div>
</div>
@endsection