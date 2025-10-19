<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_number', 'expense_date', 'account_id', 'amount',
        'description', 'category', 'payment_method', 'reference_number',
        'notes', 'user_id'
    ];

    protected $casts = [
        'expense_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            if (empty($expense->expense_number)) {
                $expense->expense_number = 'EXP-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($expense) {
            // Create accounting voucher
            $expense->createAccountingVoucher();
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountingVouchers()
    {
        return $this->morphMany(AccountingVoucher::class, 'reference');
    }

    public function createAccountingVoucher()
    {
        // Expense entry
        AccountingVoucher::create([
            'voucher_number' => $this->expense_number,
            'voucher_date' => $this->expense_date,
            'reference_type' => Expense::class,
            'reference_id' => $this->id,
            'account_id' => $this->account_id,
            'debit' => $this->amount,
            'credit' => 0,
            'description' => $this->description,
            'user_id' => $this->user_id
        ]);

        // Cash/Bank entry
        if ($this->payment_method === 'cash') {
            $paymentAccountId = Account::where('code', '1000')->first()->id;
        } else {
            $paymentAccountId = Account::where('code', '1200')->first()->id;
        }

        AccountingVoucher::create([
            'voucher_number' => $this->expense_number,
            'voucher_date' => $this->expense_date,
            'reference_type' => Expense::class,
            'reference_id' => $this->id,
            'account_id' => $paymentAccountId,
            'debit' => 0,
            'credit' => $this->amount,
            'description' => $this->description,
            'user_id' => $this->user_id
        ]);
    }
}