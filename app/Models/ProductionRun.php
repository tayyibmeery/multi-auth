<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number', 'bom_id', 'quantity_to_produce', 'actual_quantity',
        'status', 'production_date', 'completion_date', 'notes', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($productionRun) {
            if (empty($productionRun->batch_number)) {
                $productionRun->batch_number = 'BATCH-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class, 'bom_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stockLedgers()
    {
        return $this->morphMany(StockLedger::class, 'reference');
    }

    public function getTotalProductionCostAttribute()
    {
        return $this->stockLedgers()->where('type', 'production_usage')->sum('total_cost');
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }
}