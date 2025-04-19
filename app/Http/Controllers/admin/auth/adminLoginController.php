<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminLoginController extends Controller
{
    public function login (){
        return view('admin.auth.login');
    }

    public function checkLogin(Request $request){
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if(Auth::guard('admin')->attempt((['email' => $request->email , 'password' => $request->password]))){
            return redirect()->route('admin.dashboard.home');
        }
        else{
            return redirect()->back()
            ->withInput(['email'=>$request->email])
            ->with('errorResponse' , 'these credentials do not match our records');

        }
    }


    public function logout(){
        Auth::guard('admin')->logout();

        return redirect()->route('user.profile');
    }

}
