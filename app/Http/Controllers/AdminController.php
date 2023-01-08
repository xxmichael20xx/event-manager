<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\User;
use App\Rules\DateChecker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $totalEvents = Event::all()->count();
        $todayEvents = Event::whereDate( 'date', Carbon::today() )->get()->count();
        $totalUsers = User::where( 'role', 'user' )->get()->count();

        return view( 'admin.dashboard', compact( 'totalEvents', 'todayEvents', 'totalUsers' ) );
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
            $logTitle = "Booking Event Archive";
            $logDescription = "Archived the booking event for customer `{$event->name}`. Event ID: {$event->id}";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'booking.delete.success', 'Booking event has been successfully archived.' );
        }

        return back()->with( 'booking.delete.fail', 'Failed to archive booking event. Please try again.' );
    }

    public function doneEvent( Request $request, $id ) {
        $event = Event::find( $id );
        $event->status = 'done';
        
        if ( $event->save() ) {
            $logTitle = "Booking Event Done";
            $logDescription = "Event for customer `{$event->name}` has been marked as `Done`. Event ID: {$event->id}";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'booking.done.success', 'Booking event has been successfully marked as `Done`.' );
        }

        return back()->with( 'booking.done.fail', 'Failed to mark event as `Done`. Please try again.' );
    }

    public function updateEvent( Request $request, $id ) {
        $this->validate( $request, [
            'occasion' => 'required',
            'venue' => 'required',
            'date' => [ 'required', new DateChecker() ],
            'time' => 'required',
        ] );

        $updateEvent = Event::find( $id );
        $updateEvent->occasion = $request->occasion;
        $updateEvent->venue = $request->venue;
        $updateEvent->date = $request->date;
        $updateEvent->time = $request->time;

        if ( $updateEvent->save() ) {
            $logTitle = "Booking Event Update";
            $logDescription = "Updated the booking event for customer `$updateEvent->name`. Event ID: {$updateEvent->id}";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'booking.update.success', 'Booking event has been successfully updated.' );
        }

        return back()->with( 'booking.update.fail', 'Failed to update booking event. Please try again.' );
    }

    public function addEvent( Request $request ) {
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
        $newEvent->name = $request->name;
        $newEvent->occasion = $request->occasion;
        $newEvent->venue = $request->venue;
        $newEvent->date = $request->date;
        $newEvent->time = $request->time;

        if ( $newEvent->save() ) {
            $logTitle = "New Booking Event";
            $logDescription = "Added a new booking event for `{$request->name}`. Event ID: {$newEvent->id}";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'booking.add.success', 'New booking event has been successfully created.' );
        }

        return back()->with( 'booking.add.fail', 'Failed to add new booking event. Please try again.' );
    }

    public function activityLogs( Request $request ) {
        $activityLogs = ActivityLog::latest()->paginate( 10 );

        return view( 'admin.activity-logs', compact( 'activityLogs' ) );
    }

    public function adminUsers( Request $request ) {
        $users = User::where( 'role', 'user' )->latest()->paginate( 10 );

        return view( 'admin.users', compact( 'users' ) );
    }

    public function adminUsersShow( Request $request, $id ) {
        $user = User::findOrFail( $id );

        return view( 'admin.users-show', compact( 'user' ) );
    }

    public function adminUsersActivate( Request $request, $id ) {
        $user = User::find( $id );
        $user->status = 'activated';
        $user->notes = NULL;

        if ( $user->save() ) {
            $logTitle = "User Account activated";
            $logDescription = "Activated a user account with an ID of {$id}.";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'user.activate.success', "User account has been successfuly activated." );
        }

        return back()->with( 'user.activate.fail', 'Failed to activate account. Please try again.' );
    }

    public function adminUsersDeactivate( Request $request, $id ) {
        $this->validate( $request, [
            'notes' => 'required'
        ] );
        $user = User::find( $id );
        $user->status = 'deactivated';
        $user->notes = $request->notes;

        if ( $user->save() ) {
            $logTitle = "User Account Deactivate";
            $logDescription = "Deactivated the User with an ID of {$id}.<br>Reason: {$request->notes}";
            $this->addLog( $logTitle, $logDescription );
            return back()->with( 'user.deactivate.success', "User account has been successfuly deactivated." );
        }

        return back()->with( 'user.deactivate.fail', 'Failed to deactivate account. Please try again.' );
    }
}
