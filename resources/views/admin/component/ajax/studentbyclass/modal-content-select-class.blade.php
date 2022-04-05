<table class="table table-bordered text-center">
    <thead>
    <tr>
        <th>Tên lớp</th>
        <th>Ngày bắt đầu</th>
        <th>Ngày kết thúc</th>
        <th>Khóa học</th>
        <th width="40%">Thời gian học</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ isset($class->name) ? $class->name : '[N/A]' }}</td>
        <td>{{ isset($class->start_date) ? date('d-m-Y',strtotime($class->start_date)) : "[N/A]" }}</td>
        <td>{{ isset($class->end_date) ? date('d-m-Y',strtotime($class->end_date)) : "[N/A]" }}</td>
        <td>{{ isset($class->course->name) ? $class->course->name : "[N/A]" }}</td>
        <td>
            <div class="row">
                @if(isset($schedules))
                    @foreach($schedules as $schedule)
                        <div class="col-12">
                            Phòng {{ $schedule['room']['name'] }} - {{ $schedule['weekday']['name'] }} - {{ $schedule['shift']['name'] }} ( {{ $schedule['shift']['start_at'] }} - {{ $schedule['shift']['end_at'] }} )
                        </div>
                    @endforeach
                @endif
            </div>
        </td>
    </tr>
    </tbody>
</table>
