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
                            <h5>Xếp lịch học</h5>
                            <span>Quản lý lịch học của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">lịch học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Xếp lịch học thep lớp</h3>
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
                                    <label for="">Trạng thái:</label>
                                    <select name="kw_status" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status') == 1 ? "selected='selected'" : "" }} value="1">Đã xếp lịch</option>
                                        <option {{ \Request::get('kw_status') == "0" ? "selected='selected'" : "" }} value="0">Chưa xếp lịch</option>
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
                        <th>Số học sinh</th>
                        <th>Số buổi học</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($classes))
                            @foreach($classes as $key => $class)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $class->name }}
                                    </td>
                                    <td>{{ isset($class->course->name) ? $class->course->name : '[N/A]' }}</td>
                                    <td>{{ isset($class->classStudent) ? count($class->classStudent) : 0 }}/{{ $class->population }}</td>
                                    <td>{{ $class->number_of_sessions }}</td>
                                    <td>{{ date('d-m-Y',strtotime($class->start_date)) }}</td>
                                    <td>
                                        @if(count($class->schedule) > 0)
                                            <strong class="text-success">
                                                Đã xếp
                                            </strong>
                                        @else
                                            <strong class="text-danger">
                                                Chưa xếp lịch
                                            </strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if(count($class->schedule) > 0)
                                            <button type="button"
                                                    class="btn btn-outline-primary show-view-schedule"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalCenter1"
                                                    data-class-id="{{ $class->id }}"
                                            >
                                                Xem lịch
                                            </button>
                                            @if($class->start_date <= $today)
                                                <button type="button"
                                                        class="btn btn-outline-primary change-schedule-modal"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalCenter2"
                                                        data-change-schedule-id="{{ $class->id }}"
                                                >
                                                    Chuyển lịch
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="btn btn-outline-warning show-modal-edit-schedule"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalCenterUpdate"
                                                        data-edit-schedule-id="{{ $class->id }}"
                                                >
                                                    Sửa lịch
                                                </button>
                                                <button type="button"
                                                        class="btn btn-outline-primary change-schedule-modal"
                                                        data-toggle="modal"
                                                        data-target="#exampleModalCenter2"
                                                        data-change-schedule-id="{{ $class->id }}"
                                                >
                                                    Chuyển lịch
                                                </button>
                                            @endif
                                        @else
                                            <button type="button"
                                                    class="btn btn-outline-danger show-modal-schedule"
                                                    data-toggle="modal"
                                                    data-target="#exampleModalCenter"
                                                    data-id="{{ $class->id }}"
                                            >
                                                Xếp lịch
                                            </button>
                                        @endif
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

    {{--    start modal full window create schedule --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample form-create-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel"><strong>Xếp lịch học</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div class="blog-header-content d-flex justify-content-between mb-25">
                            <strong>
                                Tên lớp: <span class="name-class"></span>
                            </strong>
                            <strong>
                                Khóa học: <span class="name-course"></span>
                            </strong>
                            <strong>
                                Số buổi học: <span class="number-of-sessions"></span>
                            </strong>
                            <strong>
                                Ngày bắt đầu: <span class="start-date-class"></span>
                            </strong>
                        </div>
                        <div class="schedule-modal-content">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-form-schedule text-danger-modal"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary btn-cancel-form" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-primary btn-submit">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal full window create schedule --}}

    {{--     start modal full window view schedule --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter1" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <strong>Lịch học lớp : <span class="name-class-view-schedule"></span></strong>
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content-schedule-view">

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
    {{--    end modal full window view schedule --}}

    {{--    start modal full window change schedule --}}
    <div class="modal fade bd-example-modal" id="exampleModalCenter2" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample forms-change-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <strong>Chuyển lịch học lớp : <span class="name-class-modal-change-schedule"></span></strong>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group list-date-schedule">

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><strong>Ngày chuyển sang</strong></label>
                                <input type="date" oninput="changeDateTo()" name="date_to" class="form-control">
                                <p class="text-danger error-change-schedule error-date-to"></p>
                            </div>
                        </div>
                        <div class="form-room-shift">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-same-schedule-teacher"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-primary submit-change-schedule">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal full window change schedule --}}

    {{--    start modal full window create schedule --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenterUpdate" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample form-edit-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel"><strong>Sửa lịch học</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div class="blog-header-content d-flex justify-content-between mb-25">
                            <strong>
                                Tên lớp: <span class="name-class"></span>
                            </strong>
                            <strong>
                                Khóa học: <span class="name-course"></span>
                            </strong>
                            <strong>
                                Số buổi học: <span class="number-of-sessions"></span>
                            </strong>
                            <strong>
                                Ngày bắt đầu: <span class="start-date-class"></span>
                            </strong>
                        </div>
                        <div class="schedule-modal-content">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <strong class="text-danger error-form-edit-schedule text-danger-modal"></strong>
                        <div class="action">
                            <button type="button" class="btn btn-secondary btn-cancel-form" data-dismiss="modal">Thoát</button>
                            <button type="submit" class="btn btn-primary btn-submit-edit-schedule">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--    end modal full window create schedule --}}

@stop

@section('js')
    @include('admin.schedule.script')
    <script>
        $(document).ready(function() {
            $('.show-modal-edit-schedule').click(function (event) {
                event.preventDefault();
                let $this = $(this);
                let id = $this.attr('data-edit-schedule-id');
                $("form.form-edit-schedule").removeAttr("form-edit-schedule-id");
                $("form.form-edit-schedule").attr("form-edit-schedule-id",id);
                $.ajax({
                    url: '{{ route('show.modal.edit.schedule') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        id : id,
                    }
                }).done(function(result) {
                    if(result.class) {
                        $('.name-class').text(result.class.name);
                        $('.name-course').text(result.class.course.name);
                        $('.start-date-class').text(result.class.start_date);
                        $('.number-of-sessions').text(result.class.number_of_sessions);
                        $('.schedule-modal-content').html(result.html);
                    }
                });
            })

            $(".btn-submit-edit-schedule").click(function(e){
                e.preventDefault();
                let classId = $("form.form-edit-schedule").attr("form-edit-schedule-id");
                let data = $('form.form-edit-schedule').serializeArray();
                data = [...data, {"name" : "classId", "value" : classId}];

                $.ajax({
                    url: window.location.href,
                    type:'POST',
                    data: data,
                    success: function(data) {
                        if(data.success){
                            location.reload();
                        }

                        if(data.error) {
                            $('.text-danger-modal').empty();
                            $('select').removeClass("is-invalid");
                            $('.error-form-edit-schedule').text(data.error);
                        }

                        if(data.errorField){
                            $('.text-danger-modal').empty();
                            $('select').removeClass("is-invalid");
                            data.errorField.forEach((value)=>{
                                if(value.name == 'room') {
                                    $('.error-room-'+value.key).text("Vui lòng chọn phòng học");
                                    $('.error-room-'+value.key).parent().find('select').addClass("is-invalid");
                                }else {
                                    $('.error-shift-'+value.key).text("Vui lòng chọn ca học");
                                    $('.error-shift-'+value.key).parent().find('select').addClass("is-invalid");
                                }
                            })
                        }
                    }
                });
            });
        })
    </script>
@stop

