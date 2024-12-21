<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['notename','ngay', 'content' ,'userid','ghim']; // fillable
    // protected $guarded = ['id']; // Các trường không thể gán giá trị (nếu sử dụng $guarded thay vì $fillable)

    // Cột không muốn hiển thị khi trả về trong API hoặc response
    protected $hidden = ['created_at', 'updated_at']; // Các trường này sẽ bị ẩn

    protected $casts = [
        'ngay' => 'datetime',  // datetime
    ];
}
