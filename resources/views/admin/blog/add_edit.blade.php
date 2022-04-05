@extends('layout.main')
@section('title', 'Tin tức')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>Tin tức</h5>
                            <span>Quản lý tin tức trung tâm</span>
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
                                <a href="{{ route('get.blog.index') }}">Tin tức</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($blog) ? "Cập nhật" : "Thêm mới"}} tin tức</li>
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
                            @if(isset($blog))
                                <h3 class="card-title">Cập nhật tin tức</h3>
                            @else
                                <h3 class="card-title">Thêm mới tin tức</h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="title"
                                           value="{{ old('title', isset($blog->title) ? $blog->title : '') }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="tiêu đề ...">
                                    @if($errors->has('title'))
                                        <span class="text-danger">
                                            {{$errors->first('title')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Người đăng
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="admin_id"
                                           value="{{ Auth::user()->full_name }}"
                                           readonly class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Mô tả <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           name="description"
                                           value="{{ old('description', isset($blog->description) ? $blog->description : '') }}"
                                           class="form-control @error('description') is-invalid @enderror"
                                           placeholder="mô tả ...">
                                    @if($errors->has('description'))
                                        <span class="text-danger">
                                            {{$errors->first('description')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Url key
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           name="url_key"
                                           value="{{ old('url_key', isset($blog->url_key) ? $blog->url_key : '') }}"
                                           class="form-control @error('url_key') is-invalid @enderror"
                                           placeholder="url key ...">
                                    @if($errors->has('url_key'))
                                        <span class="text-danger">
                                            {{$errors->first('url_key')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Trạng thái
                                </label>
                                <div class="col-sm-10">
                                    <input type="checkbox"
                                           name="status"
                                           {{ isset($blog->status) ? $blog->status == 1 ? 'checked' : '' : "checked" }} />
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
                                    {{ old('content',isset($blog->content) ? $blog->content : '') }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                </label>
                                <div class="col-sm-5">
                                    <img class="img-thumbnail" width="200px"
                                         src="{{ isset($blog->thumbnail) ? asset('storage/'.$blog->thumbnail) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image"
                                         alt="Card image cap">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Hình ảnh <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-5">
                                    <input id="input-preview-image"
                                           name="thumbnail"
                                           type="file">
                                    @if($errors->has('thumbnail'))
                                        <p class="text-danger">
                                            {{$errors->first('thumbnail')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($blog) ? "Cập nhật" : "Thêm mới"}}</button>
                            <a href="{{ route('get.blog.index') }}" class="btn btn-light">Hủy</a>
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
