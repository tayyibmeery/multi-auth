<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_number', 'voucher_date', 'reference_type', 'reference_id',
        'account_id', 'debit', 'credit', 'description', 'user_id'
    ];

    protected $casts = [
        'voucher_date' => 'datetime',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function reference()
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}