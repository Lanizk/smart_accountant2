<?php

namespace App\Observers;
use App\Services\InvoiceService;
use App\Models\StudentExtraFee;

class ExtraFeeAssignmentObserver
{
    public function created(StudentExtraFee $extraFee): void
    {
        // Skip invoice update if we are inside a batch assignment
        if (app()->bound('extraFeeBatch') && app('extraFeeBatch') === true) {
            return;
        }

        // Refresh the relation so term_id is not null due to stale cache
        $extraFee->loadMissing('extraFee');

        $student = $extraFee->student;
        $termId  = $extraFee->extraFee?->term_id;

        if ($student && $termId) {
            app(InvoiceService::class)->createOrUpdateInvoice($student, $termId);
        }
    }

    public function deleted(StudentExtraFee $extraFee): void
    {
        // Always refresh relation (otherwise term_id is null)
        $extraFee->loadMissing('extraFee', 'student');

        $student = $extraFee->student;
        $termId  = $extraFee->extraFee?->term_id;
        \Log::info("Observer fired for StudentExtraFee deleted", [
        'student_id' => $student?->id,
        'term_id'    => $termId,
    ]);

        if ($student && $termId) {
            app(InvoiceService::class)->createOrUpdateInvoice($student, $termId);
        }
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
