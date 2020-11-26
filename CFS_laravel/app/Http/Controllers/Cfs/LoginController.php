<?php

namespace App\Http\Controllers\Cfs;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    
    public function index()
    {
        return view('companyprofile.login'); 
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $user = User::where('email',$request->email)->first();


        if($user->user_password == md5($request->password)){
            Auth::login($user);
            return \redirect()->route('company');
        }
        else{

        }
    }
    public function logout()
    {
        Auth::logout();
    }
}
