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
        @auth
            <div class="nav-left">
                <div>
                    <a class="nav-link" href="{{ route('projects.index') }}" >My Projects</a>
                </div>
                <div>
                    <a class="nav-link" href="{{ route('projects.create') }}" >Add Project</a>
                </div>
            </div>
            <div class="nav-right">
                <span class="profile-name dropdown">
                    <span id="login-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </span>
                    <div class="dropdown-menu" aria-labelledby="login-dropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a id="logout" class="dropdown-item" href="#">Logout</a>
                    </div>
                </span>
            </div>
        @endauth
        @guest
            <div class="nav-right">
                <a href="{{ route('login') }}" class="nav-link">
                    Login
                </a>
                <a href="{{ route('register') }}" class="nav-link">
                    Register
                </a>
            </div>
        @endguest
    </div>
</nav>

<script>
    const logout = document.getElementById('logout');

    logout.addEventListener('click', function(e) {
        e.preventDefault()
        axios.post('/logout')
        .then(res => {
            window.location.reload();
        })
    })
</script>
