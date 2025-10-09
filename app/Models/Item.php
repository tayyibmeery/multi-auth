<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'description', 'category_id',
        'current_price', 'current_stock', 'min_stock', 'unit'
    ];

    protected $appends = ['stock_value', 'is_low_stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function bomItems()
    {
        return $this->hasMany(BomItem::class);
    }

    public function stockLedgers()
    {
        return $this->hasMany(StockLedger::class);
    }

    public function getStockValueAttribute()
    {
        return $this->current_stock * $this->current_price;
    }

    public function getIsLowStockAttribute()
    {
        return $this->current_stock <= $this->min_stock;
    }
}