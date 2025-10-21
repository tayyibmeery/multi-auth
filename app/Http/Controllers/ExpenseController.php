<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Account;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['account', 'user'])
            ->orderBy('expense_date', 'desc')
            ->paginate(20);

        // Calculate total amount for statistics
        $totalAmount = Expense::sum('amount');
        $officeSuppliesCount = Expense::where('category', 'office_supplies')->count();
        $utilitiesCount = Expense::where('category', 'utilities')->count();

        return view('expenses.index', compact('expenses', 'totalAmount', 'officeSuppliesCount', 'utilitiesCount'));
    }

    public function create()
    {
        $accounts = Account::where('is_active', true)->get();
        return view('expenses.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500',
            'category' => 'required|string|max:100',
            'payment_method' => 'required|in:cash,bank_transfer,card,cheque',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $expense = Expense::create([
                'expense_date' => $request->expense_date,
                'account_id' => $request->account_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'category' => $request->category,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('expenses.index')
                ->with('success', 'Expense created successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create expense: ' . $e->getMessage()]);
        }
    }

    public function show(Expense $expense)
    {
        $expense->load(['account', 'user']);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $accounts = Account::where('is_active', true)->get();
        return view('expenses.edit', compact('expense', 'accounts'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500',
            'category' => 'required|string|max:100',
            'payment_method' => 'required|in:cash,bank_transfer,card,cheque',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $expense->update([
                'expense_date' => $request->expense_date,
                'account_id' => $request->account_id,
                'amount' => $request->amount,
                'description' => $request->description,
                'category' => $request->category,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
            ]);

            return redirect()->route('expenses.index')
                ->with('success', 'Expense updated successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update expense: ' . $e->getMessage()]);
        }
    }

    public function destroy(Expense $expense)
    {
        try {
            $expense->delete();
            return redirect()->route('expenses.index')
                ->with('success', 'Expense deleted successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete expense: ' . $e->getMessage()]);
        }
    }
}