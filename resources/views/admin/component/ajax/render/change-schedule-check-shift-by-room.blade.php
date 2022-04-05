<label for=""><strong>Ca học trống</strong></label>
<select name="shift" onchange="changeShift()" class="form-control">
    <option value="">Chọn ca</option>
    @if(isset($shifts))
        @foreach($shifts as $shift)
            @if(isset($checkShift) && in_array($shift->id, $checkShift))
                <option disabled>{{ $shift->name }} ( đã có lớp )</option>
            @else
                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
            @endif
        @endforeach
    @endif
</select>
<p class="text-danger error-change-schedule error-shift-change-schedule"></p>
