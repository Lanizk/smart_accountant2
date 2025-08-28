<?php

namespace App\Observers;

use App\Models\ClassFee;

class ClassFeeObserver
{
    public function created(ClassFee $classFee)
    {
        foreach ($classFee->class->students as $student) {
            app(InvoiceService::class)
                ->createOrUpdateInvoice($student, $classFee->term_id);
        }
    }

    public function updated(ClassFee $classFee)
    {
        foreach ($classFee->class->students as $student) {
            app(InvoiceService::class)
                ->createOrUpdateInvoice($student, $classFee->term_id);
        }
    }

    /**
     * Handle the ClassFee "deleted" event.
     */
    public function deleted(ClassFee $classFee): void
    {
        //
    }

    /**
     * Handle the ClassFee "restored" event.
     */
    public function restored(ClassFee $classFee): void
    {
        //
    }

    /**
     * Handle the ClassFee "force deleted" event.
     */
    public function forceDeleted(ClassFee $classFee): void
    {
        //
    }
}
