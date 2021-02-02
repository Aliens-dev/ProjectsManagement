
@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="edit-project">
        <div class="container">
            <div class="nav">
                <span>
                        <span><a href="{{ route('projects.index') }}">My projects</a></span>
                        /
                        <span><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></span>
                        /
                        <span>Edit Project</span>
                </span>
                <a href="{{ route('projects.create') }}" class="my-btn">Add Project</a>
            </div>
            <div class="my-card p-5">
                <form method="post" action="{{ route('projects.update', $project->id) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" id="title" placeholder="Title" class="form-control" value="{{ $project->title }}" />
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea name="description" id="description" placeholder="Title" rows="6" class="form-control">{{ $project->description }}</textarea>
                    </div>
                    <div>
                        <input name="submit" value="Update Project" class="my-btn" type="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
