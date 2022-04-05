@extends('layout.main')
@section('title', 'Thay đổi mật khẩu')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Thay đổi mật khẩu</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Thay đổi mật khẩu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-7 m-auto">
                <div class="card">
                    <form method="POST" action="{{ route('post.change.password') }}">
                        @csrf
                        <div class="card-header"><h3>Thay đổi mật khẩu</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputName1">Mật khẩu cũ <span class="text-danger">*</span></label>
                                <input class="form-control" name="old_password" type="password" placeholder="Nhập mật khẩu cũ">
                                @error('old_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Mật khẩu mới <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu">
                                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
