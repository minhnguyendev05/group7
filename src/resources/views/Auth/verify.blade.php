<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Xác Minh Tài Khoản</title>
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
            <h2>SIGN UP NEW ACCOUNT</h2>
            <form method="" action="" id="my-form">
                <div class="flex flex-wrap">
                @if (session('error'))
                <label for="error">MÃ XÁC NHẬN KHÔNG CHÍNH XÁC!</label>
                @endif
                    @if (session('verified'))
                    <label for="success">XÁC NHẬN TÀI KHOẢN THÀNH CÔNG!</label>
                    @else
                    <label for="token" style="width:100%">NHẬP MÃ ĐÃ ĐƯỢC GỬI ĐẾN EMAIL CỦA BẠN ĐỂ XÁC NHẬN</label>
                    <input type="text" style="flex:unset" id="token" name="token" value="" required>
                    @endif
                </div>
                @if (session('verified'))
                <input type="submit" value="OK" id="ok">
                <div id="submit"></div>
                @else
                <input type="submit" value="CONFIRM" id="submit">
                @endif
            </form>
        </div>
    </div>
    <script>
        var submit = document.getElementById('submit');
        var ok = document.getElementById('ok');
        var token = document.getElementById('token');
        submit.addEventListener("click", (e)=>{
            if (token.value === "") return false;
            e.preventDefault();
            window.location.href= "verify/"+token.value;
        });
        ok.addEventListener('click', (e)=>{
            e.preventDefault();
            window.location.href= "/";
        });
    </script>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('footer')

</body>

</html>