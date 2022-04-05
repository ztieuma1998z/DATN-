@extends('layout.main')
@section('title', 'Cấu hình trung tâm')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-settings bg-blue"></i>
                        <div class="d-inline">
                            <h5>Cấu hình trung tâm</h5>
                            <span>Quản lý cấu hình thiệu trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Cấu hình</li>
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
                        <div class="card-header"><h3>Cập nhật cấu hình</h3></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Favicon <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <img class="img-thumbnail" width="150px"
                                         src="{{ isset($setting->favicon) ? asset('storage/'.$setting->favicon) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image"
                                         alt="Card image cap">
                                    <input name="favicon" id="input-preview-image" type="file">
                                    @if($errors->has('favicon'))
                                        <p class="text-danger">
                                            {{$errors->first('favicon')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Logo <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <img class="img-thumbnail" width="150px"
                                         src="{{ isset($setting->logo) ? asset('storage/'.$setting->logo) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image1"
                                         style="background: #0b0b0b"
                                         alt="Card image cap">
                                    <input id="input-preview-image1" name="logo" type="file">
                                    @if($errors->has('logo'))
                                        <p class="text-danger">
                                            {{$errors->first('logo')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Banner Website <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <img class="img-thumbnail" width="50%"
                                         style="max-height: 150px; object-fit: cover"
                                         src="{{ isset($setting->banner) ? asset('storage/'.$setting->banner) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image2"
                                         alt="Card image cap">
                                    <input id="input-preview-image2" name="banner" type="file">
                                    @if($errors->has('banner'))
                                        <p class="text-danger">
                                            {{$errors->first('banner')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tiêu đề banner <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           value="{{ old('banner_title', isset($setting->banner_title) ? $setting->banner_title : '') }}"
                                           class="form-control @error('banner_title') is-invalid @enderror"
                                           name="banner_title"
                                           placeholder="tiêu đề banner">
                                    @if($errors->has('banner_title'))
                                        <p class="text-danger">
                                            {{$errors->first('banner_title')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Mô tả banner <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('banner_description') is-invalid @enderror"
                                           name="banner_description"
                                           value="{{ old('banner_description', isset($setting->banner_description) ? $setting->banner_description : '') }}"
                                           placeholder="mô tả banner">
                                    @if($errors->has('banner_description'))
                                        <p class="text-danger">
                                            {{$errors->first('banner_description')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Banner trang chủ <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <img class="img-thumbnail" width="50%"
                                         style="max-height: 150px; object-fit: cover"
                                         src="{{ isset($setting->banner_home) ? asset('storage/'.$setting->banner_home) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image3"
                                         alt="Card image cap">
                                    <input id="input-preview-image3" name="banner_home" type="file">
                                    @if($errors->has('banner_home'))
                                        <p class="text-danger">
                                            {{$errors->first('banner_home')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tiêu đề trang chủ <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('banner_home_title') is-invalid @enderror"
                                           name="banner_home_title"
                                           value="{{ old('banner_home_title', isset($setting->banner_home_title) ? $setting->banner_home_title : '') }}"
                                           placeholder="tiêu đề trang chủ">
                                    @if($errors->has('banner_home_title'))
                                        <p class="text-danger">
                                            {{$errors->first('banner_home_title')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Mô tả trang chủ <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control  @error('banner_home_description') is-invalid @enderror"
                                           name="banner_home_description"
                                           value="{{ old('banner_home_description', isset($setting->banner_home_description) ? $setting->banner_home_description : '') }}"
                                           placeholder="mô tả trang chủ">
                                    @if($errors->has('banner_home_description'))
                                        <p class="text-danger">
                                            {{$errors->first('banner_home_description')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="number"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone"
                                           value="{{ old('phone', isset($setting->phone) ? $setting->phone : '') }}"
                                           placeholder="số điện thoại">
                                    @if($errors->has('phone'))
                                        <p class="text-danger">
                                            {{$errors->first('phone')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email', isset($setting->email) ? $setting->email : '') }}"
                                           placeholder="email">
                                    @if($errors->has('email'))
                                        <p class="text-danger">
                                            {{$errors->first('email')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Địa chỉ <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('address') is-invalid @enderror"
                                           name="address"
                                           value="{{ old('address', isset($setting->address) ? $setting->address : '') }}"
                                           placeholder="địa chỉ">
                                    @if($errors->has('address'))
                                        <p class="text-danger">
                                            {{$errors->first('address')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Copyright <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('copyright') is-invalid @enderror"
                                           name="copyright"
                                           value="{{ old('copyright', isset($setting->copyright) ? $setting->copyright : '') }}"
                                           placeholder="copyright">
                                    @if($errors->has('copyright'))
                                        <p class="text-danger">
                                            {{$errors->first('copyright')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Link Iframe Fanpage <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('link_fanpage') is-invalid @enderror"
                                           name="link_fanpage"
                                           value="{{ old('fanpage', isset($setting->link_fanpage) ? $setting->link_fanpage : '') }}"
                                           placeholder="fanpage">
                                    @if($errors->has('link_fanpage'))
                                        <p class="text-danger">
                                            {{$errors->first('link_fanpage')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                            <a href="{{ route('get.setting.index') }}" class="btn btn-light">Hủy</a>
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

        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image1').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#input-preview-image1").change(function() {
            readURL1(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image2').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#input-preview-image2").change(function() {
            readURL2(this);
        });

        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image3').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#input-preview-image3").change(function() {
            readURL3(this);
        });
    </script>
@endsection
