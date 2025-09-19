<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Models\Term;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\OtherIncome;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function showDashboard(Request $request)
{
    $schoolId = auth()->user()->school_id;

    // default to term view
    $viewType = $request->get('view', 'term'); // 'term' or 'annual'

    if ($viewType === 'annual') {
        // ----------------------
        // ANNUAL SUMMARY
        // ----------------------
        $currentYear = Term::currentYear();

// Fees
$totalFeesBilledYear = Invoice::where('year', $currentYear)->sum('total_amount');
$totalFeesCollectedYear = InvoicePayment::where('year', $currentYear)->sum('amount');
$outstandingBalancesYear = $totalFeesBilledYear - $totalFeesCollectedYear;

// Other income
$otherIncomeYear = OtherIncome::where('year', $currentYear)->sum('amount');

// Expenses
$totalExpensesYear = Expense::where('year', $currentYear)->sum('amount');

// Net
$netPositionYear = ($totalFeesCollectedYear + $otherIncomeYear) - $totalExpensesYear;

        return view('dashboard', compact(
            'viewType',
            'currentYear',
            'totalFeesBilled',
            'totalFeesCollected',
            'outstandingBalances',
            'otherIncome',
            'totalExpenses',
            'netPosition'
        ));
    }

    // ----------------------
    // TERM-BASED SUMMARY
    // ----------------------
 $termId = Term::currentId();
    $currentTerm = Term::current();

// Fees
$totalFeesBilled = Invoice::where('term_id', $termId)->sum('total_amount');
$totalFeesCollected = InvoicePayment::whereHas('invoice', function($q) use ($termId) {
    $q->where('term_id', $termId);
})->sum('amount');
$outstandingBalances = $totalFeesBilled - $totalFeesCollected;

// Other income
$otherIncome = OtherIncome::where('term_id', $termId)->sum('amount');

// Expenses
$totalExpenses = Expense::where('term_id', $termId)->sum('amount');

// Net position
$netPosition = ($totalFeesCollected + $otherIncome) - $totalExpenses;

    return view('dashboard', compact(
        'viewType',
        'currentTerm',
        'totalFeesBilled',
        'totalFeesCollected',
        'outstandingBalances',
        'otherIncome',
        'totalExpenses',
        'netPosition'
    ));
}
}