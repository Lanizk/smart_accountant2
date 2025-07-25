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
}
