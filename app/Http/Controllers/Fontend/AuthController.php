<?php

namespace App\Http\Controllers\Fontend;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{


    public function login()
    {
        return view("frontend.auth.login");
    }
    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->route('web.home')->with('success', "Đăng nhập thành công");
        }

        return redirect()->route('web.login')->with('error', "Đăng nhập thất bại, vui lòng kiểm tra email và mật khẩu");
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.login');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $data = $request->except('_token');
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "birthday" => $data['birthday'],
            "phone" => $data['phone'],
            "publish" => 1,
            "password" => Hash::make($data['password'])
        ]);
        return redirect()->route('web.login')->with('success', 'Đăng kí tài khoản thành công');
    }
}