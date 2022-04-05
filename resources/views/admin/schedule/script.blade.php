<script>
    function optionShift(event, weekdayId) {
        var shiftJson = <?php echo isset($shifts) ? json_encode($shifts) : [] ?>;
        var id = event.target.value;
        if (shiftJson.length > 0 && id) {
            shiftJson.forEach((value)=>{
                if(value.id == id){
                    $(`.time-start-${weekdayId}`).val(value.start_at);
                    $(`.time-end-${weekdayId}`).val(value.end_at);
                }
            })
        }else {
            $(`.time-start-${weekdayId}`).val('');
            $(`.time-end-${weekdayId}`).val('');
        }
    }

    function checkShiftByRoom(event, classId, weekdayId) {
        var id = event.target.value;
        $(`.time-start-${weekdayId}`).val('');
        $(`.time-end-${weekdayId}`).val('');
        $.ajax({
            url: '{{ route('check.shift.by.room') }}',
            type:'POST',
            data: {
                _token : '{{ csrf_token() }}',
                id : id,
                classId: classId,
                weekdayId: weekdayId
            }
        }).done(function(result) {
            if(result.html) {
                $('.list-shift-by-room-'+weekdayId).html(result.html);
            }
        });
    }

    $(document).ready(function() {
        $('.show-modal-schedule').click(function (event) {
            event.preventDefault();
            let $this = $(this);
            let id = $this.attr('data-id');
            $("form").removeAttr("form-data-id");
            $("form").attr("form-data-id",id);
            $.ajax({
                url: '{{ route('get.ajax.class') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    id : id,
                }
            }).done(function(result) {
                if(result.class) {
                    $('.name-class').text(result.class.name);
                    $('.name-course').text(result.class.course.name);
                    $('.start-date-class').text(result.class.start_date);
                    $('.number-of-sessions').text(result.class.number_of_sessions);
                    $('.schedule-modal-content').html(result.html);
                }
            });
        })

        $('.show-view-schedule').click(function (event) {
            event.preventDefault();
            let $this = $(this);
            let id = $this.attr('data-class-id');

            $.ajax({
                url: '{{ route('get.schedule.view') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    id : id,
                }
            }).done(function(result) {
                if(result.class) {
                    $('.name-class-view-schedule').text(result.class.name);
                    $('.content-schedule-view').html(result.html);
                }
            });
        })

        $(".btn-submit").click(function(e){
            e.preventDefault();
            let classId = $("form").attr("form-data-id");
            let data = $('form.form-create-schedule').serializeArray();
            data = [...data, {"name" : "classId", "value" : classId}];

            $.ajax({
                url: window.location.href,
                type:'POST',
                data: data,
                success: function(data) {
                    if(data.success){
                        location.reload();
                    }

                    if(data.error) {
                        $('.text-danger-modal').empty();
                        $('select').removeClass("is-invalid");
                        $('.error-form-schedule').text(data.error);
                    }

                    if(data.errorField){
                        $('.text-danger-modal').empty();
                        $('select').removeClass("is-invalid");
                        data.errorField.forEach((value)=>{
                            if(value.name == 'room') {
                                $('.error-room-'+value.key).text("Vui lòng chọn phòng học");
                                $('.error-room-'+value.key).parent().find('select').addClass("is-invalid");
                            }else {
                                $('.error-shift-'+value.key).text("Vui lòng chọn ca học");
                                $('.error-shift-'+value.key).parent().find('select').addClass("is-invalid");
                            }
                        })
                    }
                }
            });
        });

        $('.change-schedule-modal').click(function (event) {
            event.preventDefault();
            let $this = $(this);
            let id = $this.attr('data-change-schedule-id');
            $("form").removeAttr("form-data-id");
            $("form").attr("form-data-id",id);
            $.ajax({
                url: '{{ route('show.modal.change.schedule') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    id : id,
                }
            }).done(function(result) {
                if(result.html && result.class) {
                    $('.list-date-schedule').html(result.html);
                    $('.name-class-modal-change-schedule').text(result.class.name);
                }
            });
        })

        $('.submit-change-schedule').click(function (event) {
            event.preventDefault();
            let classId = $("form").attr("form-data-id");
            let data = $('form.forms-change-schedule').serializeArray();
            data = [...data, {"name" : "classId", "value" : classId}];
            let dateFrom = $('select[name="date_from"]');
            let dateTo = $('input[name="date_to"]');
            let room = $('select[name="room"]');
            let shift = $('select[name="shift"]');

            let today = new Date();
            let date = today.getFullYear()+'-'+((today.getMonth()+1) < 10 ? '0'+(today.getMonth()+1) : (today.getMonth()+1))+'-'+ (today.getDate() < 10 ? '0'+today.getDate() : today.getDate());

            if (date < dateTo.val()) {
                if(dateFrom.val() && dateTo.val() && room.val() && shift.val()) {
                    $.ajax({
                        url: '{{ route('post.change.schedule') }}',
                        type:'POST',
                        data: data,
                        success: function(data) {
                            if(data.success){
                                location.reload();
                            }

                            if(data.error) {
                                location.reload();
                            }

                            if(data.errorSameSchedule) {
                                $('.error-same-schedule-teacher').text(data.errorSameSchedule);
                            }
                        }
                    });
                }else {
                    if(!dateFrom.val()) {
                        $('.error-date-from').text('Vui lòng chọn ngày muốn nhập');
                        dateFrom.addClass("is-invalid");
                    }

                    if(!dateTo.val()) {
                        $('.error-date-to').text('Vui lòng chọn ngày chuyển sang');
                        dateTo.addClass("is-invalid");
                    }

                    if(!room.val()) {
                        $('.error-room-change-schedule').text('Vui lòng chọn phòng học');
                        room.addClass("is-invalid");
                    }

                    if(!shift.val()) {
                        $('.error-shift-change-schedule').text('Vui lòng chọn ca học');
                        shift.addClass("is-invalid");
                    }
                }
            }else {
                $('.error-date-to').text('Ngày chuyển phải lớn hơn hôm nay');
                dateTo.addClass("is-invalid");
            }
        })

        $("#exampleModalCenter").on("hidden.bs.modal", function () {
            $('.forms-sample').trigger('reset')
            $('.text-danger-modal').empty();
            $('select').removeClass("is-invalid");
        });

        $("#exampleModalCenter2").on("hidden.bs.modal", function () {
            $('.forms-sample').trigger('reset')
            $('.error-change-schedule').empty();
            $('select').removeClass("is-invalid");
            $('input').removeClass("is-invalid");
            $('.form-room-shift').html('');
        });

    });

    function changeDateFrom() {
        $('select[name="date_from"]').removeClass("is-invalid");
        $('.error-date-from').text('');
    }

    function changeDateTo() {
        let dateTo = $('input[name="date_to"]');
        dateTo.removeClass("is-invalid");
        $('.error-date-to').text('');

        let today = new Date();
        let date = today.getFullYear()+'-'+((today.getMonth()+1) < 10 ? '0'+(today.getMonth()+1) : (today.getMonth()+1))+'-'+ (today.getDate() < 10 ? '0'+today.getDate() : today.getDate());

        if (dateTo.val() && date < dateTo.val()) {
            dateTo = dateTo.val();
            let classId = $("form").attr("form-data-id");

            $.ajax({
                url: '{{ route('change.schedule.by.date.to') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    dateTo : dateTo,
                    classId : classId
                },
                success: function(data) {
                    if (data.html) {
                        $('.form-room-shift').html(data.html);
                    }
                }
            });
        }else {
            $('.form-room-shift').html("");
        }
    }

    function changeRoom(dateTo) {
        let room = $('select[name="room"]');
        room.removeClass("is-invalid");
        $('.error-room-change-schedule').text('');

        if (room.val()) {
            let roomId = room.val();
            let classId = $("form").attr("form-data-id");

            $.ajax({
                url: '{{ route('change.schedule.check.shift.by.room') }}',
                type:'POST',
                data: {
                    _token : '{{ csrf_token() }}',
                    roomId : roomId,
                    classId : classId,
                    dateTo : dateTo
                },
                success: function(data) {
                    if (data.html) {
                        $('.change-schedule-check-shift-by-room').html(data.html);
                    }
                }
            });
        }

    }

    function changeShift(){
        $('select[name="shift"]').removeClass("is-invalid");
        $('.error-shift-change-schedule').text('');
    }

</script>
