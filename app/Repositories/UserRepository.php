<?php
/**
 * Created by PhpStorm.
 * User: fantonglei
 * Date: 2017/4/19
 * Time: 下午2:05
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}