@extends('layouts.dashboard')
    @section('dashboard-content')
        <div class="project-page">
            <div class="project-info">
                <div class="nav">
                <span>
                    <span><a href="{{ route('projects.index') }}">My projects</a></span>
                    /
                    <span>My Tasks</span>
                </span>

                    <div>
                        @foreach($project->members as $member)
                            <img class="rounded-circle" src="{{ gravatar($member->email) }}?s=40" alt="{{ $member }}">
                        @endforeach
                        <a href="{{ route('projects.edit',$project->id) }}" class="my-btn ml-2">Edit Project</a>
                    </div>

                </div>
                <div class="single-project">
                    <div class="tasks">
                        <div class="task">
                            @foreach($project->tasks as $task)
                                <div class="my-card d-flex flex-row align-items-center  pb-0 pt-0 mb-2">
                                    <div class="my-card-title flex-grow-1 {{ $task->completed ? 'bg-success' : ''}}">
                                        <form action="{{ route('projects.tasks.update', [$project->id, $task->id]) }}" method="POST" class="d-flex flex-grow-1 justify-content-between align-items-center">
                                            @method('PATCH')
                                            @csrf
                                            <input
                                                class="d-flex mr-1 ml-1 border-0 {{ $task->completed ? 'bg-success text-white' : ''}} flex-grow-1" name="body"
                                                value="{{ $task->body }}"
                                            />
                                            <input class="d-flex mr-1 pl-1 border-0"
                                                   name="completed"
                                                   type="checkbox"
                                                   {{ $task->completed  ? 'checked' : '' }}
                                                   onClick="this.form.submit()"
                                            />
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <form action="{{ route('projects.tasks.store' , $project->id) }}" method="POST">
                                @csrf
                                <input name="body" class="form-control mt-3 my-shadow" rows="2" placeholder="Task ...">
                                <button class="my-btn mt-2 mb-2">Add Task</button>
                            </form>
                        </div>
                        <div class="add-task">
                            <div class="nav">
                                <span>General Notes</span>
                            </div>
                            <form action="{{ route('projects.update' , $project->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <textarea name="notes" class="form-control mt-3 my-shadow" rows="4">{{ $project->notes }}</textarea>
                                <button class="my-btn mt-2 mb-2">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="project">
                        @include('layouts.components.card', ['title' => $project->title, 'desc'=> $project->description])
                        @can('invite',$project)
                            <div class="my-card mt-3">
                                <div class="my-card-title">
                                    Invite other users
                                </div>
                                <form method="POST" class="w-100" action="{{ $project->path() . "/invitations" }}">
                                    @csrf
                                    <div class="my-card-desc d-flex flex-grow-1">
                                        <input name="email" class="form-control" placeholder="Example@example.com">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary mr-2 mt-2">invite</button>
                                    </div>
                                </form>
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                            {{ $error }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="latest-updates">
                <div class="nav d-flex">
                    <span>Lastest Updates</span>
                </div>
                <div class="updates">
                    @foreach($project->activity as $activity)
                        <div class="activity">
                            @include('projects.activity.'. $activity->description)
                            <span class="text-info">
                            {{ $activity->created_at->diffForHumans(null,true) }}
                        </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endsection
