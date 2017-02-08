<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if(is_null($user)){

            return redirect('/');
        }

        $user->is_confirm = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user);
        session()->flash('status', '恭喜你，邮箱验证成功。');
        return redirect('/home');
    }

}
