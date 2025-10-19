<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 'product_id', 'quantity', 'unit_price', 'total_price'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($saleItem) {
            // Update product stock
            $saleItem->product->decrement('current_stock', $saleItem->quantity);

            // Create stock ledger entry
            StockLedger::create([
                'date' => $saleItem->sale->sale_date,
                'type' => 'sale',
                'reference_type' => Sale::class,
                'reference_id' => $saleItem->sale_id,
                'product_id' => $saleItem->product_id,
                'quantity_out' => $saleItem->quantity,
                'unit_cost' => $saleItem->product->activeBom ? $saleItem->product->activeBom->total_estimated_cost : 0,
                'total_cost' => $saleItem->quantity * ($saleItem->product->activeBom ? $saleItem->product->activeBom->total_estimated_cost : 0),
                'stock_after_transaction' => $saleItem->product->current_stock,
                'notes' => 'Sale: ' . $saleItem->sale->sale_number,
                'user_id' => $saleItem->sale->user_id
            ]);
        });
    }
}