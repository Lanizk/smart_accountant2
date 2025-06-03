<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
  
    public function listClass(){
        $data['getRecord'] = Classes::getRecord();
        return view('class.list',$data);
    }

    public function addClass(){
        return view('class.add');
    }

    public function insert(Request $request){

        $schoolId = auth()->user()->school_id; 

        $save=new Classes;
        $save->name=$request->name;
        $save->school_id = $schoolId;
        $save->save();
        return redirect()->route('classlist')->with('success', "Class successfully Created");

    }
}

