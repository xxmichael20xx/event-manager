@extends('layouts.admin', [ 'pageTitle' => 'Events' ])

@section('content')
    <div class="row">
        <div class="col">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">Event #</th>
                                    <th class="cell">Customer</th>
                                    <th class="cell">Occasion</th>
                                    <th class="cell">Date & Time</th>
                                    <th class="cell">Venue</th>
                                    <th class="cell">Date Created</th>
                                    <th class="cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $events as $event )
                                    <tr>
                                        <td class="cell">{{ $event->id }}</td>
                                        <td class="cell">{{ $event->user->name }}</td>
                                        <td class="cell">{{ $event->occasion }}</td>
                                        <td class="cell">{{ $event->date }} @ {{ $event->time }}</td>
                                        <td class="cell">{{ $event->venue }}</td>
                                        <td class="cell">{{ $event->created_at->diffForHumans() }}</td>
                                        <td class="cell">
                                            <a class="btn btn-info text-white" href="javascript:;">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="cell" colspan="7">No event(s) yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!--//table-responsive-->
                    
                </div><!--//app-card-body-->		
            </div>
        </div>
    </div>
@endsection