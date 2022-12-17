<div class="card rounded-3 col-lg-6 mb-3 px-0 pr-lg-1">
    <div class="d-flex flex-md-row m-3">
        <img class="media-object img-radius m-r-20 rounded-5 col-md-2 img-thumbnail"
            @if ($publication->foto_perfil == null) src="/img/default_profile.jpg"
                        @else
                            src="data:image/png;base64,{{ base64_encode($publication->foto_perfil) }}" @endif
            alt="Generic placeholder image" style="height: 100%; aspect-ratio:1/1; margin-right:10px">
        <div class="chat-header fw-bold my-auto">{{ $publication->nom_usu }}</div>

    </div>
    <a href="/{{ $publication->nom_usu }}/publication/{{ $publication->id_pub }}">
        <img src="data:image/png;base64,{{ base64_encode($publication->cont_pub) }}" alt="publicaciones"
            class="img-fluid rounded-bottom shadow-sm" style="width: 100%; aspect-ratio:1/1 ">
    </a>
</div>
