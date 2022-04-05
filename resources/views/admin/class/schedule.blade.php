@extends('layout.main')
@section('title', 'Lịch học')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Lịch học</h5>
                            <span>Quản lý lớp học của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách lịch học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-4">
                    <h3>Danh sách lịch học lớp : <strong>@if(isset($class)) {{ $class->name }} @endif</strong></h3>
                </div>
                <div class="col col-sm-4">
                    <div class="text-center">
                        <h3>Số buổi đã học: <strong>{{ $numberLearned }}/{{ isset($schedules) ? $schedules->count() : '' }}</strong></h3>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="text-right">
                        <a href="{{ route('get.class.index') }}" class="btn btn-outline-success"><i class="ik ik-corner-up-right"></i> Quay lại</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th class="nosort" width="10">
                                STT
                            </th>
                            <th>Ngày</th>
                            <th>Phòng</th>
                            <th>Khóa học</th>
                            <th>Lớp</th>
                            <th>Giáo viên</th>
                            <th>Ca học</th>
                            <th>Thời gian</th>
                            <th class="nosort">Điểm danh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($schedules))
                            @foreach($schedules as $key => $schedule)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ isset($schedule->weekday->name) ? $schedule->weekday->name : '[N/A]'  }} <br>
                                        {{ date('d-m-Y',strtotime($schedule->date)) }}
                                    </td>
                                    <td>{{ isset($schedule->room->name) ? $schedule->room->name : '[N/A]' }}</td>
                                    <td>{{ isset($schedule->course->name) ? $schedule->course->name : '[N/A]' }}</td>
                                    <td>{{ isset($schedule->class->name) ? $schedule->class->name : '[N/A]' }}</td>
                                    <td>
                                        @if(isset($schedule->teacher->full_name))
                                            {{ $schedule->teacher->full_name }}
                                        @else
                                            <span class="text-danger">Chưa xếp giảng viên</span>
                                        @endif
                                    </td>
                                    <td>{{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }}</td>
                                    <td>{{ isset($schedule->shift->start_at) ? $schedule->shift->start_at : '[N/A]' }} - {{ isset($schedule->shift->end_at) ? $schedule->shift->end_at : '[N/A]' }}</td>
                                    <td>
                                        @if(isset($class))
                                            @if($date ==  $schedule->date)
                                                @if(isset($scheduleIds) && in_array($schedule->id, $scheduleIds))
                                                    <a href="{{ route('get.roll-call.index',['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                        <button type="button" class="btn btn-outline-primary">Điểm danh</button>
                                                    </a>
                                                @else
                                                    @if($time > $schedule->shift->end_at)
                                                        <a href="{{ route('get.roll-call.index',['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                            <button type="button" class="btn btn-outline-warning">Sửa điểm danh</button>
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
                                            @if($schedule->date < $date)
                                                <a href="{{ route('get.roll-call.index',['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                    <button type="button" class="btn btn-outline-warning">Sửa điểm danh</button>
                                                </a>
                                            @endif
                                        @endif
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
