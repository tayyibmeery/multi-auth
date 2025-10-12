@extends("layouts.app")

@section("title", "")

@section("styles")
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .feature-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .login-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .login-card:hover::before {
        transform: scaleX(1);
    }

    .login-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .7;
        }
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    [data-theme="dark"] .bg-white {
        background-color: var(--card-bg) !important;
    }

    [data-theme="dark"] .text-gray-800 {
        color: var(--text-primary) !important;
    }

    [data-theme="dark"] .text-gray-600 {
        color: var(--text-secondary) !important;
    }

    [data-theme="dark"] .bg-gray-50 {
        background-color: var(--bg-tertiary) !important;
    }

    [data-theme="dark"] .bg-blue-50,
    [data-theme="dark"] .bg-green-50 {
        background-color: var(--bg-tertiary) !important;
    }

    [data-theme="dark"] .feature-card {
        border-color: var(--border-color);
    }

</style>
@endsection

@section("content")
<!-- Hero Section -->
<section class="hero-gradient relative overflow-hidden py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 h-64 w-64 rounded-full bg-white blur-3xl"></div>
        <div class="absolute bottom-10 right-10 h-96 w-96 rounded-full bg-white blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center text-white">
            <div class="mb-6 floating">
                <i class="fas fa-warehouse text-7xl drop-shadow-lg"></i>
            </div>
            <h1 class="mb-4 text-5xl md:text-6xl font-bold drop-shadow-lg">
                Inventory Management System
            </h1>
            <p class="mb-8 text-xl md:text-2xl font-light max-w-3xl mx-auto">
                Streamline your operations with intelligent inventory tracking, production management, and real-time analytics
            </p>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mt-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                    <div class="text-3xl font-bold">100%</div>
                    <div class="text-sm opacity-90">Accuracy</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                    <div class="text-3xl font-bold">24/7</div>
                    <div class="text-sm opacity-90">Access</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                    <div class="text-3xl font-bold">Real-time</div>
                    <div class="text-sm opacity-90">Tracking</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                    <div class="text-3xl font-bold">Secure</div>
                    <div class="text-sm opacity-90">Platform</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Login Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-gray-800">
                Get Started Today
            </h2>
            <p class="text-center text-gray-600 mb-12 text-lg">
                Login to access your inventory management dashboard
            </p>

            <!-- Single Login Card -->
            <div class="login-card bg-white rounded-2xl p-8 md:p-12 shadow-lg max-w-xl mx-auto">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 mb-4">
                        <i class="fas fa-sign-in-alt text-4xl text-blue-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-2">System Login</h3>
                    <p class="text-gray-600 mb-6">Access your inventory management dashboard</p>

                    <div class="grid md:grid-cols-2 gap-4 mb-8 text-left">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-shield text-blue-500 mr-2"></i>
                                Admin Features
                            </h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                                    <span>Manage users & permissions</span>
                                </li>
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                                    <span>Configure system settings</span>
                                </li>
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-blue-500 mr-2 mt-0.5"></i>
                                    <span>Vendor & category management</span>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user text-green-500 mr-2"></i>
                                User Features
                            </h4>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Manage inventory items</span>
                                </li>
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Process purchases</span>
                                </li>
                                <li class="flex items-start text-gray-700">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                    <span>Track production runs</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="block w-full text-center rounded-lg bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 px-6 py-4 font-semibold text-white text-lg hover:from-blue-700 hover:via-purple-700 hover:to-blue-800 transition-all shadow-md hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login to Dashboard
                </a>

                <p class="text-center text-gray-500 text-sm mt-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    All users login through the same portal
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Powerful Features for Complete Control
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Everything you need to manage your inventory efficiently and effectively
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <!-- Feature 1 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-boxes text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Inventory Tracking</h3>
                <p class="text-gray-600">
                    Real-time tracking of all inventory items with detailed stock levels, locations, and movement history
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-industry text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Production Management</h3>
                <p class="text-gray-600">
                    Manage Bill of Materials (BOM), track production runs, and monitor manufacturing processes seamlessly
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-purple-100 mb-4">
                    <i class="fas fa-shopping-cart text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Purchase Orders</h3>
                <p class="text-gray-600">
                    Create and manage purchase orders, track vendor information, and streamline procurement workflows
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-chart-line text-2xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Analytics & Reports</h3>
                <p class="text-gray-600">
                    Comprehensive reporting with stock valuation, low stock alerts, and detailed transaction histories
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Low Stock Alerts</h3>
                <p class="text-gray-600">
                    Automatic notifications when inventory levels fall below reorder points to prevent stockouts
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-indigo-100 mb-4">
                    <i class="fas fa-history text-2xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Stock Ledger</h3>
                <p class="text-gray-600">
                    Complete audit trail of all stock movements with date, time, quantity, and transaction details
                </p>
            </div>

            <!-- Feature 7 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-pink-100 mb-4">
                    <i class="fas fa-tags text-2xl text-pink-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Category Management</h3>
                <p class="text-gray-600">
                    Organize inventory with custom categories and subcategories for easy navigation and reporting
                </p>
            </div>

            <!-- Feature 8 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-teal-100 mb-4">
                    <i class="fas fa-truck text-2xl text-teal-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Vendor Management</h3>
                <p class="text-gray-600">
                    Maintain vendor database with contact information, pricing, and purchase history for better relationships
                </p>
            </div>

            <!-- Feature 9 -->
            <div class="feature-card bg-white rounded-xl p-6 shadow-md">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-orange-100 mb-4">
                    <i class="fas fa-cube text-2xl text-orange-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Product Assembly</h3>
                <p class="text-gray-600">
                    Create finished products from raw materials using BOM specifications with automated inventory adjustments
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
                Why Choose Our Inventory System?
            </h2>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Save Time</h3>
                        <p class="text-gray-600">Automate manual processes and reduce data entry with streamlined workflows</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Reduce Costs</h3>
                        <p class="text-gray-600">Minimize waste, prevent stockouts, and optimize inventory investment</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-purple-500 text-white">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Better Insights</h3>
                        <p class="text-gray-600">Make data-driven decisions with comprehensive analytics and reporting</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-500 text-white">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Secure & Reliable</h3>
                        <p class="text-gray-600">Enterprise-grade security with role-based access control and audit trails</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 hero-gradient text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Ready to Streamline Your Inventory?
        </h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Join businesses that trust our system to manage their inventory efficiently
        </p>
        <a href="{{ route('login') }}" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all shadow-lg transform hover:scale-105">
            <i class="fas fa-rocket mr-2"></i>
            Get Started Now
        </a>
    </div>
</section>
@endsection
