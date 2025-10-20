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
use App\Models\Account;
use App\Models\AccountingVoucher;
use App\Models\Employee;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $stats = [
            'total_items' => Item::count(),
            'total_products' => Product::count(),
            'total_vendors' => Vendor::count(),
            'total_purchases' => Purchase::count(),
            'total_production_runs' => ProductionRun::count(),
            'total_sales' => Sale::count(),
            'total_customers' => Customer::count(),
            'total_expenses' => Expense::sum('amount'),
            'total_employees' => Employee::count(),
            'total_revenue' => Sale::where('sale_status', 'completed')->sum('total_amount'),
        ];

        // Accounting Stats
        $accountingStats = [
            'cash_balance' => Account::where('code', '1000')->first()->current_balance ?? 0,
            'bank_balance' => Account::where('code', '1300')->first()->current_balance ?? 0,
            'total_accounts' => Account::where('is_active', true)->count(),
            'recent_vouchers_count' => AccountingVoucher::count(),
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

        // Recent accounting vouchers
        $recentVouchers = AccountingVoucher::with(['account', 'user'])
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

        // Performance metrics (you can replace with actual calculations)
        $performance = [
            'stock_turnover' => 2.5,
            'order_fulfillment_rate' => 95,
            'production_efficiency' => 88,
            'customer_satisfaction' => 92,
        ];

        return view('dashboard', compact(
            'stats',
            'accountingStats',
            'lowStockItems',
            'recentPurchases',
            'recentProductions',
            'recentSales',
            'recentVouchers',
            'totalStockValue',
            'monthlySales',
            'expenseByCategory',
            'outOfStockItems',
            'performance'
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
            'total_employees' => Employee::count(),
            'total_revenue' => Sale::where('sale_status', 'completed')->sum('total_amount'),
        ];

        // Accounting Stats for Admin
        $accountingStats = [
            'cash_balance' => Account::where('code', '1000')->first()->current_balance ?? 0,
            'bank_balance' => Account::where('code', '1300')->first()->current_balance ?? 0,
            'total_accounts' => Account::where('is_active', true)->count(),
            'recent_vouchers_count' => AccountingVoucher::count(),
            'total_assets' => Account::where('type', 'asset')->sum('current_balance'),
            'total_liabilities' => Account::where('type', 'liability')->sum('current_balance'),
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

        // Recent accounting vouchers
        $recentVouchers = AccountingVoucher::with(['account', 'user'])
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
            'accountingStats',
            'monthlyPurchases',
            'monthlySales',
            'topVendors',
            'topCustomers',
            'recentSales',
            'recentVouchers',
            'expenseByCategory',
            'totalStockValue'
        ));
    }
}