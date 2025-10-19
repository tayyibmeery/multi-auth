<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductionRun;
use App\Models\Vendor;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'total_products' => Product::count(),
            'total_vendors' => Vendor::count(),
            'total_purchases' => Purchase::count(),
            'total_production_runs' => ProductionRun::count(),
            'total_sales' => Sale::count(),
            'total_customers' => Customer::count(),

            'total_expenses' => Expense::sum('amount'),
        ];

        // Low stock items
        $lowStockItems = Item::whereRaw('current_stock <= min_stock')
                            ->orderBy('current_stock', 'asc')
                            ->limit(5)
                            ->get();

        // Recent purchases
        $recentPurchases = Purchase::with('vendor')
                                ->latest()
                                ->limit(5)
                                ->get();

        // Recent production runs
        $recentProductions = ProductionRun::with('billOfMaterial.product')
                                    ->latest()
                                    ->limit(5)
                                    ->get();

        // Recent sales
        $recentSales = Sale::with('customer')
                        ->latest()
                        ->limit(5)
                        ->get();

        // Stock value
        $totalStockValue = DB::table('items')
                            ->select(DB::raw('SUM(current_stock * current_price) as total'))
                            ->value('total') ?? 0;

        // Monthly sales data for chart
        $monthlySales = Sale::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Expense by category
        $expenseByCategory = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
$outOfStockItems = Item::where('current_stock', '<=', 0)->count();

        return view('dashboard', compact(
            'stats',
            'lowStockItems',
            'recentPurchases',
            'recentProductions',
            'recentSales',
            'totalStockValue',
            'monthlySales',
            'expenseByCategory',
        ));
    }

    public function adminDashboard()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $stats = [
            'total_items' => Item::count(),
            'total_products' => Product::count(),
            'total_vendors' => Vendor::count(),
            'total_purchases' => Purchase::count(),
            'total_production_runs' => ProductionRun::count(),
            'total_users' => User::count(),
            'total_sales' => Sale::count(),
            'total_customers' => Customer::count(),
            'total_expenses' => Expense::sum('amount'),
        ];

        // Monthly purchase data for chart
        $monthlyPurchases = Purchase::select(
                DB::raw('MONTH(purchase_date) as month'),
                DB::raw('YEAR(purchase_date) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('purchase_date', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Monthly sales data for chart
        $monthlySales = Sale::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Top vendors
        $topVendors = Vendor::withCount('purchases')
                        ->orderBy('purchases_count', 'desc')
                        ->limit(5)
                        ->get();

        // Top customers
        $topCustomers = Customer::withCount('sales')
                        ->orderBy('sales_count', 'desc')
                        ->limit(5)
                        ->get();

        // Recent sales
        $recentSales = Sale::with('customer')
                        ->latest()
                        ->limit(5)
                        ->get();

        // Expense by category
        $expenseByCategory = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // Stock value
        $totalStockValue = DB::table('items')
                            ->select(DB::raw('SUM(current_stock * current_price) as total'))
                            ->value('total') ?? 0;

        return view('admin.dashboard', compact(
            'stats',
            'monthlyPurchases',
            'monthlySales',
            'topVendors',
            'topCustomers',
            'recentSales',
            'expenseByCategory',
            'totalStockValue'
        ));
    }
}