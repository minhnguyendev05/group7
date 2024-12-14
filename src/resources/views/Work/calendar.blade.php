<html>

<head>
    <title>Lịch</title>
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
    <div class="content-form">
        <div class="form-container">
            <h2>LỊCH</h2>
            <div id='calendar'></div>

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