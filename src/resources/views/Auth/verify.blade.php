<html>

<head>
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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