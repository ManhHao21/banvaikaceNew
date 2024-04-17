<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{


    public function login()
    {
        return view("Fontend.auth.login");
    }
    public function postLogin(LoginRequest $request)
    {
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
                return redirect()->route('web.home')->with('success', "đăng nhập thành công");
        }
        return redirect()->route('.login')->with('error', "Đăng nhập Thất bại, vui lòng kiểm tra email và mật khẩu");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.login');
    }
}