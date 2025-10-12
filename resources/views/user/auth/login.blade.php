@extends("layouts.app")

@section("title", "User Login")

@section("content")
<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-600">
                <i class="fas fa-user text-xl text-white"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                User Login
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Access your inventory dashboard
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route("login") }}">
            @csrf

            <div class="-space-y-px rounded-md shadow-sm">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Email address" value="{{ old("email") }}">
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Password">
                </div>
            </div>

            @if ($errors->any())
            <div class="rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                {{ $errors->first() }}
            </div>
            @endif

            <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-green-300 group-hover:text-green-400"></i>
                    </span>
                    Sign in as User
                </button>
            </div>

            <div class="space-y-2 text-center">
                <a href="{{ route("register") }}" class="block text-sm text-green-600 hover:text-green-500">
                    Don't have an account? Register here
                </a>

            </div>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-6 rounded-md border border-yellow-200 bg-yellow-50 p-4">
            <h4 class="mb-2 text-sm font-semibold text-yellow-800">Demo Credentials:</h4>
            <p class="text-xs text-yellow-700">
                <strong>Email:</strong> user@example.com<br>
                <strong>Password:</strong> password
            </p>
        </div>
    </div>
</div>
@endsection
