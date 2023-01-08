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

    <div class="row">
        <div class="col-6 mx-auto">
            <div class="row mb-3">
                <div class="col">
                    <a href="{{ route('admin.events') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Events
                    </a>
                </div>
            </div>
            <div class="app-card app-card-orders-table shadow-sm">
                <div class="app-card-body p-5">
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
                                <strong>Date & Time: </strong>{{ date( 'M d, Y', strtotime( $event->date ) ) }} @ {{ date( 'h:ia', strtotime( $event->time ) ) }}
                            </div>
                            <div class="mb-2">
                                <strong>Venue: </strong>{{ $event->venue }}
                            </div>
                            <div class="mb-2">
                                <strong>Date Created: </strong>{{ $event->created_at->diffForHumans() }}
                            </div>
                            
                            @if ( $eventUser->role == 'admin' )
                                <strong>Note: Added by Admin</strong>
                            @endif

                            <hr>

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
                                <button type="button" class="btn btn-success text-white" id="event--done">
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
                                                            <input type="time" id="time" name="time" class="form-control @error('time') is-invalid @enderror" value="{{ $event->time }}" required>

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
                                                            <select name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror" required>
                                                                <option value="" disabled>Select a venue</option>
                                                                <option value="hallway" {{ $event->venue == 'hallway' ? 'selected' : '' }}>Hallway</option>
                                                                <option value="terrace" {{ $event->venue == 'terrace' ? 'selected' : '' }}>Terrace</option>
                                                                <option value="garden" {{ $event->venue == 'garden' ? 'selected' : '' }}>Garden</option>
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
                Swal.fire({
                    icon: 'warning',
                    title: 'Are you sure?',
                    text: 'Event will be marked as `Done`!',
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
        }
    </script>
@endsection