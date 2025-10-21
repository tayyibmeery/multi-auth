<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountingVoucher;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function dashboard()
    {
        $totalSales = Sale::where('sale_status', 'completed')->sum('total_amount');
        $totalExpenses = Expense::sum('amount');
        $cashBalance = Account::where('code', '1000')->first()->current_balance ?? 0;
        $bankBalance = Account::where('code', '1300')->first()->current_balance ?? 0;
        $products = Product::all();

        $recentVouchers = AccountingVoucher::with(['account', 'user'])
            ->orderBy('voucher_date', 'desc')
            ->take(10)
            ->get();

        // Add customers for the sales form
        $customers = \App\Models\Customer::orderBy('name')->get();

        return view('accounting.dashboard', compact(
            'totalSales', 'totalExpenses', 'cashBalance',
            'bankBalance', 'recentVouchers', 'customers','products'
        ));
    }

    /**
     * Display all accounting vouchers
     */
    public function vouchers()
    {
        $vouchers = AccountingVoucher::with(['account', 'user'])
            ->orderBy('voucher_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('accounting.vouchers', compact('vouchers'));
    }

    /**
     * Show the form for creating a new voucher
     */
    public function createVoucher()
    {
        $accounts = Account::where('is_active', true)->orderBy('name')->get();
        return view('accounting.vouchers-create', compact('accounts'));
    }

    /**
     * Store a new voucher
     */
    public function storeVoucher(Request $request)
    {
        $validated = $request->validate([
            'voucher_date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'debit' => 'required_without:credit|numeric|min:0',
            'credit' => 'required_without:debit|numeric|min:0',
            'description' => 'required|string|max:500',
            'reference' => 'nullable|string|max:255',
        ]);

        // Ensure only one of debit or credit is provided
        if ($request->has('debit') && $request->has('credit')) {
            return back()->withErrors(['error' => 'Please provide either debit or credit, not both.']);
        }

        // Generate voucher number
        $voucherNumber = 'VCH-' . date('Ymd') . '-' . str_pad(AccountingVoucher::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

        $voucher = AccountingVoucher::create([
            'voucher_number' => $voucherNumber,
            'voucher_date' => $validated['voucher_date'],
            'account_id' => $validated['account_id'],
            'debit' => $validated['debit'] ?? 0,
            'credit' => $validated['credit'] ?? 0,
            'description' => $validated['description'],
            'reference' => $validated['reference'],
            'user_id' => auth()->id(),
        ]);

        // Update account balance
        $account = Account::find($validated['account_id']);
        if ($account) {
            if ($validated['debit'] > 0) {
                $account->current_balance += $validated['debit'];
            } else {
                $account->current_balance -= $validated['credit'];
            }
            $account->save();
        }

        return redirect()->route('accounting.vouchers')
            ->with('success', 'Voucher created successfully.');
    }

    public function trialBalance()
    {
        $accounts = Account::with(['debitVouchers', 'creditVouchers'])->get();

        $trialBalance = $accounts->map(function ($account) {
            return [
                'account' => $account->name,
                'code' => $account->code,
                'debit' => $account->debitVouchers->sum('debit'),
                'credit' => $account->creditVouchers->sum('credit'),
            ];
        });

        $totalDebit = $trialBalance->sum('debit');
        $totalCredit = $trialBalance->sum('credit');

        return view('accounting.trial-balance', compact('trialBalance', 'totalDebit', 'totalCredit'));
    }

    public function incomeStatement(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->endOfMonth()->format('Y-m-d');

        $revenue = AccountingVoucher::whereHas('account', function ($query) {
            $query->where('type', 'income');
        })
        ->whereBetween('voucher_date', [$startDate, $endDate])
        ->sum('credit');

        $expenses = AccountingVoucher::whereHas('account', function ($query) {
            $query->where('type', 'expense');
        })
        ->whereBetween('voucher_date', [$startDate, $endDate])
        ->sum('debit');

        $netIncome = $revenue - $expenses;

        return view('accounting.income-statement', compact(
            'revenue', 'expenses', 'netIncome', 'startDate', 'endDate'
        ));
    }

    public function balanceSheet()
    {
        $assets = Account::where('type', 'asset')->get();
        $liabilities = Account::where('type', 'liability')->get();
        $equity = Account::where('type', 'equity')->get();

        $totalAssets = $assets->sum('current_balance');
        $totalLiabilities = $liabilities->sum('current_balance');
        $totalEquity = $equity->sum('current_balance');

        return view('accounting.balance-sheet', compact(
            'assets', 'liabilities', 'equity',
            'totalAssets', 'totalLiabilities', 'totalEquity'
        ));
    }
}