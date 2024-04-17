<?php

namespace App\Http\Controllers\Backend;

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
        // dd(Auth::guard('admin')->name());
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        }
        return view("backend.Auth.login");
    }
    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
            if (Auth::guard('admin')->attempt($credentials) || Auth::attempt($credentials)) {

                return redirect(RouteServiceProvider::ADMIN);
            } else {
                return redirect()->route('admin.login')->with('error', "Đăng nhập Thất bại, vui lòng kiểm tra email và mật khẩu");
            }
        // $credentials = [
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ];
        // if (Auth::attempt($credentials)) {
        //     if (Auth::user()->is_admin == 1) {
        //         return redirect()->route('admin.index')->with('success', "đăng nhập thành công");
        //     }
        // }
        // return redirect()->route('login')->with('error', "Đăng nhập Thất bại, vui lòng kiểm tra email và mật khẩu");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}