@extends('layout.main')
@section('title', 'Lịch dạy')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Lịch dạy</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch dạy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Lịch dạy lớp - {{ isset($class->name) ? $class->name : '' }}</h3>
                </div>
                <div class="col col-sm-6">
                </div>
                <div class="col col-sm-3">
                    <div class="text-right">
                        <a href="{{ route('teacher.chargeclass.index') }}" class="btn btn-outline-success"><i class="ik ik-corner-up-right"></i> Quay lại</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="example" class="table text-center">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Ngày</th>
                        <th>Phòng</th>
                        <th>Tên khóa</th>
                        <th>Tên lớp</th>
                        <th>Ca học</th>
                        <th>Thời gian</th>
                        <th>Thao tác</th>
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
                                <td>{{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }}</td>
                                <td>{{ isset($schedule->shift->start_at) ? $schedule->shift->start_at : '[N/A]' }} - {{ isset($schedule->shift->end_at) ? $schedule->shift->end_at : '[N/A]' }}</td>
                                <td>
                                    @if(isset($class))
                                        @if($date ==  $schedule->date)
                                            @if(isset($scheduleIds) && in_array($schedule->id, $scheduleIds))
                                                <a href="{{ route('teacher.rollcall.index', ['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                    <button type="button" class="btn btn-outline-primary">Điểm danh</button>
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.rollcall.index', ['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                    <button type="button" class="btn btn-outline-warning">xem điểm danh</button>
                                                </a>
                                            @endif
                                        @endif
                                        @if($schedule->date < $date)
                                            <a href="{{ route('teacher.rollcall.index', ['idSchedule' => $schedule->id, 'idClass' => $class->id]) }}">
                                                <button type="button" class="btn btn-outline-warning">xem điểm danh</button>
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
