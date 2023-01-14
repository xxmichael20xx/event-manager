<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use App\Rules\DateChecker;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Define the function to add new booking
     * from the user side /book-now page
     */
    public function bookingAdd( Request $request ) {
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
            $message = '
                Your booking has been successfully created.
                <br><br>
                Please be advised that you need head to the office to pay a partial payment to fully reserve your Booking, and also so that you can give more precise instruction about the Venue.
                <br><br>
                Thank you and have a greay day!
            ';
            return back()->with( 'booking.add.success', $message );
        }

        return back()->with( 'booking.add.fail', 'Failed to add your booking. Please try again.' );
    }

    public function availableSchedules( Request $request ) {
        $date = $request->date;
        $events = Event::where( 'date', $date )->where( 'status', 'pending' )->get();
        $availableVenues = $this->getAvailableVenues( $events );
        $availableTimes = $this->getAvailableTimes( $events );

        return response()->json([
            'availability' => 'all',
            'availableVenues' => $availableVenues,
            'availableTimes' => $availableTimes
        ]);
    }
    
    /**
     * Start of generating available venue options
     */
    public function getAvailableVenues( $events ) {
        $count = 0;
        $availableVenues = '<option value="" disabled selected>Select a venue</option>';

        // Check if the selected data event has no added events
        if ( $events->count() < 1 ) {
            $allVenues = Venue::orderBy( 'name', 'desc' )->get();

        } else {
            $skipVenues = [];
            foreach ( $events as $event ) {
                $skipVenues[] = $event->id;
            }

            // Fetch all venue where venue ID is not the same
            // with the events on the selected date
            $allVenues = Venue::whereNotIn( 'id', $skipVenues )->orderBy( 'name', 'desc' )->get();
        }

        // Loop through all fetched venues
        // to create a dynamic <select></select> options
        foreach ( $allVenues as $allVenue ) {
            $availableVenues .= sprintf( '<option value="%s">%s</option>', $allVenue->id, $allVenue->name );
            $count++;
        }

        // Check if the dynamic <select></select> options is blank
        // then create a single option the is disabled
        if ( $count < 1 ) {
            $availableVenues .= '<option value="" disabled>No available venue on the selected date.</option>';
        }

        return $availableVenues;
    }
    
    /**
     * Start of generating available venue times
     */
    public function getAvailableTimes( $events ) {
        $count = 0;
        $availableTimes = '<option value="" disabled selected>Select a time</option>';
        $times = [
            '7AM', '8AM', '9AM', '10AM', '11AM',
            '12PM', '1PM', '2PM', '3PM', '4PM', '5PM',
            '6PM', '8PM', '9PM', '10PM'
        ];

        // Check if the selected data event has no added events
        if ( $events->count() < 1 ) {
            $times = $times;

        } else {
            // Create an array of item of the selected date
            $skipTimes = [];
            foreach ( $events as $event ) {
                $skipTimes[] = $event->time;
            }

            // Loop through all of the time of events on the selected date
            foreach ( $skipTimes as $skipTime ) {
                // Search for the "key" of the looped time
                $key = array_search( $skipTime, $times );
                if ( $key !== false ) {
                    // Remove the specific time in the $times variable
                    unset( $times[$key] );
                }
            }

            array_unique( $times );
        }

        // Loop through all fetched venues
        // to create a dynamic <select></select> options
        foreach ( $times as $time ) {
            $availableTimes .= sprintf( '<option value="%s">%s</option>', $time, $time );
            $count++;
        }

        // Check if the dynamic <select></select> options is blank
        // then create a single option the is disabled
        if ( $count < 1 ) {
            $availableTimes .= '<option value="" disabled>No available time on the selected date.</option>';
        }

        return $availableTimes;
    }
}
