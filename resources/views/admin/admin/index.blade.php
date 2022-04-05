@extends('layout.main')
@section('title', 'Admin')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Quản trị viên</h5>
                            <span>Quản lý quản trị viên của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách quản trị viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Danh sách quản trị viên</h3>
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
                        <a href="{{ route('get.admin.create') }}">
                            <button type="button" class="btn btn-outline-success">Thêm quản trị viên</button>
                        </a>
                    </div>
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none;margin: auto">
                    <form method="get" action="">
                        <div class="row">
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
                            <th width="10">ID</th>
                            <th>Ảnh</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($admins))
                            @foreach($admins as $key => $admin)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img class="img-user" src="{{ isset($admin->avatar) ? asset('storage/'.$admin->avatar) : "admins/img/default-image.jpg" }}" alt="user">
                                    </td>
                                    <td>
                                        {{ $admin->full_name }}
                                    </td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <a href="{{ route('get.admin.action',['status',$admin->id]) }}"
                                           class="badge badge-pill mb-1 {{ $admin->getStatus($admin->status)['class'] }}">
                                            <i class="fas {{ $admin->getStatus($admin->status)['icon'] }}"></i>
                                            {{ $admin->getStatus($admin->status)['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('get.admin.edit', $admin->id) }}"><i class="ik ik-edit f-16 mr-15 text-green"></i></a>
                                        <a onclick="deleteCate(event)" href="{{ route('get.admin.action', ['delete',$admin->id]) }}"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ isset($admins) ? $admins->links() : '' }}
                </div>
            </div>
        </div>
    </div>
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
    </script>
@endsection
