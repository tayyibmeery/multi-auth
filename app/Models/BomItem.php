<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'bom_id', 'item_id', 'quantity', 'estimated_cost'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
    ];

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bom_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getTotalCostAttribute()
    {
        return $this->quantity * ($this->item->current_price ?? 0);
    }
}