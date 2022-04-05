@extends('layout.main')
@section('title', 'Lớp học')

@section('content')
    <div class="container-fluid">
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
                            <li class="breadcrumb-item active" aria-current="page">Danh sách lớp học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col-12 col-md-3 card-header--col">
                    <h3>Danh sách lớp học</h3>
                </div>
                <div class="col-12 col-md-6 card-header--col">
                    <div class="card-search with-adv-search dropdown">
                        <form action="" class="w-90">
                            <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control global_filter" id="global_filter"
                                   placeholder="Tìm kiếm..">
                            <button type="submit" style="right: 10%;" class="btn btn-icon"><i class="ik ik-search"></i></button>
                            <div id="filter-table" class="btn btn-icon"><i class="ik ik-filter"></i></div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-3 card-header--col">
                    <div class="text-right">
                        <a href="{{ route('get.class.create') }}">
                            <button type="button" class="btn btn-outline-success">Tạo lớp học</button>
                        </a>
                    </div>
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
                                    <label for="">Ngày bắt đầu từ:</label>
                                    <input type="date" name="kw_start_date" value="{{ \Request('kw_start_date') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Đến ngày:</label>
                                    <input type="date" name="kw_end_date" value="{{ \Request('kw_end_date') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trạng thái:</label>
                                    <select name="kw_status" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status') == 1 ? "selected='selected'" : "" }} value="1">Hoạt động</option>
                                        <option {{ \Request::get('kw_status') == 2 ? "selected='selected'" : "" }} value="2">Ngừng hoạt động</option>
                                        <option {{ \Request::get('kw_status') == 3 ? "selected='selected'" : "" }} value="3">Chưa xếp lịch</option>
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
                        <th width="10">STT</th>
                        <th>Tên lớp</th>
                        <th>Khóa học</th>
                        <th>Số học sinh</th>
                        <th>Số buổi học</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th class="nosort">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($classes))
                        @foreach($classes as $key => $class)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ isset($class->course->name) ? $class->course->name : '[N/A]' }}</td>
                                <td>{{ isset($class->classStudent) ? count($class->classStudent) : 0 }}/{{ $class->population }}</td>
                                <td>{{ $class->number_of_sessions }}</td>
                                <td>{{ date('d-m-Y',strtotime($class->start_date)) }}</td>
                                <td>
                                    @if(!empty($class->end_date))
                                        {{ date('d-m-Y',strtotime($class->end_date)) }}
                                    @else
                                        <strong class="text-primary">Chưa xếp lịch</strong>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($class->end_date) && $class->end_date < $today)
                                        <span class="badge badge-pill badge-danger mb-1">Ngừng hoạt động</span>
                                    @else
                                        @if(!empty($class->end_date))
                                            <span class="badge badge-pill badge-success mb-1">Hoạt động</span>
                                        @else
                                            <span class="badge badge-pill badge-primary mb-1">Chưa xếp lịch</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($class->end_date) && $class->end_date < $today)
                                        <a href="javascript:void(0)"
                                           class="text-primary show-list-student-by-class"
                                           data-toggle="modal"
                                           data-target="#exampleModalCenter"
                                           data-id-class="{{ $class->id }}"
                                           data-name-class="{{ $class->name }}"
                                        >
                                            xem danh sách học sinh
                                        </a>
                                    @else
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Chi tiết <i class="ik ik-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="{{ route('get.class.edit', $class->id) }}"><i class="ik ik-edit f-16 mr-5 text-warning"></i> &nbsp; Sửa</a>
                                                @if(!empty($class->end_date))
                                                    <a class="dropdown-item" href="{{ route('get.studentbyclass.index',$class->id) }}"><i class="ik ik-list f-16 mr-5 text-warning"></i> &nbsp; Danh sách học sinh</a>
                                                    <a class="dropdown-item" href="{{ route('get.class.schedule.index', $class->id) }}"><i class="ik ik-file-text f-16 mr-5 text-warning"></i> &nbsp; Lịch học & điểm danh</a>
                                                @endif
                                            </div>
                                        </div>
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
    {{--   list student by class --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-list-student" role="document">
            <div class="modal-content">
                <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample forms-teaching-schedule">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                            <strong class="title-modal-teaching-schedule">Danh sách học sinh lớp : <span class="name-class"></span></strong>
                        </h5>
                        <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content-list-student-by-class">

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
    {{--    end list student by class--}}
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $(".show-list-student-by-class").click(function(e){
                e.preventDefault();
                let classId = $(this).attr("data-id-class");
                let nameClass = $(this).attr("data-name-class");

                $('.name-class').text(nameClass);

                $.ajax({
                    url: '{{ route('list.student.by.class') }}',
                    type:'POST',
                    data: {
                        _token : '{{ csrf_token() }}',
                        classId : classId,
                    },
                    success: function(data) {
                        if (data.html) {
                            $('.content-list-student-by-class').html(data.html);
                        }
                    }
                });
            });
        });
    </script>
@stop
