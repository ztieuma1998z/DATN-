@extends('layout.main')
@section('title', 'Thông báo')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>thông báo</h5>
                            <span>Quản lý thông báo cho thành viên của trung tâm</span>
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
                                <a href="{{ route('get.notification.index') }}">Thông báo</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($notification) ? "Cập nhật" : "Tạo mới"}} thông báo</li>
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
                            @if(isset($notification))
                                <h3 class="card-title">Cập nhật thông báo</h3>
                            @else
                                <h3 class="card-title">Tạo mới thông báo</h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tiêu đề <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           value="{{ old('title', isset($notification->title) ? $notification->title : '') }}"
                                           placeholder="tiêu đề">
                                    @if($errors->has('title'))
                                        <p class="text-danger">
                                            {{$errors->first('title')}}
                                        </p>
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
                                    Loại thông báo <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">-----Chọn loại thông báo----</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', isset($notification->category_id) ? $notification->category_id : '') == $category->id  ? "selected='selected'" : " " }} >{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('category_id'))
                                        <p class="text-danger">
                                            {{$errors->first('category_id')}}
                                        </p>
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
                                        {{ isset($notification->status) ? $notification->status == 1 ? 'checked' : '' : "checked" }} />
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
                                        {{ old('content',isset($notification->content) ? $notification->content : '') }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($notification) ? "Cập nhật" : "Thêm mới"}}</button>
                            <a href="{{ route('get.notification.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
