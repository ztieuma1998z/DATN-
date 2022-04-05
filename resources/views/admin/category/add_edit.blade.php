@extends('layout.main')
@section('title', 'Danh mục')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Danh mục</h5>
                            <span>Quản lý danh mục trung tâm</span>
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
                                <a href="{{ route('get.category.index') }}">Danh mục</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($category) ? "Cập nhật" : "Tạo mới"}} danh mục</li>
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
                            @if(isset($category))
                                <h3 class="card-title">Cập nhật danh mục</h3>
                            @else
                                <h3 class="card-title">Tạo mới danh mục</h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tên danh mục <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', isset($category->name) ? $category->name : '') }}"
                                           placeholder="tên danh mục">
                                    @if($errors->has('name'))
                                        <span class="text-danger">
                                            {{$errors->first('name')}}
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
                                        {{ isset($category->status) ? $category->status == 1 ? 'checked' : '' : "checked" }} />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($category) ? "Cập nhật" : "Thêm mới"}}</button>
                            <a href="{{ route('get.category.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
