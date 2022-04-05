<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestResetPassword;
use App\Mail\Auth\TokenResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    private $role_array = ['admin', 'teacher', 'student'];

    private function checkHasRole($role)
    {
        return in_array(Str::lower($role), $this->role_array);
    }

    public function resetForm()
    {
        return view('auth.reset-password');
    }

    public function sendResetToken(Request $request)
    {
        //Kiểm tra role submit
        if (!$this->checkHasRole($request->role)) {
            return response()->json([
                'status' => 'error',
                'message' => "Invalid role!"
            ]);
        }
        //Gọi đến user và kiểm tra sự tồn tại
        $user = DB::table(Str::plural(Str::lower($request->role)))
            ->where('email', $request->email)
            ->first();
        if (empty($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Can not find user with that email, please double check the email and role then try again'
            ]);
        };
        //Xóa các token cũ
        DB::table($request->role . "_password_resets")
            ->where('email', $request->email)
            ->delete();
        //Thêm token mới
        $token = Str::uuid();
        DB::table($request->role . "_password_resets")
            ->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);

        Mail::to($request->email)
            ->send(new TokenResetPassword(
                    $token,
                    $request->email,
                    $request->role
                )
            );

        return response()->json([
            'status' => 'success',
            'message' => 'Sent email with reset link to your mail'
        ]);
    }

    public function resetPasswordForm()
    {
        return view('auth.reset-form');
    }

    public function submitResetPassword(RequestResetPassword $request, $role, $token)
    {
        if (!$this->checkHasRole($role)) {
            return response()->json([
                'status' => 'error',
                'message' => "Invalid role!"
            ]);
        }
        $reset_query = DB::table($role . '_password_resets')
            ->where('token', $token)
            ->first();
        if (!$reset_query) {
            return response()->json([
                'status' => 'error',
                'message' => "Invalid token!"
            ]);
        }
        if (Carbon::now()->diffInDays($reset_query->created_at) > 3) {
            return response()->json([
                'status' => 'error',
                'message' => "Expired token!"
            ]);
        }
        $reset_password_query = DB::table(Str::plural($role))
            ->where('email', $reset_query->email)
            ->limit(1)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        if ($reset_password_query) {
            DB::table($role . '_password_resets')
                ->where('token', $token)
                ->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Đổi mật khẩu thành công, bạn sẽ được điều hướng về trang đăng nhập sớm'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi cập nhật mật khẩu!'
            ]);
        }
    }
}
