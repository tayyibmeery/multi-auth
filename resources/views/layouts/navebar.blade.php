			<nav class="bg-blue-600 text-white shadow-lg">
							<div class="container mx-auto px-4">
											<div class="flex items-center justify-between py-4">
															<div class="flex items-center space-x-4">
																			<a href="{{ url("/") }}" class="text-xl font-bold">
																							<i class="fas fa-warehouse mr-2"></i>Inventory System
																			</a>

																			@auth
																							<!-- Main Navigation -->
																							<div class="hidden space-x-4 md:flex">
																											<a href="{{ route("dashboard") }}" class="rounded px-3 py-2 hover:bg-blue-700">Dashboard</a>

																											@if (auth()->user()->isAdmin())
																															<a href="{{ route("vendors.index") }}"
																																			class="rounded px-3 py-2 hover:bg-blue-700">Vendors</a>
																															<a href="{{ route("categories.index") }}"
																																			class="rounded px-3 py-2 hover:bg-blue-700">Categories</a>
																											@endif

																											<a href="{{ route("items.index") }}" class="rounded px-3 py-2 hover:bg-blue-700">Items</a>
																											<a href="{{ route("products.index") }}" class="rounded px-3 py-2 hover:bg-blue-700">Products</a>
																											<a href="{{ route("purchases.index") }}"
																															class="rounded px-3 py-2 hover:bg-blue-700">Purchases</a>
																											<a href="{{ route("boms.index") }}" class="rounded px-3 py-2 hover:bg-blue-700">Bills of
																															Materials</a>
																											<a href="{{ route("production-runs.index") }}"
																															class="rounded px-3 py-2 hover:bg-blue-700">Production</a>
																											<a href="{{ route("stock-ledgers.index") }}" class="rounded px-3 py-2 hover:bg-blue-700">Stock
																															Ledger</a>

																											@if (auth()->user()->isAdmin())
																															<a href="{{ route("reports.stock") }}"
																																			class="rounded px-3 py-2 hover:bg-blue-700">Reports</a>
																											@endif
																							</div>
																			@endauth
															</div>

															<div class="flex items-center space-x-4">
																			@auth
																							<span class="hidden sm:inline">Welcome, {{ auth()->user()->name }}
																											({{ auth()->user()->role }})</span>

																							@if (auth()->user()->isAdmin())
																											<a href="{{ route("admin.dashboard") }}"
																															class="rounded bg-blue-700 px-3 py-2 hover:bg-blue-800">
																															<i class="fas fa-cog mr-1"></i>Admin
																											</a>
																							@endif

																							<!-- Logout Form -->
																							<form method="POST" action="{{ route("logout") }}">
																											@csrf
																											<button type="submit" class="rounded bg-red-600 px-3 py-2 hover:bg-red-700">
																															<i class="fas fa-sign-out-alt mr-1"></i>Logout
																											</button>
																							</form>
																			@else
																							<a href="{{ route("login") }}" class="rounded bg-green-600 px-3 py-2 hover:bg-green-700">User
																											Login</a>
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
																			<a href="{{ route("dashboard") }}" class="rounded p-1 text-center hover:bg-blue-600">
																							<i class="fas fa-tachometer-alt mx-auto block"></i>
																							<span class="text-xs">Dashboard</span>
																			</a>
																			<a href="{{ route("items.index") }}" class="rounded p-1 text-center hover:bg-blue-600">
																							<i class="fas fa-boxes mx-auto block"></i>
																							<span class="text-xs">Items</span>
																			</a>
																			<a href="{{ route("purchases.index") }}" class="rounded p-1 text-center hover:bg-blue-600">
																							<i class="fas fa-shopping-cart mx-auto block"></i>
																							<span class="text-xs">Purchases</span>
																			</a>
																			<a href="{{ route("production-runs.index") }}" class="rounded p-1 text-center hover:bg-blue-600">
																							<i class="fas fa-industry mx-auto block"></i>
																							<span class="text-xs">Production</span>
																			</a>
															</div>
											</div>
							</div>
			@endauth

			<!-- Main Content -->
