@extends('auth.layout.main')

@section('content')
    <div class="authentication-form mx-auto">
        <div class="logo-centered">
            <a href=""><img src="{{ asset('../admins/src/img/brand.svg')}}" alt=""></a>
        </div>
        <h3>Đăng nhập vào ThemeKit</h3>
        <p>Chào mừng bạn đến với trang đăng nhập!</p>
        @if(Session::has('error_login'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error_login') }}
            </div>
            {{ Session::put('error_login', null) }}
        @endif
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email" required>
                <i class="ik ik-user"></i>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required>
                <i class="ik ik-lock"></i>
            </div>
            <div class="form-group">
                <select name="role" id="role" class="form-control form-control-lg">
                    <option value="student">Học sinh</option>
                    <option value="teacher">Giáo viên</option>
                    <option value="admin">Quản lý</option>
                </select>
            </div>
            <div class="row">
                <div class="col text-left">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                        <span class="custom-control-label">&nbsp;Ghi nhớ mật khẩu</span>
                    </label>
                </div>
                <div class="col text-right">
                    <a href="{{ route('reset-password') }}">Quên mật khẩu ?</a>
                </div>
            </div>
            <div class="sign-btn text-center">
                <button class="btn btn-theme">Đăng nhập</button>
            </div>
        </form>
    </div>
@stop


