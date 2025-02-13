<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\extrafee;
use App\Models\Classmodel;
use App\Models\Schools;
use Auth;
use Illuminate\Http\Request;


class extraFeeController extends Controller
{

    public function list(){
       
        return view('extrafee.list',);
    }

    public function add(){
        $data['classes'] = Classmodel::getClass();
        return view('extrafee.add',$data);
    }


    public function insert(Request $request){

    
    // $request->validate([
    //     'name' => 'required|string|max:255',
    //     'term' => 'required|string',
    //     'amount' => 'required|numeric|min:0',
    //     'for_entire_school' => 'required|boolean',
    //     'class_ids' => 'nullable|array', 
    //     'class_ids.*' => 'exists:classes,id'
    // ]);

    $extraFee=extrafee::create([
        'school_id'=>auth()->User()->school_id,
        'name'=>$request->name,
        'amount'=>$request->amount,
        'term'=>$request->term,
        'for_entire_school'=>$request->for_entire_school,
    ]);
    


    if(!$request->for_entire_school && !empty($request->classmodels_id))
    {
        $extraFee->classes()->attach($request->classmodels_id);
    }
}
}
