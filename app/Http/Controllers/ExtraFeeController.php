<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraFee;
use App\Models\Student;
use App\Models\Term;
use App\Models\ClassFee;
use App\Models\Classes;
use App\Models\StudentExtraFee;
use App\Services\InvoiceService;

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
        'extra_fee_id'          => 'required|exists:extra_fees,id',
        'students'              => 'required|array',
        'students.*.quantity'   => 'nullable|numeric|min:1',
    ]);

    $extraFee = ExtraFee::findOrFail($request->extra_fee_id);

    // collect student fee records for bulk insert/update
    $studentFees = [];
    $updatedStudentIds = [];

    foreach ($request->students as $studentId => $studentData) {
        if (empty($studentData['selected'])) {
            continue; // skip unchecked students
        }

        $quantity = !empty($studentData['quantity']) ? (int) $studentData['quantity'] : 1;
        $amount   = $extraFee->amount;
        $total    = $quantity * $amount;

        // Instead of firing observer per student, we collect
        $studentFees[] = [
            'student_id'     => $studentData['student_id'],
            'extra_fee_id'   => $extraFee->id,
            'quantity'       => $quantity,
            'amount'         => $total,
            'school_id'      => auth()->user()->school_id,
            'created_by'     => auth()->user()->id,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        $updatedStudentIds[] = $studentData['student_id'];
    }

    if (!empty($studentFees)) {
        // 🛑 prevent observer from running during batch
        app()->instance('batchAssigningExtraFees', true);

        // use upsert so existing records update instead of duplicate
        StudentExtraFee::upsert(
            $studentFees,
            ['extra_fee_id', 'student_id'], // unique keys
            ['quantity', 'amount', 'school_id', 'created_by', 'updated_at']
        );

        // ✅ Refresh to make sure term_id is available
        $extraFee->refresh();

        // 🔑 Fire invoice updates once per student
        $students = Student::whereIn('id', $updatedStudentIds)->get();
        foreach ($students as $student) {
            app(InvoiceService::class)->createOrUpdateInvoice($student, $extraFee->term_id);
        }

        // Reactivate observer
        app()->forgetInstance('batchAssigningExtraFees');
    }

    return redirect()
        ->route('listextrafeestudents')
        ->with('success', 'Extra Fee(s) assigned successfully.');
}


  public function showAssignExtraFeeForm(Request $request)
{
    $extraFees = ExtraFee::all();
    $classes = Classes::all();

    // Start with empty students (until an extra fee is chosen)
    $students = collect();

    // Load students only if an extra fee is selected
    if ($request->filled('extra_fee_id')) {
        $studentsQuery = Student::where('school_id', auth()->user()->school_id);

        // Apply filters only if they are given
        if ($request->filled('class_id')) {
            $studentsQuery->where('class_id', $request->class_id);
        }

        if ($request->filled('search')) {
            $studentsQuery->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('admission', 'like', '%' . $request->search . '%');
            });
        }

        $students = $studentsQuery->get();
    }

    // Get assigned fees only if extra fee is selected
    $assignedExtraFees = collect();
    if ($request->filled('extra_fee_id')) {
        $assignedExtraFees = StudentExtraFee::where('extra_fee_id', $request->extra_fee_id)
            ->where('school_id', auth()->user()->school_id)
            ->get()
            ->keyBy('student_id');
    }

    return view('extrafee.assignextrafee', compact(
        'extraFees', 'students', 'assignedExtraFees', 'classes'
    ))->with([
        'selectedExtraFee' => $request->extra_fee_id,
        'selectedClass'    => $request->class_id,
        'searchQuery'      => $request->search
    ]);
}




    public function listExtraFeeStudent(Request $request)
    {
        // $extraFeeStudents=StudentExtraFee::all();
        // return view('extrafee.extrafeestudent', compact('extraFeeStudents'));

        $query=StudentExtraFee::query();

        if($request->filled('extra_fee_id')){
            $query->where('extra_fee_id',$request->extra_fee_id);
        }

        if($request->filled('student_name')){
            $query->whereHas('student',function($q) use ($request){
                $q->where('name','like','%'.$request->student_name.'%');
            });
        }

        $extraFeeStudents=$query->with(['extraFee.term','student','creator'])->get();
        $extraFees=ExtraFee::all();

        return view('extrafee.extrafeestudent', compact('extraFeeStudents','extraFees'));

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
    dd($request);

    // Find the assigned extra fee record
    $assignedFee = StudentExtraFee::findOrFail($id);

    // Update fields
    $assignedFee->extra_fee_id = $request->extra_fee_id;
    $assignedFee->quantity = $request->quantity;
    $assignedFee->save();

    return redirect()->route('listextrafeestudents')
                     ->with('success', 'Assigned extra fee updated successfully.');
}



   public function deleteAssignedExtraFee($id)
{
    $assignedFee = StudentExtraFee::with('extraFee', 'student')->findOrFail($id);

    $student = $assignedFee->student;
    $termId  = $assignedFee->extraFee?->term_id;

    $assignedFee->delete();

    if ($student && $termId) {
        app(\App\Services\InvoiceService::class)->createOrUpdateInvoice($student, $termId);
    }

    return redirect()->back()->with('success', 'Extra Fee deleted successfully.');
}
    
    }
