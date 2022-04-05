@extends('frontend.layout.main')

@section('banner')
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="about-content col-lg-12">
                <h1 class="text-white">
                    Khóa học
                </h1>
                <p class="text-white link-nav">
                    <a href="{{ route('get.home.page') }}">Trang chủ </a>
                    <span class="lnr lnr-arrow-right"></span>
                    <a href="{{ route('get.course.page') }}"> Khóa học</a>
                </p>
            </div>
        </div>
    </div>
@stop

@section('content')
    <section class="popular-courses-area section-gap courses-page">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Danh sách khóa học</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($courses))
                        @foreach($courses as $course)
                        <div class="single-popular-carusel col-lg-3 col-md-6">
                            <div class="thumb-wrap relative">
                                <div class="thumb relative">
                                    <div class="overlay overlay-bg"></div>
                                    <img class="img-fluid" src="{{ isset($course->thumbnail) ? asset('storage/'.$course->thumbnail) : asset('admins/img/default-image.jpg') }}" alt="" />
                                </div>
                                <div class="meta d-flex justify-content-between">
                                    <h4>{{ number_format($course->price,0,',','.') }}Vnđ</h4>
                                </div>
                            </div>
                            <div class="details">
                                <a href="{{ route('get.course.detail', $course->id) }}">
                                    <h4>
                                        {{ $course->name }}
                                    </h4>
                                </a>
                                <p class="desc-course">
                                    {{ $course->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
{{--            <div class="text-center">--}}
{{--                <a href="#" class="primary-btn text-uppercase mx-auto">Xêm thêm</a>--}}
{{--            </div>--}}
        </div>
    </section>

    <section style="background:url('{{ isset($setting->banner_home) ? asset('storage/'.$setting->banner_home) : '' }}') center;background-size: cover;" class="search-course-area relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6 col-md-6 search-course-left">
                    <h1 class="text-white">
                        {{ isset($setting->banner_home_title) ? $setting->banner_home_title : '' }}
                    </h1>
                    <p>
                        {{ isset($setting->banner_home_description) ? $setting->banner_home_description : '' }}
                    </p>
                </div>
                <div class="col-lg-4 col-md-6 search-course-right section-gap">
                    <form class="form-wrap" id="register-form" method="post" action="{{ route('post.customer.register') }}">
                        @csrf
                        <h4 class="text-white pb-20 text-center mb-30">Đăng ký khóa học tại đây !</h4>
                        <input type="text"
                               class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name')}}"
                               name="full_name"
                               placeholder="Họ tên" />
                        @if($errors->has('full_name'))
                            <p class="text-danger">
                                {{$errors->first('full_name')}}
                            </p>
                        @endif
                        <input type="phone"
                               value="{{ old('phone')}}"
                               class="form-control @error('phone') is-invalid @enderror"
                               name="phone"
                               placeholder="Số điện thọai" />
                        @if($errors->has('phone'))
                            <p class="text-danger">
                                {{$errors->first('phone')}}
                            </p>
                        @endif
                        <input type="email" value="{{ old('email')}}"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               placeholder="Email" />
                        @if($errors->has('email'))
                            <p class="text-danger">
                                {{$errors->first('email')}}
                            </p>
                        @endif
                        <div style="height: inherit" class="form-select">
                            <select style="margin-bottom: 5px;
                                    border-radius: 0px;
                                    padding: 0.675rem 0.75rem;
                                    font-size: 13px;
                                    width: 100%;
                                    font-weight: 300;"
                                    class="@error('course_id') is-invalid @enderror"
                                    name="course_id">
                                <option value="">Chọn khóa học</option>
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has('course_id'))
                                <p class="text-danger">
                                    {{$errors->first('course_id')}}
                                </p>
                            @endif
                        </div>

                        <button type="submit" class="primary-btn text-uppercase">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
@section('js')
    <script>
        $().ready(function () {
            $('#register-form').validate({
                rules:{
                    full_name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    }

                },
                messages:{
                    full_name: {
                        required: 'Vui lòng nhập họ tên !',
                    },
                    phone: {
                        required: 'Vui lòng nhập số điện thoại !',
                    },
                    email: {
                        required: 'Vui lòng nhập địa chỉ email !',
                    },
                    course_id: {
                        required: 'Vui chọn khóa học !',
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if(data == "true") {
                                Swal.fire({
                                    title: 'Đăng ký thành công !',
                                    icon: 'success',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#register-form').trigger('reset')
                                    }
                                })
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop

