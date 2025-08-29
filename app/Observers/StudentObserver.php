<?php

namespace App\Observers;

use App\Models\Student;
use App\Services\InvoiceService;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
          if ($student->class_id && $student->term_id) {
            app(InvoiceService::class)->createOrUpdateInvoice($student, $student->term_id);
        }
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
         if ($student->isDirty('class_id')) {
            app(InvoiceService::class)->createOrUpdateInvoice($student, $student->term_id);
        }
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }
}
