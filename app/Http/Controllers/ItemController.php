<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
  public function index()
{
    $items = Item::with('category')->latest()->get();
    return view('items.index', compact('items'));
}
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'current_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        $item->load('category', 'stockLedgers');
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code,' . $item->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'current_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $items = Item::where('name', 'like', "%{$query}%")
                    ->orWhere('code', 'like', "%{$query}%")
                    ->get(['id', 'name', 'code', 'current_price', 'current_stock', 'unit']);

        return response()->json($items);
    }

    public function lowStock()
    {
        $items = Item::whereRaw('current_stock <= min_stock')->where('current_stock', '>', 0)->paginate(10);
        return view('items.low-stock', compact('items'));
    }

    public function outOfStock()
    {
        $items = Item::where('current_stock', '<=', 0)->paginate(10);
        return view('items.out-of-stock', compact('items'));
    }
}