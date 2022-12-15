<div class="container mt-5 col-md-4 justify-content-center ">

    <div class="card p-3 shadow-lg rounded-3 bg-dark">

        <div class="d-flex align-items-center">

            <div class="image" style='padding-right:10px'>
                <img @if ($user->foto_perfil == null) src="/img/default_profile.jpg"
                    @else
                    src="data:image/png;base64,{{ base64_encode($user->foto_perfil) }}" @endif
                    alt="Generic placeholder image" width=155 height=155 class="rounded" style="">
            </div>

            <div class="ml-3 w-100 text-white">

                <h4 class="mb-0 mt-0">{{ $user->nom_usu }}</h4>
                <span>{{ $user->nom_per }} {{ $user->apellidos }}</span>

                <div class="p-2 mt-2 justify-content-between rounded text-dark stats">

                    <div class="d-flex justify-content-center text-center py-1">
                        <div class="px-3">
                            <p class="mb-1 h5 text-white">{{ $user->seguidores }}</p>
                            <p class="small text-muted mb-0">Seguidores</p>
                        </div>
                        <div>
                            <p class="mb-1 h5 text-white">{{ $user->seguidos }}</p>
                            <p class="small text-muted mb-0">Siguiendo</p>
                        </div>
                    </div>

                </div>

                <a href="/{{ $user->nom_usu }}/profile" class="btn btn-sm btn-primary w-100">Ver</a>


            </div>


        </div>

    </div>

</div>
