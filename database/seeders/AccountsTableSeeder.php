<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder
{
    public function run(): void
    {
        $defaultAccounts = [
            // Assets
            ['name' => 'Cash at Hand', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['name' => 'Cash at Bank', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['name' => 'Accounts Receivable (Fees)', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['name' => 'Furniture & Equipment', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['name' => 'Buildings', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['name' => 'Land', 'category' => 'asset', 'normal_balance' => 'debit'],

            // Liabilities
            ['name' => 'Accounts Payable', 'category' => 'liability', 'normal_balance' => 'credit'],
            ['name' => 'Salaries Payable', 'category' => 'liability', 'normal_balance' => 'credit'],
            ['name' => 'Fees Received in Advance', 'category' => 'liability', 'normal_balance' => 'credit'],
            ['name' => 'Bank Loan', 'category' => 'liability', 'normal_balance' => 'credit'],

            // Equity
            ['name' => 'Accumulated Fund', 'category' => 'equity', 'normal_balance' => 'credit'],
            ['name' => 'Opening Balance Equity', 'category' => 'equity', 'normal_balance' => 'credit'],

            // Income
            ['name' => 'Tuition Fees Income', 'category' => 'income', 'normal_balance' => 'credit'],
            ['name' => 'Boarding Income', 'category' => 'income', 'normal_balance' => 'credit'],
            ['name' => 'Transport Income', 'category' => 'income', 'normal_balance' => 'credit'],
            ['name' => 'Other School Income', 'category' => 'income', 'normal_balance' => 'credit'],
            ['name' => 'Donations & Grants', 'category' => 'income', 'normal_balance' => 'credit'],

            // Expenses
            ['name' => 'Salaries & Wages', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Teaching Materials', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Transport Expense', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Boarding & Meals', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Repairs & Maintenance', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Utilities', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Depreciation', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['name' => 'Miscellaneous Expense', 'category' => 'expense', 'normal_balance' => 'debit'],
        ];

        // Example: seeding for school_id = 1
        foreach ($defaultAccounts as $account) {
            DB::table('accounts')->insert([
                'school_id' => 1,
                'name' => $account['name'],
                'category' => $account['category'],
                'normal_balance' => $account['normal_balance'],
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
