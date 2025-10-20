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
    $cashBalance = Account::where('code', '1000')->first()->current_balance;
    $bankBalance = Account::where('code', '1300')->first()->current_balance;
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