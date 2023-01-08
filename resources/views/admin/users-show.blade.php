@extends('layouts.admin')

@section('content')
    @if ( $userActivateSuccess = Session::get( 'user.activate.success' ) )
        <div class="alert alert-info text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $userActivateSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $userActivateFail = Session::get('user.activate.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $userActivateFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ( $userDeactivateSuccess = Session::get( 'user.deactivate.success' ) )
        <div class="alert alert-info text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $userDeactivateSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $userDeactivateFail = Session::get('user.deactivate.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $userDeactivateFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="row mb-3">
                <div class="col">
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Users
                    </a>
                </div>
            </div>
            <div class="app-card app-card-orders-table shadow-sm">
                <div class="app-card-body p-5">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <strong>User ID #{{ $user->id }}</strong>
                            </div>
                            <div class="mb-2">
                                <strong>Name: </strong>{{ $user->name }}
                            </div>
                            <div class="mb-2">
                                <strong>Email: </strong>{{ $user->email }}
                            </div>
                            <div class="mb-2">
                                <strong>Email Verified: </strong>{{ ( $user->email_verified_at ) ? date( 'M d, Y @ h:ia', strtotime( $user->email_verified_at ) ) : 'Not yet verified' }}
                            </div>
                            <div class="mb-2">
                                <strong>Total Booking Events: </strong>{{ $user->events->count() }}
                            </div>

                            <hr>

                            @if ( $user->status == 'activated' )
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#userDeactivateModal">
                                    <i class="fa fa-times-circle"></i> Deactivate
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="userDeactivateModal" tabindex="-1" aria-labelledby="userDeactivateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('admin.users.deactivate', [ 'id' => $user->id ]) }}" autocomplete="off" id="userDeactivateForm">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="userDeactivateModalLabel">Deactivate User</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label for="notes" class="lead">{{ __('Reason for deactivation:') }}</label>

                                                        <div class="col-md-12">
                                                            <textarea id="notes" name="notes" class="form-control custom__text @error('notes') is-invalid @enderror" rows="5" required></textarea>

                                                            @error('notes')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger text-white" id="user--deactivate">Deactivate</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if ( $user->status == 'deactivated' )
                                <div class="mb-2">
                                    <strong>Account deactivated: </strong> {{ $user->notes }}
                                </div>
                                <div class="mb-2">
                                    <strong>Date deactivated: </strong> {{ $user->updated_at }}
                                </div>
                                <br>
                                {{-- Activate buttton --}}
                                <button type="button" class="btn btn-success text-white" id="user--activate">
                                    <i class="fa fa-check-circle"></i> Activate
                                </button>

                                {{-- Activate form --}}
                                <form id="user--activate-form" action="{{ route('admin.users.activate', [ 'id' => $user->id ]) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ( $errors->any() )
        <script>
            window.onload = () => {
                const userDeactivateModal = new bootstrap.Modal('#userDeactivateModal', {})
                userDeactivateModal.show()
            }
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        window.onload = () => {
            const activateButton = document.getElementById( 'user--activate' )

            if ( activateButton ) {
                activateButton.addEventListener( 'click', () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'User account will be activated!',
                        showCancelButton: true,
                        showConfirmButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Confirm'
                    }).then( (e) => {
                        if ( e.isConfirmed ) {
                            document.getElementById( 'user--activate-form' ).submit()
                        }
                    } )
                } )
            }

            const deactivateButton = document.getElementById( 'user--deactivate' )

            if ( deactivateButton ) {
                deactivateButton.addEventListener( 'click', () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Are you sure?',
                        text: 'User account will be deactivated!',
                        showCancelButton: true,
                        showConfirmButton: true,
                        cancelButtonText: 'Cancel',
                        confirmButtonText: 'Confirm'
                    }).then( (e) => {
                        if ( e.isConfirmed ) {
                            document.getElementById( 'userDeactivateForm' ).submit()
                        }
                    } )
                } )
            }
        }
    </script>
@endsection