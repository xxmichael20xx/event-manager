<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $totalEvents = Event::all()->count();
        $todayEvents = Event::whereDate( 'date', Carbon::today() )->get()->count();

        return view( 'admin.dashboard', compact( 'totalEvents', 'todayEvents' ) );
    }

    public function events() {
        $events = Event::withTrashed()->latest()->get();

        return view( 'admin.events', compact( 'events' ) );
    }

    public function eventsShow( Request $request, $id ) {
        $event = Event::withTrashed()->where( 'id', $id )->first();

        return view( 'admin.events-show', compact( 'event' ) );
    }

    public function deleteEvent( Request $request, $id ) {
        $event = Event::find( $id );
        
        if ( $event->delete() ) {
            return back()->with( 'booking.delete.success', 'Booking event has been successfully archived.' );
        }

        return back()->with( 'booking.delete.fail', 'Failed to archive booking event. Please try again.' );
    }

    public function doneEvent( Request $request, $id ) {
        $event = Event::find( $id );
        $event->status = 'done';
        
        if ( $event->save() ) {
            return back()->with( 'booking.done.success', 'Booking event has been successfully marked as `Done`.' );
        }

        return back()->with( 'booking.done.fail', 'Failed to mark event as `Done`. Please try again.' );
    }

    public function updateEvent( Request $request, $id ) {
        $this->validate( $request, [
            'occasion' => 'required',
            'venue' => 'required',
            'date' => 'required',
            'time' => 'required',
        ] );

        $updateEvent = Event::find( $id );
        $updateEvent->occasion = $request->occasion;
        $updateEvent->venue = $request->venue;
        $updateEvent->date = $request->date;
        $updateEvent->time = $request->time;

        if ( $updateEvent->save() ) {
            return back()->with( 'booking.update.success', 'Booking event has been successfully updated.' );
        }

        return back()->with( 'booking.update.fail', 'Failed to update booking event. Please try again.' );
    }

    public function addEvent( Request $request ) {
        $this->validate( $request, [
            'name' => 'required',
            'occasion' => 'required',
            'venue' => 'required',
            'date' => 'required',
            'time' => 'required',
        ] );

        $userId = auth()->user()->id;
        $newEvent = new Event;
        $newEvent->user_id = $userId;
        $newEvent->name = $request->name;
        $newEvent->occasion = $request->occasion;
        $newEvent->venue = $request->venue;
        $newEvent->date = $request->date;
        $newEvent->time = $request->time;

        if ( $newEvent->save() ) {
            return back()->with( 'booking.add.success', 'New booking event has been successfully created.' );
        }

        return back()->with( 'booking.add.fail', 'Failed to add new booking event. Please try again.' );
    }
}
