<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function render(){
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            // $user = Auth::user(); // Truy cập thông tin người dùng
            // return view('dashboard', compact('user'));
            return view('dashboard');
        } else {
            // Người dùng chưa đăng nhập
            return redirect()->route('login');
        }        
    }
    public function suspended(){
        return view('auth.suspended');
    }
}
