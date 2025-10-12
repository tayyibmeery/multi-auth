@extends("layouts.app")

@section("title", "User Registration")

@section("content")
<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div>
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-600">
                <i class="fas fa-user-plus text-xl text-white"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create Account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Register for a new user account
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route("register") }}">
            @csrf

            <div class="space-y-4 rounded-md shadow-sm">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" name="name" type="text" required class="relative mt-1 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Enter your full name" value="{{ old("name") }}">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="relative mt-1 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Enter your email" value="{{ old("email") }}">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required class="relative mt-1 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Create a password">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="relative mt-1 block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm" placeholder="Confirm your password">
                </div>
            </div>

            @if ($errors->any())
            <div class="rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-green-300 group-hover:text-green-400"></i>
                    </span>
                    Create Account
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route("login") }}" class="text-sm text-green-600 hover:text-green-500">
                    Already have an account? Sign in
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
