@extends('layouts.base', ['title' => 'Nueva historia'])

@section('content')
    @foreach ($publicaciones as $publicacion)
        <div class="col-lg-6 mb-2 pr-lg-1">
            <a href="/{{ $userInfo->nom_usu }}/publication/{{ $publicacion->id_pub }}">
                <img src="data:image/png;base64,{{ base64_encode($publicacion->cont_pub) }}" alt="publicaciones"
                    class="img-fluid rounded shadow-sm" style="width: 100%; height: 100%">
            </a>
        </div>
    @endforeach
@endsection
