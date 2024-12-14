<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class RegisterController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6', //confirmed
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $coderand = rand(10000,99999);
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $coderand, 
        ]);

        // Đăng nhập và chuyển hướng đến trang chính
        //auth()->loginUsingId(User::latest()->first()->id);
        //Auth::login($user);
        // Gửi email xác nhận với mã xác nhận
        Mail::to($user->email)->send(new VerificationMail($user));

        // Lưu thông báo thành công vào session
        session()->flash('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác nhận.');
        session()->put('email',$user->email);
        // Chuyển hướng đến trang chủ hoặc dashboard
        return redirect()->route('showverify'); 
    }
    
    public function verify(Request $request)
    {   
        $email = session('email');
        $user = User::select('verification_token')->where('email',$email)->first();
        if ($user->verification_token == $request->token) {
            // Xác minh người dùng và đặt trạng thái verified
            $users = User::where('email',$email)->first();
            $users->email_verified_at = now();
            $users->verification_token = null;  // Xóa mã xác nhận sau khi đã xác minh
            $users->save();

            session(['verified'=>'true']);
            return redirect()->route('showverify')->with('success', 'Tài khoản của bạn đã được xác minh!');
        }

        return redirect()->route('showverify')->with('error', 'Mã xác nhận không hợp lệ!');
    }
    public function showverify(){
        if(Auth::check()){
            $user = Auth::user();
            if($user->email_verified_at !== null){
                return redirect()->route('dashboard');
            } else {
                return view('auth.verify');
            }
        }
        return redirect()->route('login');
    }

}

