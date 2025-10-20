<?php

namespace App\Http\Controllers;

use App\Models\CompanyInformation;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'user'])
            ->orderBy('sale_date', 'desc')
            ->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('current_stock', '>', 0)->get();
        $customers = Customer::all();

        return view('sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if ($product->current_stock < $item['quantity']) {
                    return back()->withErrors(['items' => "Insufficient stock for {$product->name}. Available: {$product->current_stock}"]);
                }

                $totalPrice = $item['quantity'] * $item['unit_price'];
                $subtotal += $totalPrice;

                $items[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ];
            }

            $taxAmount = $request->tax_amount ?? 0;
            $discountAmount = $request->discount_amount ?? 0;
            $totalAmount = $subtotal + $taxAmount - $discountAmount;

            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => 0,
                'due_amount' => $totalAmount,
                'payment_status' => 'pending',
                'sale_status' => 'completed',
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            foreach ($items as $item) {
                $sale->saleItems()->create($item);
            }

            // If payment is made at the time of sale
            if ($request->paid_amount > 0) {
                SalePayment::create([
                    'sale_id' => $sale->id,
                    'payment_date' => $request->sale_date,
                    'amount' => $request->paid_amount,
                    'payment_method' => $request->payment_method ?? 'cash',
                    'reference_number' => $request->reference_number,
                    'notes' => 'Initial payment',
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sales.show', $sale->id)
                ->with('success', 'Sale created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create sale: ' . $e->getMessage()]);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['saleItems.product', 'payments', 'customer', 'user']);
        return view('sales.show', compact('sale'));
    }

    // public function printInvoice(Sale $sale)
    // {
    //     $sale->load(['saleItems.product', 'customer']);
    //     return view('sales.invoice', compact('sale'));


    // }

    public function printInvoice(Sale $sale)
{
    // Get company information from database
    $company = CompanyInformation::first();

    return view('sales.invoice', compact('sale', 'company'));
}
}