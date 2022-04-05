<table class="table text-center">
    <thead>
        <tr>
            <th width="10">STT</th>
            <th>Ảnh</th>
            <th>Mã HS</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Ngày sinh</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($students))
            @foreach($students as $key => $student)
                <tr>
                    <td width="10">{{ $key + 1 }}</td>
                    <td>
                        @if(isset($student->student->avatar))
                        <img class="img-user" src="{{ isset($student->student->avatar) ? asset('storage/'.$student->student->avatar) : asset('admins/img/default-image.jpg') }}" alt="user">
                        @else
                            <span>[N/A]</span>
                        @endif
                    </td>
                    <td>{{ isset($student->student->code) ? $student->student->code : "[N/A]" }}</td>
                    <td>{{ isset($student->student->full_name) ? $student->student->full_name : "[N/A]" }}</td>
                    <td>{{ isset($student->student->gender) ? ($student->student->gender == 1 ? "Nam" : "Nữ") : "[N/A]" }}</td>
                    <td>{{ isset($student->student->email) ? $student->student->email : "[N/A]" }}</td>
                    <td>{{ isset($student->student->phone) ? $student->student->phone : "[N/A]" }}</td>
                    <td>{{ isset($student->student->birth_date) ? date('d-m-Y',strtotime($student->student->birth_date)) : "[N/A]" }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
