<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraFee;

class ExtraFeeController extends Controller
{
    public function listExtraFee(){

        $extraFees= ExtraFee::with('creator')->get();
        return view('extrafee.list', compact('extraFees'));
        
    }

    public function addExtraFee()
      {
            return view('extrafee.add');
     }


     
    public function insertExtraFee(Request $request){


        $schoolId=auth()->user()->school_id;
        $userId=auth()->id();

        $validated= $request->validate([

            'name' => 'required|string|max:255',
            'amount'=>'nullable|numeric',
            'is_quantity_based' => 'required|boolean',
            'description'=>'required|string',
            'status'=>'required|string|in:active,inactive'
            
        ]);

        

        $validated['school_id']=$schoolId;
        $validated['created_by']=$userId;

        ExtraFee::create($validated);

        return redirect()->route('extrafeelist')->with('Success','ExtraFee added Successfully');

    }

     public function updateExtraFee($id)
        {
           $extrafee=ExtraFee::findOrFail($id);

           return view('extrafee.edit', compact('extrafee'));

        }

    public function editExtraFee(Request $request,$id){

        $extrafee=ExtraFee::findOrFail($id);
        $schoolId=auth()->user()->school_id;

        $validated= $request->validate([
            'name' => 'required|string|max:255',
            'amount'=>'nullable|numeric',
            'is_quantity_based' => 'required|boolean',
            'description'=>'required|string',
            'status'=>'required|string|in:active,inactive'
            
        ]);

        $validated['school_id']=$schoolId;

        $extrafee->update($validated);


        return redirect()->route('extrafeelist')->with('success','ExtraFee updated Successfully');

        }

         public function deleteExtraFee($id)
      {
              $extraFee = ExtraFee::findOrFail($id); 
              $extraFee->delete();
      
              return redirect()->back()->with('success', 'Extra Fee deleted successfully.');
      }
}
