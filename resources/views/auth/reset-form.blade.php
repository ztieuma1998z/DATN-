@extends('auth.layout.main')

@section('content')
    <div class="authentication-form mx-auto">
        <div class="logo-centered">
            <a href="../index.html"><img src="{{ asset('../admins/src/img/brand.svg') }}" alt=""></a>
        </div>
        <h3>Đặt lại mật khẩu</h3>
        <p>Hãy nhập mật khẩu mới của bạn</p>
        <form method="post" onsubmit="sendRequest(); return false">
            @csrf
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="New password" required="">
                <i class="ik ik-mail"></i>
            </div>
            <div class="form-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required="">
                <i class="ik ik-mail"></i>
            </div>
            <div class="sign-btn text-center">
                <button type="submit" class="btn btn-theme">Đặt lại mật khẩu</button>
            </div>
        </form>
        <div class="row mt-3">
            <div class="col text-right">
                <a href="{{ route('login') }}">Về trang đăng nhập <i class="ik ik-arrow-right"></i></a>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function sendRequest() {
            $.ajax({
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'password': $('#password').val(),
                    'password_confirmation': $('#password_confirmation').val(),
                },
                success: function (data) {
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    })
                    if(data.status === "success"){
                        setTimeout(function() {
                            window.location.href = "{{ route('login') }}"
                        }, 3000);
                    }
                },
                error: function (data){
                    Toast.fire({
                        icon: 'error',
                        title: data.responseJSON.errors.password[0]
                    });
                }
            })
        }
    </script>
@stop
