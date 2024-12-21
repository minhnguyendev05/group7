function showToast(message, delay = 3000, type) {
    var toastContainer = document.getElementById('toast-container');
    let classadd;
   
    // new toast
    var toastEl = document.createElement('div');
    switch (type) {
        case "success":
            toastEl.classList.add('toast','text-white','bg-success');
            break;
        case "error":
            toastEl.classList.add('toast','text-white','bg-danger');
            break;
        default:
            toastEl.classList.add('toast');
            break;
    }
    
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    
    // Cấu trúc nội dung toast
    toastEl.innerHTML = `
      <div class="toast-header">
        <strong class="me-auto">Thông báo</strong>
        <small>Vừa xong</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        ${message}
      </div>
    `;
    
    // Thêm toast vào container
    toastContainer.appendChild(toastEl);
    
    // Khởi tạo và hiển thị toast
    var toast = new bootstrap.Toast(toastEl, { delay: delay });
    toast.show();
  }
window.addEventListener('DOMContentLoaded', function(){
  var bars = document.querySelector('i.mn-bars');
  var link = document.querySelector('div.links');
  bars.addEventListener('click', function(){
    link.classList.toggle('flex-i');
    bars.classList.toggle('fa-times');
  });
  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
});
  