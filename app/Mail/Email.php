<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject(subject: 'Test Email Subject') // Tiêu đề email
                    ->view('auth.email') // Sử dụng view `emails.test`
                    ->with([ // Truyền dữ liệu vào view
                        'content' => 'This is a test email content..',
                    ]);
    }
}

