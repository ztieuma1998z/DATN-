<label for=""><strong>Ngày muốn chuyển</strong></label>
<select name="date_from" onchange="changeDateFrom()" class="form-control">
    <option value="">Chọn ngày</option>
    @if(isset($schedules))
        @foreach($schedules as $schedule)
            <option value="{{ $schedule->id }}">
                Ngày {{ date('d-m-Y',strtotime($schedule->date)) }}
                ( {{isset($schedule->weekday->name) ? $schedule->weekday->name : '[N/A]'}} :
                {{ isset($schedule->shift->name) ? $schedule->shift->name : '[N/A]' }} )
            </option>
        @endforeach
    @endif
</select>
<p class="text-danger error-change-schedule error-date-from"></p>

