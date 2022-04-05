@extends('frontend.layout.main')

@section('banner')
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    Giới thiệu
                </h1>
                <p class="text-white link-nav">
                    <a href="{{ route('get.home.page') }}">Trang chủ </a>
                    <span class="lnr lnr-arrow-right"></span>
                    <a href="{{ route('get.about.page') }}"> Giới thiệu</a>
                </p>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="info-area pt-120 pb-120">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 no-padding info-area-left">
                    <img class="img-fluid" src="{{ isset($about->image) ? asset('storage/'.$about->image) : asset('admins/img/default-image.jpg') }}" alt="" />
                </div>
                <div class="col-lg-6 info-area-right">
                    <h1>{{ isset($about->title) ? $about->title : ''}}</h1>
                    <p>
                        {!! isset($about->content) ? $about->content : '' !!}
                    </p>
                </div>
            </div>
        </div>
    </section>
@stop

