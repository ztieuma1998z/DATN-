@extends('layout.main')
@section('title', 'Khóa học')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Khóa học</h5>
                            <span>Quản lý khóa học của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách khóa học</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Danh sách khóa học</h3>
                </div>
                <div class="col col-sm-6">
                    <div class="card-search with-adv-search dropdown">
                        <form action="" class="w-90">
                            <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control global_filter" id="global_filter"
                                   placeholder="Tìm kiếm...">
                            <button type="submit" style="right: 10%;" class="btn btn-icon"><i class="ik ik-search"></i></button>
                            <div id="filter-table" class="btn btn-icon"><i class="ik ik-filter"></i></div>
                        </form>
                    </div>
                </div>
                <div class="col col-sm-3">
                    <div class="text-right">
                        <a href="{{ route('get.course.create') }}">
                            <button type="button" class="btn btn-outline-success">Tạo khóa học</button>
                        </a>
                    </div>
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none;margin: auto">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tên khóa học:</label>
                                    <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control" placeholder="Tên khóa học">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Chuyên ngành:</label>
                                    <select name="kw_specialized" class="form-control">
                                        <option value="">-----</option>
                                        @if(isset($specializeds))
                                            @foreach($specializeds as $specialized)
                                                <option value="{{ $specialized->id }}"
                                                    {{ \Request::get('kw_specialized') == $specialized->id ? "selected='selected'" : "" }}
                                                >
                                                    {{ $specialized->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Giá tiền từ :</label>
                                    <input type="number" name="kw_price_from" value="{{ \Request('kw_price_from') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Đến giá:</label>
                                    <input type="number" name="kw_price_to" value="{{ \Request('kw_price_to') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme" style="display: flex;margin: auto;">Tìm kiếm</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table text-center">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Ảnh</th>
                        <th>Tên khóa học</th>
                        <th>Học phí</th>
                        <th>Số buổi học</th>
                        <th>Chuyên ngành</th>
                        <th>Ngày tạo</th>
                        <th class="nosort">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($courses))
                            @foreach($courses as $key => $course)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ isset($course->thumbnail) ? asset('storage/'.$course->thumbnail) : asset('admins/img/default-image.jpg') }}"
                                             class="list-thumbnail responsive border-0" alt="">
                                    </td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ number_format($course->price,0,',','.') }}Vnđ</td>
                                    <td>{{ $course->number_of_sessions }}</td>
                                    <td>{{ isset($course->specialized->name) ? $course->specialized->name : "" }}</td>
                                    <td>{{ $course->created_at->format('d-m-Y') }}</td>
                                    <td>
{{--                                        <a href="">--}}
{{--                                            <button type="button" class="btn btn-outline-info">--}}
{{--                                                <i class="ik ik-edit f-16"></i>--}}
{{--                                                Chi tiết--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
                                        <a href="{{ route('get.course.edit',$course->id) }}">
                                            <button type="button" class="btn btn-outline-warning">
                                                <i class="ik ik-edit f-16"></i>
                                                Sửa
                                            </button>
                                        </a>
{{--                                        <a onclick="deleteCate(event)" href="{{ route('get.course.delete',$course->id) }}">--}}
{{--                                            <button type="button" class="btn btn-outline-danger">--}}
{{--                                                <i class="ik ik-trash-2 f-16"></i>--}}
{{--                                                Xóa--}}
{{--                                            </button>--}}
{{--                                        </a>--}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ isset($courses) ? $courses->links() : '' }}
                </div>
            </div>
        </div>
    </div>
@stop








{{--@section('js')--}}
{{--    <script type="text/javascript">--}}
{{--        function deleteCate(event) {--}}
{{--            event.preventDefault();--}}
{{--            var url = event.target.parentElement.getAttribute("href");--}}
{{--            console.log(url)--}}
{{--            Swal.fire({--}}
{{--                title: 'Bạn có chắc muốn xóa?',--}}
{{--                text: "Vui lòng chọn ok hoặc cancel !",--}}
{{--                icon: 'warning',--}}
{{--                showCancelButton: true,--}}
{{--                confirmButtonColor: '#3085d6',--}}
{{--                cancelButtonColor: '#d33',--}}
{{--                confirmButtonText: 'Ok'--}}
{{--            }).then((result) => {--}}
{{--                if (result.value) {--}}
{{--                    window.location.href = url--}}
{{--                }--}}
{{--            })--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
