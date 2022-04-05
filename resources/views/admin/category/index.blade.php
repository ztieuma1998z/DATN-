@extends('layout.main')
@section('title', 'Danh mục')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Danh mục thông báo</h5>
                            <span>Quản lý danh mục trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Danh mục thông báo</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col-12 col-md-9 card-header--col">
                    <h3>Danh sách danh mục</h3>
                </div>
                <div class="col-12 col-md-3 card-header--col">
                    <div class="text-right">
                        <a href="{{ route('get.category.create') }}">
                            <button type="button" class="btn btn-outline-success">Tạo danh mục</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th width="10">STT</th>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($categories))
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('get.category.action',['status',$category->id]) }}"
                                           class="badge badge-pill mb-1 {{ $category->getStatus($category->status)['class'] }}">
                                            <i class="fas {{ $category->getStatus($category->status)['icon'] }}"></i>
                                            {{ $category->getStatus($category->status)['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('get.category.edit',$category->id) }}">
                                            <button type="button" class="btn btn-outline-warning">
                                                <i class="ik ik-edit f-16"></i>
                                                Sửa
                                            </button>
                                        </a>
                                        <a onclick="deleteCate(event)" href="{{ route('get.category.action', ['delete',$category->id]) }}">
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="ik ik-trash-2 f-16"></i>
                                                xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script type="text/javascript">
        function deleteCate(event) {
            event.preventDefault();
            var url = event.target.parentElement.getAttribute("href");
            console.log(url)
            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: "Vui lòng chọn ok hoặc cancel !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    window.location.href = url
                }
            })
        }
    </script>
@endsection
