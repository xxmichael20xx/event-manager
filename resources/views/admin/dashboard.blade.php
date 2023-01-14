@extends('layouts.admin', [ 'pageTitle' => 'Overview' ])

@section('content')
    <div class="row g-4 mb-4 mt-2">
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Events</h4>
                    <div class="stats-figure">{{ $totalEvents }}</div>
                    <div class="stats-meta">Total</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.events') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Events</h4>
                    <div class="stats-figure">{{ $todayEvents }}</div>
                    <div class="stats-meta">Today</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.events') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Users</h4>
                    <div class="stats-figure">{{ $totalUsers }}</div>
                    <div class="stats-meta">Total count</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.users') }}"></a>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Sales</h4>
                    <div class="stats-figure">₱{{ number_format( $totalSales ) }}</div>
                    <div class="stats-meta">Total sales</div>
                </div>
                <a class="app-card-link-mask" href="{{ route('admin.events') }}"></a>
            </div>
        </div>
    </div>
@endsection