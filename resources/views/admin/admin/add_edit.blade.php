@extends('layout.main')
@section('title', 'Quản trị viên')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>Quản trị viên</h5>
                            <span>Quản lý quản trị viên trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('get.admin.index') }}">Quản trị viên</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($admin) ? "Cập nhật" : "Thêm mới"}} quản trị viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="card-header">
                            @if(isset($admin))
                                <h3 class="card-title">Cập nhật quản trị viên</h3>
                            @else
                                <h3 class="card-title">Thêm mới quản trị viên</h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Họ và tên <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="full_name" value="{{ old('full_name', isset($admin->full_name) ? $admin->full_name : '') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="Họ tên ...">
                                    @if($errors->has('full_name'))
                                        <span class="text-danger">
                                            {{$errors->first('full_name')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" name="phone" value="{{ old('phone', isset($admin->phone) ? $admin->phone : '') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="số điện thoại ...">
                                    @if($errors->has('phone'))
                                        <span class="text-danger">
                                            {{$errors->first('phone')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" value="{{ old('email', isset($admin->email) ? $admin->email : '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email ...">
                                    @if($errors->has('email'))
                                        <span class="text-danger">
                                            {{$errors->first('email')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Trạng thái
                                </label>
                                <div class="col-sm-10">
                                    <input type="checkbox" name="status" {{ isset($admin->status) ? $admin->status == 1 ? 'checked' : '' : "checked" }} />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                </label>
                                <div class="col-sm-5">
                                    <img class="img-avatar" width="200px" src="{{ isset($admin->avatar) ? asset('storage/'.$admin->avatar) : "admins/img/default-image.jpg" }}" id="preview-image" alt="Card image cap">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Hình ảnh <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-5">
                                    <input id="input-preview-image" name="avatar" type="file">
                                    @if($errors->has('avatar'))
                                        <p class="text-danger">
                                            {{$errors->first('avatar')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($admin) ? "Cập nhật" : "Thêm mới"}}</button>
                            <a href="{{ route('get.admin.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#input-preview-image").change(function() {
            readURL(this);
        });
    </script>
@endsection
