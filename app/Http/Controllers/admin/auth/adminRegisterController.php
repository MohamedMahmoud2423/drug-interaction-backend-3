<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class adminRegisterController extends Controller
{
    public function Register(){
        return view('admin.auth.register');
    }

    ///this function will store the admin in the db
    public function store(Request $request){
        $adminKey = "adminKey1";

        if($request->admin_key == $adminKey){
            $request->validate([
                'name' => 'required|string|max:255', //'name' lazem ykoon bymatch el name attribute elly fe form
                'email' => 'required|string|max:255',
                'admin_key' => 'required|string',
                'password' => 'required|string|max:255|min:8|confirmed',
                'password_confirmation' => 'required|max:255|min:8',
            ] );

            ///dd($request->all());

            $data = $request->except(['password_confirmation' , '_token' ,'customer_key']);
            $data['password']= Hash::make($request->password);
            ///dd($data);
            Admin::create($data);
            return redirect()->route('admin.dashboard.login');
        }
        else{
            return redirect()->back()->with('errorResponse' , 'something went wrong');
        }

    }
}
