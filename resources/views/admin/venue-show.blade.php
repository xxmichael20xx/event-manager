@extends('layouts.admin')

@section('content')
    @if ( $venueDeleteSuccess = Session::get( 'venue.delete.success' ) )
        <div class="alert alert-info text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueDeleteSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $venueDeleteFail = Session::get('venue.delete.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueDeleteFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $venueRestoreSuccess = Session::get( 'venue.restore.success' ) )
        <div class="alert alert-info text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueRestoreSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $venueRestoreFail = Session::get('venue.restore.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueRestoreFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $venueUpdateSuccess = Session::get( 'venue.update.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueUpdateSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $venueUpdateFail = Session::get('venue.update.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueUpdateFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-6 mx-auto">
            <div class="row mb-3">
                <div class="col">
                    <a href="{{ route('admin.venues') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Venues
                    </a>
                </div>
            </div>
            <div class="app-card app-card-orders-table shadow-sm">
                <div class="app-card-body p-5">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <strong>Name: {{ $venue->name }}</strong>
                            </div>
                            <div class="mb-2">
                                <strong>Description: </strong>{{ $venue->description }}
                            </div>
                            <div class="mb-2">
                                <strong>Date added: </strong>{{ date( 'M d, Y', strtotime( $venue->created_at ) ) }}
                            </div>

                            @if ( $venue->deleted_at )
                                <div class="mb-2">
                                    <strong>Date archived: </strong>{{ date( 'M d, Y @ h:ia', strtotime( $venue->deleted_at ) ) }}
                                </div>
                            @endif

                            <hr>

                            @if ( ! $venue->deleted_at )
                                <button type="button" class="btn btn-danger text-white" id="venue--delete">
                                    <i class="fa fa-trash"></i> Delete
                                </button>

                                <form id="venue--delete-form" action="{{ route('admin.venue.delete', [ 'id' => $venue->id ]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <button type="button" class="btn btn-success text-white" id="venue--restore">
                                    <i class="fa fa-undo"></i> Restore
                                </button>

                                <form id="venue--restore-form" action="{{ route('admin.venue.restore', [ 'id' => $venue->id ]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif

                            <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#updateVenueModal">
                                <i class="fa fa-pencil"></i> Update
                            </button>
                            <div class="modal fade" id="updateVenueModal" tabindex="-1" aria-labelledby="updateVenueModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.venue.update', [ 'id' => $venue->id ]) }}" autocomplete="off">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="updateVenueModalLabel">Update Venue</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <label for="name" class="lead">{{ __('Name') }}</label>

                                                    <div class="col-md-12">
                                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $venue->name }}" required>

                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="description" class="lead">{{ __('Description') }}</label>

                                                    <div class="col-md-12">
                                                        <textarea id="description" name="description" class="form-control custom__text @error('description') is-invalid @enderror" rows="5" required>{{ $venue->description }}</textarea>

                                                        @error('description')
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ( $errors->any() )
        <script>
            window.addEventListener( 'load', () => {
                const updateVenueModal = new bootstrap.Modal('#updateVenueModal', {})
                updateVenueModal.show()
            })
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        window.onload = () => {
            const deleteButton = document.getElementById( 'venue--delete' )
            if ( deleteButton ) {
                deleteButton.addEventListener( 'click', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'Venue will be archived!',
                        showCancelButton: true,
                        showConfirmButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Confirm'
                    }).then( (e) => {
                        if ( e.isConfirmed ) {
                            document.getElementById( 'venue--delete-form' ).submit()
                        }
                    } )
                } )
            }

            const restoreButton = document.getElementById( 'venue--restore' )
            if ( restoreButton ) {
                restoreButton.addEventListener( 'click', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'Venue will be restored!',
                        showCancelButton: true,
                        showConfirmButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Confirm'
                    }).then( (e) => {
                        if ( e.isConfirmed ) {
                            document.getElementById( 'venue--restore-form' ).submit()
                        }
                    } )
                } )
            }
        }
    </script>
@endsection