<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ClassFee;
use App\Models\ExtraFeeAssignment;

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

        // Clear old invoice items before recalculating
        $invoice->items()->delete();

        $total = 0;

        // 1. Add Class Fee
        $classFee = ClassFee::where('class_id', $student->class_id)
            ->where('term_id', $termId)
            ->first();

        if ($classFee) {
            $invoice->items()->create([
                'description' => "Class Fee: {$student->class->name}",
                'amount' => $classFee->amount,
            ]);
            $total += $classFee->amount;
        }

        // 2. Add Extra Fees (per student)
        $extraFees = ExtraFeeAssignment::where('student_id', $student->id)->get();

        foreach ($extraFees as $extra) {
            $amount = $extra->is_quantity_based
                ? $extra->quantity * $extra->amount
                : $extra->amount;

            $invoice->items()->create([
                'description' => "Extra Fee: {$extra->extraFee->name}",
                'amount' => $amount,
            ]);
            $total += $amount;
        }

        // 3. Add Previous Balance
        if ($student->prev_balance > 0) {
            $invoice->items()->create([
                'description' => "Previous Balance",
                'amount' => $student->prev_balance,
            ]);
            $total += $student->prev_balance;
        }

        // Update totals
        $invoice->update([
            'total_amount' => $total,
            'balance' => $total - $invoice->amount_paid,
            'status' => $this->calculateStatus($invoice),
        ]);

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
