<?php

namespace App\Http\Controllers\Customersupport;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        return view('admin.dashboard');
    }


    public function login(){
        return view('admin.auth.login');
    }
}
