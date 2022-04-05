<div class="col-md-12">
    <div class="form-group list-date-schedule">
        <label for="">
            <strong>Lớp muốn chuyển đến</strong>
        </label>
        <select name="class_id" onchange="changeStudentClass(event, {{ $studentId }})" id="id-class-change-student" class="form-control">
            <option value="">Chọn lớp</option>
            @if(isset($classes))
                @foreach($classes as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }} - Số buổi đã học: {{$item['numberLearned']}}/{{$item['number_of_sessions']}}</option>
                @endforeach
            @endif
        </select>
        <p class="text-danger error-change-student-by-class error-date-from"></p>
        <div class="form-group content-class-select">

        </div>
    </div>
</div>
<div class="col-md-12">
    <label class="d-flex justify-content-between" for="">
        <div><strong>Thông tin lớp học hiện tại</strong></div>
        <div><strong class="text-right">Số buổi đã học: {{ isset($numberLearned) ? $numberLearned : '' }}/{{ isset($class->number_of_sessions) ? $class->number_of_sessions : '' }}</strong></div>
    </label>
    <div class="form-group list-date-schedule">
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
                        @if(isset($scheduleArr))
                            @foreach($scheduleArr as $schedule)
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
    </div>
</div>
