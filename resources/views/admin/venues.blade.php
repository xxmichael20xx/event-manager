@extends('layouts.admin')

@section('content')
    @if ( $venueAddSuccess = Session::get( 'venue.add.success' ) )
        <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueAddSuccess }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ( $venueAddFail = Session::get('venue.add.fail') )
        <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
            <p class="h4 mb-0 py-3">{{ $venueAddFail }}</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex justify-content-between">
                <h2 class="app-title">Venues</h2>
                
                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#addVenueModal">
                    <i class="fa fa-plus"></i> Add Venue
                </button>

                <div class="modal fade" id="addVenueModal" tabindex="-1" aria-labelledby="addVenueModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.venue.add') }}" autocomplete="off">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addVenueModalLabel">Add Evenue</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for="name" class="lead">{{ __('Name') }}</label>

                                        <div class="col-md-12">
                                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>

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
                                            <textarea id="description" name="description" class="form-control custom__text @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>

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
                                    <th class="cell" style="width: 20%;">Name</th>
                                    <th class="cell" style="width: 45%;">Description</th>
                                    <th class="cell" style="width: 17.5%;">Date Added</th>
                                    <th class="cell" style="width: 17.5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $venues as $venue )
                                    <tr>
                                        <td class="cell">{{ $venue->name }}</td>
                                        <td class="cell">{{ $venue->description }}</td>
                                        <td class="cell">{{ $venue->created_at->diffForHumans() }}</td>
                                        <td class="cell">
                                            <a class="btn btn-info text-white" href="{{ route('admin.venue.show', [ 'id' => $venue->id ]) }}"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="cell" colspan="3" align="center">No venue(s) yet</td>
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
                const addVenueModal = new bootstrap.Modal('#addVenueModal', {})
                addVenueModal.show()
            }
        </script>
    @endif
@endsection