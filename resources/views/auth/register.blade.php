@extends('layouts.auth', [ 'bodyClass' => 'main' ])

@section('content')
    <section class="container vh-100">
        <div class="row vh-100">
            <div class="col-8 m-auto card shadow">
                <div class="card-body row p-5">
                    <div class="col col-md-6 text-center">
                        <figure>
                            <img src="{{ asset('assets/images/register_image.jpg') }}" class="img-fluid mx-auto" alt="Register Image">
                        </figure>
                        <a href="{{ route('login') }}" class="btn btn-link">Already have an account? Login here</a>
                    </div>
                    <div class="col col-md-6">
                        <h2>Register</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="lead">{{ __('Name') }}</label>

                                <div class="col-md-12">
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="lead">{{ __('Password') }}</label>

                                <div class="col-md-12">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">

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
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
