@extends('layout.main')
@section('title', 'Lịch học')
@section('content')
    <style>
        @media (min-width: 992px) {
            .modal-lg.modal-list-student {
                max-width: 1000px;
            }
        }
    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5 style="line-height: 40px">Lớp phụ trách</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lớp phụ trách</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Danh sách lớp phụ trách</h3>
                </div>
                <div class="col col-sm-6">
                </div>
                <div class="col col-sm-3">
                </div>
            </div>
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th width="10">STT</th>
                            <th>Tên lớp</th>
                            <th>Khóa học</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trang thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($classes))
                            @foreach($classes as $key => $class)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td>
                                        {{ isset($class->course->name) ? $class->course->name : '[N/A]' }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($class->start_date)) }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($class->end_date)) }}
                                    </td>
                                    <td>
                                        @if($class->end_date < $today)
                                            <span class="badge badge-pill badge-primary mb-1">
                                                Đã dạy
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-success mb-1">
                                                Đang hoạt động
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="text-primary show-list-student-by-class"
                                                data-toggle="modal"
                                                data-target="#exampleModalCenter1"
                                                data-id-class="{{ $class->id }}"
                                                data-name-class="{{ $class->name }}"
                                        >
                                            xem danh sách học sinh
                                        </a>
                                        <a class="text-primary" href="{{ route('teacher.scheduleclass.index', $class->id) }}"> <br>
                                            xem lịch & điểm danh
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{--   list student by class --}}
    <div class="modal fade bd-example-modal-lg" id="exampleModalCenter1" tabindex="-1" role="dialog"
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
                    url: '{{ route('show.list.student.class') }}',
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
