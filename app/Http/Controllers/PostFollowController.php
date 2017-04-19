<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class PostFollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function follow($post)
    {
        Auth::user()->followThis($post);

        return back();
    }
}
