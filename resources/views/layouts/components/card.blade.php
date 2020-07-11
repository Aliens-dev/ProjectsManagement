<div class="my-card {{ $row ?? '' }}">
    <div class="my-card-title">
        @if(!isset($link) || $link === null)
            {{ $title }}
        @else
            <a href="{{ $link ?? '#' }}">
                {{ $title }}
            </a>
        @endif
    </div>
    <div class="my-card-desc d-flex flex-grow-1">
        @if(isset($desc))
            {{ $desc ?? '' }}
        @endif
    </div>
    @can('delete', $project)
        <form class="delete d-flex justify-content-end mt-2 mr-2" method="POST" action="{{ $project->path() }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger">Delete</button>
        </form>
    @endcan
</div>