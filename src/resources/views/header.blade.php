@php
if(Auth::check()){
    $user = Auth::user();
    $status = $user->status;
    $role = $user->role;
    if($status === 0){
        Auth::logout();
        echo '<script>window.location.href = "/suspended";</script>';
    }
}
@endphp
<div class="navbar">
    <div class="icon flex gap-20">
        <i class="fas fa-clock"></i>
        <i class="fas fa-bars mn-bars"></i>
    </div>
    <div class="links flex-wrap-2">
        <a href="{{ url('/') }}">TRANG CHỦ</a>
        <a href="{{ route('view_note') }}">GHI CHÚ</a>
        <div class="menu">
            <a href="#">CÔNG VIỆC</a>
            <div class="submenu">
                @if(Auth::check())
                <div class="menu-2">
                <a style="display: inline-block" class="btn text-black" href="#">Quản Lý Lịch Trình</a>
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
                <a class="text-align text-nowrap">Xin chào: {{ $user->username }}</a>
                <a class="btn text-black text-align" href="{{ route('login')}}">Hồ Sơ</a>
                <a class="btn text-black text-nowrap" href="{{ route('logout')}}">Đăng Xuất</a>
                @if ($role === "admin")
                <div class="menu-2">
                <a style="display: inline-block" class="btn text-black" href="#">Quản Lý Người Dùng</a>
                <div class="submenu-2">
                    <a class="btn text-black text-align" href="{{ route('admin_view_review')}}">Phản Hồi</a>
                    <a class="btn text-black text-nowrap" href="{{ route('admin_view_user')}}">Người Dùng</a>
                </div>
                </div>
                @endif
                @else
                <a class="btn text-black" href="{{ route('login')}}">Đăng Nhập</a>
                <a class="btn text-black" href="{{ route('register')}}">Đăng Ký</a>
                @endif
            </div>
        </div>
        <a href="{{ route('view_review') }}">ĐÁNH GIÁ</a>
    </div>
</div>