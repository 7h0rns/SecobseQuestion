<?php

namespace App\Mailer;


use App\User;

class UserMailer extends Mailer
{
    public function passwordReset($email,$token)
    {
        $data = ['url' => url('password/reset', $token)];

        $this->sendTo('secobse_app_password_reset', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify',['token' => $user->confirmation_token]),
            'name' => $user->name
        ];

        $this->sendTo('secobseQuestion_app_register', $user->email, $data);
    }
}