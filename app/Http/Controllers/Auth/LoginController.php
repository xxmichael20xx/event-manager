<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Add a custom redirection after login
    // based on user role
    public function redirectTo() {
        if ( auth()->user()->role == 'admin' ) {
            return '/admin/dashboard';
        }

        return '/book-now';
    }

    public function authenticated($request, $user)
    {
        if ( $user->status == 'deactivated' ) {
            $this->guard()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $deactivatedMessage = "
                <i class='fa fa-info-circle'></i> Your account has been deactivated.
                <br>
                Reason: {$user->notes}
                <br>
                <hr>
                Please contact <a class='btn btn-link p-0'>admin@events.com</a> for further assistance.
            ";
            return redirect( '/login' )->with( 'auth.deactivated', $deactivatedMessage );
        }
        return redirect( $this->redirectTo() );
    }
}
