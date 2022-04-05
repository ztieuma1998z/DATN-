<div class="col col-sm-6 m-auto filter-list-student">
    <div class="card-search with-adv-search dropdown">
        <form action="" class="w-90 search-list-student">
            @csrf
            <input type="text" name="keyword" class="form-control global_filter" id="global_filter"
                   placeholder="Tìm kiếm...">
            <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
            <div id="filter-table1" class="btn btn-icon"><i class="ik ik-filter"></i></div>
        </form>
    </div>
</div>
<div id="form-filter-table1" class="mt-3 col-sm-8" style="display:none;margin: auto">
    <form class="filter-list-student-class" action="">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Mã số học sinh:</label>
                    <input type="text" name="kw_code" class="form-control" placeholder="nhập mã học sinh">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Họ tên :</label>
                    <input type="text" name="kw_full_name" class="form-control" placeholder="nhập họ tên">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Email :</label>
                    <input type="text" name="kw_email" class="form-control" placeholder="nhập email">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Số điện thoại :</label>
                    <input type="number" name="kw_phone" class="form-control" placeholder="nhập số điện thoại">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-theme" style="display: flex;margin: auto;">Tìm kiếm</button>
    </form>
</div>

<h5 class="modal-title" id="fullwindowModalLabel">Danh sách học sinh</h5>
<div class="card-body table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="nosort" width="10">
                    <label class="custom-control custom-checkbox m-0">
                        <input type="checkbox" class="custom-control-input" onclick="selectAll(event)" id="selectall" value="option2">
                        <span class="custom-control-label">&nbsp;</span>
                    </label>
                </th>
                <th class="nosort">Ảnh</th>
                <th>Mã học sinh</th>
                <th>Họ Tên</th>
                <th>Giới tính</th>
                <th>Số điện thọai</th>
                <th>Email</th>
                <th>Ngày sinh</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody class="content-list-student-class">
            @if(isset($students))
                @foreach($students as $student)
                    @if(isset($studentIds) && !in_array($student->id, $studentIds))
                        @if(isset($studentSameShift) && !in_array($student->id, $studentSameShift) && $student->status == 1)
                            <tr>
                                <td>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input select_all_child" name="students[]" value="{{ $student->id }}">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                </td>
                                <td>
                                    <img class="img-user" src="{{ isset($student->avatar) ? asset('storage/'.$student->avatar) : asset('admins/img/default-image.jpg') }}" alt="user">
                                </td>
                                <td>{{ $student->code }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->gender == 1 ? "Nam" : "Nữ" }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ date('d-m-Y',strtotime($student->birth_date)) }}</td>
                                <td>
                                    <a class="badge badge-success mb-1">Hoạt động</a>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#filter-table1").click(function () {
            $("#form-filter-table1").toggle("slow");
        });

        var frm = $('.search-list-student');

        var frm2 = $('.filter-list-student-class');

        frm.submit(function (e) {
            frm2.trigger('reset');
            e.preventDefault();
            let data = $(this).serializeArray();
            let classId = {{ isset($classId) ? $classId : '' }}
            data = [...data, {"name" : "classId", "value" : classId}];

            $.ajax({
                url: '{{ route('search.student.by.class') }}',
                type:'POST',
                data: data,
                success: function(data) {
                    if (data.html) {
                        $('.content-list-student-class').html(data.html);
                    }
                }
            });
        });

        frm2.submit(function (e) {
            e.preventDefault();
            frm.trigger('reset');
            let data = $(this).serializeArray();
            let classId = {{ isset($classId) ? $classId : '' }}
                data = [...data, {"name" : "classId", "value" : classId}];

            $.ajax({
                url: '{{ route('filter.student.by.class') }}',
                type:'POST',
                data: data,
                success: function(data) {
                    if (data.html) {
                        $('.content-list-student-class').html(data.html);
                    }
                }
            });
        });
    });
</script>
