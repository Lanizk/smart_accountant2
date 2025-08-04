<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use App\Models\Term;
use App\Models\Student;
use App\Models\ClassFee;

use Illuminate\Http\Request;

class ClassFeeController extends Controller
{


   public function listClassFee()
{
    $classFees = ClassFee::all(); // Scoped automatically
    return view('classfee.list', compact('classFees'));
}

    public function addClassFee()
    {
        $data['classes']=Classes::all();
        $data['terms']=Term::all();
        return view('classfee.add', $data);
  
    }

     
        public function insertClassFee(Request $request){


        $schoolId=auth()->user()->school_id;

        $validated= $request->validate([

            
            'amount'=>'nullable|string|max:20',
            'description'=>'required|string',
            'class_id'=>'required|exists:classes,id',
            'term_id'=>'required|exists:terms,id',
            'status'=>'required|string|in:active,inactive'
            
        ]);

        // Get year from term
        $term=Term::findOrFail($validated['term_id']);
        $validated['year']=$term->year;

        $validated['school_id']=$schoolId;

        ClassFee::create($validated);

        return redirect()->route('classfeelist')->with('Success','ClassFee added Successfully');

    }

        public function editClassFee($id)
        {
           $classfee=ClassFee::findOrFail($id);
           $terms=Term::all();
           $classes=Classes::all();

           return view('classfee.edit', compact('classfee','terms','classes'));

        }

        public function updateClassFee(Request $request, $id)
        {
            $classfee=ClassFee::findOrFail($id);

             $schoolId=auth()->user()->school_id;

        $validated= $request->validate([

            
            'amount'=>'nullable|string|max:20',
            'description'=>'required|string',
            'class_id'=>'required|exists:classes,id',
            'term_id'=>'required|exists:terms,id',
            'status'=>'required|string|in:active,inactive'
            
        ]);

        // Get year from term
        $term=Term::findOrFail($validated['term_id']);
        $validated['year']=$term->year;

        $validated['school_id']=$schoolId;

        $classfee->update($validated);


        return redirect()->route('classfeelist')->with('success','ClassFee updated Successfully');

        }


        public function deleteClassFee($id)
      {
              $classFee = ClassFee::findOrFail($id); 
              $classFee->delete();
      
              return redirect()->back()->with('success', 'Class Fee deleted successfully.');
      }
  

     

}
