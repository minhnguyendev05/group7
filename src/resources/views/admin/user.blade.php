<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quản Lý Người Dùng</title>
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
    .mn-frame-bg {
        position: relative;
    }
    .pop {
        display: none;
        position: absolute;
        border: 3px solid #fff;
        background: #1c1c1c;
        border-radius: 10px;
        align-items: center;
        flex-direction: column;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

</style>

<body>
    @include('header')
    <div class="content-form">
    <div class="mn-frame-bg overflow scroll-bar">
        <h2>Danh Sách Người Dùng</h2>
        <div class="flex flex-evenly flex-wrap text-white">
            <div class="name-time">Tên</div>
            <div class="name-time">Ngày Tạo</div>
            <div class="name-time">Số Bài đánh Giá</div>
            <div class="name-time">Hành Động</div>
        </div>
        @foreach ($data as $user)
        <div class="flex flex-evenly flex-wrap text-white margin-10">
            <p class="mn-hidden" id="{{ $user->id }}"></p>
            <div class="name-time">{{ $user->username }}</div>
            <div class="name-time">{{ $user->created_at }}</div>
            <div class="name-time">{{ $user->counts}}</div>
            <a class="name-time link">Xóa</a>
        </div>
        @endforeach
        <div class="pop flex-center text-white padding-10 margin-10" id="pop">
            <h2>Xác nhận xóa?</h2>
            <!-- <input type="hidden" name="idu" id="idu"> -->
            <input type="text" name="password" id="password" style="border-radius: 20px; margin: 10px; padding:10px" class="form-control" placeholder="Nhập mật khẩu tài khoản" required>
            <div class="flex gap-20">
                <button class="button-pink" id="delete">Xóa</button>
                <button class="button-pink" id="cancel">Hủy</button>
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
        window.addEventListener('DOMContentLoaded', function(){
            var status = "{{ session('data') }}";
            if(status === 'true'){
                showToast("{{ session('success') }}",3000,"success");
            } else if(status === 'false'){
                showToast("{{ session('error') }}",3000, "error");
            }
            var btn = document.querySelectorAll(".name-time.link");
            var pop = document.getElementById('pop');
            var password = document.getElementById('password');
            btn.forEach(function(e){
                e.addEventListener('click', function(){
                    hidden_pop();
                    let parent = e.parentElement;
                    let id = parent.firstElementChild.getAttribute('id');
                    show_pop();
                    let btn_del = $('#delete');
                    let btn_cancel = $('#cancel');
                    btn_del.off('click');
                    btn_del.on("click", function(){
                        if(password.value){
                            $.ajax({
                                url: '/admin/user/delete',
                                type: 'POST',
                                data: { id: id, password: password.value },
                                success: function(response) {
                                    const {status,message} = response;
                                    if(status === 200){
                                        showToast(response.message,3000,"success");
                                    } else {
                                        showToast(response.message,3000,"error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    showToast(response.message,3000,"success");
                                }
                            });
                        } else {
                            showToast("Mật khẩu là bắt buộc!", 3000, "error");
                        }
                    });
                    btn_cancel.off('click');
                    btn_cancel.on('click',function(){
                       hidden_pop();
                    });

                });
            });
            function show_pop(){
                pop.style.display = "flex";
            }
            function hidden_pop(){
                pop.style.display = "none";
                password.value = "";
            }
        });
        
    </script>
    
    @include('footer')

</body>

</html>