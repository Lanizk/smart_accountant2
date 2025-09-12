<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
         
        $expenses = Expense::where('school_id', $schoolId)->with('category')->latest()->paginate(20);
         $categories = ExpenseCategory::all();
        return view('expensesdefined.index', compact('expenses','categories'));
    }

     public function create()
{
    $categories = ExpenseCategory::all();
    $expense = null; // 👈 very important
    return view('expensesdefined.create', compact('categories', 'expense'));
}

public function edit(Expense $expense)
{
    $categories = ExpenseCategory::all();
    return view('expensesdefined.create', compact('categories', 'expense'));
}
    public function store(Request $request)
    {
        $data = $request->validate([
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string',
            'expense_date' => 'nullable|date',
        ]);

        $data['school_id'] = auth()->user()->school_id;
        $data['created_by'] = auth()->id();

        // ExpenseObserver will create the original cashbook entry
        $expense = Expense::create($data);

        return redirect()->back()->with('success', 'Expense recorded.');
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $data = $request->validate([
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string',
            'expense_date' => 'nullable|date',
        ]);

        $expense->update($data); // observer updates the original cashbook entry
        return redirect()->back()->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete(); // soft delete -> observer creates reversal
        return redirect()->back()->with('success', 'Expense deleted (reversed in cashbook).');
    }

    public function restore($id)
    {
        $expense = Expense::withTrashed()->findOrFail($id);
        $this->authorize('restore', $expense);
        $expense->restore(); // observer creates "restored" cashbook entry
        return redirect()->back()->with('success', 'Expense restored.');
    }
}
