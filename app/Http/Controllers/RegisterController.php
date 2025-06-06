<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schools;
use Auth;

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
        return redirect()->route('dashboard')->with('success', 'School registered successfully!');
        
    }


    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'email|required',
            'password'=>'required|min:6'
        ],[
            'email.required'=>'email is required',
            'password.min'=>'Password should have a minimum of 6 characters'
        ]);

        $remember=$request->has('remember');

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password],$remember)){
       return redirect()->route('dashboard')->with('success','welcome back');
      
        }
    }
}
