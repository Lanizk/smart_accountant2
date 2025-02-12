<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classmodel;

class ClassController extends Controller
{
  
    public function listClass(){
        $data['getRecord'] = Classmodel::getRecord();
        return view('class.list',$data);
    }

    public function addClass(){
        return view('class.add');
    }

    public function insert(Request $request){

        $schoolId = auth()->user()->school_id; 

        $save=new Classmodel;
        $save->name=$request->name;
        $save->Term=$request->term;
        $save->Amount=$request->Amount;
        $save->school_id = $schoolId;
        $save->save();
        return redirect()->route('classlist')->with('success', "Class successfully Created");

    }
}

