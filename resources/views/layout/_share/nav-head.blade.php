<div class="container-fluid">
    <div class="d-flex justify-content-between">
        <div class="top-menu d-flex align-items-center">
            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
            <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button>
        </div>
        <div class="top-menu d-flex align-items-center">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(isset($user))
                        <img class="avatar" src="{{ isset($user->avatar) ? asset('storage/'.$user->avatar) : asset('admins/img/default-image.jpg')}}" alt="" />
                        <p>{{ $user->full_name }} <i class="ik ik-chevron-down"></i></p>
                    @else
                        <img class="avatar" src="{{ isset(Auth::user()->avatar) ? asset('storage/'.Auth::user()->avatar) : asset('admins/img/default-image.jpg') }}" alt="" />
                        <p>{{ isset(Auth::user()->full_name) ? Auth::user()->full_name : "" }} <i class="ik ik-chevron-down"></i></p>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    @auth('admin')
                        <a class="dropdown-item" href="{{ route('get.profile.index') }}"><i class="ik ik-user dropdown-icon"></i> Thông tin cá nhân</a>
                    @endauth
                    @auth('student')
                        <a class="dropdown-item" href="{{ route('student.profile.index') }}"><i class="ik ik-user dropdown-icon"></i> Thông tin cá nhân</a>
                    @endauth
                    @auth('teacher')
                        <a class="dropdown-item" href="{{ route('teacher.profile.index') }}"><i class="ik ik-user dropdown-icon"></i> Thông tin cá nhân</a>
                    @endauth
                    <a class="dropdown-item" href="{{ route('get.change.password') }}"><i class="ik ik-settings dropdown-icon"></i> Thay đổi mật khẩu</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="ik ik-power dropdown-icon"></i> Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
</div>
