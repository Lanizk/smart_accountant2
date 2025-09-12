<?php

namespace App\Observers;
use App\Models\Expense;
use App\Models\CashbookEntry;
use Illuminate\Support\Facades\DB;

class ExpenseObserver
{
    public function created(Expense $expense)
    {
        DB::transaction(function () use ($expense) {
            $expense->cashbookEntries()->create([
                'school_id' => $expense->school_id,
                'transaction_type' => 'outflow',
                'entry_type' => 'original',
                'amount' => $expense->amount,
                'payment_method' => $expense->payment_method,
                'transaction_date' => $expense->expense_date ?? now()->toDateString(),
                'description' => 'Expense: ' . ($expense->description ?? 'Unspecified') . ' #' . $expense->id,
            ]);
        });
    }

    public function updated(Expense $expense)
    {
        // update the original cashbook entry when key fields change
        DB::transaction(function () use ($expense) {
            $original = $expense->cashbookEntries()->where('entry_type', 'original')->first();

            if ($original) {
                $original->update([
                    'amount' => $expense->amount,
                    'payment_method' => $expense->payment_method,
                    'transaction_date' => $expense->expense_date ?? $original->transaction_date,
                    'description' => 'Expense: ' . ($expense->description ?? 'Unspecified') . ' #' . $expense->id,
                ]);
            } else {
                // fallback: create the original if missing
                $expense->cashbookEntries()->create([
                    'school_id' => $expense->school_id,
                    'transaction_type' => 'outflow',
                    'entry_type' => 'original',
                    'amount' => $expense->amount,
                    'payment_method' => $expense->payment_method,
                    'transaction_date' => $expense->expense_date ?? now()->toDateString(),
                    'description' => 'Expense (recreated): ' . ($expense->description ?? '') . ' #' . $expense->id,
                ]);
            }
        });
    }

    public function deleting(Expense $expense)
    {
        // only run for soft deletes
        if ($expense->isForceDeleting()) {
            return;
        }

        DB::transaction(function () use ($expense) {
            // find the original entry (if any)
            $original = $expense->cashbookEntries()->where('entry_type', 'original')->first();

            $expense->cashbookEntries()->create([
                'school_id' => $expense->school_id,
                'transaction_type' => 'inflow', // reversal of an outflow
                'entry_type' => 'reversal',
                'amount' => $expense->amount,
                'payment_method' => $expense->payment_method,
                'transaction_date' => now()->toDateString(),
                'description' => 'Reversal of expense #' . $expense->id,
                'related_entry_id' => $original ? $original->id : null,
            ]);
        });
    }

    public function restoring(Expense $expense)
    {
        DB::transaction(function () use ($expense) {
            
            $reversal = $expense->cashbookEntries()
                        ->where('entry_type', 'reversal')
                        ->orderByDesc('created_at')
                        ->first();

            $expense->cashbookEntries()->create([
                'school_id' => $expense->school_id,
                'transaction_type' => 'outflow',
                'entry_type' => 'restored',
                'amount' => $expense->amount,
                'payment_method' => $expense->payment_method,
                'transaction_date' => now()->toDateString(),
                'description' => 'Restored expense #' . $expense->id,
                'related_entry_id' => $reversal ? $reversal->id : null,
            ]);
        });
    }

}
