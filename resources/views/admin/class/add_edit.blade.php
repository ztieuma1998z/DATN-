@extends('layout.main')
@section('title', 'Lớp học')

@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Lớp học</h5>
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
                            <li class="breadcrumb-item active" aria-current="page">Tạo mới lớp học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        <div class="card-header"><h3>Tạo mới lớp học</h3></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Tên lớp <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           placeholder="Nhập tên lớp"
                                           value="{{ old('name', isset($class->name) ? $class->name : '') }}"
                                    >
                                    @if($errors->has('name'))
                                        <p class="text-danger">
                                            {{$errors->first('name')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Sỹ số tối đa <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="number"
                                           class="form-control @error('population') is-invalid @enderror"
                                           name="population"
                                           placeholder="Nhập sỹ số tối đa"
                                           value="{{ old('population', isset($class->population) ? $class->population : '') }}"
                                           @if(isset($class->end_date))
                                               readonly
                                           @endif
                                    >
                                    @if($errors->has('population'))
                                        <p class="text-danger">
                                            {{$errors->first('population')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <input type="number"
                                   class="form-control hidden number-of-sessions"
                                   name="number_of_sessions"
                                   placeholder="Nhập số buổi học"
                                   value="{{ old('number_of_sessions', isset($class->number_of_sessions) ? $class->number_of_sessions : '') }}"
                            >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Khóa học <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <select name="course_id" onchange="onChangeCourse(event)" @if(isset($class->end_date)) readonly @endif class="form-control id-course @error('course_id') is-invalid @enderror">
                                        @if(!isset($class->end_date))
                                            <option value="">-----Chọn khóa học----</option>
                                        @endif
                                        @if(isset($courses))
                                            @if(isset($class->end_date))
                                                @foreach($courses as $course)
                                                    @if($course->id == $class->course_id)
                                                        <option value="{{ $course->id }}" {{ old('course_id', isset($class->course_id) ? $class->course_id : '') == $course->id  ? "selected='selected'" : " " }} >{{ $course->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ old('course_id', isset($class->course_id) ? $class->course_id : '') == $course->id  ? "selected='selected'" : " " }} >{{ $course->name }}</option>
                                                @endforeach
                                            @endif
                                        @endif
                                    </select>
                                    @if($errors->has('course_id'))
                                        <p class="text-danger">
                                            {{$errors->first('course_id')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">
                                    Ngày bắt đầu <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="date"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           name="start_date"
                                           @if(isset($class->end_date))
                                                readonly
                                           @endif
                                           placeholder="Nhập số buổi học"
                                           value="{{ old('start_date', isset($class->start_date) ? $class->start_date : '') }}"
                                    >
                                    @if($errors->has('start_date'))
                                        <p class="text-danger">
                                            {{$errors->first('start_date')}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if(isset($class->end_date))
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">
                                        Ngày kết thúc <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="date"
                                               class="form-control"
                                               readonly
                                               value="{{ $class->end_date }}"
                                        >
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Hoàn tất</button>
                            <a href="{{ route('get.class.index') }}" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function onChangeCourse(event) {
            event.preventDefault();
            courseId = event.target.value;
            $.ajax({
                url: '{{ route('get.number.of.sessions') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    courseId : courseId,
                },
                success: function(data) {
                    if (data.number) {
                        $('.number-of-sessions').removeAttr("value");
                        $(".number-of-sessions").attr("value",data.number);
                    }
                }
            });
        }
    </script>
@stop
