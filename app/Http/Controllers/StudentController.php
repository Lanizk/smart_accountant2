<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function listStudents(){
        return view('student.list');
    }

    public function addStudents(){
        return view('student.add');
    }

    public function insert(Request $request){
        $student=New student;
        $student->name=$request->school_name;
        $school->email=$request->email;
        $school->phone=$request->phone;
        $school->admission_no=$request->address;
        $school->gender="inactive";
        $school->class_id=$request->address;
        $school->save();



    }
}
