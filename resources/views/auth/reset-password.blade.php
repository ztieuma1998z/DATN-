@extends('auth.layout.main')

@section('content')
    <div class="authentication-form mx-auto">
        <div class="logo-centered">
            <a href="../index.html"><img src="{{ asset('../admins/src/img/brand.svg') }}" alt=""></a>
        </div>
        <h3>Quên mật khẩu</h3>
        <p>Chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu.</p>
        <form id="reset-form" onsubmit="sendRequest(); return false;">
            @csrf
            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="">
                <i class="ik ik-mail"></i>
            </div>
            <div class="form-group">
                <select name="role" id="role" class="form-control form-control-lg">
                    <option value="student">Học sinh</option>
                    <option value="teacher">Giáo viên</option>
                    <option value="admin">Quản lý</option>
                </select>
            </div>
            <div class="sign-btn text-center">
                <button onclick="sendRequest()" type="button" class="btn btn-theme">Lấy lại mật khẩu</button>
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
                url: "{{ route('reset-password') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'email': $('#email').val(),
                    'role': $('#role').val(),
                },
                success: function (data) {
                    $('#reset-form').trigger("reset");
                    Toast.fire({
                        icon: data.status,
                        title: data.message
                    })

                }
            })
        }
    </script>
@stop
