<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('vendor', 'user')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $items = Item::all();
        return view('purchases.create', compact('vendors', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'vendor_id' => $request->vendor_id,
                'purchase_date' => $request->purchase_date,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            $totalAmount = 0;

            foreach ($request->items as $itemData) {
                $totalPrice = $itemData['quantity'] * $itemData['unit_price'];

                $purchase->purchaseItems()->create([
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $totalPrice,
                ]);

                // Update item stock and price
                $item = Item::find($itemData['item_id']);
                $item->current_stock += $itemData['quantity'];
                $item->current_price = $itemData['unit_price']; // Update to latest price
                $item->save();

                // Create stock ledger entry
                StockLedger::create([
                    'date' => $request->purchase_date,
                    'type' => 'purchase',
                    'reference_type' => Purchase::class,
                    'reference_id' => $purchase->id,
                    'item_id' => $itemData['item_id'],
                    'quantity_in' => $itemData['quantity'],
                    'unit_cost' => $itemData['unit_price'],
                    'total_cost' => $totalPrice,
                    'stock_after_transaction' => $item->current_stock,
                    'notes' => 'Purchase from ' . $purchase->vendor->name,
                    'user_id' => auth()->id(),
                ]);

                $totalAmount += $totalPrice;
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('vendor', 'purchaseItems.item', 'user');
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            // Reverse stock changes
            foreach ($purchase->purchaseItems as $purchaseItem) {
                $item = $purchaseItem->item;
                $item->current_stock -= $purchaseItem->quantity;
                $item->save();

                // Remove stock ledger entries
                $purchase->stockLedgers()->where('item_id', $item->id)->delete();
            }

            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}