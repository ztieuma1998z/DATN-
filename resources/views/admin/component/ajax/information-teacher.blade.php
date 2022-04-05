<table class="table table-bordered text-center">
    <thead>
    <tr>
        <th>Ảnh</th>
        <th>Mã giáo viên</th>
        <th>Họ tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Ngày sinh</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td> <img class="img-user" src="{{ isset($teacher->avatar) ? asset('storage/'.$teacher->avatar) : asset('admins/img/default-image.jpg') }}" alt="user"></td>
        <td>{{ isset($teacher->code) ? $teacher->code : "[N/A]" }}</td>
        <td>{{ isset($teacher->full_name) ? $teacher->full_name : "[N/A]" }}</td>
        <td>
            {{ isset($teacher->phone) ? $teacher->phone : "[N/A]" }}
        </td>
        <td>
            {{ isset($teacher->email) ? $teacher->email : "[N/A]" }}
        </td>
        <td>
            {{ isset($teacher->birth_date) ? date('d-m-Y',strtotime($teacher->birth_date)) : "[N/A]" }}
        </td>
    </tr>
    </tbody>
</table>
<div class="col-md-12 p-0">
    <h5 class="text-primary mb-10">
        <strong>Danh sách lớp phụ trách</strong>
    </h5>
    <div class="form-group list-date-schedule">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên Khóa học</th>
                <th>Tên lớp</th>
                <th>Số buổi học</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($classes))
                @foreach($classes as $key => $class)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $class->course->name }}</td>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->number_of_sessions }}</td>
                        <td>{{ date('d-m-Y',strtotime($class->start_date)) }}</td>
                        <td>{{ date('d-m-Y',strtotime($class->end_date)) }}</td>
                        <td>
                            @if($class->end_date<$today)
                                <span class="badge badge-pill badge-primary mb-1">Đã dạy</span>

                            @else
                                <span class="badge badge-pill badge-success mb-1">Đang dạy</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <strong>Chưa có lớp phụ trách</strong>
            @endif
            </tbody>
        </table>
    </div>
</div>


