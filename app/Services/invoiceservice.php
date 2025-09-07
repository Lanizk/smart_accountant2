<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ClassFee;
use App\Models\StudentExtraFee;
use App\Models\InvoicePayment;

class InvoiceService
{
    /**
     * Ensure a student has an invoice for the given term.
     */
    public function createOrUpdateInvoice($student, $termId)
{
    $invoice = Invoice::firstOrCreate(
        ['student_id' => $student->id, 'term_id' => $termId],
        ['invoice_date' => now()]
    );

    // Clear old invoice items
    $invoice->items()->delete();

    $total = 0;

    // 1. Add Class Fee (only for this term)
    $classFee = ClassFee::where('class_id', $student->class_id)
        ->where('term_id', $termId)
        ->first();

    if ($classFee) {
        $invoice->items()->create([
            'term_id'     => $termId,
            'description' => "Class Fee: {$student->class->name}",
            'amount'      => $classFee->amount,
        ]);
        $total += $classFee->amount;
    }

    // 2. Add Extra Fees (scoped to this term)
    $extraFees = StudentExtraFee::where('student_id', $student->id)
        ->whereHas('extraFee', fn($q) => $q->where('term_id', $termId))
        ->get();

    foreach ($extraFees as $extra) {
        $amount = $extra->amount;

        $invoice->items()->create([
            'term_id'     => $termId,
            'description' => "Extra Fee: {$extra->extraFee->name}",
            'amount'      => $amount,
        ]);
        $total += $amount;
    }

    // 3. Add Previous Balance (carry over)
    if ($student->prev_balance > 0) {
        $invoice->items()->create([
            'term_id'     => $termId,
            'description' => "Previous Balance",
            'amount'      => $student->prev_balance,
        ]);
        $total += $student->prev_balance;
    }

    // Update totals
    $invoice->update([
        'total_amount' => $total,
        'balance'      => $total - $invoice->amount_paid,
        'status'       => $this->calculateStatus($invoice),
    ]);

    return $invoice->fresh(); // force reload to avoid stale cache
}

      public function paymentMade(Invoice $invoice, $amount,$method)
    {

       InvoicePayment::create([
        'invoice_id' => $invoice->id,
        'amount' => $amount,
        'method' => $method,
        'payment_date' => now(),
           ]);
        // Increment the paid amount
        $invoice->increment('amount_paid', $amount);

        // Update balance & status
        $invoice->update([
            'balance' => $invoice->total_amount - $invoice->amount_paid,
            'status' => $this->calculateStatus($invoice),
        ]);
        // event(new InvoiceUpdated($invoice));
        return $invoice;
    }

    /**
     * Recalculate invoice status.
     */
    private function calculateStatus($invoice)
    {
        if ($invoice->amount_paid >= $invoice->total_amount) {
            return 'paid';
        } elseif ($invoice->amount_paid > 0) {
            return 'partially_paid';
        }
        return 'unpaid';
    }
}
