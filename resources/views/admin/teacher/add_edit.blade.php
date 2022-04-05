@extends('layout.main')
@section('title', 'Giáo viên')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Giáo viên</h5>
                        <span>Quản lý giáo viên trung tâm</span>
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
                            <a href="{{ route('get.teacher.index') }}">Giáo viên</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($teacher) ? "Cập nhật" : "Thêm mới"}} giáo viên</li>
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
                        @if(isset($teacher))
                        <h3 class="card-title">Cập nhật giáo viên</h3>
                        @else
                        <h3 class="card-title">Thêm mới giáo viên</h3>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(isset($teacher->code))
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Mã giáo viên <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="code" value="{{ old('code', isset($teacher->code) ? $teacher->code : '') }}" readonly class="form-control">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Họ và Tên <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name" value="{{ old('full_name', isset($teacher->full_name) ? $teacher->full_name : '') }}" class="form-control @error('full_name') is-invalid @enderror" placeholder="tên ...">
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
                                <input type="number" name="phone" value="{{ old('phone', isset($teacher->phone) ? $teacher->phone : '') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="số điện thoại ...">
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
                                <input type="text" name="email" value="{{ old('email', isset($teacher->email) ? $teacher->email : '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email ...">
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
                                <input type="text" name="address" value="{{ old('address', isset($teacher->address) ? $teacher->address : '') }}" class="form-control @error('address') is-invalid @enderror" placeholder="địa chỉ ...">
                                @if($errors->has('address'))
                                <span class="text-danger">
                                    {{$errors->first('address')}}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Chuyên ngành <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-10">
                                <select name="specialized_id" class="form-control @error('specialized_id') is-invalid @enderror">
                                    <option value="">-----Chọn chuyên ngành----</option>
                                    @if(isset($specializeds))
                                        @foreach($specializeds as $specialized)
                                            <option value="{{ $specialized->id }}" {{ old('specialized_id', isset($teacher->specialized_id) ? $teacher->specialized_id : '') == $specialized->id  ? "selected='selected'" : " " }} >{{ $specialized->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if($errors->has('specialized_id'))
                                    <p class="text-danger">
                                        {{$errors->first('specialized_id')}}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Giới tính
                            </label>
                            <div class="col-sm-10">
                                <span>Nam</span>
                                <input type="radio" name="gender" {{ (isset($teacher->gender) ? $teacher->gender : "") == 1 ? "checked" : "" }} class="mr-5" value="1" />
                                <span>Nữ</span>
                                <input type="radio" name="gender" {{ (isset($teacher->gender) ? $teacher->gender : "") == 0 ? "checked" : "" }} value="0" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                                Ngày sinh
                            </label>
                            <div class="col-sm-10">
                                <input type="date" name="birth_date" value="{{ old('birth_date', isset($teacher->birth_date) ? $teacher->birth_date : '') }}" class="form-control @error('birth_date') is-invalid @enderror" placeholder="ngày sinh ...">
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
                                <input type="checkbox" name="status" {{ isset($teacher->status) ? $teacher->status == 1 ? 'checked' : '' : "checked" }} />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">
                            </label>
                            <div class="col-sm-5">
                                <img class="img-avatar" width="200px" src="{{ isset($teacher->avatar) ? asset('storage/'.$teacher->avatar) : asset('admins/img/default-image.jpg') }}" id="preview-image" alt="Card image cap">
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
                        <button type="submit" class="btn btn-primary mr-2">{{ isset($teacher) ? "Cập nhật" : "Thêm mới"}}</button>
                        <a href="{{ route('get.teacher.index') }}" class="btn btn-light">Hủy</a>
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
