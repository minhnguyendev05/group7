<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lịch Sử</title>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    @include('header')
    <div class="content-form">
        <div style="overflow:auto" class="mn-frame-bg scroll-bar">
            <h2>LỊCH SỬ</h2>
            <div class="flex flex-wrap-2 flex-evenly text-white">
                <p class="name-time border-right">TÊN CV</p>
                <p class="name-time border-right">DATE</p>
                <p class="name-time">HÀNH ĐỘNG</p>
            </div>
            @foreach ($works as $work)
            @php 
                $time = date("d/m/Y", strtotime($work->timestart));
            @endphp
            <div class="flex flex-wrap flex-evenly text-white padding-10 margin-10">
                <div class="name-time border-right">{{$work->workname}}</div>
                <div class="name-time border-right">{{$time}}</div>
                <a class="name-time link text-white" href="{{ url('/') }}/work/details/{{$work->id}}">Xem Chi Tiết</a>
            </div>
            @endforeach
            <a href="{{ route('dashboard') }}" class="button-pink">OK</a>
        </div>
    </div>

    @include('footer')

</body>

</html>