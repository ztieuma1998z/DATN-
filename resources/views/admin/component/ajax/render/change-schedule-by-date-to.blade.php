@if(isset($scheduleSameAll))
    <div class="col-md-12">
        <div class="form-group">
            <p class="text-danger error-change-schedule">Vui lòng chọn ngày khác hiện tại ngày này đã kín lịch</p>
        </div>
    </div>
@endif


@if(isset($notScheduleSameAll))
    <div class="col-md-12">
        <div class="form-group">
            <label for=""><strong>Phòng học trống</strong></label>
            <select name="room" onchange="changeRoom('{{ $dateTo }}')" class="form-control">
                <option value="">Chọn phòng</option>
                @if(isset($rooms))
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger error-change-schedule error-room-change-schedule"></p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group change-schedule-check-shift-by-room">
            <label for=""><strong>Ca học trống</strong></label>
            <select name="shift" onchange="changeShift()" class="form-control">
                <option value="">Chọn ca</option>
                @if(isset($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger error-change-schedule error-shift-change-schedule"></p>
        </div>
    </div>
@endif

@if(isset($isCheckRoom))
    <div class="col-md-12">
        <div class="form-group">
            <label for=""><strong>Phòng học trống</strong></label>
            <select name="room" onchange="changeRoom('{{ $dateTo }}')" class="form-control">
                <option value="">Chọn phòng</option>
                @if(isset($rooms))
                    @foreach($rooms as $room)
                        @if(isset($checkRoom) && in_array($room->id, $checkRoom))
                            <option disabled>{{ $room->name }} ( không còn ca trống )</option>
                        @else
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
            <p class="text-danger error-change-schedule error-room-change-schedule"></p>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group change-schedule-check-shift-by-room">
            <label for=""><strong>Ca học trống</strong></label>
            <select name="shift" onchange="changeShift()" class="form-control">
                <option value="">Chọn ca</option>
                @if(isset($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger error-change-schedule error-shift-change-schedule"></p>
        </div>
    </div>
@endif

