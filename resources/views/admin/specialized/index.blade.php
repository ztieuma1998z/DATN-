@extends('layout.main')
@section('title', 'Chuyên Ngành')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Chuyên Ngành</h5>
                            <span>Quản lý chuyên ngành giáo viên</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chuyên ngành</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col-12 col-md-9 card-header--col">
                    <h3>Danh sách chuyên ngành</h3>
                </div>
                <div class="col-12 col-md-3 card-header--col">
                    <div class="text-right">
                        <a href="{{ route('get.specialized.create') }}">
                            <button type="button" class="btn btn-outline-success">Thêm chuyên ngành</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Tên chuyên ngành</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($specializeds))
                        @foreach($specializeds as $key => $specialized)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $specialized->name }}</td>
                                <td>
                                    <a href="{{ route('get.specialized.edit',$specialized->id) }}">
                                        <button type="button" class="btn btn-outline-warning">
                                            <i class="ik ik-edit f-16"></i>
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
