<div class="col-md-12">
    <div class="form-group list-date-schedule">
        <label for="">
            <strong>Giáo viên được xếp</strong>
        </label>
        <select name="teacher_id" onchange="changeSelectTeacher()" class="form-control">
            <option value="">Chọn giáo viên</option>
            @if(isset($teachers))
                @foreach($teachers as $teacher)
                    @if(isset($teacherIds) && in_array($teacher->id, $teacherIds))
{{--                        <option disabled>--}}
{{--                            {{ $teacher->full_name }} - {{ $teacher->code }}--}}
{{--                            ( Chuyên ngành : {{ $teacher->specialized->name }} )--}}
{{--                            ( Giáo viên bị trùng lịch )--}}
{{--                        </option>--}}
                    @else
                        <option {{ (isset($class->teacher_id) ? $class->teacher_id : '') == $teacher->id  ? "selected='selected'" : " " }} value="{{ $teacher->id }}">
                            {{ $teacher->full_name }} - {{ $teacher->code }}
                            ( Chuyên ngành : {{ $teacher->specialized->name }} )
                        </option>
                    @endif
                @endforeach
            @endif
        </select>
        <p class="text-danger error-teaching-schedule error-date-from"></p>
    </div>
</div>
<div class="col-md-12">
    <label for="">
        <strong>Thông tin lớp học</strong>
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
                <td>{{ isset($class->name) ? $class->name : "[N/A]" }}</td>
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
