@extends('layouts.guest', [ 'bodyClass' => 'home', 'pageTitle' => 'Home' ])

@section('content')
    <section class="banner position-relative" id="banner">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white">Welcome To</h1>
            <h3 class="text-white">Event Manager!</h3>
            <a class="btn btn-info mt-3 text-white" href="javascript:;">Learn More</a>
        </div>
    </section>

  
@endsection
