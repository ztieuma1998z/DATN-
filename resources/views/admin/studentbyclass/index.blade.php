@extends('layout.main')
@section('title', 'Danh sách học sinh theo lớp')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Danh sách học sinh</h5>
                            <span>Quản lý danh sách học sinh theo lớp</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">danh sách học sinh</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col-12 col-md-3 card-header--col">
                    <h3>Lớp : {{ isset($class->name) ? $class->name : ''}}</h3>
                </div>
                <div class="col-12 col-md-6 card-header--col">

                </div>
                <div class="col-12 col-md-3 card-header--col">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="m-0">
                            Sỹ số: {{ isset($classStudent) ? count($classStudent) : 0 }}/{{ isset($class->population) ? $class->population : ['N/A'] }}
                        </h3>

                        @if(isset($class->population) && isset($classStudent))
                            @if($class->population == count($classStudent))
                                <button type="button"
                                        class="btn btn-outline-success show-modal-add-student"
                                >
                                    Thêm học sinh
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-outline-success show-modal-add-student"
                                        data-toggle="modal"
                                        data-target="#fullwindowModal"
                                >
                                    Thêm học sinh
                                </button>
                            @endif
                        @else
                            <button type="button"
                                    class="btn btn-outline-success show-modal-add-student"
                                    data-toggle="modal"
                                    data-target="#fullwindowModal"
                            >
                                Thêm học sinh
                            </button>
                        @endif
                    </div>
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none; margin: auto">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Mã hs:</label>
                                    <input type="text" name="kw_code" value="{{ \Request('kw_code') }}" class="form-control" placeholder="Mã hs">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Họ Tên:</label>
                                    <input type="text" name="kw_full_name" value="{{ \Request('kw_full_name') }}" class="form-control" placeholder="Họ tên">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Số điện thọai:</label>
                                    <input type="number" name="kw_phone" value="{{ \Request('kw_phone') }}" class="form-control" placeholder="Số điện thọai">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email:</label>
                                    <input type="text" name="kw_email" value="{{ \Request('kw_email') }}" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme" style="display: flex;margin: auto;">Tìm kiếm</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Ảnh</th>
                        <th>Mã học sinh</th>
                        <th>Tên học sinh</th>
                        <th>Giới tính</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($classStudent))
                        @foreach($classStudent as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img class="img-user" src="{{ isset($value->student->avatar) ? asset('storage/'.$value->student->avatar) : "" }}" alt="user">
                                </td>
                                <td>{{ isset($value->student->code) ? $value->student->code : "[N/A]" }}</td>
                                <td>{{ isset($value->student->full_name) ? $value->student->full_name : "[N/A]" }}</td>
                                <td>{{ (isset($value->student->gender) ? $value->student->gender : "[N/A]") == 1 ? "Nam" : "Nữ" }}</td>
                                <td>{{ isset($value->student->phone) ? $value->student->phone : "[N/A]" }}</td>
                                <td>{{ isset($value->student->email) ? $value->student->email : "[N/A]" }}</td>
                                <td>
                                    <button class="btn btn-outline-primary show-modal-change-student"
                                            data-toggle="modal"
                                            data-target="#exampleModalCenter"
                                            data-id={{$value->student_id}}
                                    >
                                        <i class="ik ik-refresh-ccw"></i>
                                        Chuyển lớp
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ isset($classStudent) ? $classStudent->links() : '' }}
                </div>
            </div>
        </div>
    </div>
    {{--    modal full window--}}
    <div class="modal fade full-window-modal" id="fullwindowModal" tabindex="-1" role="dialog"
         aria-labelledby="fullwindowModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample modal-content forms-add-student">
                @csrf
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <p class="f-16 mr-25 mb-0">Tên lớp: <span>{{ isset($class->name) ? $class->name : ''}}</span></p>
                        <p class="f-16 mr-25 mb-0">khóa học: <span>{{ isset($class->course->name) ? $class->course->name : ''}}</span></p>
                        <p class="f-16 mr-25 mb-0">Sỹ số hiện tại: <span> {{ isset($classStudent) ? count($classStudent) : 0 }}/{{ isset($class->number_of_sessions) ? $class->number_of_sessions : ''}}</span></p>
                        <p class="f-16 mr-25 mb-0">Số buổi học: <span>{{ isset($class->population) ? $class->population : ''}}</span></p>
                        <p class="f-16 mr-25 mb-0">Ngày bắt đầu: <span>{{ isset($class->start_date) ? date('d-m-Y',strtotime($class->start_date)) : ''}}</span></p>
                        <p class="f-16 mr-25 mb-0">Ngày kết thúc: <span>{{ isset($class->end_date) ? date('d-m-Y',strtotime($class->end_date)) : ''}}</span></p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body content-add-student">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary btn-submit-add-student">Thêm học học sinh</button>
                </div>
            </form>
        </div>
    </div>
    {{--    end modal full window--}}

    {{--    modal change student by class --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample form-change-student-by-class">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <div class="text-center">
                                <strong>Chuyển lớp</strong>
                            </div>
                            <div class="text-center">
                                <strong>Tên học sinh: <span class="name-student"></span></strong>
                            </div>
                            <div class="text-center">
                                <strong>Mã học sinh: <span class="code-student"></span></strong>
                            </div>
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body modal-content-change-student">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-form-schedule text-danger-modal"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary btn-cancel-form" data-dismiss="modal">Thoát</button>
                            <button class="btn btn-primary btn-submit-change-student-by-class">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal change student by class --}}
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.show-modal-add-student').click(function (event) {
                event.preventDefault();
                let classId = {{ isset($class->id) ? $class->id : "" }};
                let classPopulation = {{ $class->population }};
                let classStudent = {{ count($classStudent) }};

                if (classPopulation == classStudent) {
                    Swal.fire('Lớp hiện tại không còn chỗ trống')
                }else {
                    $.ajax({
                        url: '{{ route('show.modal.add.student') }}',
                        type:'POST',
                        data: {
                            _token : '{{ csrf_token() }}',
                            classId : classId,
                        }
                    }).done(function(result) {
                        if(result.html) {
                            $('.content-add-student').html(result.html);
                        }
                    });
                }
            })

            $(".btn-submit-add-student").click(function(e){
                e.preventDefault();
                let classId = {{ isset($class->id) ? $class->id : "" }};
                let data = $('form.forms-add-student').serializeArray();
                let dataStudent = data;
                let classPopulation = {{ $class->population }};
                let classStudent = {{ count($classStudent) }};

                let result = classPopulation-classStudent;

                data = [...data, {"name" : "classId", "value" : classId}];

                if (result+1 < dataStudent.length) {
                    Swal.fire(`Bạn chỉ có thể thêm tối đa ${result} học sinh vào lớp!`)
                }else {
                    $.ajax({
                        url: '{{ route('save.student.by.class') }}',
                        type:'POST',
                        data: data,
                        success: function(data) {
                            if(data.success) {
                                location.reload();
                            }
                        }
                    });
                }
            });

            $('.show-modal-change-student').click(function (event) {
                event.preventDefault();
                let $this = $(this);
                let studentId = $this.attr('data-id');
                let classId = {{ isset($class->id) ? $class->id : "" }};

                $.ajax({
                    url: '{{ route('show.modal.change.student') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        classId : classId,
                        studentId : studentId,
                    }
                }).done(function(result) {
                    if(result.html) {
                        $('.modal-content-change-student').html(result.html);
                    }

                    if (result.student) {
                        $('.name-student').text(result.student.full_name);
                        $('.code-student').text(result.student.code);
                    }
                });
            })

            $(".btn-submit-change-student-by-class").click(function(e){
                e.preventDefault();
                let classIdCurrent = {{ isset($class->id) ? $class->id : "" }};
                let classId = $('#id-class-change-student').val();
                if(classId) {
                    let studentId = $(".form-change-student-by-class").attr('data-id-student');
                    if(studentId) {
                        $.ajax({
                            url: '{{ route('save.change.student.by.class') }}',
                            type:'POST',
                            data: {
                                _token : '{{ csrf_token() }}',
                                classIdCurrent : classIdCurrent,
                                classId : classId,
                                studentId : studentId
                            },
                            success: function(data) {
                                if (data.success) {
                                    location.reload();
                                }
                            }
                        });
                    }
                }else {
                    $('.error-change-student-by-class').text('Vui lòng chọn lớp muốn chuyển');
                    $('#id-class-change-student').addClass("is-invalid");
                }
            });
        });

        function selectAll(event) {
            let checkBoxStudent = $('.select_all_child');

            if(event.target.checked) {
                checkBoxStudent.attr('checked', true);
            }else {
                checkBoxStudent.attr('checked', false);
            }
        }

        function changeStudentClass(event, studentId) {
            $('#id-class-change-student').removeClass("is-invalid");
            let classId = event.target.value;
            if (classId) {
                $.ajax({
                    url: '{{ route('change.select.class') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        classId : classId,
                        studentId : studentId,
                        classCurrentId : {{ $class->id }},
                    }
                }).done(function(result) {
                    if(result.html) {
                        $('.error-change-student-by-class').text('');
                        $('.content-class-select').html(result.html);
                        $(".form-change-student-by-class").attr("data-id-student",result.studentId);
                    }

                    if(result.error) {
                        $('.content-class-select').html('');
                        $('.error-change-student-by-class').text(result.error);
                        $(".form-change-student-by-class").removeAttr("data-id-student");
                    }
                });
            }else {
                $(".form-change-student-by-class").removeAttr("data-id-student");
            }
        }

    </script>
@stop
