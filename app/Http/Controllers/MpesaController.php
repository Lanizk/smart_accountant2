<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\InvoiceService;
use App\Models\PaymentChannel;

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

    $adm          = $request->input('BillRefNumber'); 
    $amount       = $request->input('TransAmount');
    $mpesaTransId = $request->input('TransID');
    $phone        = $request->input('MSISDN');
    $shortcode    = $request->input('BusinessShortCode'); // Paybill/Till number

    // ✅ Check duplicate
    if (Transaction::where('reference', $mpesaTransId)->exists()) {
        return response()->json([
            "ResultCode" => 0,
            "ResultDesc" => "Duplicate transaction"
        ]);
    }

    // ✅ Find school by Paybill/Till
    $channel = PaymentChannel::where('identifier', $shortcode)->first();

    if (! $channel) {
        return response()->json([
            "ResultCode" => 1,
            "ResultDesc" => "No school found for this paybill/till"
        ]);
    }

    // ✅ Find student in that school
    $student = Student::where('admission', $adm)
        ->where('school_id', $channel->school_id)
        ->first();

    if (! $student) {
        Transaction::create([
            'school_id'   => $channel->school_id,
            'amount'      => $amount,
            'reference'   => $mpesaTransId,
            'phone'       => $phone,
            'status'      => 'rejected',
            'raw_payload' => json_encode($request->all()),
        ]);

        return response()->json([
            "ResultCode" => 1,
            "ResultDesc" => "Admission number not found in this school"
        ]);
    }

    // ✅ Active term for school
    $currentTerm = Term::current1($channel->school_id);

    if (! $currentTerm) {
        return response()->json([
            "ResultCode" => 1,
            "ResultDesc" => "No active term found for the school"
        ]);
    }

    // ✅ Find invoice for student + term
    $invoice = Invoice::where('student_id', $student->id)
        ->where('term_id', $currentTerm->id)
        ->first();

    if (! $invoice) {
        return response()->json([
            "ResultCode" => 1,
            "ResultDesc" => "No invoice found for student in current term"
        ]);
    }

    // ✅ Apply payment
    $invoiceService->paymentMade($invoice, $amount, 'mpesa');

    Transaction::create([
        'school_id'   => $channel->school_id,
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
