<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show register//create form
    public function register(){
        return view('Users.register');
    }

    //Store

    public function store(Request $request){
        $formFields=$request->validate([
           'name'=>['required', 'min:3'], 
           'email'=>['required', 'email' , Rule::unique('users','email')],
           'password'=>'required|confirmed|min:6'
        ]);

        //hash password
        $formFields['password']=bcrypt($formFields['password']);

        //Create users
    $user = User::create($formFields);
    
    //Login

    auth()->login($user);

    return redirect('/')->with('message', 'User created and logged in');

    }

    //Logout USer

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    //Show login Form

    public function login(){
        return view('Users.login');
    }

    //Authenticate user
    public function authenticate(Request $request){
        $formFields=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
    }

     return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }
       
    
}
