<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classmodel;
use App\Models\Student;
use Illuminate\Validation\Rule;
class StudentController extends Controller
{
    public function listStudents(){
        $data['getRecord'] = student::getRecord();
        return view('student.list',$data);
    }

    public function addStudents(){
        $data['classes'] = Classmodel::getClass();
        return view('student.add',$data);
    }

    public function insertStudents(Request $request){

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/' // Only letters and spaces
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]{10}$/', // Exactly 10 digits
                'unique:students,phone'
            ],
            'admission_no' => [
                'required',
                'string',
                'max:20',
                'unique:students,admission_no',
                'regex:/^[A-Z0-9]+$/' // Uppercase letters and numbers only
            ],
            'gender' => [
                'required',
                Rule::in(['male', 'female'])
            ],
            'class_id' => [
                'required',
                'numeric',
                'exists:classmodels,id'
            ],
            
        ], [
            // Custom error messages
            'name.regex' => 'Name should only contain letters and spaces',
            'phone.regex' => 'Phone number must be exactly 10 digits',
            'admission_no.regex' => 'Admission number should only contain uppercase letters and numbers',
           
        ]);

        $student=New student;
        $student->name=$request->name;
        $student->phone=$request->phone;
        $student->admission_no=$request->admission_no;
        $student->gender=$request->gender;
        $student->class_id=$request->class_id;
        $student->save();

        return redirect()->back()->with('success', 'Student added successfully.');



    }
}
