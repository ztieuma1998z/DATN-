@extends('layout.main')
@section('title', 'Giới thiệu')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-airplay bg-blue"></i>
                        <div class="d-inline">
                            <h5>Giới thiệu</h5>
                            <span>Quản lý trang giới thiệu trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
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
                        <div class="card-header"><h3>Cập nhật trang giới thiệu</h3></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', isset($aboutPage->title) ? $aboutPage->title : '') }}"
                                           placeholder="tiêu đề ...">
                                    @if($errors->has('title'))
                                        <p class="text-danger">
                                            {{$errors->first('title')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                </label>
                                <div class="col-sm-5">
                                    <img class="img-thumbnail" width="200px"
                                         src="{{ isset($aboutPage->image) ? asset('storage/'.$aboutPage->image) : asset('admins/img/default-image.jpg') }}"
                                         id="preview-image"
                                         alt="Card image cap">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Hình ảnh
                                </label>
                                <div class="col-sm-5">
                                    <input id="input-preview-image" name="image" type="file">
                                    @if($errors->has('image'))
                                        <p class="text-danger">
                                            {{$errors->first('image')}}
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
                                        {{ old('title', isset($aboutPage->content) ? $aboutPage->content : '') }}
                                    </textarea>
                                    @if($errors->has('content'))
                                        <p class="text-danger">
                                            {{$errors->first('content')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Cập nhật</button>
                            <a href="{{ route('get.about.index') }}" class="btn btn-light">Hủy</a>
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
