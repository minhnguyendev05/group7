<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Phản Hồi Người Dùng</title>
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
    .user-info {
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 10px;
    }
    .rating,.contents {
        margin-left: 40px;
        scale: 1;
    }
    .comment {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
        align-items: flex-start;
    }
    
    .contents {
        display: flex;
        gap: 20px;
    }
    

</style>

<body>
    @include('header')
    <div class="content-form">
    <div class="mn-frame-bg overflow scroll-bar">
        <h2>Phản Hồi Người Dùng</h2>
        @foreach ($data as $comment)
        <div class="comment margin-10 padding-10">
            <div class="user-info text-white"><i class="fa fa-user user-avatar"></i>{{ $comment->username }}</div>
            <div class="rating text-white">
                @for ($i=1;$i <= 5;$i++)
                    @if($i <= $comment->rate)
                    <i class="fas fa-star active" data-value="{{$i}}"></i>
                    @else 
                    <i class="fas fa-star" data-value="{{$i}}"></i>
                    @endif
                @endfor
            </div>
            <div class="contents text-white"><p class="text-white">{{ $comment->content }}</p><a class="text-white pointer">Reply</a></div>
        </div>
        @endforeach
        
    </div>
    </div>
    <script>
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