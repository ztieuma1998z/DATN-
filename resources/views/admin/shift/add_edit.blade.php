@extends('layout.main')
@section('title', 'Ca học')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Ca học</h5>
                            <span>Quản lý ca học trung tâm</span>
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
                                <a href="{{ route('get.shift.index') }}">Ca học</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($shift) ? "Cập nhật" : "Tạo mới"}} ca học</li>
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
                            @if(isset($shift))
                                <h3 class="card-title">Cập nhật ca học</h3>
                            @else
                                <h3 class="card-title">Tạo mới ca học</h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tên ca học <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', isset($shift->name) ? $shift->name : '') }}"
                                           placeholder="tên ca học">
                                    @if($errors->has('name'))
                                        <span class="text-danger">
                                            {{$errors->first('name')}}
                                        </span>
                                    @endif
                                </div>
                            </div   >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Thời gian bắt đầu <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control @error('start_at') is-invalid @enderror"
                                           name="start_at"
                                           type="time"
                                           value="{{ old('start_at', isset($shift->start_at) ? $shift->start_at : '') }}"
                                    >
                                    @if($errors->has('start_at'))
                                        <span class="text-danger">
                                            {{$errors->first('start_at')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Thời gian kết thúc <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input class="form-control @error('end_at') is-invalid @enderror"
                                           name="end_at"
                                           type="time"
                                           value="{{ old('end_at', isset($shift->end_at) ? $shift->end_at : '') }}"
                                    >
                                    @if($errors->has('end_at'))
                                        <span class="text-danger">
                                            {{$errors->first('end_at')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{ isset($shift) ? "Cập nhật" : "Thêm mới"}}</button>
                            <a href="{{ route('get.shift.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
