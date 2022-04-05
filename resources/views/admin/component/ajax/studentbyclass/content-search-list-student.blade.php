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
