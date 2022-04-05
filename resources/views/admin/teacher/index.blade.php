@extends('layout.main')
@section('title', 'Giáo Viên')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-bell bg-blue"></i>
                    <div class="d-inline">
                        <h5>Giáo viên</h5>
                        <span>Quản lý giáo viên của trung tâm</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">danh sách giáo viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header row">
            <div class="col col-sm-3">
                <h3>Danh sách giáo viên</h3>
            </div>
            <div class="col col-sm-6">
                <div class="card-search with-adv-search dropdown">
                    <form method="get" action="" class="w-90">
                        <input type="text" name="kw_full_name" value="{{ \Request('kw_full_name') }}" class="form-control global_filter" id="global_filter"
                               placeholder="Tìm kiếm...">
                        <button type="submit" style="right: 10%;" class="btn btn-icon"><i class="ik ik-search"></i></button>
                        <div id="filter-table" class="btn btn-icon"><i class="ik ik-filter"></i></div>
                    </form>
                </div>
            </div>
            <div class="col col-sm-3">
                <div class="text-right">
                    <a href="{{ route('get.teacher.create') }}">
                        <button type="button" class="btn btn-outline-success">Thêm giáo viên</button>
                    </a>
                </div>
            </div>
            <div id="form-filter-table" class="mt-3" style="display:none;margin: auto">
                <form method="get" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Mã giáo viên:</label>
                                <input type="text" name="kw_code" value="{{ \Request('kw_code') }}" class="form-control" placeholder="Mã hs">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Trạng thái:</label>
                                <select name="kw_status" class="form-control">
                                    <option value="">-----</option>
                                    <option {{ \Request::get('kw_status') == 1 ? "selected='selected'" : "" }} value="1">Hoạt động</option>
                                    <option {{ \Request::get('kw_status') == "0" ? "selected='selected'" : "" }} value="0">Tạm ngừng</option>
                                </select>
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
                                <label for="">Giới tính:</label>
                                <select name="kw_gender" class="form-control">
                                    <option value="">-----</option>
                                    <option {{ \Request::get('kw_gender') == 1 ? "selected='selected'" : "" }} value="1">Name</option>
                                    <option {{ \Request::get('kw_gender') == "0" ? "selected='selected'" : "" }} value="0">Nữ</option>
                                </select>
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
                        <th>Mã giáo viên</th>
                        <th>Tên giáo viên</th>
                        <th>Giới tính</th>
                        <th>Chuyên ngành</th>
                        <th>Số điện thọai</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($teachers))
                    @foreach($teachers as $key => $teacher)
                    <tr>
                        <td>{{$key +1 }}</td>
                        <td>
                            <img class="img-user" src="{{ isset($teacher->avatar) ? asset('storage/'.$teacher->avatar) : asset('admins/img/default-image.jpg') }}" alt="user">
                        </td>
                        <td>{{ $teacher->code }}</td>
                        <td>{{ $teacher->full_name }}</td>
                        <td>{{ $teacher->gender == 1 ? "Nam" : "Nữ" }}</td>
                        <td>{{ isset($teacher->specialized->name) ? $teacher->specialized->name : '' }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>
                            <a href="{{ route('get.teacher.action',['status',$teacher->id]) }}"
                               class="badge badge-pill mb-1 {{ $teacher->getStatus($teacher->status)['class'] }}">
                                <i class="fas {{ $teacher->getStatus($teacher->status)['icon'] }}"></i>
                                {{ $teacher->getStatus($teacher->status)['name'] }}
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0)"
                               class="show-information-teacher"
                               data-toggle="modal"
                               data-target="#exampleModalCenter"
                               data-id-teacher="{{ $teacher->id }}"
                            >
                                <i class="f-16 mr-15 ik ik-eye text-info"></i>
                            </a>
                            <a href="{{ route('get.teacher.edit',$teacher->id) }}"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                            <a onclick="deleteCate(event)" href="{{ route('get.teacher.action', ['delete',$teacher->id]) }}"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="paginate d-flex justify-content-end">
                {{ isset($teachers) ? $teachers->links() : '' }}
            </div>
        </div>
    </div>
</div>

{{-- modal view teacher  --}}
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form role="form" action="" method="post" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title m-auto text-primary" id="exampleModalCenterLabel">
                        <strong class="title-modal-teaching-schedule">Thông tin giáo viên <span class="name-class"></span></strong>
                    </h5>
                    <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="content-information-teacher">

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
{{--    end list teacher by class--}}
@stop
@section('js')
<script type="text/javascript">
    function deleteCate(event) {
        event.preventDefault();
        var url = event.target.parentElement.getAttribute("href");
        console.log(url)
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            text: "Vui lòng chọn ok hoặc cancel !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                window.location.href = url
            }
        })
    }

    $(document).ready(function() {
        $(".show-information-teacher").click(function(e){
            e.preventDefault();
            let teacherId = $(this).attr("data-id-teacher");

            $.ajax({
                url: '{{ route('get.information.teacher') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    teacherId : teacherId,
                },
                success: function(data) {
                    if (data.html) {
                        $('.content-information-teacher').html(data.html);
                    }
                }
            });
        });
    });

</script>
@endsection
