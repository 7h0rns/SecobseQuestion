<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Auth;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers
 */
class InboxController extends Controller
{

    /**
     * @var MessageRepository
     */
    protected $message;

    /**
     * InboxController constructor.
     * @param MessageRepository $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->middleware('auth');
        $this->message = $message;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {   
        $messages = $this->message->getAllMessage();
        
        return view('inbox.index',['messages' => $messages->groupBy('dialog_id')]);
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($dialogId)
    {
        $messages = $this->message->getDialogMessageBy($dialogId);
        $messages->markAsRead();
        return view('inbox.show',compact('messages','dialogId'));
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($dialogId)
    {
        $message = $this->message->getSingleMessageBy($dialogId);
        $toUserId = $message->from_user_id === Auth::id() ? $message->to_user_id : $message->from_user_id;

        $this->message->create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);

        return back();
    }
}
