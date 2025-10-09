@extends('layouts.app')

@section('title', 'User Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 bg-green-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                User Login
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Access your inventory dashboard
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('user.login') }}">
            @csrf

            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                           placeholder="Email address" value="{{ old('email') }}">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                           placeholder="Password">
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-green-300 group-hover:text-green-400"></i>
                    </span>
                    Sign in as User
                </button>
            </div>

            <div class="text-center space-y-2">
                <a href="{{ route('user.register') }}" class="text-green-600 hover:text-green-500 text-sm block">
                    Don't have an account? Register here
                </a>
                <a href="{{ route('admin.login') }}" class="text-blue-600 hover:text-blue-500 text-sm block">
                    Are you an admin? Login here
                </a>
            </div>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <h4 class="text-sm font-semibold text-yellow-800 mb-2">Demo Credentials:</h4>
            <p class="text-xs text-yellow-700">
                <strong>Email:</strong> user@example.com<br>
                <strong>Password:</strong> password
            </p>
        </div>
    </div>
</div>
@endsection