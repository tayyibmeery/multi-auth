<?php

namespace App\Http\Controllers;

use App\Models\StockLedger;
use Illuminate\Http\Request;

class StockLedgerController extends Controller
{
    public function index(Request $request)
    {
        $query = StockLedger::with(['item', 'product', 'user']);

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('item_id') && $request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('date', '<=', $request->date_to);
        }

        $stockLedgers = $query->latest()->paginate(20);

        return view('stock-ledgers.index', compact('stockLedgers'));
    }

      public function itemLedger($itemId)
    {
        $item = \App\Models\Item::findOrFail($itemId);

        $ledgers = StockLedger::where('item_id', $itemId)
                            ->with('user')
                            ->latest()
                            ->paginate(20);

        // Calculate totals
        $totalIn = StockLedger::where('item_id', $itemId)->sum('quantity_in');
        $totalOut = StockLedger::where('item_id', $itemId)->sum('quantity_out');

        return view('stock-ledgers.item', compact('item', 'ledgers', 'totalIn', 'totalOut'));
    }

    public function productLedger($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $ledgers = StockLedger::where('product_id', $productId)
                            ->with('user')
                            ->latest()
                            ->paginate(20);

        return view('stock-ledgers.product', compact('product', 'ledgers'));
    }
}