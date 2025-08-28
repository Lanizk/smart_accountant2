<?php

namespace App\Observers;

use App\Models\ExtraFeeAssignment;

class ExtraFeeAssignmentObserver
{
    public function created(ExtraFeeAssignment $extraFee)
    {
        $student = $extraFee->student;
        app(InvoiceService::class)
            ->createOrUpdateInvoice($student, $extraFee->term_id);
    }

    public function deleted(ExtraFeeAssignment $extraFee)
    {
        $student = $extraFee->student;
        app(InvoiceService::class)
            ->createOrUpdateInvoice($student, $extraFee->term_id);
    }

    /**
     * Handle the ExtraFeeAssignment "deleted" event.
     */
    public function updated(ExtraFeeAssignment $extraFeeAssignment): void
    {
        //
    }

    /**
     * Handle the ExtraFeeAssignment "restored" event.
     */
    public function restored(ExtraFeeAssignment $extraFeeAssignment): void
    {
        //
    }

    /**
     * Handle the ExtraFeeAssignment "force deleted" event.
     */
    public function forceDeleted(ExtraFeeAssignment $extraFeeAssignment): void
    {
        //
    }
}
