@extends('layout.main')
@section('title', 'Điểm danh')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Điểm danh</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Điểm danh</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        @if(isset($classes) && isset($schedules))
             @foreach($classes as $class)
                 <div class="card">
                    <div class="card-header row">
                        <div class="col col-sm-4">
                            <h3>Lớp : {{ $class->name }} |
                                Khóa học : {{ isset($class->course->name) ? $class->course->name : "[N/A]" }}
                            </h3>
                        </div>
                        <div class="col col-sm-5">
                        </div>
                        <div class="col col-sm-3">
                            @if(!empty($numberAbsences))
                                @foreach($numberAbsences as $value)
                                    @if($value['class_id'] == $class->id)
                                        <h3 class="text-right">Vắng: <span class="text-danger">{{ $value['absences'] }}/{{ $value['numberSessions'] }}</span> trên tổng số</h3>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="" class="table display text-center">
                            <thead>
                                <tr>
                                    <th width="10">STT</th>
                                    <th>Ngày</th>
                                    <th>Ca học</th>
                                    <th>Thời gian</th>
                                    <th>Người điểm danh</th>
                                    <th>Trang thái đi học</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $key => $schedule)
                                    @if($schedule->class->id == $class->id)
                                        <tr>
                                            <td width="10">{{ $key + 1 }}</td>
                                            <td>
                                                {{ isset($schedule->weekday->name) ? $schedule->weekday->name : '[N/A]'  }} <br>
                                                {{ date('d-m-Y',strtotime($schedule->date)) }}
                                            </td>
                                            <td>
                                                {{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }}
                                            </td>
                                            <td>{{ isset($schedule->shift->start_at) ? $schedule->shift->start_at : '[N/A]' }} - {{ isset($schedule->shift->end_at) ? $schedule->shift->end_at : '[N/A]' }}</td>
                                            <td>
                                                @if($schedule->date < $date)
                                                    {{ isset($schedule->teacher->full_name) ? $schedule->teacher->full_name : '[N/A]' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->date < $date)
                                                    @if(($schedule->rollCall->count() > 0))
                                                        @if($schedule->rollCall->where('student_id', 7)->count() > 0)
                                                            <strong class="text-primary">Có mặt</strong>
                                                        @else
                                                            <strong class="text-danger">Vắng mặt</strong>
                                                        @endif
                                                    @else
                                                        <strong class="text-danger">Vắng mặt</strong>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('table.display').DataTable();
        } );
    </script>
@stop
