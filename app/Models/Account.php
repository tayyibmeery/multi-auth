<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'type', 'parent_id', 'balance', 'is_active'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function debitVouchers()
    {
        return $this->hasMany(AccountingVoucher::class)->where('debit', '>', 0);
    }

    public function creditVouchers()
    {
        return $this->hasMany(AccountingVoucher::class)->where('credit', '>', 0);
    }

    public function getCurrentBalanceAttribute()
    {
        $debitTotal = $this->debitVouchers->sum('debit');
        $creditTotal = $this->creditVouchers->sum('credit');

        if (in_array($this->type, ['asset', 'expense'])) {
            return $debitTotal - $creditTotal;
        } else {
            return $creditTotal - $debitTotal;
        }
    }
}