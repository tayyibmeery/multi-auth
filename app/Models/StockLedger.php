<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'type', 'reference_type', 'reference_id', 'item_id',
        'product_id', 'quantity_in', 'quantity_out', 'unit_cost',
        'total_cost', 'stock_after_transaction', 'notes', 'user_id'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function reference()
    {
        return $this->morphTo();
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTransactionTypeAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }
}