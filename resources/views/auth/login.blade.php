@extends('layouts.app')

    @section('content')

        <div class="page">
            <div class="container">
                <div class="page-card">
                    <div class="page-image">
                        <img src="/img/login.svg" />
                    </div>
                    <div class="page-body">
                        <div class="page-header">
                            <h3>Welcome Back!</h3>
                            <span>Login to continue</span>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <i class="fa fa-user"></i>
                                <input id="email" placeholder="Email address" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                            <div class="form-group">
                                    <i class="fa fa-key"></i>
                                    <input id="password" placeholder="Password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            </div>

                            <div class="remember-me">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label  for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div class="form-buttons">
                                <button type="submit" >
                                    Login
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
