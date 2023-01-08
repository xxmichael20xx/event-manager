@extends('layouts.admin')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex justify-content-between">
                <h2 class="app-title">Activity Logs</h2>
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
                                    <th class="cell">ID</th>
                                    <th class="cell">Name</th>
                                    <th class="cell">Email</th>
                                    <th class="cell">Total Booking Events</th>
                                    <th class="cell">Account Status</th>
                                    <th class="cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $users as $user )
                                    <tr>
                                        <td class="cell">#{{ $user->id }}</td>
                                        <td class="cell">{{ $user->name }}</td>
                                        <td class="cell">{{ $user->email }}</td>
                                        <td class="cell">{{ $user->events->count() }}</td>
                                        <td class="cell">
                                            @if ( $user->status == 'activated' )
                                                <div class="text-success">
                                                    <i class="fa-solid fa-circle"></i> Activated
                                                </div>
                                            @else
                                                <div class="text-danger">
                                                    <i class="fa-solid fa-circle"></i> Deactivated
                                                </div>
                                            @endif
                                        </td>
                                        <td class="cell">
                                            <a class="btn btn-info text-white" href="{{ route('admin.users.show', [ 'id' => $user->id ]) }}"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="cell" colspan="6" align="center">No user(s) yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-5">
                        <div class="col custom__pagination">
                            {{ $users->links( 'pagination::bootstrap-5' ) }}
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </div>
@endsection