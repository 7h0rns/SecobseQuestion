<?php

namespace App\Mailer;

use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email){
            $message->from('gasbylei@foxmail.com', 'SecobseQuestion');
            $message->to($email);
        });
    }
}