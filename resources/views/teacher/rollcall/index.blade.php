@extends('layout.main')
@section('title', 'Điểm danh')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
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
        <div class="card">
            <form action="">
                <div class="card-header row">
                    <div class="col col-sm-6">
                        <h3>Điểm danh lớp - @if(isset($class)) {{ $class->name }} @endif</h3>
                    </div>
                    <div class="col col-sm-6 text-right">
                        <h3>Ngày: {{ isset($schedule->date) ? date('d-m-Y',strtotime($schedule->date)) : '' }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                        <tr>
                            <th width="10">STT</th>
                            <th>Ảnh</th>
                            <th>Tên học sinh</th>
                            <th>Mã học sinh</th>
                            @if(empty($scheduleIds))
                                <th>Trạng thái đi học</th>
                            @else
                                <th>Có mặt</th>
                                <th>Vắng mặt</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($classStudents))
                            @foreach($classStudents as $key => $classStudent)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img class="img-user" src="{{ isset($classStudent->student->avatar) ? asset('storage/'.$classStudent->student->avatar) : asset('admins/img/default-image.jpg') }}" alt="user">
                                    </td>
                                    <td>{{ isset($classStudent->student->full_name) ? $classStudent->student->full_name : "" }}</td>
                                    <td>{{ isset($classStudent->student->code) ? $classStudent->student->code : "" }}</td>

                                    @if(empty($scheduleIds))
                                        @if(isset($studentIds) && in_array($classStudent->student->id, $studentIds))
                                            <td><strong class="text-success">Có mặt</strong></td>
                                        @else
                                            <td><strong class="text-danger">Vắng mặt</strong></td>
                                        @endif
                                    @else
                                        @if(isset($studentIds) && in_array($classStudent->student->id, $studentIds))
                                            <td><input type="radio" checked value="{{ isset($classStudent->student->id) ? $classStudent->student->id : '' }}" name="radio-{{$key}}"></td>
                                            <td><input type="radio" name="radio-{{$key}}"></td>
                                        @else
                                            <td><input type="radio" value="{{ isset($classStudent->student->id) ? $classStudent->student->id : '' }}" name="radio-{{$key}}"></td>
                                            <td><input type="radio" name="radio-{{$key}}" checked></td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    @if(!empty($scheduleIds))
                        <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                    @endif
                    @if(isset($class))
                        <a href="{{ route('teacher.scheduleclass.index', $class->id) }}" class="btn btn-light">Quay lại</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop
