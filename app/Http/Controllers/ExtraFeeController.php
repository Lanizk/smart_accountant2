<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraFee;
use App\Models\Student;
use App\Models\Term;
use App\Models\ClassFee;
use App\Models\StudentExtraFee;

class ExtraFeeController extends Controller
{
    public function listExtraFee(){

        $extraFees= ExtraFee::with('creator')->get();
        return view('extrafee.list', compact('extraFees'));
        
    }

     public function assignExtraFee(){
        return view('extrafee.assignextrafee');
        
    }

    public function addExtraFee()
      {     
            $data['terms']=Term::all();
            return view('extrafee.add',$data);
     }


     
    public function insertExtraFee(Request $request){
        $schoolId=auth()->user()->school_id;
        $userId=auth()->id();

        $validated= $request->validate([

            'name' => 'required|string|max:255',
            'amount'=>'nullable|numeric',
            'is_quantity_based' => 'required|boolean',
            'description'=>'required|string',
             'term_id'=>'required|exists:terms,id',
            'status'=>'required|string|in:active,inactive'
            
        ]);
        $term=Term::findOrFail($validated['term_id']);
        $validated['year']=$term->year;
        $validated['school_id']=$schoolId;
        $validated['created_by']=$userId;

        ExtraFee::create($validated);

        return redirect()->route('extrafeelist')->with('success','ExtraFee added Successfully');

    }

     public function updateExtraFee($id)
        {
            
           $extrafee=ExtraFee::findOrFail($id);
           
           $terms=Term::all();
        //    $classfee=ClassFee::find($id);
           return view('extrafee.edit', compact('extrafee','terms'));

        }

    public function editExtraFee(Request $request,$id){

        $extrafee=ExtraFee::findOrFail($id);
        $schoolId=auth()->user()->school_id;

        $validated= $request->validate([
            'name' => 'required|string|max:255',
            'amount'=>'nullable|numeric',
            'is_quantity_based' => 'required|boolean',
            'description'=>'required|string',
            'status'=>'required|string|in:active,inactive'
            
        ]);

        $validated['school_id']=$schoolId;

        $extrafee->update($validated);


        return redirect()->route('extrafeelist')->with('success','ExtraFee updated Successfully');

        }

         public function deleteExtraFee($id)
      {
              $extraFee = ExtraFee::findOrFail($id); 
              $extraFee->delete();
              return redirect()->back()->with('success', 'Extra Fee deleted successfully.');
    }




//These methods are used to assign the extra fee to particular students

    public function assignStudentExtraFee(Request $request)
         
    { 
        $request->validate([       
        'extra_fee_id' => 'required|exists:extra_fees,id',
        'students' => 'required|array',
        'students.*.quantity' => 'nullable|numeric|min:1'
        ]);
    
       
    
        $extraFee = ExtraFee::findOrFail($request->extra_fee_id);
    
        foreach ($request->students  as $studentId => $studentData) {
            if (empty($studentData['selected'])) {
            continue; 
        }
        $quantity = !empty($studentData['quantity']) ? (int) $studentData['quantity'] : 1;
        $amount = $extraFee->amount;
        $total = $quantity * $amount;

        

        StudentExtraFee::updateOrCreate(
            [
                'extra_fee_id' => $extraFee->id,
                'student_id' => $studentData['student_id'],
            ],
            [
                'quantity' => $quantity,
                'amount' => $total,
                'school_id' => auth()->user()->school_id, // if scoped by school
                'created_by'=> auth()->user()->id,
             ]

              
         );
        }
         return redirect()->route('listextrafeestudents')->with('success','ExtraFee added Successfully');
    
        // return redirect()->route('getextrafee')->with('success', 'Extra fee assigned successfully.');
    
}

// Method get the extra fees from the Extra fee Table to display in the dropdown in the assign extra fee page
    public function getExtraFee(){
    $extraFees = ExtraFee::all(); 
    $students = Student::all(); 

    return view('extrafee.assignextrafee', compact('extraFees', 'students'));
    }


    public function listExtraFeeStudent()
    {
        
        $extraFeeStudents=StudentExtraFee::all();
        
        return view('extrafee.extrafeestudent', compact('extraFeeStudents'));

    }


     public function editAssignedExtraFee($id)
    {
        $assignedFee = StudentExtraFee::findOrFail($id);
        $students = Student::with('class')->get();
        $assignedStudents = StudentExtraFee::where('extra_fee_id',  $assignedFee->extra_fee_id)->get();
        $extraFees = ExtraFee::with('term')->get();

        return view('extrafee.editextrafeestudent', compact(
            'assignedFee',
            'extraFees',
            'students',
            'assignedStudents'
        ));
         
    }


    public function updateAssignedExtraFee(Request $request, $id)
{
    $request->validate([
        'extra_fee_id' => 'required|exists:extra_fees,id',
        'quantity' => 'required|numeric|min:1'
    ]);

    // Find the assigned extra fee record
    $assignedFee = StudentExtraFee::findOrFail($id);

    // Update fields
    $assignedFee->extra_fee_id = $request->extra_fee_id;
    $assignedFee->quantity = $request->quantity;
    $assignedFee->save();

    return redirect()->route('listextrafeestudents')
                     ->with('success', 'Assigned extra fee updated successfully.');
}



    public function deleteAssignedExtraFee($id){
              $assignedFee = StudentExtraFee::findOrFail($id); 
              $assignedFee->delete();
              return redirect()->back()->with('success', 'Extra Fee deleted successfully.');
   
    }
    
    }
