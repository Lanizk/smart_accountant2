<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schools;

class RegisterController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function register(Request $request){
        // $request->validate([
        //     'school_name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:schools,email',
        //     'phone' => 'required|numeric',
        //     'address' => 'nullable|string',
        //     'admin_name' => 'required|string|max:255',
        //     'password' => 'required|string|confirmed|min:8',
        // ]);

        $school=New Schools;
        $school->school_name=$request->school_name;
        $school->email=$request->email;
        $school->phone=$request->phone;
        $school->address=$request->address;
        $school->subscription_status="inactive";
        $school->save();

        $user=New User();
        $user->admin_name=$request->admin_name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->role=$request->role ?? 'admin';
        $user->school_id = $school->id;
        
        $user->save();

        
    }
}
