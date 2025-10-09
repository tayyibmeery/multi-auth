<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'description', 'selling_price', 'current_stock'
    ];

    protected $appends = ['stock_value'];

    public function billOfMaterials()
    {
        return $this->hasMany(BillOfMaterial::class);
    }

    public function stockLedgers()
    {
        return $this->morphMany(StockLedger::class, 'reference');
    }

    public function getStockValueAttribute()
    {
        return $this->current_stock * $this->selling_price;
    }

    public function getActiveBomAttribute()
    {
        return $this->billOfMaterials()->where('is_active', true)->first();
    }
}