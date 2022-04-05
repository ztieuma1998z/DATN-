@extends('layout.main')
@section('title', 'Tạo khóa học')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Khóa học</h5>
                            <span>Quản lý khóa học của trung tâm</span>
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
                                <a href="{{ route('get.course.index') }}">Khóa học</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($blog) ? "Cập nhật" : "Tạo mới"}} khóa học</li>
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
                        <div class="card-header"><h3>{{ isset($course) ? "Cập nhật" : "Tạo mới"}} khóa học</h3></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tên khóa học <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', isset($course->name) ? $course->name : '') }}"
                                           placeholder="tên khóa học">
                                    @if($errors->has('name'))
                                        <p class="text-danger">
                                            {{$errors->first('name')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Học phí <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="number"
                                           class="form-control @error('price') is-invalid @enderror"
                                           name="price"
                                           value="{{ old('price', isset($course->price) ? $course->price : '') }}"
                                           placeholder="học phí">
                                    @if($errors->has('price'))
                                        <p class="text-danger">
                                            {{$errors->first('price')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if(isset($classes))
                                @if(!$classes->count())
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">
                                            Số buổi học <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="number"
                                                   class="form-control @error('number_of_sessions') is-invalid @enderror"
                                                   name="number_of_sessions"
                                                   value="{{ old('number_of_sessions', isset($course->number_of_sessions) ? $course->number_of_sessions	: '') }}"
                                                   placeholder="số buổi học">
                                            @if($errors->has('number_of_sessions'))
                                                <p class="text-danger">
                                                    {{$errors->first('number_of_sessions')}}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <input type="number"
                                           class="form-control hidden"
                                           name="number_of_sessions"
                                           value="{{ old('number_of_sessions', isset($course->number_of_sessions) ? $course->number_of_sessions	: '') }}"
                                           placeholder="số buổi học">
                                @endif
                            @else
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Số buổi học <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="number"
                                               class="form-control @error('number_of_sessions') is-invalid @enderror"
                                               name="number_of_sessions"
                                               value="{{ old('number_of_sessions', isset($course->number_of_sessions) ? $course->number_of_sessions	: '') }}"
                                               placeholder="số buổi học">
                                        @if($errors->has('number_of_sessions'))
                                            <p class="text-danger">
                                                {{$errors->first('number_of_sessions')}}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Chuyên ngành <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="specialized_id" class="form-control @error('specialized_id') is-invalid @enderror">
                                        <option value="">-----Chọn chuyên ngành----</option>
                                        @if(isset($specializeds))
                                            @foreach($specializeds as $specialized)
                                                <option value="{{ $specialized->id }}" {{ old('specialized_id', isset($course->specialized_id) ? $course->specialized_id : '') == $specialized->id  ? "selected='selected'" : " " }} >{{ $specialized->name }}</option>
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
                                    Mô tả <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description"
                                           value="{{ old('description', isset($course->description) ? $course->description : '') }}"
                                           placeholder="mô tả">
                                    @if($errors->has('description'))
                                        <p class="text-danger">
                                            {{$errors->first('description')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Nội dung
                                </label>
                                <div class="col-sm-10">
                                    <textarea class="textarea" name="content" placeholder="Place some text here"
                                              style="width: 100%; height: 200px; font-size: 14px;
                                              line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        {{ old('content', isset($course->content) ? $course->content : '') }}
                                    </textarea>
                                    @if($errors->has('content'))
                                        <p class="text-danger">
                                            {{$errors->first('content')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                </label>
                                <div class="col-sm-5">
                                    <img class="img-thumbnail" width="200px"
                                         src="{{ isset($course->thumbnail) ? asset('storage/'.$course->thumbnail) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image"
                                         alt="Card image cap">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Hình ảnh <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-5">
                                    <input id="input-preview-image" name="thumbnail" type="file">
                                    @if($errors->has('thumbnail'))
                                        <p class="text-danger">
                                            {{$errors->first('thumbnail')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($course) ? "Cập nhật" : "Tạo mới"}}</button>
                            <a href="{{ route('get.course.index') }}" class="btn btn-light">Hủy</a>
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
