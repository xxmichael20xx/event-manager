@extends('layouts.guest', [ 'bodyClass' => 'book__now' ])

@section('content')
    <section class="banner position-relative" id="banner">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="text-white">Book Now</h1>
            <h3 class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime, nulla, tempore. Deserunt excepturi quas vero.</h3>
        </div>
    </section>

    <section class="py-5 my-5" id="bookNow">
        <div class="container">
            <div class="row">
                <div class="col-8 m-auto card shadow">
                    <div class="card-body row p-5">
                        <div class="col">
                            <div class="text-center">
                                <h2>Book Now</h2>
                                <label class="lead">Enter your details below</label>
                            </div>
                            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="lead">{{ __('Name') }}</label>

                                    <div class="col-md-12">
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}12" readonly required>

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
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" readonly required>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="occasion" class="lead">{{ __('Occasion') }}</label>

                                    <div class="col-md-12">
                                        <input type="text" id="occasion" name="occasion" class="form-control @error('occasion') is-invalid @enderror" required>

                                        @error('occasion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="date" class="lead">{{ __('Date') }}</label>

                                    <div class="col-md-12">
                                        <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" required>

                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="time" class="lead">{{ __('Time') }}</label>

                                    <div class="col-md-12">
                                        <input type="time" id="time" name="time" class="form-control @error('time') is-invalid @enderror" required>

                                        @error('time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="venue" class="lead">{{ __('Venue') }}</label>

                                    <div class="col-md-12">
                                        <select name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror" required>
                                            <option value="" selected disabled>Select a venue</option>
                                            <option value="hallway">Hallway</option>
                                            <option value="terrace">Terrace</option>
                                            <option value="garden">Garden</option>
                                        </select>

                                        @error('venue')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit Booking') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
