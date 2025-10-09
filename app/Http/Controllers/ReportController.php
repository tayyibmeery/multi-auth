<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductionRun;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function stockReport()
    {
        $items = Item::with('category')->get();
        $products = Product::all();

        return view('reports.stock', compact('items', 'products'));
    }





 


    // Add these methods to ReportController

public function purchaseReport(Request $request)
{
    $query = Purchase::with('vendor', 'purchaseItems.item');

    if ($request->has('date_from') && $request->date_from) {
        $query->where('purchase_date', '>=', $request->date_from);
    }

    if ($request->has('date_to') && $request->date_to) {
        $query->where('purchase_date', '<=', $request->date_to);
    }

    if ($request->has('vendor_id') && $request->vendor_id) {
        $query->where('vendor_id', $request->vendor_id);
    }

    $purchases = $query->latest()->get();
    $vendors = \App\Models\Vendor::all();

    return view('reports.purchases', compact('purchases', 'vendors'));
}

public function productionReport(Request $request)
{
    $query = ProductionRun::with('billOfMaterial.product');

    if ($request->has('date_from') && $request->date_from) {
        $query->where('production_date', '>=', $request->date_from);
    }

    if ($request->has('date_to') && $request->date_to) {
        $query->where('production_date', '<=', $request->date_to);
    }

    $productionRuns = $query->latest()->get();

    return view('reports.production', compact('productionRuns'));
}

public function lowStockReport()
{
    $items = \App\Models\Item::whereRaw('current_stock <= min_stock')->get();
    return view('reports.low-stock', compact('items'));
}

public function stockValuation()
{
    $items = \App\Models\Item::select('items.*', \DB::raw('(current_stock * current_price) as total_value'))
                ->orderBy('total_value', 'desc')
                ->get();

    $products = \App\Models\Product::select('products.*', \DB::raw('(current_stock * selling_price) as total_value'))
                    ->orderBy('total_value', 'desc')
                    ->get();

    $totalItemValue = $items->sum('total_value');
    $totalProductValue = $products->sum('total_value');

    return view('reports.stock-valuation', compact('items', 'products', 'totalItemValue', 'totalProductValue'));
}
}