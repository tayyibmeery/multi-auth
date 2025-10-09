<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductionRun;
use App\Models\Vendor;
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

        // Stock value
        $totalStockValue = DB::table('items')
                            ->select(DB::raw('SUM(current_stock * current_price) as total'))
                            ->value('total') ?? 0;

        return view('dashboard', compact(
            'stats',
            'lowStockItems',
            'recentPurchases',
            'recentProductions',
            'totalStockValue'
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
            'total_users' => \App\Models\User::count(),
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

        // Top vendors
        $topVendors = Vendor::withCount('purchases')
                        ->orderBy('purchases_count', 'desc')
                        ->limit(5)
                        ->get();

        return view('admin.dashboard', compact('stats', 'monthlyPurchases', 'topVendors'));
    }
}