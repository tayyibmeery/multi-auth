<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductionRun;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $sales = Sale::with(['customer', 'saleItems.product'])
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('sale_status', 'completed')
            ->orderBy('sale_date', 'desc')
            ->get();

        $totalSales = $sales->sum('total_amount');
        $totalProfit = $sales->sum('profit_margin');

        return view('reports.sales', compact('sales', 'totalSales', 'totalProfit', 'startDate', 'endDate'));
    }

    public function stockReport(Request $request)
    {
        $items = Item::with('category')
            ->orderBy('current_stock', 'asc')
            ->get();

        $products = Product::with('category')
            ->orderBy('current_stock', 'asc')
            ->get();

        return view('reports.stock', compact('items', 'products'));
    }

    public function purchaseReport(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $purchases = Purchase::with(['vendor', 'purchaseItems.item'])
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->orderBy('purchase_date', 'desc')
            ->get();

        $totalPurchases = $purchases->sum('total_amount');

        return view('reports.purchases', compact('purchases', 'totalPurchases', 'startDate', 'endDate'));
    }

    public function productionReport(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $productions = ProductionRun::with(['billOfMaterial.product'])
            ->whereBetween('production_date', [$startDate, $endDate])
            ->orderBy('production_date', 'desc')
            ->get();

        return view('reports.production', compact('productions', 'startDate', 'endDate'));
    }

  public function lowStockReport()
{
    $lowStockItems = Item::whereRaw('current_stock <= min_stock')
        ->orderBy('current_stock', 'asc')
        ->get();

    $lowStockProducts = Product::whereRaw('current_stock <= min_stock')
        ->orderBy('current_stock', 'asc')
        ->get();

    // Also get out of stock items for the summary
    $outOfStockItems = Item::where('current_stock', '<=', 0)->get();
    $outOfStockProducts = Product::where('current_stock', '<=', 0)->get();

    return view('reports.low-stock', compact(
        'lowStockItems',
        'lowStockProducts',
        'outOfStockItems',
        'outOfStockProducts'
    ));
}
    public function stockValuation()
    {
        $items = Item::select('*',
                DB::raw('(current_stock * current_price) as total_value')
            )
            ->orderBy('total_value', 'desc')
            ->get();

        $products = Product::select('*',
                DB::raw('(current_stock * selling_price) as total_value')
            )
            ->orderBy('total_value', 'desc')
            ->get();

        $totalItemValue = $items->sum('total_value');
        $totalProductValue = $products->sum('total_value');

        return view('reports.stock-valuation', compact('items', 'products', 'totalItemValue', 'totalProductValue'));
    }
}