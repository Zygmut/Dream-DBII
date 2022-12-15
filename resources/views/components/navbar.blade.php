<nav class="navbar navbar-dark navbar-expand-lg bg-dark rounded sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">EPS Xarxa social</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/{{ session('user')->nom_usu }}">Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/{{ session('user')->nom_usu }}/search">Buscar</a>
                </li>
                @if (session()->has('user'))
                    <li class="nav-item">
                        <a class="nav-link
            @if (Request::is('/settings')) active @endif"
                            href="/{{ session('user')->nom_usu }}/settings">Settings</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link
            @if (Request::is('/publication/new')) active @endif"
                        href="/publication/new">Nueva publicacion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/history/new">Nueva historia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/{{ session('user')->nom_usu }}/logout">Logout</a>
                </li>
            </ul>
            <span class="navbar-text">
                @if (session()->has('user'))
                    <a href="/{{ session('user')->nom_usu }}/profile"
                        class="text-white nav-link">{{ session('user')->nom_usu }}</a>
                @else
                    <a href="/login" class="text-white nav-link">Login</a>
                @endif
            </span>
        </div>
    </div>
</nav>
