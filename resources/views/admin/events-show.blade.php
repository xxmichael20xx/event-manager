@extends('layouts.admin')

@section('content')
    @if ( $bookingDeleteSuccess = Session::get( 'booking.delete.success' ) )
        <div class="alert alert-info text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingDeleteSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $bookingDeleteFail = Session::get('booking.delete.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingDeleteFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $bookingDoneSuccess = Session::get( 'booking.done.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingDoneSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $bookingDoneFail = Session::get('booking.done.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingDoneFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $bookingUpdateSuccess = Session::get( 'booking.update.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingUpdateSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $bookingUpdateFail = Session::get('booking.update.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $bookingUpdateFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $eventAddPaymentSuccess = Session::get( 'event.add.payment.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $eventAddPaymentSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $eventAddPaymentFailed = Session::get('event.add.payment.failed') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $eventAddPaymentFailed }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('admin.events') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Back to Events
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-5">
                    <p class="h3 mb-3">Event Details</p>
                    <div class="row">
                        <div class="col">
                            @php
                                $eventUser = $event->user;
                                $eventName = $event->user->name;

                                if ( $eventUser->role == 'admin' ) {
                                    $eventName = $event->name;
                                }
                            @endphp

                            <div class="mb-2">
                                <strong>Event #{{ $event->id }}</strong>
                            </div>
                            <div class="mb-2">
                                <strong>Customer: </strong>{{ $eventName }}
                            </div>
                            <div class="mb-2">
                                <strong>Occasion: </strong>{{ $event->occasion }}
                            </div>
                            <div class="mb-2">
                                <strong>Date & Time: </strong>{{ date( 'M d, Y', strtotime( $event->date ) ) }} @ {{ $event->time }}
                            </div>
                            <div class="mb-2">
                                <strong>Venue: </strong>{{ $event->single_venue->name }}
                            </div>
                            <div class="mb-2">
                                <strong>Date Created: </strong>{{ $event->created_at->diffForHumans() }}
                            </div>
                            
                            @if ( $eventUser->role == 'admin' )
                                <strong>Note: Added by Admin</strong>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer px-5 py-3 bg-white">
                    <div class="row">
                        <div class="col-12">
                            @if ( $event->status == 'pending' && ! $event->deleted_at )
                                {{-- Archive/Delete buttton --}}
                                <button type="button" class="btn btn-danger text-white" id="event--archive">
                                    <i class="fa fa-trash"></i> Archive
                                </button>

                                {{-- Archive/Delete form --}}
                                <form id="event--archive-form" action="{{ route('admin.booking.delete', [ 'id' => $event->id ]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                {{-- Done buttton --}}
                                <button type="button" class="btn btn-success text-white" id="event--done" data-payment="{{ $event->payment_status }}">
                                    <i class="fa fa-check-circle"></i> Done
                                </button>

                                {{-- Done form --}}
                                <form id="event--done-form" action="{{ route('admin.booking.done', [ 'id' => $event->id ]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#updateEventModal">
                                    <i class="fa fa-pencil"></i> Update
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('admin.booking.update', [ 'id' => $event->id ]) }}" autocomplete="off">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateEventModalLabel">Update Event</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label for="occasion" class="lead">{{ __('Occasion') }}</label>

                                                        <div class="col-md-12">
                                                            <input type="text" id="occasion" name="occasion" class="form-control @error('occasion') is-invalid @enderror" value="{{ $event->occasion }}" required>

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
                                                            <input type="date" id="date" name="date" min="{{ now() }}" max="{{ \Carbon\Carbon::now()->addYears( 10 ) }}" class="form-control @error('date') is-invalid @enderror" value="{{ $event->date }}" required>
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
                                                                    <option value="{{ $time }}" @if($event->time == $time) selected @endif>{{ $time }}</option>
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
                                                                <option value="" disabled>Select a venue</option>
                                                                @foreach ($venues as $venue)
                                                                    <option value="{{ $venue->name }}" @if($venue->id == $event->venue) selected @endif>{{ $venue->name }}</option>
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
                                                    <button type="submit" class="btn btn-info text-white">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if ( $event->status == 'done' )
                                <div class="text-center">
                                    <strong><i class="fa fa-check-circle"></i> Marked as `Done` on {{ $event->updated_at }}</strong>
                                </div>
                            @endif

                            @if ( $event->deleted_at )
                                <div class="text-center">
                                    <strong><i class="fa fa-archive"></i> Archived on {{ $event->updated_at }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 mx-auto">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body p-5">
                    <p class="h3 mb-3">Payment Details</p>
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <strong>Payment Status: </strong>{{ toWords( $event->payment_status ) }}
                            </div>
                            <div class="mb-2">
                                <strong>Paid amount: </strong>{{ ( $event->payment_status == 'no_payment' ) ? '₱0' : '₱' . number_format( $event->payment ) }}
                            </div>
                            <div class="mb-2">
                                <strong>Balance: </strong>₱{{ number_format( 2500 - $event->payment ) }}
                            </div>
                        </div>
                    </div>
                </div>

                @if ( ! $event->deleted_at && $event->payment_status !== 'paid' )
                    <div class="card-footer px-5 py-3 bg-white">
                        @if ( $event->payment_status !== 'paid' )
                            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#addPayment">
                                <i class="fa fa-hand"></i> Add Payment
                            </button>

                            <div class="modal fade" id="addPayment" tabindex="-1" aria-labelledby="addPaymentLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.event.payment', [ 'id' => $event->id ]) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="addPaymentLabel">Add Payment</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <label class="lead">Balance: ₱{{ number_format( 2500 - $event->payment ) }}</label>
                                                </div>
                                                <div class="row my-3">
                                                    <label for="amount" class="lead">Amount</label>

                                                    <div class="col-12">
                                                        @php
                                                            $amount = $event->payment;
                                                            $min = 500;
                                                            $max = 2500;

                                                            if ( $amount > 0 ) {
                                                                $max = 2500 - $amount;
                                                                $min = 1;
                                                            } else {
                                                                $min = 1250;
                                                                $max = 2500;
                                                            }
                                                        @endphp
                                                        <input type="number" name="amount" id="amount" min="{{ $min }}" max="{{ $max }}" class="form-control @error('amount') is-invalid @enderror" value="0" required>

                                                        @error('amount')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <label class="lead">Quick button</label>

                                                    <div class="col-12">
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-info text-white quick__buttons" data-value="reset">Reset</button>
                                                            <button type="button" class="btn btn-info text-white quick__buttons" data-value="100">100</button>
                                                            <button type="button" class="btn btn-info text-white quick__buttons" data-value="500">500</button>
                                                            <button type="button" class="btn btn-info text-white quick__buttons" data-value="full" data-balance="{{ 2500 - $event->payment }}">Full Balance</button>
                                                        </div>
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
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload = () => {
            // Archive/Delete button
            const archiveButton = document.getElementById( 'event--archive' )
            archiveButton.addEventListener( 'click', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Event will be permanently archived!',
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Confirm'
                }).then( (e) => {
                    if ( e.isConfirmed ) {
                        document.getElementById( 'event--archive-form' ).submit()
                    }
                } )
            } )

            // Done button
            const doneButton = document.getElementById( 'event--done' )
            doneButton.addEventListener( 'click', function() {
                const paymentStatus = doneButton.getAttribute( 'data-payment' )
                let text = 'Event will be marked as `Done`!'

                if ( paymentStatus !== 'paid' ) {
                    text = 'Event will be marked as `Done` even though the event is not yet Fully Paid!'
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: text,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Confirm'
                }).then( (e) => {
                    if ( e.isConfirmed ) {
                        document.getElementById( 'event--done-form' ).submit()
                    }
                } )
            } )

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

            const quickButtons = document.querySelectorAll( '.quick__buttons' )
            if ( quickButtons.length > 0 ) {
                quickButtons.forEach( (el) => {
                    el.addEventListener( 'click', () => {
                        const value = el.getAttribute( 'data-value' )
                        const amountInput = document.getElementById( 'amount' )

                        if ( value == 'reset' ) {
                            amountInput.value = 0
                        } else if ( value == 'full' ) {
                            const amountBalance = el.getAttribute( 'data-balance' )
                            amountInput.value = amountBalance
                        } else {
                            let amountInputCurrent = amountInput.value
                            amountInputCurrent = Number( amountInputCurrent ) + Number( value )
                            amountInput.value = amountInputCurrent
                        }
                    } )
                } )
            }
        }
    </script>
@endsection