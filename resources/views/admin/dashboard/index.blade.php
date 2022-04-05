@extends('layout.main')
@section('title', 'Trang chủ')
@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Tổng số học sinh</h6>
                                <h2>{{ $students->count() }}</h2>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Tổng số khách hàng</h6>
                                <h2>{{ $customers1->count() }}</h2>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Tổng số lớp học</h6>
                                <h2>{{ $classes->count() }}</h2>
                            </div>
                            <div class="icon">
                                <i class="fas fa-home"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="state">
                                <h6>Tổng số bài viết</h6>
                                <h2>{{ $blogs->count() }}</h2>
                            </div>
                            <div class="icon">
                                <i class="far fa-newspaper"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Thông báo hôm nay</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body timeline">
                        <div class="header bg-theme" style="background-image: url('{{ asset('admins/img/placeholder/placeimg_400_200_nature.jpg')}}')">
                            <div class="color-overlay d-flex align-items-center">
                                <div class="day-number">{{ isset($today) ? $today['mday'] : '' }}</div>
                                <div class="date-right">
                                    <div class="day-name">{{ isset($today) ? $today['wday']==0 ? 'Chủ nhật' : 'Thứ '.($today['wday']+1) : '' }}</div>
                                    <div class="month">Tháng {{ isset($today) ? $today['mon'] : '' }} Năm {{ isset($today) ? $today['year'] : '' }}</div>
                                </div>
                            </div>
                        </div>
                        <ul>
                            @if(isset($notifications))
                                @foreach($notifications as $notification)
                                    <li>
                                        <a href="{{ route('get.notification.edit',$notification->id) }}">
                                            <div class="bullet bg-pink"></div>
                                            <div class="time">lúc {{ $notification->created_at->format('H:i') }}</div>
                                            <div class="desc">
                                                <h3 class="title text-primary f-18">
                                                    {{ isset($notification->category->name) ? $notification->category->name : '[N/A]'  }}
                                                </h3>
                                                <h4 class="title text-primary">
                                                    <strong>
                                                        {{ $notification->title }}
                                                    </strong>
                                                </h4>
                                                <p class="f-12">Người đăng: {{ isset($notification->admin->full_name) ? $notification->admin->full_name : '[N/A]'  }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card table-card">
                    <div class="card-header">
                        <h3>Khách hàng mới nhất</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>Tên khách hàng</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Khóa học đăng ký</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($customers))
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                        <img src="{{asset('admins/img/avatar-default.png')}}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                                                        <div class="d-inline-block">
                                                            <h6 style="line-height: 40px;">{{ $customer->full_name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ isset($customer->course->name) ? $customer->course->name : '[N/A]' }}</td>
                                                <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
