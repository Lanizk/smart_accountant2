<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Auth;

use Illuminate\Http\Request;

class studentController extends Controller
{
    public function listStudents()
    {
        $data['getRecord']=Student::getRecord();
        return view('student.list',$data);
    }

     public function addStudents(){
        $data['getClass']=Student::getClass();
        $data['getTerm']=Student::getTerm();
        return view('student.add');
    }

    public function insertStudents(Request $request){


        $schoolId=auth()->user()->school_id;

        $validated= $request->validate([

            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:20',
            'admission'=>'required|string|unique:students,admission',
            'gender'=>'required|in:male,female',
            'dob'=>'nullable|date',
            'class_id'=>'required|exists:classes,id',
            'term_id'=>'required|exists:terms,id'
        ]);

        $validated['school_id']=$schoolId;

        Student::create($validated);

        return redirect()->back()->with('Success','Student added Successfully');

    }
}
