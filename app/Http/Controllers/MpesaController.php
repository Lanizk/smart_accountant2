<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\InvoiceService;

class MpesaController extends Controller
{
    /**
     * M-Pesa Validation URL
     */
    public function validatePayment(Request $request)
    {
        Log::info('M-Pesa Validation Request:', $request->all());

        $adm = $request->input('BillRefNumber'); // admission number

        $student = Student::where('admission', $adm)->first();

        if (! $student) {
            return response()->json([
                "ResultCode" => 1,
                "ResultDesc" => "Invalid Admission Number"
            ]);
        }

        return response()->json([
            "ResultCode" => 0,
            "ResultDesc" => "Accepted"
        ]);
    }

    /**
     * M-Pesa Confirmation URL
     */
    public function confirmPayment(Request $request, InvoiceService $invoiceService)
    {
        Log::info('M-Pesa Confirmation Request:', $request->all());

        $adm         = $request->input('BillRefNumber');
        $amount      = $request->input('TransAmount');
        $mpesaTransId = $request->input('TransID');
        $phone       = $request->input('MSISDN');

        $student = Student::where('admission', $adm)->first();

        if (! $student) {
            // record rejected transaction
            Transaction::create([
                'amount'      => $amount,
                'reference'   => $mpesaTransId,
                'phone'       => $phone,
                'status'      => 'rejected',
                'raw_payload' => json_encode($request->all()),
            ]);

            return response()->json([
                "ResultCode" => 1,
                "ResultDesc" => "Admission number not found"
            ]);
        }

        // ✅ get current active term
    $currentTerm = Term::current1($student->school_id);

    if (! $currentTerm) {
        return response()->json([
            "ResultCode" => 1,
            "ResultDesc" => "No active term found for the school"
        ]);
    } // You need to implement Term::current()

        $invoice = Invoice::where('student_id', $student->id)
            ->where('term_id', $currentTerm->id)
            ->first();

           

        if (! $invoice) {
            return response()->json([
                "ResultCode" => 1,
                "ResultDesc" => "No invoice found for student in current term"
            ]);
        }

        // ✅ Apply payment using the same service as manual entry
        $invoiceService->paymentMade($invoice, $amount, 'mpesa');

        // record raw M-Pesa transaction for audit trail
        Transaction::create([
            'student_id'  => $student->id,
            'invoice_id'  => $invoice->id,
            'amount'      => $amount,
            'reference'   => $mpesaTransId,
            'phone'       => $phone,
            'status'      => $invoice->balance < 0 ? 'overpaid' : 'applied',
            'raw_payload' => json_encode($request->all()),
        ]);

        // ✅ Handle possible overpayment (future rollover logic)
        if ($invoice->balance < 0) {
            // TODO: implement rollover to next term or store in a "credits" table
        }

        return response()->json([
            "ResultCode" => 0,
            "ResultDesc" => "Payment processed successfully"
        ]);
    }
}
