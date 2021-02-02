@extends('layouts.dashboard')

    @section('dashboard-content')
        <div class="projects-page">
            <div class="container">
                <div class="nav">
                    <span>{{ __('My Projects') }}</span>
                    <a href="{{ route('projects.create') }}" class="my-btn">{{ __('Add Project') }}</a>
                </div>
                <div class="my-projects">
                    @foreach($projects as $project)
                        @include('layouts.components.card', [
                            'title' => $project->title ,
                            'desc'  => $project->description ,
                            'link'  => $project->path()
                            ])
                    @endforeach
                </div>
            </div>
        </div>

    @endsection
