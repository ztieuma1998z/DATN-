@extends('layout.main')
@section('title', 'Học sinh')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Học sinh</h5>
                        <span>Quản lý học sinh trung tâm</span>
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
                            <a href="{{ route('get.student.index') }}">Học sinh</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($student) ? "Cập nhật" : "Thêm mới"}} học sinh</li>
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
                        @if(isset($student))
                        <h3 class="card-title">Cập nhật học sinh</h3>
                        @else
                        <h3 class="card-title">Thêm mới học sinh</h3>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(isset($student->code))
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Mã học sinh <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="code" value="{{ old('code', isset($student->code) ? $student->code : '') }}" class="form-control" readonly>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Họ và tên <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name" value="{{ old('full_name', isset($student->full_name) ? $student->full_name : '') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="Họ tên ...">
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
                                <input type="number" name="phone" value="{{ old('phone', isset($student->phone) ? $student->phone : '') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="số điện thoại ...">
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
                                <input type="text" name="email" value="{{ old('email', isset($student->email) ? $student->email : '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email ...">
                                @if($errors->has('email'))
                                <span class="text-danger">
                                    {{$errors->first('email')}}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Địa chỉ
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="address" value="{{ old('address', isset($student->address) ? $student->address : '') }}" class="form-control @error('address') is-invalid @enderror" placeholder="địa chỉ ...">
                                @if($errors->has('address'))
                                <span class="text-danger">
                                    {{$errors->first('address')}}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Giới tính
                            </label>
                            <div class="col-sm-10">
                                <span>Nam</span>
                                <input type="radio" name="gender" {{ (isset($student->gender) ? $student->gender : "") == 1 ? "checked" : "" }} class="mr-5" value="1" />
                                <span>Nữ</span>
                                <input type="radio" name="gender" {{ (isset($student->gender) ? $student->gender : "") == 0 ? "checked" : "" }} value="0" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Ngày sinh
                            </label>
                            <div class="col-sm-10">
                                <input type="date" name="birth_date" value="{{ old('birth_date', isset($student->birth_date) ? $student->birth_date : '') }}" class="form-control @error('birth_date') is-invalid @enderror" placeholder="ngày sinh ...">
                                @if($errors->has('birth_date'))
                                <span class="text-danger">
                                    {{$errors->first('birth_date')}}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Trạng thái
                            </label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="status" {{ isset($student->status) ? $student->status == 1 ? 'checked' : '' : "checked" }} />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                            </label>
                            <div class="col-sm-5">
                                <img class="img-avatar" width="200px" src="{{ isset($student->avatar) ? asset('storage/'.$student->avatar) : asset('admins/img/default-image.jpg') }}" id="preview-image" alt="Card image cap">
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
                        <button type="submit" class="btn btn-primary mr-2">{{ isset($student) ? "Cập nhật" : "Thêm mới"}}</button>
                        <a href="{{ route('get.student.index') }}" class="btn btn-light">Hủy</a>
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
