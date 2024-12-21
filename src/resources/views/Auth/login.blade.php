<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đăng Nhập</title>
  <meta name="description" content="Quan Ly Lich Trinh">
  <meta name="keywords" content="Quan Ly Lich Trinh">
  <meta name="robots" content="index, follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "name": "Quản Lý Lịch Trình",
      "description": "Quản Lý Lịch Trình",
      "url": "https://calendar.minhnguyen.eu.org"
    }
  </script>
  <link rel="icon" href="{{ url('/assets/image/favicon.ico') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <meta property="og:title" content="Quản Lý Lịch Trình">
  <meta property="og:description" content="Quản Lý Lịch Trình">
  <meta property="og:url" content="https://calendar.minhgnguyen.eu.org">
  <meta property="og:image" content="https://calendar.minhgnguyen.eu.org/assets/image/image.jpg">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Quản Lý Lịch Trình">
  <meta name="twitter:description" content="Quản Lý Lịch Trình">
  <meta name="twitter:image" content="https://calendar.minhgnguyen.eu.org/assets/image/image.jpg">
  <meta name="charset" content="UTF-8">
  <link rel="canonical" href="https://calendar.minhgnguyen.eu.org">
</head>


<body>
    @include('header')
    <div class="content-form">
        <div class="form-container">
            <h2>SIGN IN</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if ($errors->any())
                    <div class="flex flex-wrap">
                        @foreach ($errors->all() as $error)
                            <label>{{ $error }}</label>
                        @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div class="flex flex-wrap">
                        <label>{{ session('success') }}</label>
                    </div>
                @endif
                <div class="flex flex-wrap">
                    <label for="username">TÊN NGƯỜI DÙNG</label>
                    <input type="text" id="username" name="username" value="" required>
                </div>
                <div class="flex flex-wrap">
                    <label for="password">MẬT KHẨU</label>
                    <input type="password" id="password" name="password" value="" required>
                </div>
                <input type="submit" value="SIGN IN">
            </form>
            <a class="have-account" href="{{ route('register') }}">Chưa có tài khoản ?</a>
        </div>
    </div>

    @include('footer')

</body>

</html>