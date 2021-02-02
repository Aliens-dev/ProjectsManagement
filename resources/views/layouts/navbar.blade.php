<nav class="navbar">
    <div class="container">
        <div class="nav-brand">
            <img src="{{ asset("/svg/feather.png") }}" alt="feather">
            <span>
            <a href="{{ route('home.index') }}">
                Project MGM
            </a>
        </span>
        </div>
        <div class="flex-grow-1"></div>
        <div class="nav-left">
            <div>
                <a class="nav-link" href="{{ route('projects.index') }}" >My Projects</a>
            </div>
            <div>
                <a class="nav-link" href="{{ route('projects.create') }}" >Add Project</a>
            </div>
        </div>
        <div class="nav-right">
            <span class="profile-name">
                Nabil Merazga
            </span>
        </div>
    </div>
</nav>
