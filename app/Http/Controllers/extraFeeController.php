<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class extraFeeController extends Controller
{

    public function list(){
        $data['getRecord'] = extrafee::getRecord();
        return view('extrafee.list',$data);
    }

    public function add(){
        return view('extrafee.add');
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

    if(!request->for_entire_school && !empty($request->classmodels_id))
    {
        $extraFee->clases()->attach($request->classmodels_id);
    }
}
}
