   <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-xl font-bold">
                        <i class="fas fa-warehouse mr-2"></i>Inventory System
                    </a>

                    @auth
                    <!-- Main Navigation -->
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Dashboard</a>

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('vendors.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Vendors</a>
                        <a href="{{ route('categories.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Categories</a>
                        @endif

                        <a href="{{ route('items.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Items</a>
                        <a href="{{ route('products.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Products</a>
                        <a href="{{ route('purchases.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Purchases</a>
                        <a href="{{ route('boms.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Bills of Materials</a>
                        <a href="{{ route('production-runs.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Production</a>
                        <a href="{{ route('stock-ledgers.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Stock Ledger</a>

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('reports.stock') }}" class="hover:bg-blue-700 px-3 py-2 rounded">Reports</a>
                        @endif
                    </div>
                    @endauth
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                    <span class="hidden sm:inline">Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded">
                        <i class="fas fa-cog mr-1"></i>Admin
                    </a>
                    @endif

                    <!-- Logout Form -->
                    <form method="POST" action="{{ auth()->user()->isAdmin() ? route('admin.logout') : route('user.logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-2 rounded">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                    @else
                    <a href="{{ route('admin.login') }}" class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded">Admin Login</a>
                    <a href="{{ route('user.login') }}" class="bg-green-600 hover:bg-green-700 px-3 py-2 rounded">User Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>



      <!-- Mobile Menu -->
    @auth
    <div class="bg-blue-500 text-white md:hidden">
        <div class="container mx-auto px-4 py-2">
            <div class="grid grid-cols-4 gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-center hover:bg-blue-600 p-1 rounded">
                    <i class="fas fa-tachometer-alt block mx-auto"></i>
                    <span class="text-xs">Dashboard</span>
                </a>
                <a href="{{ route('items.index') }}" class="text-center hover:bg-blue-600 p-1 rounded">
                    <i class="fas fa-boxes block mx-auto"></i>
                    <span class="text-xs">Items</span>
                </a>
                <a href="{{ route('purchases.index') }}" class="text-center hover:bg-blue-600 p-1 rounded">
                    <i class="fas fa-shopping-cart block mx-auto"></i>
                    <span class="text-xs">Purchases</span>
                </a>
                <a href="{{ route('production-runs.index') }}" class="text-center hover:bg-blue-600 p-1 rounded">
                    <i class="fas fa-industry block mx-auto"></i>
                    <span class="text-xs">Production</span>
                </a>
            </div>
        </div>
    </div>
    @endauth

    <!-- Main Content -->