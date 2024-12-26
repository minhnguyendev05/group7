<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lịch</title>
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body>
    @include('header')
    @if (count($note) !== 0)
    <div class="flex flex-center" style="background: #ffb6c1">
      <div class="form-container margin-10 overflow scroll-bar text-white" style="width: 100vw;">
        <h4>Ghi Chú</h4>
        <ol start="1">
        @foreach ($note as $nt)
          <li>{{$nt->content}}</li>
        @endforeach
        </ol>
        
    </div>
  </div>
    @endif
    <div class="content-form">
        <div class="form-container">
            <h2>LỊCH</h2>
            <div id='calendar'></div>
            <div id="popup" class="popup">
              <div class="popup-content">
                <!-- <h5 class="popup-title"></h5>
                <p class="popup-description"></p>
                <button class="btn btn-primary">Tùy chọn 1</button>
                <button class="btn btn-secondary">Tùy chọn 2</button> -->
                  <label for="done">Hoàn Thành</label>
                  <input style="width:20px;height:20px;"type="checkbox" name="done" id="done">
              </div>
            </div>
            <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        //plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
        locale: 'vi', 
        initialView: 'dayGridMonth', // Khởi tạo với chế độ dayGrid
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' // Các tùy chọn hiển thị
        },
        editable: true, // Cho phép kéo thả
        droppable: true,
        events: '/work/get',
        eventDidMount: function(info) {
          let startTime = info.event.start;
          let endTime = info.event.end;
          let start = new Date();
          let end = new Date(endTime);
          let timeDifference = end - start; // timeDifference là mili giây
          let hours,minutes,seconds;
          if(timeDifference > 0){
            hours = Math.floor(timeDifference / (1000 * 60 * 60)); // Tính giờ
            minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60)); // Tính phút
            seconds = Math.floor((timeDifference % (1000 * 60)) / 1000); // Tính giây
          } else {
            hours = minutes = seconds = 0;
          }
          //console.log(`Thời gian còn lại: ${hours} giờ, ${minutes} phút, ${seconds} giây`);

          var tooltip = new bootstrap.Tooltip(info.el, {
            title: `<div class="border-line padding-10">Tên: ${info.event.title}</div>`+`<div class="border-line padding-10">Thời gian còn lại: ${hours} giờ, ${minutes} phút, ${seconds} giây</div>`+`<p>Mô tả: ${info.event.extendedProps.description}</p>`,
            placement: 'right',
            trigger: 'hover focus',
            container: 'body',
            animation: true,
            delay: { "show": 100, "hide": 100 },
            html: true,
            //template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            boundary: 'viewport'
          });
          var tooltip2 = new bootstrap.Tooltip(info.el, {
            title: `<div class="border-line padding-10">Tên: ${info.event.title}</div>`+`<div class="border-line padding-10">Thời gian còn lại: ${hours} giờ, ${minutes} phút, ${seconds} giây</div>`+`<p>Mô tả: ${info.event.extendedProps.description}</p>`,
            placement: 'left',
            trigger: 'hover focus',
            container: 'body',
            animation: true,
            delay: { "show": 100, "hide": 100 },
            html: true,
            //template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            boundary: 'viewport'
          });
        },
        eventClick: function(info) {
        var event = info.event;
        var jsEvent = info.jsEvent;
        let idw = event.id;
        let statusw = event.extendedProps.status;

        if (!jsEvent) {
          console.error('jsEvent is undefined');
          return; // Ngừng nếu jsEvent không hợp lệ
        }
        // Lấy vị trí của sự kiện trên trang
        var eventOffset = $(jsEvent.target).offset();
        var popup = $('#popup');
  
        // Tính toán vị trí của popup để tránh che Tooltip
        var popupWidth = popup.outerWidth();
        var popupHeight = popup.outerHeight();
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
  
        var leftPosition = eventOffset.left + 10; // Vị trí bên trái của sự kiện (thêm khoảng cách 10px từ sự kiện)
        var topPosition = eventOffset.top + 20;  // Vị trí trên của sự kiện (thêm khoảng cách 20px từ sự kiện)
  
        // Kiểm tra xem popup có vượt quá màn hình bên phải
        if (leftPosition + popupWidth > windowWidth) {
          leftPosition = eventOffset.left - popupWidth - 10;  // Đưa popup sang trái nếu vượt quá
        }
  
        // Kiểm tra xem popup có vượt quá màn hình bên dưới
        if (topPosition + popupHeight > windowHeight) {
          topPosition = eventOffset.top - popupHeight - 20; // Đưa popup lên trên nếu vượt quá
        }
  
        // Đặt vị trí cho popup
        popup.css({
          'top': topPosition,
          'left': leftPosition
        });
  
        // Hiển thị popup
        popup.show();
  
        // Điền thông tin vào popup
        popup.find('.popup-title').text(event.title);
        popup.find('.popup-description').text(event.extendedProps.description);
        if(statusw === 1){
          popup.find('#done').prop("checked",true);
        } else {
          popup.find('#done').prop("checked",false);
        }
        // Đóng popup khi người dùng click ra ngoài
        $(document).click(function(event) {
          if (!$(event.target).closest('#popup').length && !$(event.target).closest('.fc-event').length) {
            popup.hide();
          }
        });
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $('#done').off("click");
        $('#done').click(function(event) {
          //event.stopPropagation();
          let valuecheck = event.target.checked;
          let status = 0;
          switch (valuecheck){
            case true:
              status = 1;
              break;
            case false:
              status = 0;
              break;
            default: 
              status = 0;
              break;
          }
          $.ajax({
            url: '/work/update',
            type: 'POST',
            data: { id: idw, status: status },
            success: function(response) {
              const {status,message} = response;
              if(status === 200){
                showToast(response.message,3000,"success");
                calendar.refetchEvents();
              } else {
                showToast(response.message,3000,"error");
              }
            },
            error: function(xhr, status, error) {
              showToast(response.message,3000,"success");
            }
          });

        });
        // Ngừng sự kiện lan truyền
        jsEvent.stopPropagation();
      } 
      });
      calendar.render();
    });
  </script>
        </div>
    </div>
    
    
    @include('footer')

</body>

</html>