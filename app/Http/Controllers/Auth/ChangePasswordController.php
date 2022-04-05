<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    public function index()
    {
        $guardName = checkGuard();
        $user_id = Auth::guard($guardName)->id();
        $user = DB::table(Str::plural($guardName))
            ->where('id', $user_id)
            ->limit(1)
            ->first();

        return view('auth.change-password', compact('user'));
    }

    public function submitChangePassword(RequestResetPassword $request){
        $guardName = checkGuard();
        $user_id = Auth::guard($guardName)->id();
        $old_password = DB::table(Str::plural($guardName))
            ->where('id', $user_id)
            ->limit(1)
            ->first()
            ->password;

        if(Hash::check($request->old_password, $old_password)){
            DB::table(Str::plural($guardName))
                ->where('id', $user_id)
                ->limit(1)
                ->update([
                    'password' => bcrypt($request->password)
                ]);
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        }else{
            return redirect()->back()->with('error', 'Mật khẩu cũ không chính xác');
        }
    }
}
