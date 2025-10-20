<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'tax_number', 'contact_person'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getTotalSalesAttribute()
    {
        return $this->sales->sum('total_amount');
    }

    public function getTotalDueAttribute()
    {
        return $this->sales->sum('due_amount');
    }

public function getSalesCountAttribute()
{
    return $this->sales->count();
}

public function getLastSaleDateAttribute()
{
    return $this->sales()->latest()->first()->sale_date ?? null;
}
}
