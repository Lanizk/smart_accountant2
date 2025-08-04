<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use App\Models\Term;
use App\Models\Student;
use Auth;

use Illuminate\Http\Request;

class studentController extends Controller
{
    public function listStudents(Request $request)
    {
        $data['getRecord']=Student::getRecord($request);
        $data['classes'] = Classes::all();
        $data['terms'] = Term::all(); 
        return view('student.list',$data);
    }

     public function addStudents(){
        $data['classes']=Classes::all();
        $data['terms']=Term::all();
        return view('student.add', $data);
    }

    public function insertStudents(Request $request){


        $schoolId=auth()->user()->school_id;

        $validated= $request->validate([

            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:20',
            'admission'=>'required|string|unique:students,admission',
            'gender'=>'required|in:male,female',
            
            'class_id'=>'required|exists:classes,id',
            'term_id'=>'required|exists:terms,id'
            
        ]);

        $validated['school_id']=$schoolId;

        Student::create($validated);

        return redirect()->route('listStudents')->with('Success','Student added Successfully');

    }


    public function editStudents($id){
           $student=Student::getSingleStudent($id);
           $terms=Term::all();
           $classes=Classes::all();

           return view('student.edit', compact('student','terms','classes'));

    }


    public function updateStudents(Request $request,$id){

    
        $student=Student::getSingleStudent($id);

        $validated= $request->validate([

            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:20',
            'admission'=>'required|string|unique:students,admission,'. $id,
            'gender'=>'required|in:male,female',
            
            'class_id'=>'required|exists:classes,id',
            'term_id'=>'required|exists:terms,id'
        ]);

        $validated['school_id']=auth()->user()->school_id;
        $student->update($validated);

         return redirect()->route('listStudents')->with('success', 'Student updated successfully.');
      

    }

    public function deleteStudent($id){
        $students=Student::findOrFail($id);
        $students->delete();

        return redirect()->back()->with('success','Deleted Successfully');
    }
}
