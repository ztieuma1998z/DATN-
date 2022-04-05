@extends('layout.main')
@section('title', 'Lịch học')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Lịch học</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="get" action="">
                    <label for="time"><strong class="f-16">Thời gian</strong></label>
                    <select name="day" id="day" onchange="this.form.submit();" class="form-control">
                        <option value="" {{ \Request::get('day') == "" ? "selected='selected'" : "" }}>Chọn thời gian</option>
                        <option value="today" {{ \Request::get('day') == "today" ? "selected='selected'" : "" }}>Hôm nay</option>
                        <option value="7" {{ \Request::get('day') == "7" ? "selected='selected'" : "" }}>7 ngày tới</option>
                        <option value="14" {{ \Request::get('day') == "14" ? "selected='selected'" : "" }}>14 ngày tới</option>
                        <option value="30" {{ \Request::get('day') == "30" ? "selected='selected'" : "" }}>30 ngày tới</option>
                        <option value="60" {{ \Request::get('day') == "60" ? "selected='selected'" : "" }}>60 ngày tới</option>
                        <option value="-7" {{ \Request::get('day') == "-7" ? "selected='selected'" : "" }}>7 ngày trước</option>
                        <option value="-14" {{ \Request::get('day') == "-14" ? "selected='selected'" : "" }}>14 ngày trước</option>
                        <option value="-30" {{ \Request::get('day') == "-30" ? "selected='selected'" : "" }}>30 ngày trước</option>
                        <option value="-60" {{ \Request::get('day') == "-60" ? "selected='selected'" : "" }}>60 ngày trước</option>
                    </select>
                    <span class="form-text text-muted">Lựa chọn thời gian để hiển thị chi tiết lịch học</span>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Lịch học</h3>
                </div>
                <div class="col col-sm-6">
                </div>
                <div class="col col-sm-3">
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
                            <th>Giảng viên</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($schedules))
                        @foreach($schedules as $key => $schedule)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    {{ isset($schedule->weekday->name) ? $schedule->weekday->name : '[N/A]'  }} <br>
                                    {{ date('d-m-Y',strtotime($schedule->date)) }}
                                </td>
                                <td>
                                    {{ isset($schedule->room->name) ? $schedule->room->name : '[N/A]' }}
                                </td>
                                <td>
                                    {{ isset($schedule->course->name) ? $schedule->course->name : '[N/A]' }}
                                </td>
                                <td>
                                    {{ isset($schedule->class->name) ? $schedule->class->name : '[N/A]' }}
                                </td>
                                <td>
                                    {{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }}
                                </td>
                                <td>{{ isset($schedule->shift->start_at) ? $schedule->shift->start_at : '[N/A]' }} - {{ isset($schedule->shift->end_at) ? $schedule->shift->end_at : '[N/A]' }}</td>
                                <td>
                                    {{ isset($schedule->teacher->full_name) ? $schedule->teacher->full_name : '[N/A]' }}
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
