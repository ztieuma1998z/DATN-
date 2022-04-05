@extends('layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>{{ $notification->title }}</strong></h3>
                    </div>
                    <div class="card-body px-4">
                        {!! $notification->content !!}
                    </div>
                    <div class="card-footer">
                        <p class="f-13 my-0"><em>Người đăng: {{ isset($notification->admin->full_name) ? $notification->admin->full_name : '[N/A]'  }}</em></p>
                        <p class="f-13 my-0"><em>Ngày đăng: {{ $notification->created_at->format('d-m-Y') }}</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
