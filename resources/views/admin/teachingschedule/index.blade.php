@extends('layout.main')
@section('title', 'Lịch dạy')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Xếp lịch dạy</h5>
                            <span>Quản lý lịch dạy của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">lịch dạy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Xếp lịch dạy thep lớp</h3>
                </div>
                <div class="col col-sm-6">
                    <div class="card-search with-adv-search dropdown">
                        <form method="get" action="" class="w-90">
                            <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control global_filter" id="global_filter"
                                   placeholder="Tìm kiếm...">
                            <button type="submit" style="right: 10%;" class="btn btn-icon"><i class="ik ik-search"></i></button>
                            <div id="filter-table" class="btn btn-icon"><i class="ik ik-filter"></i></div>
                        </form>
                    </div>
                </div>
                <div class="col col-sm-3">
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none; margin: auto">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tên lớp:</label>
                                    <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control" placeholder="Tên lớp học">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Khóa học:</label>
                                    <select name="kw_course" class="form-control">
                                        <option value="">-----</option>
                                        @if(isset($courses))
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ \Request::get('kw_course') == $course->id ? "selected='selected'" : "" }}
                                                >
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trạng thái lịch học:</label>
                                    <select name="kw_status_schedule" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status_schedule') == 1 ? "selected='selected'" : "" }} value="1">Đã xếp lịch</option>
                                        <option {{ \Request::get('kw_status_schedule') == "0" ? "selected='selected'" : "" }} value="0">Chưa xếp lịch</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trạng thái giáo viên:</label>
                                    <select name="kw_status_teacher" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status_teacher') == 1 ? "selected='selected'" : "" }} value="1">Đã có giáo viên</option>
                                        <option {{ \Request::get('kw_status_teacher') == "0" ? "selected='selected'" : "" }} value="0">Chưa có giáo viên</option>
                                    </select>
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
                        <th class="nosort" width="10">
                            STT
                        </th>
                        <th>Tên lớp</th>
                        <th>Khóa học</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Giáo viên được phân công</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($classes))
                            @foreach($classes as $key => $class)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        {{ $class->name }}
                                    </td>
                                    <td>
                                        {{ isset($class->course->name) ? $class->course->name : '[N/A]' }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($class->start_date)) }}
                                    </td>
                                    <td>
                                        @if(!empty($class->end_date))
                                            {{ date('d-m-Y',strtotime($class->end_date)) }}
                                        @else
                                            <strong class="text-danger">Chưa xếp lịch</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($class->teacher_id))
                                            <strong class="text-success">
                                                {{ isset($class->teacher->full_name) ? $class->teacher->full_name : '[N/A]' }}
                                            </strong>
                                        @else
                                            <strong class="text-danger">Chưa có giáo viên</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($class->end_date))
                                            @if(!empty($class->teacher_id))
                                                <button type="button"
                                                        class="btn btn-outline-warning show-modal-teaching-schedule"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalCenter"
                                                        data-id="{{ $class->id }}"
                                                        data-teacher-id="{{ $class->teacher_id }}"
                                                >
                                                    Đổi giáo viên
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="btn btn-outline-primary show-modal-teaching-schedule"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalCenter"
                                                        data-id="{{ $class->id }}"
                                                >
                                                    Xếp giáo viên
                                                </button>
                                            @endif
                                        @endif
                                        <button type="button"
                                                class="btn btn-outline-primary show-detail-teaching-schedule"
                                                data-toggle="modal"
                                                data-target="#exampleModalCenter1"
                                                data-id="{{ $class->id }}"
                                        >
                                            Chi tiết
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ isset($classes) ? $classes->links() : '' }}
                </div>
            </div>
        </div>
    </div>

    {{--    modal teaching schedule--}}
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample forms-teaching-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <strong class="title-modal-teaching-schedule">Xếp giảng viên</strong>
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content-modal-teaching-schedule">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-form-schedule text-danger-modal"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary btn-cancel-form" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-primary btn-submit-teaching-schedule">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal teaching schedule--}}

    {{--    modal teaching schedule--}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter1" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample forms-teaching-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <strong class="title-detail-teaching-schedule">Chi tiết lịch dạy</strong>
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content-detail-teaching-schedule">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-form-schedule text-danger-modal"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary btn-cancel-form" data-dismiss="modal">Thoát</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal teaching schedule--}}

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.show-modal-teaching-schedule').click(function (event) {
                event.preventDefault();
                let $this = $(this);
                let id = $this.attr('data-id');
                $("form.forms-teaching-schedule").removeAttr("form-data-id");
                $("form.forms-teaching-schedule").attr("form-data-id",id);
                $(".title-modal-teaching-schedule").text("Xếp giảng viên");

                if ($(this).attr("data-teacher-id")) {
                    $(".title-modal-teaching-schedule").text("Đổi giảng viên");
                }

                $.ajax({
                    url: '{{ route('show.modal.teaching.schedule') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        id : id,
                    }
                }).done(function(result) {
                    if(result.html) {
                        $('.content-modal-teaching-schedule').html(result.html);
                    }
                });
            })

            $(".btn-submit-teaching-schedule").click(function(e){
                e.preventDefault();
                let classId = $("form.forms-teaching-schedule").attr("form-data-id");
                let data = $('form.forms-teaching-schedule').serializeArray();
                data = [...data, {"name" : "classId", "value" : classId}];
                let teacherId = $('select[name="teacher_id"]').val();

                if(teacherId) {
                    $.ajax({
                        url: '{{ route('save.modal.teaching.schedule') }}',
                        type:'POST',
                        data: data,
                        success: function(data) {
                            if (data.error) {
                                $('.error-teaching-schedule').text(data.error);
                                $('select[name="teacher_id"]').addClass("is-invalid");
                            }

                            if (data.success) {
                                location.reload();
                            }
                        }
                    });
                }else {
                    $('.error-teaching-schedule').text('Vui lòng chọn giáo viên');
                    $('select[name="teacher_id"]').addClass("is-invalid");
                }
            });

            $(".show-detail-teaching-schedule").click(function (event) {
                event.preventDefault();
                let $this = $(this);
                let id = $this.attr('data-id');

                $.ajax({
                    url: '{{ route('show.detail.teaching.schedule') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        id : id,
                    }
                }).done(function(result) {
                    if(result.html) {
                        $('.content-detail-teaching-schedule').html(result.html);
                    }
                });
            })
        });

        function changeSelectTeacher() {
            $('select[name="teacher_id"]').removeClass("is-invalid");
            $('.error-teaching-schedule').text('');
        }
    </script>
@stop
