<?php

namespace App\Listeners;

use App\Events\InvoiceUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvoiceNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvoiceUpdated $event): void
    {
         $invoice = $event->invoice;
        $student = $invoice->student;

        // Example: Send SMS or email
        // SMSService::send($student->phone, "Your invoice #{$invoice->id} updated. Balance: {$invoice->balance}");
        // Mail::to($student->parent_email)->send(new InvoiceMail($invoice));
    }
}
