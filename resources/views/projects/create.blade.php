
@extends('layouts.dashboard')

    @section('dashboard-content')

        <h1>Create a Project</h1>
        <div class="my-card p-5">
            <form method="post" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" id="title" placeholder="Title" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <textarea name="description" id="description" placeholder="Title" class="form-control"></textarea>
                </div>
                <div>
                    <input name="submit" value="Add Project" class="my-btn" type="submit">
                </div>
            </form>
        </div>
        
        @endsection