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
            <form method="POST" action="{{ route('register') }}">
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
                <div class="flex flex-wrap">
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" value="" required>
                </div>
                <input type="submit" value="SIGN UP">
            </form>
            <a class="have-account" href="{{ route('login') }}">Đã có tài khoản ?</a>
        </div>
    </div>
    
    
    @include('footer')

</body>

</html>