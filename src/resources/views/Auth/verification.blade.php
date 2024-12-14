<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã xác nhận đăng ký</title>
</head>
<body>
    <h2>Xin chào {{ $user->name }}</h2>
    <p>Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã xác nhận dưới đây:</p>
    <h3>{{ $user->verification_token }}</h3>
    <p>Cảm ơn bạn đã đăng ký!</p>
</body>
</html>
