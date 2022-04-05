@extends('frontend.layout.main')

@section('banner')
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    {{ isset($blog->title) ? $blog->title : "" }}
                </h1>
                <p class="text-white link-nav">
                    <a href="{{ route('get.home.page') }}">Trang chủ </a>
                    <span class="lnr lnr-arrow-right"></span>
                    <a href="{{ route('get.blog.page') }}">Tin tức </a>
                    <span class="lnr lnr-arrow-right"></span>
                    <a href="#"> {{ isset($blog->title) ? $blog->title : "" }}</a>
                </p>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="post-content-area single-post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post row">
                        <div class="col-lg-12">
                            <div class="feature-img">
                                <img class="img-fluid" src="{{ isset($blog->thumbnail) ? asset('storage/'.$blog->thumbnail) : asset('admins/img/default-image.jpg') }}" alt="{{ $blog->title }}" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 meta-details">
                            <div class="user-details row">
                                <p class="user-name col-lg-12 col-md-12 col-6"><a href="#">{{ isset($blog->admin->full_name) ? $blog->admin->full_name : '[N/A]'  }}</a> <span
                                        class="lnr lnr-user"></span></p>
                                <p class="date col-lg-12 col-md-12 col-6"><a href="#">{{ $blog->created_at->format('d-m-Y') }}</a> <span
                                        class="lnr lnr-calendar-full"></span></p>
                                <p class="view col-lg-12 col-md-12 col-6"><a href="#">{{ $blog->view }} lượt xem</a> <span class="lnr lnr-eye"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <h3 class="mt-20 mb-20">{{ $blog->title }}</h3>
                            <p class="excert">
                                {{ $blog->description }}
                            </p>
                        </div>
                        <div class="col-lg-12">
                            <div class="row mt-30 mb-30">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 sidebar-widgets">
                    <div class="widget-wrap">
                        <div class="single-sidebar-widget popular-post-widget">
                            <h4 class="popular-title">Danh sách khóa học</h4>
                            <div class="popular-post-list">
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <div class="single-post-list d-flex flex-row align-items-center">
                                            <div class="thumb">
                                                <img class="img-fluid img-course-page-blog" src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->name }}" />
                                            </div>
                                            <div class="details">
                                                <a href="{{ route('get.course.detail', $course->id) }}">
                                                    <h6>{{ $course->name }}</h6>
                                                </a>
                                                <p class="desc-course">{{ $course->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center">
                                        <a href="{{ route('get.course.page') }}" class="primary-btn">Xem thêm</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

