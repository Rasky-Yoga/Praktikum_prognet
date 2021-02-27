<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{

    public function __construct(){
        $this->middleware('guest:admin', ['except'=>['logout']]);
    }

    public function showLoginform(){
        return view('auth.admin-login');
    }

    public function login(Request $request){
        //validasi data di form
        $this->validate($request,[
            'username'=>'required|string',
            'password'=>'required|min:5'
        ]);
        //percobaan login
        if(Auth::guard('admin')->attempt(['username'=> $request->username, 'password'=> $request->password],$request->remember)){
            //redirect jika sukses login
            return redirect()->intended(route('admin.dashboard'));
        }else {
             //redirect jika gagal login
            return redirect()->back()->with('alert', 'Invalid Username or Password');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }    
    
}
