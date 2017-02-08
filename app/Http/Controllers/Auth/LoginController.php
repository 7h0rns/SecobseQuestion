<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Cover AuthenticatesUsers trait username().
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge($this->credentials($request), ['is_confirm' => 1]);
        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        DB::table('users')
                    ->where('name', $request->input('name'))
                    ->update(['isactive' => $request->input('isactive')]);

        $this->clearLoginAttempts($request);
        session()->flash('status', '欢迎回来');
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        DB::table('users')
                    ->where('id', Auth::user()->id)
                    ->update(['isactive' => $request->input('isactive')]);

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/')->with('logout', 'Logout Successfully!');
    }

}
