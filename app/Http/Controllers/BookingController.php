<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Rules\DateChecker;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Define the function to add new booking
     * from the user side /book-now page
     */
    public function bokkingAdd( Request $request ) {
        if ( auth()->user()->email_verified_at == NULL ) {
            return back()->with( 'auth.verified.false', 'Please check your email to verify your account to create an Booking Event.' );
        }

        $this->validate( $request, [
            'name' => 'required',
            'occasion' => 'required',
            'venue' => 'required',
            'date' => [ 'required', new DateChecker() ],
            'time' => 'required',
        ] );

        $userId = auth()->user()->id;
        $newEvent = new Event;
        $newEvent->user_id = $userId;
        $newEvent->occasion = $request->occasion;
        $newEvent->venue = $request->venue;
        $newEvent->date = $request->date;
        $newEvent->time = $request->time;

        if ( $newEvent->save() ) {
            return back()->with( 'booking.add.success', 'Your booking has been successfully created.' );
        }

        return back()->with( 'booking.add.fail', 'Failed to add your booking. Please try again.' );
    }
}
