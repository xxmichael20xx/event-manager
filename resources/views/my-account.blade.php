@extends('layouts.guest', [ 'bodyClass' => 'my__account', 'pageTitle' => 'My Account' ])

@section('content')
    <section class="my__account-container pt-5 my-5">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-my-account-profile-list" data-bs-toggle="list" href="#list-my-account-profile" role="tab" aria-controls="list-my-account-profile"><i class="fa fa-user-edit"></i> Profile</a>
                        <a class="list-group-item list-group-item-action" id="list-my-account-events-list" data-bs-toggle="list" href="#list-my-account-events" role="tab" aria-controls="list-my-account-events"><i class="fa fa-calendar-days"></i> My Events</a>
                        <a class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-my-account-profile" role="tabpanel" aria-labelledby="list-my-account-profile-list">
                            @if ( $profileUpdateSuccess = Session::get( 'profile.update.success' ) )
                                <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                                    <p class="h4 mb-0 py-3">{{ $profileUpdateSuccess }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if ( $profileUpdateFailed = Session::get( 'profile.update.failed' ) )
                                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                    <p class="h4 mb-0 py-3">{{ $profileUpdateFailed }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if ( $profileUploadFailed = Session::get( 'profile.upload.failed' ) )
                                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                    <p class="h4 mb-0 py-3">{{ $profileUploadFailed }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="page-title">My Account - Profile</h3>

                                    <form method="POST" action="{{ route('profile-update') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row mb-4">
                                            <div class="col-4 mx-auto">
                                                @if ( Auth::user()->profile )
                                                    @php
                                                        $profileSrc = 'uploads/profile/' . Auth::user()->profile;
                                                    @endphp
                                                    <img src="{{ asset( $profileSrc ) }}" class="img-fluid rounded-circle" id="previewProfile">
                                                @else
                                                    <img class="img-fluid rounded-circle collapse" id="previewProfile">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="profile" class="lead">Upload your image</label>

                                            <div class="col-md-12">
                                                <input class="form-control" type="file" id="profile" name="profile" accept="image/*" required>

                                                @error('profile')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="name" class="lead">{{ __('Name') }}</label>

                                            <div class="col-md-12">
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

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
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ auth()->user()->email }}" required readonly>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="lead">{{ __('New Password') }}</label>

                                            <div class="col-md-12">
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm" class="lead">{{ __('Confirm Password') }}</label>

                                            <div class="col-md-12">
                                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-info text-white">
                                                    <i class="fa fa-save"></i> {{ __('Save Changes') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-my-account-events" role="tabpanel" aria-labelledby="list-my-account-events-list">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="page-title">My Account - Events</h3>

                                    <div class="table-responsive">
                                        <table class="table app-table-hover mb-0 text-left">
                                            <thead>
                                                <tr>
                                                    <th class="cell">Event #</th>
                                                    <th class="cell">Occasion</th>
                                                    <th class="cell">Date & Time</th>
                                                    <th class="cell">Date Created</th>
                                                    <th class="cell">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ( $myEvents as $event )
                                                    <tr>
                                                        <td class="cell">{{ $event->id }}</td>
                                                        <td class="cell">{{ $event->occasion }}</td>
                                                        <td class="cell">{{ date( 'M d, Y', strtotime( $event->date ) ) }} @ {{ date( 'h:ia', strtotime( $event->time ) ) }}</td>
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
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="cell" colspan="5" align="center">No event(s) yet</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    window.onload = () => {
        const inputEvents = [ 'change', 'blur', 'input', 'keyup', 'keydown' ]
        const newPassword = document.getElementById( 'password' )
        const newPasswordConfirm = document.getElementById( 'password-confirm' )

        inputEvents.forEach( el => {
            newPassword.addEventListener( el, () => {
                if ( newPassword.value == '' ) {
                    newPasswordConfirm.removeAttribute( 'required' )
                } else {
                    newPasswordConfirm.setAttribute( 'required', true )
                }
            } )
        } )

        // Profile input
        const profileInput = document.getElementById( 'profile' )
        profileInput.addEventListener( 'change', ( e ) => {
            const files = e.target.files
            
            if ( files.length > 0 ) {
                const extension = files[0].name.substring(files[0].name.lastIndexOf('.') + 1, files[0].name.length);
                const images = [ 'jpg', 'jpeg', 'png' ]

                if ( images.indexOf( extension ) == -1 ) return false

                const src = URL.createObjectURL( files[0] )
                const preview = document.getElementById( 'previewProfile' )
                preview.src = src
                preview.classList.remove( 'collapse' )
            }
        } )
    }
</script>
@endsection
