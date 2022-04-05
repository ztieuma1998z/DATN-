@extends('layout.main')
@section('title', 'Khách hàng')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-bell bg-blue"></i>
                        <div class="d-inline">
                            <h5>Khách hàng đăng ký</h5>
                            <span>Quản lý khách hàng của trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Khách hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Danh sách khách hàng</h3>
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
                </div>
                <div id="form-filter-table" class="mt-3" style="display:none; margin: auto;padding: 0 88px;">
                    <form method="get" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tên khách hàng:</label>
                                    <input type="text" name="kw_name" value="{{ \Request('kw_name') }}" class="form-control" placeholder="Tên khách hàng">
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Email:</label>
                                    <input type="text" name="kw_email" value="{{ \Request('kw_email') }}" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Số điện thoại:</label>
                                    <input type="text" name="kw_phone" value="{{ \Request('kw_phone') }}" class="form-control" placeholder="Số điện thoại">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ngày đăng ký từ :</label>
                                    <input type="date" name="kw_date_from" value="{{ \Request('kw_date_from') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Đến ngày:</label>
                                    <input type="date" name="kw_date_to" value="{{ \Request('kw_date_to') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Người tư vấn:</label>
                                    <select name="kw_consultants" class="form-control">
                                        <option value="">-----</option>
                                        @if(isset($customers))
                                            @foreach($customers->unique('admin_id') as $customer)
                                                @if(isset($customer->admin->id))
                                                    <option value="{{ isset($customer->admin->id) ? $customer->admin->id : '' }}"
                                                        {{ \Request::get('kw_consultants') == $customer->admin->id ? "selected='selected'" : "" }}
                                                    >
                                                        {{ isset($customer->admin->full_name) ? $customer->admin->full_name : '[N/A]' }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Trạng thái:</label>
                                    <select name="kw_status" class="form-control">
                                        <option value="">-----</option>
                                        <option {{ \Request::get('kw_status') == 1 ? "selected='selected'" : "" }} value="1">Chờ tư vấn</option>
                                        <option {{ \Request::get('kw_status') == 2 ? "selected='selected'" : "" }} value="2">Đang tư vấn</option>
                                        <option {{ \Request::get('kw_status') == 3 ? "selected='selected'" : "" }} value="3">Đã tư vấn</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-theme" style="display: flex;margin: auto;">Tìm kiếm</button>
                    </form>
                </div>

            </div>
            <div class="card-body">
                <table id="example" class="table">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Khóa học đăng ký</th>
                        <th>Giá tiền khóa học</th>
                        <th>Ngày đăng ký</th>
                        <th>Người tư vấn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($customers))
                        @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $customer->full_name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ isset($customer->course->name) ? $customer->course->name : '[N/A]' }}</td>
                                <td>{{ isset($customer->course->price) ? number_format($customer->course->price,0,',','.')."Vnđ" : '[N/A]' }}</td>
                                <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                <td>{{ isset($customer->admin->full_name) ? $customer->admin->full_name : '( trống )' }}</td>
                                <td>
                                    <a href="{{ route('get.customer.status',$customer->id) }}"
                                       class="badge badge-pill mb-1 {{ $customer->getStatus($customer->status)['class'] }}">
                                        <i class="ik ik-refresh-ccw"></i>
                                        {{ $customer->getStatus($customer->status)['name'] }}
                                    </a>
                                </td>
                                <td>
                                    @if($customer->status == 3)
                                        <a onclick="deleteCate(event)" href="{{ route('get.customer.delete',$customer->id) }}">
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="ik ik-trash-2 f-16"></i>
                                                xóa
                                            </button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function deleteCate(event) {
            event.preventDefault();
            var url = event.target.parentElement.getAttribute("href");
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
