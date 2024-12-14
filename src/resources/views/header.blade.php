<div class="navbar">
    <div class="icon">
        <i class="fas fa-clock"></i>
    </div>
    <div class="links">
        <a href="{{ url('/') }}">TRANG CHỦ</a>
        <div class="menu">
            <a href="#">CÔNG VIỆC</a>
            <div class="submenu">
                @if(Auth::check())
                <div class="menu-2">
                <a style="display: inline-block" class="btn text-black" href="{{ route('dashboard')}}">Quản Lý Lịch Trình</a>
                <div class="submenu-2">
                    @if(Auth::check())
                    <a class="btn text-black text-align" href="{{ route('add_work')}}">Thêm Công Việc</a>
                    <a class="btn text-black text-nowrap" href="{{ route('view_work')}}">Lịch Trình</a>
                    @else
                    <a class="btn text-black" href="{{ route('login')}}">Đăng Nhập</a>
                    <a class="btn text-black" href="{{ route('register')}}">Đăng Ký</a>
                    @endif
                </div>
                </div>
                <a class="btn text-black" href="{{ route('history_work')}}">Lịch Sử</a>
                @else
                <a class="btn text-black" href="{{ route('login')}}">Quản Lý Lịch Trình</a>
                <a class="btn text-black" href="{{ route('login')}}">Lịch Sử</a>
                @endif
            </div>
        </div>
        <div class="menu">
            <a href="#">TÀI KHOẢN</a>
            <div class="submenu">
                @if(Auth::check())
                @php
                    $user = Auth::user();
                @endphp
                <a class="text-align text-nowrap">Xin chào: {{ $user->name }}</a>
                <a class="btn text-black text-align" href="{{ route('login')}}">Hồ Sơ</a>
                <a class="btn text-black text-nowrap" href="{{ route('logout')}}">Đăng Xuất</a>
                @else
                <a class="btn text-black" href="{{ route('login')}}">Đăng Nhập</a>
                <a class="btn text-black" href="{{ route('register')}}">Đăng Ký</a>
                @endif
            </div>
        </div>
    </div>
</div>