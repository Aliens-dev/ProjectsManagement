@extends('layouts.dashboard')


    @section('dashboard-content')
        <div class="nav">
            <span>My Tasks</span>
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
                                            class="d-flex mr-1 ml-1 border-0 flex-grow-1" name="body"
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
                        <textarea name="notes" class="form-control mt-3 my-shadow" rows="4">{{ $project->notes }}</textarea>
                        <button class="my-btn mt-2 mb-2">Add Note</button>
                    </form>
                </div>
            </div>
            <div class="project">
                @include('layouts.components.card', ['title' => $project->title, 'desc'=> $project->description])
            </div>
        </div>
    @endsection