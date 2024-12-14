<html>

<head>
    <title>Lịch Sử</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @include('header')
    <div class="content-form">
        <div style="height:300px;overflow:auto" class="mn-frame-bg">
            <h2>LỊCH SỬ</h2>
            <div class="flex flex-wrap-2 flex-evenly text-white">
                <p class="name-time">TÊN CV</p>
                <p class="name-time">DATE</p>
                <p class="name-time">HÀNH ĐỘNG</p>
            </div>
            @foreach ($works as $work)
            @php 
                $time = date("d/m/Y", strtotime($work->timestart));
            @endphp
            <div class="flex flex-wrap flex-evenly text-white padding-10 margin-10">
                <div class="name-time">{{$work->workname}}</div>
                <div class="name-time">{{$time}}</div>
                <a class="name-time link text-white" href="{{ url('/') }}/work/details/{{$work->id}}">Xem Chi Tiết</a>
            </div>
            @endforeach
            <a href="{{ route('dashboard') }}" class="button-pink">OK</a>
        </div>
    </div>

    @include('footer')

</body>

</html>