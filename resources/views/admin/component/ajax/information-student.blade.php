<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>Ảnh</th>
            <th>Mã học sinh</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ngày sinh</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td> <img class="img-user" src="{{ isset($student->avatar) ? asset('storage'.$student->avatar) : asset('admins/img/default-image.jpg') }}" alt="user"></td>
        <td>{{ isset($student->code) ? $student->code : "[N/A]" }}</td>
        <td>{{ isset($student->full_name) ? $student->full_name : "[N/A]" }}</td>
        <td>
            {{ isset($student->phone) ? $student->phone : "[N/A]" }}
        </td>
        <td>
            {{ isset($student->email) ? $student->email : "[N/A]" }}
        </td>
        <td>
            {{ isset($student->birth_date) ? date('d-m-Y',strtotime($student->birth_date)) : "[N/A]" }}
        </td>
    </tr>
    </tbody>
</table>
<div class="col-md-12 p-0">
    <h5 class="text-primary mb-10">
        <strong>Danh sách khóa học đăng ký</strong>
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
                    @foreach($classes as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->course_name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->number_of_sessions }}</td>
                            <td>{{ date('d-m-Y',strtotime($item->start_date)) }}</td>
                            <td>{{ date('d-m-Y',strtotime($item->end_date)) }}</td>
                            <td>
                                @if($item->end_date<$today)
                                    <span class="badge badge-pill badge-primary mb-1">Đã học</span>

                                @else
                                    <span class="badge badge-pill badge-success mb-1">Đang học</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <strong>Chưa có khóa học đăng ký</strong>
                @endif
            </tbody>
        </table>
    </div>
</div>


