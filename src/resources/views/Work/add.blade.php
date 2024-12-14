<html>

<head>
    <title>Thêm Công Việc Mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
                    <input type="datetime-local" name="timestart" id="timestart">                  
                </div>
                <div class="flex flex-wrap">
                    <label for="timeend">NGÀY KẾT THÚC</label>
                    <input type="datetime-local" name="timeend" id="timeend"> 
                </div>
                <div class="flex flex-wrap">
                    <label for="mota">MÔ TẢ </label>
                    <textarea rows="5" name="mota" id="mota"></textarea>
                </div>
                <input type="submit" value="LƯU">
                @endif
            </form>
        </div>
    </div>
    
    
    @include('footer')

</body>

</html>