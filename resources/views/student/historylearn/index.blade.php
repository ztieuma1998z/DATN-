@extends('layout.main')
@section('title', 'Lịch sử học')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Lịch sử học tại trung tâm</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch sử học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Lịch sử học</h3>
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
                        <th width="10">STT</th>
                        <th>Tên lớp</th>
                        <th>Khóa học</th>
                        <th>Tổng số buổi</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Giáo viên</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($classHistory))
                        @foreach($classHistory as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->course_name }}</td>
                                <td>{{ $item->number_of_sessions }}</td>
                                <td>{{ date('d-m-Y',strtotime($item->start_date)) }}</td>
                                <td>{{ date('d-m-Y',strtotime($item->end_date)) }}</td>
                                <td>{{ $item->full_name }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
