<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AdminAuthController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    // use AuthenticatesAndRegistersUsers;

	protected $redirectTo = '/admin/users';

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin() {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }
        
        return view('admin.auth.login');
    }

    public function postLogin(Request $request){
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
            ]);
        
        $throttles = $this->isUsingThrottlesLoginsTrait();
        
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        
        $credentials = $this->getCredentials($request);
        
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        
        return redirect('/admin/users')
        ->withInput($request->only($this->loginUsername(), 'remember'))
        ->withErrors([
        $this->loginUsername() => $this->getFailedLoginMessage(),
        ]);
    }
}
