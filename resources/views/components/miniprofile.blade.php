<div class="col-6 justify-content-center">
    <div class="card p-3 shadow-lg rounded-3 bg-dark d-flex align-items-center flex-md-row">

        <div class="image col-lg-5 px-10" style='padding-right:10px'>
            <img @if ($user->foto_perfil == null) src="/img/default_profile.jpg"
                    @else
                    src="data:image/png;base64,{{ base64_encode($user->foto_perfil) }}" @endif
                alt="Generic placeholder image" class="rounded" style="width:100%; aspect-ratio:1/1;">
        </div>

        <div class="ml-3 w-100 h-100 text-white d-flex flex-column">
            <h4>{{ $user->nom_usu }}</h4>
            <span>{{ $user->nom_per }} {{ $user->apellidos }}</span>
            <div class="justify-content-between text-dark d-flex flex-md-column">
                <div class="d-flex flex-md-row justify-content-center text-center py-1">
                    <div class="px-3 ">
                        <p class="mb-1 h5 text-white">{{ $user->seguidores }}</p>
                        <p class="small text-muted mb-0">Seguidores</p>
                    </div>
                    <div>
                        <p class="mb-1 h5 text-white">{{ $user->seguidos }}</p>
                        <p class="small text-muted mb-0">Siguiendo</p>
                    </div>
                </div>
                <a href="/{{ $user->nom_usu }}/profile" class="btn btn-sm btn-primary w-100">Ver</a>
            </div>
        </div>
    </div>
</div>
