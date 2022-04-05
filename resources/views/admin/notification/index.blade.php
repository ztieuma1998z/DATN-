@extends('layout.main')
@section('title', 'Thông báo')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Thông báo</h5>
                            <span>Quản lý thông báo cho thành viên của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Thông báo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col-12 col-md-3 card-header--col">
                    <h3>Danh sách thông báo</h3>
                </div>
                <div class="col-12 col-md-6 card-header--col">
                    <div class="card-search with-adv-search dropdown">
                        <form action="" class="w-90">
                            <input type="text" name="kw_title" value="{{ \Request('kw_title') }}" class="form-control global_filter" id="global_filter"
                                   placeholder="Tìm kiếm..">
                            <button type="submit" style="right: 10%;" class="btn btn-icon"><i class="ik ik-search"></i></button>
                            <div id="filter-table" class="btn btn-icon"><i class="ik ik-filter"></i></div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-3 card-header--col">
                    <div class="text-right">
                        <a href="{{ route('get.notification.create') }}">
                            <button type="button" class="btn btn-outline-success">Tạo thông báo</button>
                        </a>
                    </div>
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none; margin: auto">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tiêu đề:</label>
                                    <input type="text" name="kw_title" value="{{ \Request('kw_title') }}" class="form-control" placeholder="Tiêu đề">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Danh mục:</label>
                                    <select name="kw_category" class="form-control">
                                        <option value="">-----</option>
                                        @if(isset($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ \Request::get('kw_category') == $category->id ? "selected='selected'" : "" }}
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Người đăng:</label>
                                    <select name="kw_admin" class="form-control">
                                        <option value="">-----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Trạng thái:</label>
                                    <select name="kw_status" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status') == "0" ? "selected='selected'" : "" }} value="0">Ẩn</option>
                                        <option {{ \Request::get('kw_status') == 1 ? "selected='selected'" : "" }} value="1">Hiện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Ngày đăng ký từ :</label>
                                    <input type="date" name="kw_date_from" value="{{ \Request('kw_date_from') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Đến ngày:</label>
                                    <input type="date" name="kw_date_to" value="{{ \Request('kw_date_to') }}" class="form-control">
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
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Người đăng</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($notifications))
                            @foreach($notifications as $key => $notification)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ isset($notification->category->name) ? $notification->category->name : '[N/A]'  }}</td>
                                    <td>{{ isset($notification->admin->full_name) ? $notification->admin->full_name : '[N/A]'  }}</td>
                                    <td>{{ $notification->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('get.notification.action',['status',$notification->id]) }}"
                                           class="badge badge-pill mb-1 {{ $notification->getStatus($notification->status)['class'] }}">
                                            <i class="fas {{ $notification->getStatus($notification->status)['icon'] }}"></i>
                                            {{ $notification->getStatus($notification->status)['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('get.notification.edit',$notification->id) }}">
                                            <button type="button" class="btn btn-outline-warning">
                                                <i class="ik ik-edit f-16"></i>
                                                Sửa
                                            </button>
                                        </a>
                                        <a onclick="deleteCate(event)" href="{{ route('get.notification.action', ['delete',$notification->id]) }}">
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="ik ik-trash-2 f-16"></i>
                                                xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ isset($notifications) ? $notifications->links() : '' }}
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

