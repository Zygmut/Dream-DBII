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
                    <a class="nav-link" href="/{{ session('user')->nom_usu }}/search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </a>
                </li>
                @if (session()->has('user'))
                    <li class="nav-item">
                        <a class="nav-link
            @if (Request::is('/settings')) active @endif"
                            href="/{{ session('user')->nom_usu }}/settings">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-gear-fill" viewBox="0 0 16 16">
                                <path
                                    d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                            </svg>
                        </a>
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
            <span>
                <a href="/{{ session('user')->nom_usu }}/profile" class="text-white nav-link " style="width: 50px">

                    <img @if ($user->foto_perfil == null) src="/img/default_profile.jpg"
                                @else
                                src="data:image/png;base64,{{ base64_encode($user->foto_perfil) }}" @endif
                        alt="Generic placeholder image" class="rounded-5"
                        style=" width: 100%; height: 100%; padding:5px;">

                </a>
            </span>
        </div>
    </div>
</nav>
