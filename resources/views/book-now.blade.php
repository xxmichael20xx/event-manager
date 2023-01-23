@extends('layouts.guest', [ 'bodyClass' => 'book__now', 'pageTitle' => 'Book Now' ])

@section('content')
    <section class="banner position-relative" id="banner">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white">Book Now</h1>
            <h3 class="text-white">↓</h3>
        </div>
    </section>

    <section class="py-5 my-5" id="bookNow">
        <div class="container">
            <div class="row">
                <div class="col-8 m-auto card shadow">
                    <div class="card-body row p-5">
                        @if ( $authVerifiedFalse = Session::get( 'auth.verified.false' ) )
                            <div class="alert alert-danger text-center">
                                <p class="h3 mb-0 py-3">{{ $authVerifiedFalse }}</p>
                                <a href="{{ route('book-now') }}" class="btn btn-link">Reload Page</a>
                            </div>
                        @elseif ( $bookingAddSuccess = Session::get( 'booking.add.success' ) )
                            <div class="alert alert-success text-center">
                                <p class="h3 mb-0 py-3">{!! $bookingAddSuccess !!}</p>
                            </div>
                        @elseif ( $bookingAddFail = Session::get('booking.add.fail') )
                            <div class="alert alert-danger text-center">
                                <p class="h3 mb-0 py-3">{{ $bookingAddFail }}</p>
                            </div>
                        @else
                            <div class="col">
                                <div class="text-center mb-5">
                                    <h2>Book Now</h2>
                                    <label class="lead">Enter your details below and please keep in mind all booking venue costs ₱2,500</label>
                                </div>
                                <form method="POST" action="{{ route('booking.add') }}" autocomplete="off">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="name" class="lead">{{ __('Name') }}</label>

                                        <div class="col-md-12">
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly required>

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
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" readonly required>

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

                                    <div class="row mb-0">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-info text-white">
                                                {{ __('Submit Booking') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
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