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
            $totalFeesBilled = Invoice::whereYear('created_at', $currentYear)
                ->sum('total_amount');
            $totalFeesCollected = InvoicePayment::whereYear('created_at', $currentYear)
                ->sum('amount');
            $outstandingBalances = $totalFeesBilled - $totalFeesCollected;

            // Other income
            $otherIncome = OtherIncome::whereYear('created_at', $currentYear)
                ->sum('amount');

            // Expenses
            $totalExpenses = Expense::whereYear('created_at', $currentYear)
                ->sum('amount');

            // Net
            $netPosition = ($totalFeesCollected + $otherIncome) - $totalExpenses;

            // Expenses by category
            $expensesByCategory = Expense::selectRaw('SUM(amount) as total, expense_category_id')
                ->whereYear('created_at', $currentYear)
                ->groupBy('expense_category_id')
                ->with('category')
                ->get();

            // Monthly net for line chart
            $monthlyNet = [];
            for ($m=1; $m<=12; $m++) {
                $fees = InvoicePayment::whereMonth('created_at', $m)
                    ->whereYear('created_at', $currentYear)
                    ->sum('amount');
                $expenses = Expense::whereMonth('created_at', $m)
                    ->whereYear('created_at', $currentYear)
                    ->sum('amount');
                $income = OtherIncome::whereMonth('created_at', $m)
                    ->whereYear('created_at', $currentYear)
                    ->sum('amount');
                $monthlyNet[] = ($fees + $income) - $expenses;
            }

            return view('dashboard', compact(
                'viewType',
                'currentYear',
                'totalFeesBilled',
                'totalFeesCollected',
                'outstandingBalances',
                'otherIncome',
                'totalExpenses',
                'netPosition',
                'expensesByCategory',
                'monthlyNet'
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

        // Expenses by category
        $expensesByCategory = Expense::selectRaw('SUM(amount) as total, expense_category_id')
            ->where('term_id', $termId)
            ->groupBy('expense_category_id')
            ->with('category')
            ->get();

        // Monthly net for line chart (current year)
        $monthlyNet = [];
        $year = now()->year;
        for ($m=1; $m<=12; $m++) {
            $fees = InvoicePayment::whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->sum('amount');
            $expenses = Expense::whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->sum('amount');
            $income = OtherIncome::whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->sum('amount');
            $monthlyNet[] = ($fees + $income) - $expenses;
        }

        return view('dashboard', compact(
            'viewType',
            'currentTerm',
            'totalFeesBilled',
            'totalFeesCollected',
            'outstandingBalances',
            'otherIncome',
            'totalExpenses',
            'netPosition',
            'expensesByCategory',
            'monthlyNet'
        ));
    }
}
