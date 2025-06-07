<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use Auth;

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


    public function edit($id,Request $request){
         $schoolId = auth()->user()->school_id; 

         $save=classes::getSingle($id);
         $save->name=$request->name;
         $save->save();
         return redirect()->route('classlist')->with('success', 'Class updated Successfully');

    }

    public function update($id , Request $request)
    {
        $data['getRecord']=classes::getSingle($id);
        if(!empty($data['getRecord'])){
            return view('class.edit',$data);
        }
    }

    public function delete($id){
        $classes=classes::findOrFail($id);
        $classes->delete();

        return redirect()->back()->with('success','Deleted Successfully');
    }
}

