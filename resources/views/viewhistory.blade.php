@extends('layouts.base', ['title' => 'Nueva historia'])

@section('content')
    <a href="/{{ $userInfo->nom_usu }}/story/{{ $idHistoria }}/edit">Editar historia</a>
    <form action="/{{ $userInfo->nom_usu }}/story/{{ $idHistoria }}/delete" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Eliminar historia</button>
    </form>
    @if (count($publicaciones) > 0)
        @foreach ($publicaciones as $publicacion)
            <div class="col-lg-6 mb-2 pr-lg-1">
                <a href="/{{ $userInfo->nom_usu }}/publication/{{ $publicacion->id_pub }}">
                    <img src="data:image/png;base64,{{ base64_encode($publicacion->cont_pub) }}" alt="publicaciones"
                        class="img-fluid rounded shadow-sm" style="width: 100%; height: 100%">
                </a>
            </div>
        @endforeach
    @else
        <div class="col-lg-6 mb-2 pr-lg-1 mt-2 pt-2">
            <h1 class="text-center">No hay publicaciones</h1>
        </div>
    @endif
@endsection
