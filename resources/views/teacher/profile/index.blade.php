@extends('layout.main')
@section('title', 'Thông tin cá nhân')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Thông tin cá nhân</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ isset($teacher->avatar) ? asset('storage/'.$teacher->avatar) : asset('admins/img/default-image.jpg') }}" class="rounded-circle" width="150">
                            <h4 class="card-title mt-10">{{ isset($teacher->full_name) ? $teacher->full_name : "" }}</h4>
                            <p class="card-subtitle">{{ isset($teacher->code) ? $teacher->code : "" }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="card-header"><h3>Thông tin cá nhân</h3></div>
                    <div class="card-body">
                        <form class="forms-sample">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Họ tên</label>
                                        <input type="text" value="{{ isset($teacher->full_name) ? $teacher->full_name : "" }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Mã học sinh</label>
                                        <input type="text" value="{{ isset($teacher->code) ? $teacher->code : "" }}" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Email</label>
                                        <input type="email" value="{{ isset($teacher->email) ? $teacher->email : "" }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Gender</label>
                                        <input type="text" class="form-control" value="Nam" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Ngày sinh</label>
                                <input class="form-control" value="{{ isset($teacher->birth_date) ? date('d-m-Y',strtotime($teacher->birth_date)) : "" }}" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Số điện thoại</label>
                                <input type="text" value="{{ isset($teacher->phone) ? $teacher->phone : "" }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName1">Đia chỉ</label>
                                <input type="text" value="{{ isset($teacher->address) ? $teacher->address : "" }}" class="form-control" readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
