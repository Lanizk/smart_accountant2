<?php

namespace App\Http\Controllers;
use App\Models\Term;
use Auth;

use Illuminate\Http\Request;

class TermController extends Controller
{
    
    public function listTerm(){

        $data['getRecord']=Term::getRecord();
        return view('term.list',$data);
    } 

    public function addTerm(){
          
        return view('term.add');
    }

    public function insertTerm( Request $request){
      
        $schoolId=auth()->user()->school_id;

        $save=new Term;
        $save->school_id=$schoolId;
        $save->name=$request->name;
        $save->start_date=$request->start_date;
        $save->end_date=$request->end_date;
        $save->year=$request->year;
        $save->save();

        return redirect()->route('termlist')->with('success','Term Created Succesfully');

    }


    public function editTerm($id,Request $request){

        $schoolId=auth()->user()->school_id;

        $save=Term::getSingle($id);
        $save->name=$request->name;
        $save->year=$request->year;
        $save->save();

         return redirect()->route('termlist')->with('success','Term Updated Succesfully');


    }


    public function updateTerm($id,Request $request){
           $schoolId=auth()->user()->school_id;

           $data['getRecord']=Term::getSingle($id);
           if(!empty($data['getRecord'])){

            return view('term.edit',$data);
           }

    }

     public function delete($id){
        $classes=Term::findOrFail($id);
        $classes->delete();

        return redirect()->back()->with('success','Deleted Successfully');
    }

}
