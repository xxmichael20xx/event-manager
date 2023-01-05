<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Define the function to add new booking
     * from the user side /book-now page
     */
    public function bokkingAdd( Request $request ) {
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
