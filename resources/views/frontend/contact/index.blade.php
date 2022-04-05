@extends('frontend.layout.main')

@section('banner')
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    Liên Hệ
                </h1>
                <p class="text-white link-nav">
                    <a href="{{ route('get.home.page') }}">Trang chủ </a>
                    <span class="lnr lnr-arrow-right"></span>
                    <a href="{{ route('get.contact.page') }}"> Liên Hệ</a>
                </p>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="contact-page-area section-gap">
        <div class="container">
            <div class="row text-center d-flex address-wrap">
                <div class="map-wrap" style="width: 100%; height: 445px;" id="map"></div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="single-contact-address">
                        <div class="icon">
                            <span class="lnr lnr-home"></span>
                        </div>
                        <div class="contact-details">
                            <h5>{{ isset($setting->address) ? $setting->address : '' }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="single-contact-address">
                        <div class="icon">
                            <span class="lnr lnr-phone-handset"></span>
                        </div>
                        <div class="contact-details">
                            <h5>{{ isset($setting->phone) ? $setting->phone : '' }}</h5>
                            <p>Thứ Hai đến Thứ Sáu, 9 giờ sáng đến 6 giờ chiều</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="single-contact-address">
                        <div class="icon">
                            <span class="lnr lnr-envelope"></span>
                        </div>
                        <div class="contact-details">
                            <h5>{{ isset($setting->email) ? $setting->email : '' }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

