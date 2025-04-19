<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminHomeController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function showUsers()
{
    $users = User::all(); // Or paginate if needed
    return view('admin.home', compact('users'));
}
}
