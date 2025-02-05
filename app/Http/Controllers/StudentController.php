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
}
