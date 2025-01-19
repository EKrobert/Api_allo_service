<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //VUE DE LOGIN
    public function loginVue()
    {
        return view('login');
    }

    //FONCTION DE LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:5|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'The credentials are incorrect. Try Again.');
        }

        $check = $request->only('username', 'password');
        if (Auth::guard('admin')->attempt($check)) {
            $user = Auth::guard('admin')->user();
            if ($user) {
                return redirect('/');
            }
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Votre compte a été désactivé'); 
        }
        return back()->with('fail', 'Wrong username or password')->withInput();
    }

    // FONCTION DE DECONNEXION    
    public function deconnexion() //logout
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
}
