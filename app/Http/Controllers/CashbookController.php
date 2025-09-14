<?php
namespace App\Http\Controllers;

use App\Models\CashbookEntry;
use Illuminate\Http\Request;

class CashbookController extends Controller
{
    public function index()
    {
        $entries = CashbookEntry::where('school_id', auth()->user()->school_id)
            ->latest('transaction_date')
            ->paginate(20);

        // Calculate running balance (optional)
        $balance = CashbookEntry::where('school_id', auth()->user()->school_id)
            ->selectRaw("
                SUM(CASE WHEN transaction_type = 'inflow' THEN amount ELSE -amount END) as balance
            ")
            ->value('balance');

        return view('cashbook.index', compact('entries', 'balance'));
    }
}
