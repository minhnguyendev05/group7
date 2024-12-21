<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ghi Chú</title>
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
            <h2>GHI CHÚ</h2>
            @if ($errors->any())
                <div class="flex flex-wrap">
                    @foreach ($errors->all() as $error)
                        <label>{{ $error }}</label>
                    @endforeach
                </div>
            @endif
            <div class="flex flex-center flex-wrap-2">
                <div style="flex: 1 1 0">
                    <h2>TẠO GHI CHÚ</h2>
                    <div class="flex flex-wrap padding-10">
                        <label for="notename">TÊN GHI CHÚ</label>
                        <input type="text" id="notename" name="notename" value="" required>
                    </div>
                    <div class="flex flex-wrap padding-10">
                        <label for="ngay">NGÀY</label>
                        <input type="date" id="ngay" name="ngay" value="" required>
                    </div>
                    <div class="flex flex-wrap-2 padding-10">
                        <label for="content">NỘI DUNG</label>
                        <textarea class="text-align" name="content" id="content" cols="5" rows="5" required></textarea>
                    </div>
                    <button class="button-pink margin-10" id="create">TẠO</button>
                </div>
                <div style="flex: 1 1 0">
                    <h2>DANH SÁCH GHI CHÚ</h2>
                    <div class="flex flex-wrap-2 flex-evenly text-white">
                        <p class="name-time border-right">TÊN</p>
                        <p class="name-time border-right">NỘI DUNG</p>
                        <p class="name-time border-right">NGÀY</p>
                        <p class="name-time border-right">HÀNH ĐỘNG</p>
                    </div>
                    <div id="notes" class="scroll-bar">
                        @foreach ($notes as $note)
                        <div class="flex flex-wrap flex-evenly text-white padding-10 margin-10">
                            <div class="name-time border-right">{{ $note->notename}}</div>
                            <div class="name-time border-right">{{ $note->content }}</div>
                            <div class="name-time border-right">{{ $note->ngay }}</div>
                            @php
                            if ($note->ghim === 1)
                                echo '<a class="name-time link text-white" onclick="ghim('.$note->id.',0)">Bỏ Ghim</a>';
                            else 
                                echo '<a class="name-time link text-white" onclick="ghim('.$note->id.',1)">Ghim</a>';
                            @endphp
                        </div>
                        @endforeach
                    </div>
                    <button class="button-pink margin-10" id="ok">OK</button>
                </div>
            </div>
                
                
        </div>
    </div>
    <script>
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $(document).ready(function(){
            $('#create').click(function(event) {
                let notename = document.getElementById('notename').value;
                let ngay = document.getElementById('ngay').value;
                let content = document.getElementById('content').value;
                $.ajax({
                    url: '/note/add',
                    type: 'POST',
                    data: { notename: notename, ngay: ngay, content: content },
                    success: function(response) {
                    const {status,message} = response;
                    if(status === 200){
                        showToast(response.message,3000,"success");
                        get_note();
                    } else {
                        showToast(response.message,3000,"error");
                    }
                    },
                    error: function(xhr, status, error) {
                        showToast(response.message,3000,"success");
                    }
                });
            });
            $('#ok').on('click', function(){
                window.location.href = "/";
            });
        });
        function get_note(){
            $.ajax({
                url: '/note/get',
                type: 'POST',
                data: { },
                success: function(response) {
                const {status,message} = response;
                    if(status === 200){
                        $('#notes').html(message);
                    } else {
                        showToast(response.message,3000,"error");
                    }
                },
                error: function(xhr, status, error) {
                    showToast(response.message,3000,"success");
                }
            });
        }
        function ghim(i,t){
            $.ajax({
                url: '/note/bind',
                type: 'POST',
                data: { id: i, type: t },
                success: function(response) {
                const {status,message} = response;
                if(status === 200){
                    showToast(response.message,3000,"success");
                    get_note();
                    // setTimeout(function(){
                    //     location.reload();
                    // },3000);
                } else {
                    showToast(response.message,3000,"error");
                }
                },
                error: function(xhr, status, error) {
                    showToast(response.message,3000,"success");
                }
            });
        }
    </script>
    
    @include('footer')

</body>

</html>