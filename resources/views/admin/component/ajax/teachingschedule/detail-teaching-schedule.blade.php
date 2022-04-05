<div class="col-md-12">
    <div class="form-group list-date-schedule">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>Tên lớp</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th width="50%">Thời gian học</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ isset($class->name) ? $class->name : "[N/A]" }}</td>
                <td>{{ isset($class->start_date) ? date('d-m-Y',strtotime($class->start_date)) : "[N/A]" }}</td>
                <td>
                    @if(isset($class->end_date))
                        {{ date('d-m-Y',strtotime($class->end_date)) }}
                    @else
                        <strong class="text-danger">Chưa xếp lịch học</strong>
                    @endif
                </td>
                <td>
                    @if(!empty($scheduleArr))
                        <div class="row">
                            @foreach($scheduleArr as $schedule)
                                <div class="col-12">
                                    Phòng {{ $schedule['room']['name'] }} - {{ $schedule['weekday']['name'] }} - {{ $schedule['shift']['name'] }} ( {{ $schedule['shift']['start_at'] }} - {{ $schedule['shift']['end_at'] }} )
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <strong class="text-danger">Chưa xếp lịch học</strong>
                        </div>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>Khóa học</th>
                <th>Số học sinh</th>
                <th>Số buổi</th>
                <th>Giảng viên được xếp</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ isset($class->course->name) ? $class->course->name : "[N/A]" }}</td>
                <td>{{ isset($classStudent) ? count($classStudent) : 0 }}/{{ isset($class->population) ? $class->population : "[N/A]" }}</td>
                <td>{{ isset($class->number_of_sessions) ? $class->number_of_sessions : "[N/A]" }}</td>
                <td>
                    @if(isset($class->teacher->full_name))
                        <strong class="text-success">{{ $class->teacher->full_name }}</strong>
                    @else
                        <strong class="text-danger">Chưa có giáo viên</strong>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
