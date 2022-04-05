<header id="header" id="home">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-8 header-top-left no-padding">

                </div>
                <div class="col-lg-6 col-sm-6 col-4 header-top-right no-padding">
                    <a href="#">
                        <span class="lnr lnr-phone-handset"></span>
                        <span class="text">
                            {{ isset($setting->phone) ? $setting->phone : "" }}
                        </span>
                    </a>
                    <a href="#">
                        <span class="lnr lnr-envelope"></span>
                        <span class="text">
                            <span class="__cf_email__">
                                {{ isset($setting->email) ? $setting->email : "" }}
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-menu">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="{{ route('get.home.page') }}">
                    <img src="{{ isset($setting->logo) ? asset('storage/'.$setting->logo) : asset('admins/img/default-image.jpg') }}" alt="" title="" />
                </a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="{{ route('get.home.page') }}">Trang chủ</a></li>
                    <li><a href="{{ route('get.about.page') }}">Giới thiệu</a></li>
                    <li class="menu-has-children">
                        <a href="{{ route('get.course.page') }}">Khóa học</a>
                        <ul>
                            @if(isset($courses))
                                @foreach($courses as $course)
                                    <li><a href="{{ route('get.course.detail', $course->id) }}">{{ $course->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li><a href="{{ route('get.blog.page') }}">Tin tức</a></li>
                    <li><a href="{{ route('get.contact.page') }}">Liên Hệ</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
