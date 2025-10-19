<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceProductController extends Controller
{
    public function index()
    {
        $products = ServiceProduct::orderBy('sort_order')->get();
        return view('admin.service-products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.service-products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'nullable|numeric|min:0',
            'icon' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['features'] = json_encode(explode("\n", $validated['features']));
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        ServiceProduct::create($validated);

        return redirect()->route('admin.service-products.index')->with('success', 'Service product created successfully.');
    }

    public function edit(ServiceProduct $serviceProduct)
    {
        return view('admin.service-products.edit', compact('serviceProduct'));
    }

    public function update(Request $request, ServiceProduct $serviceProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'required|string',
            'monthly_price' => 'required|numeric|min:0',
            'yearly_price' => 'nullable|numeric|min:0',
            'icon' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['features'] = json_encode(explode("\n", $validated['features']));
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $serviceProduct->update($validated);

        return redirect()->route('admin.service-products.index')->with('success', 'Service product updated successfully.');
    }

    public function destroy(ServiceProduct $serviceProduct)
    {
        $serviceProduct->delete();
        return redirect()->route('admin.service-products.index')->with('success', 'Service product deleted successfully.');
    }
}