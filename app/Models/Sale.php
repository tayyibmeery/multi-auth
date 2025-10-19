<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_number', 'customer_id', 'sale_date', 'subtotal',
        'tax_amount', 'discount_amount', 'total_amount', 'paid_amount',
        'due_amount', 'payment_status', 'sale_status', 'notes', 'user_id'
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            if (empty($sale->sale_number)) {
                $sale->sale_number = 'SALE-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($sale) {
            // Create accounting voucher
            if ($sale->sale_status === 'completed') {
                $sale->createAccountingVoucher();
            }
        });

        static::updated(function ($sale) {
            // Update accounting voucher if sale is completed
            if ($sale->sale_status === 'completed') {
                $sale->updateAccountingVoucher();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stockLedgers()
    {
        return $this->morphMany(StockLedger::class, 'reference');
    }

    public function accountingVouchers()
    {
        return $this->morphMany(AccountingVoucher::class, 'reference');
    }

    public function createAccountingVoucher()
    {
        // Create sales revenue entry
        AccountingVoucher::create([
            'voucher_number' => 'VCH-' . date('Ymd') . '-' . str_pad(AccountingVoucher::count() + 1, 4, '0', STR_PAD_LEFT),
            'voucher_date' => $this->sale_date,
            'reference_type' => Sale::class,
            'reference_id' => $this->id,
            'account_id' => Account::where('code', '4000')->first()->id, // Sales Revenue
            'debit' => 0,
            'credit' => $this->total_amount,
            'description' => 'Sales revenue from sale ' . $this->sale_number,
            'user_id' => $this->user_id
        ]);

        // Create accounts receivable or cash entry based on payment status
        if ($this->payment_status === 'paid') {
            $accountId = Account::where('code', '1000')->first()->id; // Cash
        } else {
            $accountId = Account::where('code', '1100')->first()->id; // Accounts Receivable
        }

        AccountingVoucher::create([
            'voucher_number' => 'VCH-' . date('Ymd') . '-' . str_pad(AccountingVoucher::count() + 1, 4, '0', STR_PAD_LEFT),
            'voucher_date' => $this->sale_date,
            'reference_type' => Sale::class,
            'reference_id' => $this->id,
            'account_id' => $accountId,
            'debit' => $this->total_amount,
            'credit' => 0,
            'description' => 'Sale ' . $this->sale_number,
            'user_id' => $this->user_id
        ]);
    }

    public function updateAccountingVoucher()
    {
        // Update existing vouchers
        $this->accountingVouchers()->delete();
        $this->createAccountingVoucher();
    }

    public function getProfitMarginAttribute()
    {
        $costOfGoodsSold = $this->saleItems->sum(function ($item) {
            return $item->product->activeBom ? $item->product->activeBom->total_estimated_cost * $item->quantity : 0;
        });

        return $this->total_amount - $costOfGoodsSold;
    }
}