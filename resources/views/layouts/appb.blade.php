<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Multi Auth App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">MultiAuth App</a>
            <div>
                @auth
                    <span class="mr-4">Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="mr-4">Dashboard</a>
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">Logout</a>
                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="mr-4">Dashboard</a>
                        <a href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">Logout</a>
                        <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="mr-4">Admin Login</a>
                    <a href="{{ route('user.login') }}" class="mr-4">User Login</a>
                    <a href="{{ route('user.register') }}">User Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html>