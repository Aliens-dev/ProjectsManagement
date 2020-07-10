@extends('layouts.app')

@section('content')

    <div class="projects">
        <div class="projects-container">
            <div class="projects-view">
                @yield('dashboard-content')
            </div>
        </div>
    </div>

@endsection