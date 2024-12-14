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
            </div>
            @php 
                $work = $work[0];
                $time = date("d/m/Y", strtotime($work->timestart));
            @endphp
            <div class="flex flex-wrap flex-evenly text-white padding-10 margin-10">
                <div class="name-time margin-10">{{$work->workname}}</div>
                <div class="name-time margin-10">{{$time}}</div>
                
            </div>
            <div class="flex flex-center padding-10 margin-10"> 
                <textarea class="text-align" style="flex: 1; border-radius: 10px; font-size:20px" cols="50" rows="10">{{ $work->mota }}</textarea>
            </div>
            <a href="{{ route('history_work') }}" class="button-pink">OK</a>
        </div>
    </div>

    @include('footer')

</body>

</html>