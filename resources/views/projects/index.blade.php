@extends('layouts.app')

    @section('content')

       <div class="projects">
           <div class="container">
               <ul class="list-group">
                   @foreach($projects as $project)
                       <li class="list-group-item mb-2 border-1">
                           <a href="{{ $project->path() }}" >
                               {{ $project->title }}
                           </a>
                       </li>
                   @endforeach

               </ul>
           </div>
       </div>

    @endsection