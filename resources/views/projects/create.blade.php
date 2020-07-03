
@extends('layouts.app')

    @section('content')

        <div class="container">
            <h1>Create a Project</h1>
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
                    <input name="submit" value="Add Project" type="submit">
                </div>
            </form>
        </div>


        @endsection