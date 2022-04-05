<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function loginForm()
    {
        Auth::guard('admin')->logout();
        Auth::guard('teacher')->logout();
        Auth::guard('student')->logout();

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard($request->role)->attempt($credentials)) {

            $check = DB::table(Str::plural($request->role))->where('email', $request->email)
                ->where('status', 1)
                ->get();
            if ($check->count() == 0) {
                return back()->with('error_login', 'Tài khoản bị tạm ngừng hoạt động !');
            }
                   return redirect()->route($request->role . '.index');
        } else {
            return back()->with('error_login', 'Tài khoản hoặc mật khẩu không chính xác !');
        }
    }
}
