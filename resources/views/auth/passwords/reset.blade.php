@extends('layouts.app')

@section('content')
    <div class="page">
        <div class="container">
            <div class="page-card">
                <div class="page-image">
                    <img src="/img/reset.svg" />
                </div>

                <div class="page-body">
                    <div class="page-header">
                        <h3>Reset Password</h3>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn btn-primary">
                                Reset Password }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
