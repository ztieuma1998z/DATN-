<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <div id="logo" class="mb-3">
                        <a href="{{ route('get.home.page') }}">
                            <img src="{{ isset($setting->logo) ? asset('storage/'.$setting->logo) : asset('admins/img/default-image.jpg') }}" alt="" title="" />
                        </a>
                    </div>
                    <ul>
                        <li><a href="#"><i class="fa fa-home"></i> &nbsp; {{ isset($setting->address) ? $setting->address : "" }}</a></li>
                        <li><a href="#"><i class="fa fa-phone"></i> &nbsp; {{ isset($setting->phone) ? $setting->phone : "" }}</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i> &nbsp; {{ isset($setting->email) ? $setting->email : "" }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h4>Thông tin website</h4>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Giới thệu</a></li>
                        <li><a href="#">Khóa học</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h4>Fanpage Website</h4>
                    <div class="" id="mc_embed_signup">
                        {!! isset($setting->link_fanpage) ? $setting->link_fanpage : '' !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom row align-items-center justify-content-between">
            <p class="footer-text m-0 col-lg-6 col-md-12">
                {{ isset($setting->copyright) ? $setting->copyright : '' }}
                <a href="javascript:void(0)" target="_blank">Education</a>
            </p>
            <div class="col-lg-6 col-sm-12 footer-social">
            </div>
        </div>
    </div>
</footer>

