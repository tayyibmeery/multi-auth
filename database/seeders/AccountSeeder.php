<?php
// database/seeders/AccountSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // Assets
            ['name' => 'Cash', 'code' => '1000', 'type' => 'asset'],
            ['name' => 'Accounts Receivable', 'code' => '1100', 'type' => 'asset'],
            ['name' => 'Inventory', 'code' => '1200', 'type' => 'asset'],
            ['name' => 'Bank', 'code' => '1300', 'type' => 'asset'],
            ['name' => 'Fixed Assets', 'code' => '1400', 'type' => 'asset'],

            // Liabilities
            ['name' => 'Accounts Payable', 'code' => '2000', 'type' => 'liability'],
            ['name' => 'Loans Payable', 'code' => '2100', 'type' => 'liability'],

            // Equity
            ['name' => 'Capital', 'code' => '3000', 'type' => 'equity'],
            ['name' => 'Retained Earnings', 'code' => '3100', 'type' => 'equity'],

            // Income
            ['name' => 'Sales Revenue', 'code' => '4000', 'type' => 'income'],
            ['name' => 'Other Income', 'code' => '4100', 'type' => 'income'],

            // Expenses
            ['name' => 'Cost of Goods Sold', 'code' => '5000', 'type' => 'expense'],
            ['name' => 'Salary Expense', 'code' => '5100', 'type' => 'expense'],
            ['name' => 'Rent Expense', 'code' => '5200', 'type' => 'expense'],
            ['name' => 'Utilities Expense', 'code' => '5300', 'type' => 'expense'],
            ['name' => 'Marketing Expense', 'code' => '5400', 'type' => 'expense'],
            ['name' => 'Other Expenses', 'code' => '5500', 'type' => 'expense'],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}