<div class="card-body table-responsive">
    <table class="table text-center">
        <thead>
            <tr>
                <th width="10">
                    STT
                </th>
                <th>Ngày</th>
                <th>Phòng</th>
                <th>Khóa học</th>
                <th>Giáo viên</th>
                <th>Ca học</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($schedules))
                @foreach($schedules as $key => $schedule)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            {{ isset($schedule->weekday->name) ? $schedule->weekday->name : '[N/A]'  }} <br>
                            {{ date('d-m-Y',strtotime($schedule->date)) }}
                        </td>
                        <td>{{ isset($schedule->room->name) ? $schedule->room->name : '[N/A]' }}</td>
                        <td>{{ isset($schedule->course->name) ? $schedule->course->name : '[N/A]' }}</td>
                        <td>
                            @if(isset($schedule->teacher->full_name))
                                {{ $schedule->teacher->full_name }}
                            @else
                                <span class="text-danger">Chưa xếp giảng viên</span>
                            @endif
                        </td>
                        <td>{{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }}</td>
                        <td>{{ isset($schedule->shift->start_at) ? $schedule->shift->start_at : '[N/A]' }} - {{ isset($schedule->shift->end_at) ? $schedule->shift->end_at : '[N/A]' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
