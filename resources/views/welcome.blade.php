@extends("layouts.app")

@section("title", "Welcome - Inventory Management System")

@section("content")
				<div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
								<div class="mx-auto max-w-4xl text-center">
												<div class="rounded-2xl bg-white p-8 shadow-xl md:p-12">
																<div class="mb-8">
																				<i class="fas fa-warehouse mb-4 text-6xl text-blue-600"></i>
																				<h1 class="mb-4 text-4xl font-bold text-gray-800 md:text-5xl">
																								Inventory Management System
																				</h1>
																				<p class="mb-8 text-xl text-gray-600">
																								Manage inventory, production, and stock — all in one smart platform.
																				</p>
																</div>

																<div class="mb-8 grid gap-8 md:grid-cols-2">
																				<div class="rounded-lg bg-blue-50 p-6">
																								<i class="fas fa-user-shield mb-4 text-3xl text-blue-600"></i>
																								<h3 class="mb-2 text-xl font-semibold text-gray-800">Admin Access</h3>
																								<p class="mb-4 text-gray-600">Full system access with administrative privileges</p>
																								<a href="{{ route("admin.login") }}"
																												class="inline-block rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">
																												Admin Login
																								</a>
																				</div>

																				<div class="rounded-lg bg-green-50 p-6">
																								<i class="fas fa-user mb-4 text-3xl text-green-600"></i>
																								<h3 class="mb-2 text-xl font-semibold text-gray-800">User Access</h3>
																								<p class="mb-4 text-gray-600">Standard access for daily operations</p>
																								<a href="{{ route("user.login") }}"
																												class="inline-block rounded-lg bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700">
																												User Login
																								</a>
																				</div>
																</div>

																<div class="rounded-lg bg-gray-50 p-6">
																				<h3 class="mb-4 text-2xl font-semibold text-gray-800">System Features</h3>
																				<div class="grid gap-4 text-left md:grid-cols-3">
																								<div class="flex items-start">
																												<i class="fas fa-boxes mr-3 mt-1 text-blue-500"></i>
																												<div>
																																<h4 class="font-semibold">Inventory Management</h4>
																																<p class="text-sm text-gray-600">Track items, stock levels, and movements</p>
																												</div>
																								</div>
																								<div class="flex items-start">
																												<i class="fas fa-industry mr-3 mt-1 text-green-500"></i>
																												<div>
																																<h4 class="font-semibold">Production Control</h4>
																																<p class="text-sm text-gray-600">Manage Bill of Materials and production runs</p>
																												</div>
																								</div>
																								<div class="flex items-start">
																												<i class="fas fa-chart-bar mr-3 mt-1 text-purple-500"></i>
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
