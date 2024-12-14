<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Xác thực thông tin đăng nhập
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->email_verified_at === null){
                return redirect()->route('showverify');
            }
            // Đăng nhập thành công
            return redirect()->intended('dashboard');  // Chuyển hướng đến trang dashboard hoặc trang mong muốn
        }

        // Đăng nhập thất bại
        return redirect()->back()->withErrors(['name' => 'Thông tin đăng nhập không đúng']);
    }
    public function logout()
    {
        Auth::logout();  // Đăng xuất người dùng
        return redirect()->route('login');  // Chuyển hướng đến trang đăng nhập
    }

}

