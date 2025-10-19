<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'position',
        'department', 'basic_salary', 'hire_date', 'is_active'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'hire_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function salaryPayments()
    {
        return $this->hasMany(SalaryPayment::class);
    }

    public function getTotalSalaryPaidAttribute()
    {
        return $this->salaryPayments->sum('net_salary');
    }

    public function getLastPaymentDateAttribute()
    {
        $lastPayment = $this->salaryPayments()->latest()->first();
        return $lastPayment ? $lastPayment->payment_date : null;
    }
}