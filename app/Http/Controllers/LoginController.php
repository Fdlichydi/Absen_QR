<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function aksilogin(Request $request){
        $credential = $request->validate([
         'email'=> 'required',
         'password'=> 'required',
        ]);
 
        if(Auth::attempt($credential)){
         return redirect('/');
        }
 
     } 
     public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
 
         return redirect('/login');
     }
}
