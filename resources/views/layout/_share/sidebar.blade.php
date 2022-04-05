<div class="sidebar-content">
    <div class="nav-container">
        <nav id="main-menu-navigation" class="navigation-main">
            @auth('admin')
                <div class="nav-lavel">Navigation</div>
                <div class="nav-item {{ \Request::route()->getName() == 'admin.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}"><i class="ik ik-bar-chart-2"></i><span>Trang chủ</span></a>
                </div>
                <div class="nav-lavel">UI Element</div>
                <div class="nav-item has-sub {{ \Request::route()->getName() == 'get.notification.index' ? 'active' : '' }}">
                    <a href="javascript:void(0)"><i class="ik ik-bell"></i><span>Quản lý thông báo</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('get.notification.index') }}" class="menu-item">Thông báo</a>
                        <a href="{{ route('get.category.index') }}" class="menu-item">Danh mục</a>
                    </div>
                </div>
                <div class="nav-item has-sub">
                    <a href="javascript:void(0)"><i class="ik ik-grid"></i><span>Quản lý lớp học</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('get.class.index') }}" class="menu-item">Lớp học</a>
                        <a href="{{ route('get.room.index') }}" class="menu-item">Phòng học</a>
                        <a href="{{ route('get.shift.index') }}" class="menu-item">Ca học</a>
                    </div>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.course.index' ? 'active' : '' }}">
                    <a href="{{ route('get.course.index') }}"><i class="ik ik-book"></i><span>Quản lý khóa học</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.schedule.index' ? 'active' : '' }}">
                    <a href="{{ route('get.schedule.index') }}"><i class="ik ik-calendar"></i><span>Quản lý lịch học</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.teaching.schedule.index' ? 'active' : '' }}">
                    <a href="{{ route('get.teaching.schedule.index') }}"><i class="ik ik-briefcase"></i><span>Quản lý lịch dạy</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.customer.index' ? 'active' : '' }}">
                    <a href="{{ route('get.customer.index') }}"><i class="fas fa-user-tie"></i><span>Quản lý khách hàng</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.specialized.index' ? 'active' : '' }}">
                    <a href="{{ route('get.specialized.index') }}"><i class="far fa-address-card"></i><span>Quản lý chuyên ngành</span></a>
                </div>
                <div class="nav-item has-sub">
                    <a href="javascript:void(0)"><i class="fas fa-users"></i><span>Quản lý User</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('get.student.index') }}" class="menu-item"><i class="ik ik-users"></i> Học sinh</a>
                        <a href="{{ route('get.teacher.index') }}" class="menu-item"><i class="ik ik-users"></i> Giáo viên</a>
                        <a href="{{ route('get.admin.index') }}" class="menu-item"><i class="ik ik-users"></i> Admin</a>
                    </div>
                </div>
                <div class="nav-lavel">Cấu hình trung tâm</div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.blog.index' ? 'active' : '' }}">
                    <a href="{{ route('get.blog.index') }}"><i class="ik ik-file-text"></i><span>Quản lý tin tức</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.about.index' ? 'active' : '' }}">
                    <a href="{{ route('get.about.index') }}"><i class="ik ik-airplay"></i><span>Quản lý trang giới thiệu</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'get.setting.index' ? 'active' : '' }}">
                    <a href="{{ route('get.setting.index') }}"><i class="ik ik-settings"></i><span>Cấu hình trung tâm</span></a>
                </div>
            @endauth
            @auth('student')
                <div class="nav-lavel">UI Element</div>
                <div class="nav-item {{ \Request::route()->getName() == 'student.index' ? 'active' : '' }}">
                    <a href="{{ route('student.index') }}"><i class="ik ik-bell"></i><span> Thông báo</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'student.schedule.index' ? 'active' : '' }}">
                    <a href="{{ route('student.schedule.index') }}"><i class="ik ik-align-justify"></i><span> Lịch học</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'student.rollcall.index' ? 'active' : '' }}">
                    <a href="{{ route('student.rollcall.index') }}"><i class="ik ik-check-square"></i><span> Điểm danh</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'student.historylearn.index' ? 'active' : '' }}">
                    <a href="{{ route('student.historylearn.index') }}"><i class="ik ik-server"></i><span> Lịch sử học</span></a>
                </div>
            @endauth
            @auth('teacher')
                <div class="nav-lavel">Menu</div>
                <div class="nav-item {{ \Request::route()->getName() == 'teacher.index' ? 'active' : '' }}">
                    <a href="{{ route('teacher.index') }}"><i class="ik ik-align-justify"></i><span> Lịch dạy</span></a>
                </div>
                <div class="nav-item {{ \Request::route()->getName() == 'teacher.chargeclass.index' ? 'active' : '' }}">
                    <a href="{{ route('teacher.chargeclass.index') }}"><i class="ik ik-grid"></i><span> Lớp phụ trách</span></a>
                </div>
            @endauth
        </nav>
    </div>
</div>
