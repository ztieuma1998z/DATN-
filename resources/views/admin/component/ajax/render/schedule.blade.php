@if(isset($weekdays))
    @foreach($weekdays as $key => $weekday)
        <div class="row">
            <div class="col-md-1 p-0 text-center" style="line-height: 40px">
                <strong>{{ $weekday['name'] }}</strong>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    @if(!empty($sameSchedule) && in_array($weekday['id'], $sameSchedule))
                        <input name="rooms[]" class="form-control" type="text" placeholder="Không còn phòng trống" readonly />
                    @else
                        <select name="rooms[]" onchange="checkShiftByRoom(event, {{ $class->id }}, {{ $weekday['id'] }})" class="form-control">
                            <option value="">Chọn phòng</option>
                            @if(isset($weekday['rooms']))
                                @foreach($weekday['rooms'] as $room)
                                    @if(isset($room['check_room']))
                                        <option disabled >{{ $room['name'] }} ( không còn ca trống )</option>
                                    @else
                                        <option value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    @endif
                    <p class="text-danger text-danger-modal error-room-{{$key}}"></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="list-shift-by-room-{{ $weekday['id'] }}">
                        @if(!empty($sameSchedule) && in_array($weekday['id'], $sameSchedule))
                            <input name="shifts[]" class="form-control" type="text" placeholder="Không còn ca trống" readonly />
                        @else
                            <select onchange="optionShift(event,{{$weekday['id']}})" name="shifts[]" class="form-control">
                                <option value="">Chọn ca</option>
                                @if(isset($shifts))
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endif
                    </div>
                    <p class="text-danger text-danger-modal error-shift-{{$key}}"></p>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input class="form-control time-start-{{$weekday['id']}}" type="text" placeholder="--:--:--" readonly />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input class="form-control time-end-{{$weekday['id']}}" type="text" placeholder="--:--:--" readonly />
                </div>
            </div>
        </div>
    @endforeach
@endif
