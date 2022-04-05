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
                            <h5>Điểm danh</h5>
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
                            <li class="breadcrumb-item active" aria-current="page">Điểm danh</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <form action="{{ route('post.save.roll-call') }}" method="post">
                @csrf
                <input name="schedule_id" value="{{ $schedule->id }}" type="hidden">
                <input name="class_id" value="{{ $class->id }}" type="hidden">
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
                                <th>Có mặt</th>
                                <th>Vắng mặt</th>
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

                                        @if(isset($studentIds) && in_array($classStudent->student->id, $studentIds))
                                            <td><input type="radio" checked value="{{ isset($classStudent->student->id) ? $classStudent->student->id : '' }}" name="radio-{{$key}}"></td>
                                            <td><input type="radio" name="radio-{{$key}}"></td>
                                        @else
                                            <td><input type="radio" value="{{ isset($classStudent->student->id) ? $classStudent->student->id : '' }}" name="radio-{{$key}}"></td>
                                            <td><input type="radio" name="radio-{{$key}}" checked></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary mr-2">Xác nhận</button>
                    @if(isset($class))
                        <a href="{{ route('get.class.schedule.index', $class->id) }}" class="btn btn-light">Quay lại</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@stop
