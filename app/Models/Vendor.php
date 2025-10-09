<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'contact_person', 'email', 'phone', 'address'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->purchases->sum('total_amount');
    }
}