<?php

namespace App\Observers;
use App\Services\InvoiceService;
use App\Models\StudentExtraFee;

class ExtraFeeAssignmentObserver
{
    public function created(StudentExtraFee $extraFee)
    {
        $student = $extraFee->student;
        app(InvoiceService::class)
            ->createOrUpdateInvoice($student, $extraFee->term_id);
    }

    public function deleted(StudentExtraFee $extraFee)
    {
        $student = $extraFee->student;
        app(InvoiceService::class)
            ->createOrUpdateInvoice($student, $extraFee->term_id);
    }

    /**
     * Handle the ExtraFeeAssignment "deleted" event.
     */
    public function updated(StudentExtraFee $extraFee): void
    {
        $student = $extraFee->student;
        app(InvoiceService::class)->createOrUpdateInvoice($student, $extraFee->term_id);
    }

    /**
     * Handle the ExtraFeeAssignment "restored" event.
     */
    public function restored(StudentExtraFee $extraFee): void
    {
        //
    }

    /**
     * Handle the ExtraFeeAssignment "force deleted" event.
     */
    public function forceDeleted(StudentExtraFee $extraFee): void
    {
        //
    }
}
