<?php

namespace App\Observers;

use App\Models\OtherIncome;
use App\Models\CashbookEntry;

class OtherIncomeObserver
{
    public function created(OtherIncome $income)
    {
        CashbookEntry::create([
            'school_id' => $income->school_id,
            'transaction_type' => 'inflow',
            'entry_type' => 'original',
            'source_id' => $income->id,
            'source_type' => OtherIncome::class,
            'amount' => $income->amount,
            'payment_method' => $income->payment_method,
            'transaction_date' => $income->income_date,
            'description' => $income->description,
        ]);
    }

    public function updated(OtherIncome $income)
    {
        $entry = CashbookEntry::where('source_type', OtherIncome::class)
                              ->where('source_id', $income->id)
                              ->first();

        if ($entry) {
            $entry->update([
                'amount' => $income->amount,
                'payment_method' => $income->payment_method,
                'transaction_date' => $income->income_date,
                'description' => $income->description,
            ]);
        }
    }

    public function deleted(OtherIncome $income)
    {
        // Soft delete: create reversal entry
        $entry = CashbookEntry::where('source_type', OtherIncome::class)
                              ->where('source_id', $income->id)
                              ->first();

        if ($entry) {
            CashbookEntry::create([
                'school_id' => $entry->school_id,
                'transaction_type' => 'outflow',
                'entry_type' => 'reversal',
                'source_id' => $income->id,
                'source_type' => OtherIncome::class,
                'related_entry_id' => $entry->id,
                'amount' => $entry->amount,
                'payment_method' => $entry->payment_method,
                'transaction_date' => now(),
                'description' => 'Reversal: ' . $entry->description,
            ]);
        }
    }

    public function restored(OtherIncome $income)
    {
        // Recreate original cashbook entry when income is restored
        $this->created($income);
    }
}