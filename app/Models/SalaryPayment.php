<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number', 'employee_id', 'payment_date', 'month',
        'year', 'basic_salary', 'allowances', 'deductions',
        'net_salary', 'payment_method', 'notes', 'user_id'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($salary) {
            if (empty($salary->payment_number)) {
                $salary->payment_number = 'SAL-' . date('Ymd') . '-' . str_pad(static::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($salary) {
            // Create accounting voucher
            $salary->createAccountingVoucher();
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accountingVouchers()
    {
        return $this->morphMany(AccountingVoucher::class, 'reference');
    }

    public function createAccountingVoucher()
    {
        // Salary expense entry
        AccountingVoucher::create([
            'voucher_number' => $this->payment_number,
            'voucher_date' => $this->payment_date,
            'reference_type' => SalaryPayment::class,
            'reference_id' => $this->id,
            'account_id' => Account::where('code', '5000')->first()->id, // Salary Expense
            'debit' => $this->net_salary,
            'credit' => 0,
            'description' => 'Salary payment for ' . $this->employee->name . ' - ' . $this->month . ' ' . $this->year,
            'user_id' => $this->user_id
        ]);

        // Cash/Bank entry
        if ($this->payment_method === 'cash') {
            $paymentAccountId = Account::where('code', '1000')->first()->id;
        } else {
            $paymentAccountId = Account::where('code', '1200')->first()->id;
        }

        AccountingVoucher::create([
            'voucher_number' => $this->payment_number,
            'voucher_date' => $this->payment_date,
            'reference_type' => SalaryPayment::class,
            'reference_id' => $this->id,
            'account_id' => $paymentAccountId,
            'debit' => 0,
            'credit' => $this->net_salary,
            'description' => 'Salary payment for ' . $this->employee->name,
            'user_id' => $this->user_id
        ]);
    }
}