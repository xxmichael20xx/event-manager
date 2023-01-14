<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the book now page
     */
    public function bookNow() {
        $venues = Venue::orderBy( 'name', 'asc' )->get();

        return view('book-now', compact( 'venues' ));
    }

    /**
     * Show My Account page
     */
    public function myAccount( Request $request ) {
        $myEvents = auth()->user()->events;

        return view( 'my-account', compact( 'myEvents' ) );
    }

    public function profileUpdate( Request $request ) {
        $user = User::where( 'email', $request->email )->first();

        if ( ! $user ) {
            return back()->with( 'access.denied', 'Unable to update account. Please try again.' );
        }

        if ( $user->email !== auth()->user()->email ) {
            return back()->with( 'access.denied', 'Unable to update account. Please try again.' );
        }

        $this->validate( $request, [
            'profile' => [ 'required', 'mimes:jpg,jpeg,png', 'max:2048' ],
            'name' => [ 'required', 'string', 'max:255' ],
            'password' => [ 'nullable', 'string', 'min:8', 'confirmed' ]
        ] );

        $fileName = 'user_profile_' . auth()->user()->id . '_' . time() . '.' . $request->profile->extension();

        if ( $request->profile->move( public_path( 'uploads/profile' ), $fileName ) ) {
            $user->name = $request->name;
            $user->profile = $fileName;

            if ( $request->password ) {
                $user->password = bcrypt( $request->password );
            }

            if ( $user->save() ) {
                return back()->with( 'profile.update.success', 'Profile has been successfully updated.' );
            }

            return back()->with( 'profile.update.failed', 'Failed to update profile. Please try again.' );
        }

        return back()->with( 'profile.upload.failed', 'Failed to upload profile image. Please try again.' );
    }

    public function events() {
        $venues = Venue::orderBy( 'name', 'asc' )->get();

        return view( 'events', compact( 'venues') );
    }
}
