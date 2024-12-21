<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Thêm Công Việc</title>
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
            <h2>THÊM CÔNG VIỆC MỚI</h2>
            <form method="POST" action="{{ route('add_work') }}">
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
                    <img style="padding:10px;margin:10px;" src="{{ asset('assets/image/welldone.png') }}" />
                    <div class="flex flex-evenly">
                        <input type="button" id="ok" value="OK" >
                        <input type="button" id="view-calender" value="Xem Lịch">
                    </div>
                    <script>
                        var view = document.getElementById('view-calender');
                        var ok = document.getElementById('ok');
                        ok.addEventListener("click", ()=>{
                            window.location.reload();
                        });
                        view.addEventListener('click', ()=>{
                            window.location.href= "/work/view";
                        });
                    </script>
                @else
                <div class="flex flex-wrap">
                    <label for="workname">TÊN CÔNG VIỆC</label>
                    <input type="text" id="workname" name="workname" value="" required>
                </div>
                <div class="flex flex-wrap">
                    <label for="timestart">NGÀY BẮT ĐẦU</label>
                    <input type="datetime-local" name="timestart" id="timestart" required>                  
                </div>
                <div class="flex flex-wrap">
                    <label for="timeend">NGÀY KẾT THÚC</label>
                    <input type="datetime-local" name="timeend" id="timeend" required> 
                </div>
                <div class="flex flex-wrap">
                    <label for="mota">MÔ TẢ </label>
                    <textarea rows="5" name="mota" id="mota" required></textarea>
                </div>
                <input type="submit" value="LƯU">
                @endif
            </form>
        </div>
    </div>
    
    
    @include('footer')

</body>

</html>