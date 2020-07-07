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
    <div class="my-card-desc">
        @if(isset($desc))
            {{ $desc ?? '' }}
        @endif
    </div>
</div>