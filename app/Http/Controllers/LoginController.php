<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index() {

        return view('login');
    }

    public function register() {

        return view('register');
    }


    public function save(Request $request)
    {
        
        $input = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->cpassword
        ];
        
        $rules = [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $messages = [
            
            'confirmed_password.required' => 'Please confirm the password',
            'password.min' => 'Password must be at least 6 characters long',
            'required' => ' :attribute is required',
            'confirmed' => 'passwords not matching',
            'unique' => ':attribute already exists'
        ];
        $validator = Validator::make($input, $rules, $messages);
        
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
            ]);
        return redirect('/login')->with('error', 'User Successfully Created');
   
    }
    

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect('/home');
        }
        return back()->with('error', 'email or password incorrect');
    }
    
    
    public function logout(Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
    }
}
