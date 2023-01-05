<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        return view( 'admin.dashboard' );
    }

    public function events() {
        $events = Event::latest()->get();

        return view( 'admin.events', compact( 'events' ) );
    }
}
