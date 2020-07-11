@if(count($activity->changes['after']) === 1)
    {{ $activity->user->name }} updated the {{ key($activity->changes['after']) }} in the project
@else
    {{ $activity->user->name }} updated the project
@endif