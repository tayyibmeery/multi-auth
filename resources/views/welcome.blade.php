@extends('layouts.app')

@section('title', 'Welcome - Inventory Management System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-4xl mx-auto text-center">
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
            <div class="mb-8">
                <i class="fas fa-warehouse text-6xl text-blue-600 mb-4"></i>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Inventory Management System
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Streamline your inventory, production, and stock management in one powerful platform
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <i class="fas fa-user-shield text-3xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Admin Access</h3>
                    <p class="text-gray-600 mb-4">Full system access with administrative privileges</p>
                    <a href="{{ route('admin.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold inline-block">
                        Admin Login
                    </a>
                </div>

                <div class="bg-green-50 p-6 rounded-lg">
                    <i class="fas fa-user text-3xl text-green-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">User Access</h3>
                    <p class="text-gray-600 mb-4">Standard access for daily operations</p>
                    <a href="{{ route('user.login') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold inline-block">
                        User Login
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">System Features</h3>
                <div class="grid md:grid-cols-3 gap-4 text-left">
                    <div class="flex items-start">
                        <i class="fas fa-boxes text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Inventory Management</h4>
                            <p class="text-sm text-gray-600">Track items, stock levels, and movements</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-industry text-green-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Production Control</h4>
                            <p class="text-sm text-gray-600">Manage BOMs and production runs</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-chart-bar text-purple-500 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Reporting</h4>
                            <p class="text-sm text-gray-600">Comprehensive reports and analytics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection