<div class="container">
    <div class="d-flex pb-0">
        <a class="media-left" href="/{{ $info->nom_usu }}/profile">
            <img class="media-object img-radius m-r-20 rounded-3"
                @if ($info->foto_perfil == null) src="/img/default_profile.jpg"
                        @else
                            src="data:image/png;base64,{{ base64_encode($info->foto_perfil) }}" @endif
                alt="Generic placeholder image">
        </a>
        <div>
            <div class="chat-header fw-bold">{{ $info->nom_usu }}</div>
            <div class="text-muted">{{ $info->fecha_com }}</div>
        </div>
    </div>
    <p class="text-muted">{{ $info->cont_com }}</p>
</div>
