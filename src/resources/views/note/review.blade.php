<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đánh Giá</title>
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
<style>
    label {
        font-weight: 600;
    }
</style>

<body>
    @include('header')
    <div class="content-form">
    <div class="form-container">
        <h2>ĐÁNH GIÁ</h2>
        <form method="POST" action="{{ route('view_review') }}">
            @csrf
            <div class="flex flex-wrap">
                <label>MỨC ĐỘ HÀI LÒNG</label>
                <div class="rating text-white margin-10">
                    <i class="fas fa-star" data-value="1"></i>
                    <i class="fas fa-star" data-value="2"></i>
                    <i class="fas fa-star" data-value="3"></i>
                    <i class="fas fa-star" data-value="4"></i>
                    <i class="fas fa-star" data-value="5"></i>
                </div>
                <input type="hidden" name="stars" id="stars" value="">
            </div>
            <div class="flex flex-wrap margin-10 padding-10">
                <label>NỘI DUNG</label>
                <textarea cols="3" rows="10" name="content" class="text-align" required></textarea>
            </div>
            <input type="submit" value="GỬI ĐÁNH GIÁ">
        </form>
    </div>
    </div>
    <script>
        var star = document.querySelectorAll('div.rating i');
        var stars = document.getElementById('stars');
        var current = 0;
        star.forEach(function (e){
            e.addEventListener('click',function (i){
                current = e.getAttribute("data-value");
                let a = b = e;
                a.classList.add('active');
                while (b.nextElementSibling !== null){
                    b = b.nextElementSibling;
                    b.classList.remove('active');
                }
                while (a.previousElementSibling !== null){
                    a = a.previousElementSibling;
                    a.classList.add('active');
                }
                stars.value = current;
            });
        });
        window.addEventListener('DOMContentLoaded', function(){
            var status = "{{ session('data') }}";
            if(status === 'true'){
                showToast("{{ session('success') }}",3000,"success");
            } else if(status === 'false'){
                showToast("{{ session('error') }}",3000, "error");
            }
        });
        
    </script>
    
    @include('footer')

</body>

</html>