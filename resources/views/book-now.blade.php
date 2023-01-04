@extends('layouts.guest', [ 'bodyClass' => 'book__now' ])

@section('content')
    <section class="banner position-relative" id="banner">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white">Book Now</h1>
            <h3 class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</h3>
        </div>
    </section>

    <section class="py-5" id="bookNow">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img alt="Home About" class="img-fluid" src="{{ asset('assets/images/home_about.jpg') }}">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text">
                        <h2>Lorem ipsum dolor</h2>
                        <p class="lead">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Totam, labore reiciendis. Assumenda eos quod animi! Soluta nesciunt inventore dolores excepturi provident, culpa beatae tempora, explicabo corporis quibusdam corrupti. Autem, quaerat. Assumenda quo aliquam vel, nostrum explicabo ipsum dolor, ipsa perferendis porro doloribus obcaecati placeat natus iste odio est non earum?</p>
                        <a class="btn btn-info text-white" href="javascript:;">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
