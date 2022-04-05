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
                                        @if(!empty($scheduleClassCurrent) && check_room_current($weekday['id'], $room['id'], $scheduleClassCurrent))
                                            <option selected value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                                        @else
                                            <option disabled >{{ $room['name'] }} ( không còn ca trống )</option>
                                        @endif
                                    @else
                                        @if(!empty($scheduleClassCurrent) && check_room_current($weekday['id'], $room['id'], $scheduleClassCurrent))
                                            <option selected value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                                        @else
                                            <option value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                                        @endif
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
                                        @if(!empty($scheduleClassCurrent) && check_shift_current($weekday['id'], $shift->id, $scheduleClassCurrent))
                                            <option selected value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @else
                                            @if(!empty($checkShiftArr) && check_shift_same($weekday['id'], $shift->id, $checkShiftArr))
                                                <option disabled >{{ $shift->name }} (đã có lớp)</option>
                                            @else
                                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                            @endif
                                        @endif
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
                    @if(!empty($scheduleClassCurrent) && check_weekday_current($weekday['id'], $scheduleClassCurrent, 'start_at'))
                        <input class="form-control time-start-{{$weekday['id']}}" value="{{ check_weekday_current($weekday['id'], $scheduleClassCurrent, 'start_at') }}" type="text" placeholder="--:--:--" readonly />
                    @else
                        <input class="form-control time-start-{{$weekday['id']}}" type="text" placeholder="--:--:--" readonly />
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    @if(!empty($scheduleClassCurrent) && check_weekday_current($weekday['id'], $scheduleClassCurrent, 'end_at'))
                        <input class="form-control time-end-{{$weekday['id']}}" value="{{ check_weekday_current($weekday['id'], $scheduleClassCurrent, 'end_at') }}" type="text" placeholder="--:--:--" readonly />
                    @else
                        <input class="form-control time-end-{{$weekday['id']}}" type="text" placeholder="--:--:--" readonly />
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
