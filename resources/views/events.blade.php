@extends('layouts.guest', [ 'bodyClass' => 'events', 'pageTitle' => 'Events' ])

@section('content')
    <section class="banner position-relative" id="banner">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white">Events</h1>
            <h3 class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h3>
        </div>
    </section>

    <section class="py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center">
                    <p class="h5">
                        Are you looking for a fun and exciting event to attend this summer? Look no further because we offer various places for you events.

                        <br>
                        <br>

                        Enjoy delicious food and drinks, listen to live music, and participate in fun games. The event is free and open to the public, so bring your friends and family for a day of sunshine and celebration.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="h4 fw-bold">Here are some images for our recent events...</p>
                    <div class="your-class">
                        <div>
                            <img src="{{ asset('assets/images/fancy-tables.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/garden-with-friends.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/fancy-conference.jpg') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5">
        <div class="row">
            <div class="col-12 bg-info text-white text-center py-5">
                <p class="h1 fw-bold mb-0">What are you waiting for?</p>
                <a href="{{ route('book-now') }}" class="btn btn-dark mt-3">
                    <span class="h1">Book Yours Now!</span>
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        (function($) {
            $(document).ready(function(){
                $('.your-class').slick({
                    prevArrow: false,
                    nextArrow: false
                })
            });
        })(jQuery)
    </script>
@endsection