@extends('layout.main')
@section('title', 'Cấu hình')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Cấu hình</h5>
                            <span>Quản lý cấu hình trung tâm</span>
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
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Cấu hình trung tâm</h3>
                </div>
                <div class="col col-sm-6">
                </div>
                <div class="col col-sm-3">
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Favicon</th>
                        <th>Logo</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>copyright</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($settings))
                        @foreach($settings as $key => $setting)
                            <tr>
                                <td width="10">{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$setting->favicon) }}"
                                         class="list-thumbnail responsive border-0" alt="">
                                </td>
                                <td>
                                    <img style="background: #0b0b0b" src="{{ asset('storage/'.$setting->logo) }}" alt="">
                                </td>
                                <td>{{ $setting->phone }}</td>
                                <td>{{ $setting->email }}</td>
                                <td>{{ $setting->address }}</td>
                                <td>{{ $setting->copyright }}</td>
                                <td>
                                    <a href="{{ route('get.setting.edit', $setting->id) }}">
                                        <button type="button" class="btn btn-outline-primary">
                                            <i class="ik ik-edit f-16 mr-5 text-primary"></i>
                                            Sửa
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
