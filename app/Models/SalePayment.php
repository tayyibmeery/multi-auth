<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 'payment_date', 'amount', 'payment_method',
        'reference_number', 'notes', 'user_id'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountingVouchers()
    {
        return $this->morphMany(AccountingVoucher::class, 'reference');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            // Update sale payment status
            $sale = $payment->sale;
            $totalPaid = $sale->payments->sum('amount');

            if ($totalPaid >= $sale->total_amount) {
                $sale->update([
                    'paid_amount' => $totalPaid,
                    'due_amount' => 0,
                    'payment_status' => 'paid'
                ]);
            } else {
                $sale->update([
                    'paid_amount' => $totalPaid,
                    'due_amount' => $sale->total_amount - $totalPaid,
                    'payment_status' => 'partial'
                ]);
            }

            // Create accounting voucher for payment
            if ($payment->payment_method === 'cash') {
                $accountId = Account::where('code', '1000')->first()->id; // Cash
            } else {
                $accountId = Account::where('code', '1200')->first()->id; // Bank
            }

            AccountingVoucher::create([
                'voucher_number' => 'VCH-' . date('Ymd') . '-' . str_pad(AccountingVoucher::count() + 1, 4, '0', STR_PAD_LEFT),
                'voucher_date' => $payment->payment_date,
                'reference_type' => SalePayment::class,
                'reference_id' => $payment->id,
                'account_id' => $accountId,
                'debit' => $payment->amount,
                'credit' => 0,
                'description' => 'Payment for sale ' . $sale->sale_number,
                'user_id' => $payment->user_id
            ]);

            // If there was accounts receivable, reduce it
            if ($sale->payment_status === 'pending' || $sale->payment_status === 'partial') {
                AccountingVoucher::create([
                    'voucher_number' => 'VCH-' . date('Ymd') . '-' . str_pad(AccountingVoucher::count() + 1, 4, '0', STR_PAD_LEFT),
                    'voucher_date' => $payment->payment_date,
                    'reference_type' => SalePayment::class,
                    'reference_id' => $payment->id,
                    'account_id' => Account::where('code', '1100')->first()->id, // Accounts Receivable
                    'debit' => 0,
                    'credit' => $payment->amount,
                    'description' => 'Reduce AR for sale ' . $sale->sale_number,
                    'user_id' => $payment->user_id
                ]);
            }
        });
    }
}