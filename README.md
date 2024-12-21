# Group 07
- Website tạo lịch trình công việc


## Yêu Cầu (Requirement)
- PHP 
- Composer
Run test if it installed!
```bash 
php -v
composer -v
```
## Cài đặt
- Chọn thư mục để lưu dự án trên máy
```bash
cd path_to_your_folder
git clone https://github.com/minhnguyendev05/group7.git
cd group7\src
```
- Sau đó thực hiện: 
```bash
copy .env.example .env
composer install
```
- Config .env (Database,...), tiếp theo:
```bash
php artisan migrate
php artisan serve
```

### Hướng dẫn sử dụng (Usage)
- Cung cấp thông tin về cách sử dụng dự án sau khi cài đặt xong.
```markdown
Sau khi cài đặt, bạn có thể mở web bằng cách mở đường dẫn mà chương trình cung cấp trong Terminal
```
### Các tính năng

- Đăng nhập và đăng ký người dùng
- Tạo lịch trình, xem lịch
- Giao diện người dùng thân thiện

### Công nghệ sử dụng

- PHP (Laravel)
- HTML,CSS,JS
- MySQL

### Giấy phép

Dự án này được cấp phép theo giấy phép MIT.

### Liên hệ

Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ qua email: example@example.com
...

