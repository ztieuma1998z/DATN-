<select onchange="optionShift(event, {{$weekdayId}})" name="shifts[]" class="form-control">
    <option value="">Chọn ca</option>
    @if(isset($shifts))
        @foreach($shifts as $shift)
            @if(isset($shift['check_shift']))
                @if(!empty($shiftArr) && in_array($shift['id'], $shiftArr))
                    <option value="{{ $shift['id'] }}">{{ $shift['name'] }}</option>
                @else
                    <option disabled >{{ $shift['name'] }} (đã có lớp)</option>
                @endif
            @else
                <option value="{{ $shift['id'] }}">{{ $shift['name'] }}</option>
            @endif
        @endforeach
    @endif
</select>
