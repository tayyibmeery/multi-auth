<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Http\Request;

class SalePaymentController extends Controller
{
    public function create(Sale $sale)
    {
        return view('sales.payments.create', compact('sale'));
    }

    public function store(Request $request, Sale $sale)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01|max:' . $sale->due_amount,
            'payment_method' => 'required|in:cash,bank_transfer,card,cheque',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        SalePayment::create([
            'sale_id' => $sale->id,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('sales.show', $sale->id)
            ->with('success', 'Payment added successfully.');
    }
}