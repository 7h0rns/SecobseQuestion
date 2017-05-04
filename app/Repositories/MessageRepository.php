<?php

namespace App\Repositories;


use App\Message;
use Auth;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @return mixed
     */
    public function getAllMessage()
    {
        return Message::where('to_user_id',Auth::user()->id)
            ->orWhere('from_user_id',Auth::user()->id)
            ->with(['fromUser' => function ($query) {
                return $query->select(['id','name','avatar']);
            },'toUser' => function ($query) {
                return $query->select(['id','name','avatar']);
            }])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getDialogMessageBy($dialogId)
    {
        return Message::where('dialog_id',$dialogId)->with(['fromUser' => function ($query) {
            return $query->select(['id','name','avatar']);
        },'toUser' => function ($query) {
            return $query->select(['id','name','avatar']);
        }])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageBy($dialogId)
    {
        return Message::where('dialog_id',$dialogId)->first();
    }
}