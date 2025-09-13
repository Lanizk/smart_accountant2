<?php
namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $categories = IncomeCategory::where('school_id', auth()->user()->school_id)->get();
        return view('income.incomecategories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255|unique:income_categories,name',
            'description' => 'nullable|string',
        ]);

          IncomeCategory::create([
        'name' => $request->name,
        'description' => $request->description,
        'school_id' => auth()->user()->school_id, // 🔑 Attach school
    ]);

        return redirect()->route('income_categories.index')
                         ->with('success', 'Income category added successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = IncomeCategory::where('school_id', auth()->user()->school_id) // 🔒 Security
                               ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:income_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'school_id' => auth()->user()->school_id, // make sure it stays aligned
    ]);

        return redirect()->route('income_categories.index')
                         ->with('success', 'Income category updated successfully.');
    }

    public function destroy($id)
    {
        $category = IncomeCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('income_categories.index')
                         ->with('success', 'Income category deleted successfully.');
    }
}
