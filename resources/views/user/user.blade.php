@extends('layouts.base', ['title' => 'Home'])

@push('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
@endpush

@section('content')
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card shadow-lg rounded-3 bg-light">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 mt-5 row" style="width: 150px;">
                                <img @if ($user->foto_perfil == null) src="/img/default_profile.jpg"
                                @else
                                src="data:image/png;base64,{{ base64_encode($user->foto_perfil) }}" @endif
                                    alt="Generic placeholder image" class="img-thumbnail mt-4 mb-2"
                                    style="z-index: 1; width: 100%; height: 100%; padding:5px;">
                                @if ($isOwner)
                                    <a href="/{{ $userInfo->nom_usu }}/settings" class="btn btn-outline-dark"
                                        style="z-index: 1;">
                                        Editar perfil
                                    </a>
                                    <a href="/{{ $userInfo->nom_usu }}/notifications" class="btn btn-outline-dark"
                                        style="z-index: 1; margin-top:15px">Notificaciones</a>
                                @else
                                    @if ($isFollowing)
                                        <form action="/{{ session('user')->nom_usu }}/unfollow/{{ $userInfo->nom_usu }}"
                                            method="POST" style="z-index: 1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-dark">Dejar de seguir</button>
                                        </form>
                                    @else
                                        <form action="/{{ session('user')->nom_usu }}/follow/{{ $userInfo->nom_usu }}"
                                            method="POST" style="z-index: 1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-dark w-100">Seguir</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5> {{ $userInfo->nom_usu }} </h5>
                                <p>{{ $per->nom_per }} {{ $per->apellidos }}</p>
                            </div>
                        </div>
                        <div class="p-4 text-black">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div >
                                    <a class="mb-1 h5 text-decoration-none text-black " >
                                        {{ $numberPublications }}
                                    </a>
                                    <p class="small text-muted mb-0">Fotos</p>
                                </div>
                                <div class="px-3">
                                    <a class="mb-1 h5 text-decoration-none text-black"
                                        href="/{{ $userInfo->nom_usu }}/followers">{{ $followers }}</a>
                                    <p class="small text-muted mb-0">Seguidores</p>
                                </div>
                                <div>
                                    <a class="mb-1 h5 text-decoration-none text-black"
                                        href="/{{ $userInfo->nom_usu }}/following">{{ $following }}</a>
                                    <p class="small text-muted mb-0">Siguiendo</p>
                                </div>
                            </div>
                            <div class="card-body p-4 text-black">
                                <div class="mb-5">
                                    <p class="lead fw-normal mb-1">Sobre mi</p>
                                    <div class="p-4 bg-gradient rounded-3 shadow">
                                        {{ $user->description }}
                                    </div>
                                </div>
                                @if ($stories->count() > 0)
                                    <h2 class="lead fw-normal mb-3 text-center fw-bold">Historias</h2>
                                    <div class="row">
                                        @foreach ($stories as $story)
                                            @if ($story->estado_his == 'publica')
                                                <!-- 0 = publica -->
                                                <div class="col-lg-6 mb-2 pr-lg-1">
                                                    <a href="/{{ $userInfo->nom_usu }}/story/{{ $story->id_his }}">
                                                        <img src="data:image/png;base64,{{ base64_encode($story->cont_his) }}"
                                                            alt="historias" class="img-fluid rounded shadow-sm"
                                                            style="width: 100%; height: 100%">
                                                    </a>
                                                </div>
                                            @else
                                                <!-- 1 = privada -->
                                                @if ($isFollowing || $isOwner)
                                                    <div class="col-lg-6 mb-2 pr-lg-1">
                                                        <a href="/{{ $userInfo->nom_usu }}/story/{{ $story->id_his }}">
                                                            <img src="data:image/png;base64,{{ base64_encode($story->cont_his) }}"
                                                                alt="historias" class="img-fluid rounded shadow-sm"
                                                                style="width: 100%; height: 100%">
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    <hr>
                                @endif
                                @if ($rts->count() > 0)
                                    <h2 class="lead fw-normal mb-3 text-center fw-bold">Compartido</h2>
                                    <div class="row">
                                        @foreach ($rts as $rt)
                                            <div class="col-lg-6 mb-2 pr-lg-1">
                                                <a href="/{{ $rt->nom_usu }}/publication/{{ $rt->id_pub }}">
                                                    <img src="data:image/png;base64,{{ base64_encode($rt->cont_pub) }}"
                                                        alt="rt" class="img-fluid rounded shadow-sm"
                                                        style="width: 100%; height: 100%">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                @endif
                                @if ($publications->count() > 0)
                                    <h2 class="lead fw-normal mb-3 text-center fw-bold">Publicaciones</h2>
                                    <div class="row">
                                        @foreach ($publications as $publication)
                                            <div class="col-lg-6 mb-2 pr-lg-1">
                                                <a
                                                    href="/{{ $userInfo->nom_usu }}/publication/{{ $publication->id_pub }}">
                                                    <img src="data:image/png;base64,{{ base64_encode($publication->cont_pub) }}"
                                                        alt="publicaciones" class="img-fluid rounded shadow-sm"
                                                        style="width: 100%; height: 100%">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
