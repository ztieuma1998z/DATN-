@extends('layout.main')
@section('title', 'Giới thiệu')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-align-justify bg-blue"></i>
                        <div class="d-inline">
                            <h5>Giới thiệu</h5>
                            <span>Quản lý giới thiệu trung tâm</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header row">
                <div class="col col-sm-3">
                    <h3>Trang giới thệu trung tâm</h3>
                </div>
                <div class="col col-sm-6">
                </div>
                <div class="col col-sm-3">
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th width="15%">Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($aboutPages))
                        @foreach($aboutPages as $key => $aboutPage)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $aboutPage->title }}</td>
                                <td>{!! $aboutPage->content !!}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$aboutPage->image) }}"
                                         class="list-thumbnail responsive border-0" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('get.about.edit', $aboutPage->id) }}">
                                        <button type="button" class="btn btn-outline-primary">
                                            <i class="ik ik-edit f-16 mr-5 text-primary"></i>
                                            Sửa
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
