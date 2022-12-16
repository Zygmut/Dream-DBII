<div
    class="d-flex flex-md-row card p-3 shadow rounded-3 
@if ($mensaje->estado_not == 'leido') bg-secondary
@else
bg-dark @endif
">
    <div class="w-100 d-flex flex-md-row">
        <img class="align-self-center media-object col-2 img-radius m-r-20 rounded-4"
            style="margin-right: 1em;height:100%; aspect-ratio:1/1;"
            @if ($mensaje->foto_perfil == null) src="/img/default_profile.jpg"
                @else
                    src="data:image/png;base64,{{ base64_encode($mensaje->foto_perfil) }}" @endif
            alt="Generic placeholder image">
        <div>
            <div class="chat-header fw-bold text-white">{{ $mensaje->nom_usu }}</div>
            <div class="text-white">{{ $mensaje->cont_men }}</div>
        </div>
    </div>

    <div class="d-flex flex-md-column justify-content-between">
        <form action="/{{ $mensaje->nom_usu }}/notification/{{ $mensaje->id_men }}/read" method="POST"
            style=" width:100%; aspect-ratio:1/1">
            @csrf
            <input type="hidden" value="{{ $mensaje->link }}" name="link">
            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-caret-right-fill" viewBox="0 0 16 16"
                    style="height:1em; width:1em; top: -.125em; position: relative;">
                    <path
                        d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                </svg>
            </button>
        </form>
        <form action="/{{ $user->nom_usu }}/notification/{{ $mensaje->id_men }}/delete" method="POST"
            class="btn btn-danger btn-sm waves-effect waves-light" style=" width:100%; aspect-ratio:1/1">
            @csrf
            <input type="hidden" value="{{ $mensaje->link }}" name="link">
            <button type="submit" style="all: unset">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="mr-10" fill="currentColor"
                    class="bi bi-trash3-fill" viewBox="0 0 16 16"
                    style="height:1em; width:1em; top: -.125em; position: relative;">
                    >
                    <path
                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                </svg>
            </button>
        </form>

    </div>
</div>
