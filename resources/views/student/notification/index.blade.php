@extends('layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if(isset($categories))
                @foreach($categories as $category)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3><strong>{{ $category->name }}</strong></h3>
                            </div>
                            <div class="card-body">
                                <ul class="p-0">
                                    @if(!empty($category->notifications))
                                        @foreach($category->notifications as $notification)
                                            <li style="list-style: none">
                                                <a href="{{ route('student.notification.detail',$notification->id) }}">
                                                    <div class="desc">
                                                        <h6 class="title text-primary">
                                                            <strong>
                                                                {{ $notification->title }}
                                                            </strong>
                                                        </h6>
                                                        <p class="f-12 my-0"><em>Người đăng: {{ isset($notification->admin->full_name) ? $notification->admin->full_name : '[N/A]'  }}</em></p>
                                                        <p class="f-12"><em>Ngày đăng: {{ $notification->created_at->format('d-m-Y') }}</em></p>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@stop
