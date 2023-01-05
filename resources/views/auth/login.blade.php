@extends('layouts.auth', [ 'bodyClass' => 'main' ])

@section('content')
    <section class="container vh-100">
        <div class="row vh-100">
            <div class="col-8 m-auto card shadow">
                <div class="card-body row p-5">
                    <div class="col col-md-6 text-center">
                        <figure>
                            <img src="{{ asset('assets/images/login_image.jpg') }}" class="img-fluid mx-auto" alt="Login Image">
                        </figure>
                        <a href="{{ route('register') }}" class="btn btn-link">Create an account</a>
                    </div>
                    <div class="col col-md-6">
                        <h2 class="form-title">Login</h2>
                        <form method="POST" action="{{ route('login') }}" class="mt-3">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="lead">{{ __('Email address') }}</label>

                                <div class="col-md-12">
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"  required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    {{-- @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
