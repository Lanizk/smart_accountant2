<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
  
    public function listClass(){
        return view('class.list');
    }

    public function addClass(){
        return view('class.add');
    }

    public function insert(Request $request){
        

    }
}

