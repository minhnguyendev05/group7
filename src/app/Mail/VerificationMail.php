<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationMail extends Mailable
{
    use SerializesModels;

    public $user;

    /**
     * Tạo một instance mới của lớp Mailable.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Xây dựng thông điệp email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mã xác nhận đăng ký')->view('auth.verification');
    }
}
