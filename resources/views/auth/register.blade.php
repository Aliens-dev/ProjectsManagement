@extends('layouts.app')

@section('content')
    <div class="page">
        <div class="container">
            <div class="page-card">
                <div class="page-image">
                    <img src="/img/register.svg" />
                </div>
                <div class="page-body">
                    <div class="page-header">
                        <h3>Register</h3>
                        <span>Join Our Community</span>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <i class="fa fa-user"></i>
                                <input id="name" type="text" placeholder="Name" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                            <div class="form-group">
                                <i class="fa fa-envelope"></i>
                                <input id="email" type="email" placeholder="Email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            <div class="form-group">
                                <i class="fa fa-lock"></i>
                                <input id="password" type="password" placeholder="Password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <i class="fa fa-lock"></i>
                                <input id="password-confirm" type="password" placeholder="Passworc confirmation" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="form-buttons">
                                <button type="submit" >
                                    Register
                                </button>
                                <a href="{{ route('login') }}">
                                    Have an account?
                                </a>
                            </div>
                            @error('name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('email')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('password')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
