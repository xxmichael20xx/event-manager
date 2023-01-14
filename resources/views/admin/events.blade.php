@extends('layouts.admin')

@section('content')
    @if ( $bookingAddSuccess = Session::get( 'booking.add.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingAddSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $bookingAddFail = Session::get('booking.add.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingAddFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex justify-content-between">
                <h2 class="app-title">Events</h2>
                
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="fa fa-plus"></i> Add Event
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.booking.add') }}" autocomplete="off">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addEventModalLabel">Add Event</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="name" class="lead">{{ __('Name') }}</label>

                                        <div class="col-md-12">
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="lead">{{ __('Email Address') }}</label>

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="occasion" class="lead">{{ __('Occasion') }}</label>

                                        <div class="col-md-12">
                                            <input type="text" id="occasion" name="occasion" class="form-control @error('occasion') is-invalid @enderror" required>

                                            @error('occasion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="date" class="lead">{{ __('Date') }}</label>

                                        <div class="col-md-12">
                                            <input type="date" id="date" name="date" min="{{ now() }}" max="{{ \Carbon\Carbon::now()->addYears( 10 ) }}" class="form-control @error('date') is-invalid @enderror" required>
                                            <small class="text-help">Note: Changing date will refresh the available Time and Venue based on the selected date</small>

                                            @error('date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="time" class="lead">{{ __('Time') }}</label>

                                        <div class="col-md-12">
                                            @php
                                                $times = [
                                                    '7AM', '8AM', '9AM', '10AM', '11AM',
                                                    '12PM', '1PM', '2PM', '3PM', '4PM', '5PM',
                                                    '6PM', '8PM', '9PM', '10PM'
                                                ];
                                            @endphp
                                            <select name="time" id="time" class="form-control @error('time') is-invalid @enderror" disabled required>
                                                <option value="" selected disabled>Select a time</option>
                                                @foreach ($times as $time)
                                                    <option value="{{ $time }}">{{ $time }}</option>
                                                @endforeach
                                            </select>

                                            @error('time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="venue" class="lead">{{ __('Venue') }}</label>

                                        <div class="col-md-12">
                                            <select name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror" disabled required>
                                                <option value="" selected disabled>Select a venue</option>
                                                @foreach ($venues as $venue)
                                                    <option value="{{ $venue->name }}">{{ $venue->name }}</option>
                                                @endforeach
                                            </select>

                                            @error('venue')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info text-white">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body p-5">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">Event #</th>
                                    <th class="cell">Customer</th>
                                    <th class="cell">Occasion</th>
                                    <th class="cell">Date & Time</th>
                                    <th class="cell">Date Created</th>
                                    <th class="cell">Status</th>
                                    <th class="cell">Payment Status</th>
                                    <th class="cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $events as $event )
                                    @php
                                        $eventUser = $event->user;
                                        $eventName = $event->user->name;

                                        if ( $eventUser->role == 'admin' ) {
                                            $eventName = $event->name;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="cell">{{ $event->id }}</td>
                                        <td class="cell">{{ $eventName }}</td>
                                        <td class="cell">{{ $event->occasion }}</td>
                                        <td class="cell">{{ date( 'M d, Y', strtotime( $event->date ) ) }} @ {{ $event->time }}</td>
                                        <td class="cell">{{ $event->created_at->diffForHumans() }}</td>
                                        <td class="cell">
                                            @if ( $event->deleted_at )
                                                <div class="text-danger">
                                                    <i class="fa-solid fa-circle"></i> Archived
                                                </div>
                                            @elseif ( $event->status == 'pending' )
                                                <div class="text-warning">
                                                    <i class="fa-solid fa-circle"></i> Pending
                                                </div>
                                            @else
                                                <div class="text-success">
                                                    <i class="fa-solid fa-circle"></i> Done
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $paymentStatus = $event->payment_status;
                                            @endphp
                                            @if ( $paymentStatus == 'no_payment' )
                                                <div class="text-danger">
                                                    <i class="fa-solid fa-circle"></i> {{ toWords( $paymentStatus ) }}
                                                </div>
                                            @elseif ( $paymentStatus == 'partial' )
                                                <div class="text-info">
                                                    <i class="fa-solid fa-circle"></i> {{ toWords( $paymentStatus ) }}
                                                </div>
                                            @else
                                                <div class="text-success">
                                                    <i class="fa-solid fa-circle"></i> {{ toWords( $paymentStatus ) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="cell">
                                            <a class="btn btn-info text-white" href="{{ route('admin.events.show', [ 'id' => $event->id ]) }}"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="cell" colspan="7" align="center">No event(s) yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>	
            </div>
        </div>
    </div>

    @if ( $errors->any() )
        <script>
            window.onload = () => {
                const addEventModal = new bootstrap.Modal('#addEventModal', {})
                addEventModal.show()
            }
        </script>
    @endif
@endsection

@section('scripts')
<script>
    window.addEventListener( 'DOMContentLoaded', (e) => {
        const dateInput = document.getElementById( 'date' )

        if ( dateInput ) {
            dateInput.addEventListener( 'change', () => {
                if ( dateInput.value !== '') {
                    fetchAvailableSchedules()
                }
            } )
        }

        function fetchAvailableSchedules() {
            const dateInput = document.getElementById( 'date' )
            const data = {
                'date': dateInput.value,
            }
            fetch( '/available-schedules', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify( data )
            } ).then( r => r.json() ).then( res => {
                const venue = document.getElementById( 'venue' )
                const time = document.getElementById( 'time' )

                if ( venue ) {
                    venue.removeAttribute( 'disabled' )
                    venue.innerHTML = res.availableVenues
                }

                if ( time ) {
                    time.removeAttribute( 'disabled' )
                    time.innerHTML = res.availableTimes
                }
            } )
        }
    } )
</script>
@endsection