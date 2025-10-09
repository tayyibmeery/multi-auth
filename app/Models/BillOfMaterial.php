<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'name', 'description', 'is_active'
    ];

    protected $appends = ['total_estimated_cost'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bomItems()
    {
        return $this->hasMany(BomItem::class, 'bom_id');
    }

    public function productionRuns()
    {
        return $this->hasMany(ProductionRun::class, 'bom_id');
    }

    public function getTotalEstimatedCostAttribute()
    {
        return $this->bomItems->sum(function ($bomItem) {
            return $bomItem->quantity * ($bomItem->item->current_price ?? 0);
        });
    }
}