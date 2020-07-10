@extends('layouts.dashboard')

    @section('dashboard-content')
        <div class="projects-page">
            <div class="nav">
                <span>My Projects</span>
                <a href="{{ route('projects.create') }}" class="my-btn">Add Project</a>
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

    @endsection