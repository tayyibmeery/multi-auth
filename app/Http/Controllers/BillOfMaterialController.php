<?php

namespace App\Http\Controllers;

use App\Models\BillOfMaterial;
use App\Models\Product;
use App\Models\Item;
use Illuminate\Http\Request;
use DB;

class BillOfMaterialController extends Controller
{
    public function index()
    {
        $boms = BillOfMaterial::with('product')->latest()->paginate(10);
        return view('boms.index', compact('boms'));
    }

    public function create()
    {
        $products = Product::all();
        $items = Item::all();
        return view('boms.create', compact('products', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $bom = BillOfMaterial::create([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            foreach ($request->items as $itemData) {
                $item = Item::find($itemData['item_id']);
                $bom->bomItems()->create([
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'estimated_cost' => $item->current_price * $itemData['quantity'],
                ]);
            }
        });

        return redirect()->route('boms.index')->with('success', 'Bill of Material created successfully.');
    }

    public function show(BillOfMaterial $bom)
    {
        $bom->load('product', 'bomItems.item');
        return view('boms.show', compact('bom'));
    }

    public function edit(BillOfMaterial $bom)
    {
        $products = Product::all();
        $items = Item::all();
        $bom->load('bomItems');
        return view('boms.edit', compact('bom', 'products', 'items'));
    }

    public function update(Request $request, BillOfMaterial $bom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $bom) {
            $bom->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $bom->bomItems()->delete();

            foreach ($request->items as $itemData) {
                $item = Item::find($itemData['item_id']);
                $bom->bomItems()->create([
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'estimated_cost' => $item->current_price * $itemData['quantity'],
                ]);
            }
        });

        return redirect()->route('boms.index')->with('success', 'Bill of Material updated successfully.');
    }

    public function destroy(BillOfMaterial $bom)
    {
        $bom->delete();
        return redirect()->route('boms.index')->with('success', 'Bill of Material deleted successfully.');
    }
}