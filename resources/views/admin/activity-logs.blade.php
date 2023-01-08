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
                                    <th class="cell">No</th>
                                    <th class="cell">Performed by</th>
                                    <th class="cell">Title</th>
                                    <th class="cell">Description</th>
                                    <th class="cell">Date Performed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $activityLogs as $activityLog )
                                    <tr>
                                        <td class="cell">#{{ $activityLog->id }}</td>
                                        <td class="cell">{{ $activityLog->user->name }}</td>
                                        <td class="cell">{{ $activityLog->title }}</td>
                                        <td class="cell">{!! $activityLog->description !!}</td>
                                        <td class="cell">{{ $activityLog->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="cell" colspan="5" align="center">No activity log(s) yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-5">
                        <div class="col custom__pagination">
                            {{ $activityLogs->links( 'pagination::bootstrap-5' ) }}
                        </div>
                    </div>
                </div>	
            </div>
        </div>
    </div>
@endsection