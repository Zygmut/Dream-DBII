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
                            <div class="ms-4 mt-5 d-flex flex-column " style="width: 150px;">
                                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ficon-library.com%2Fimages%2Fno-profile-picture-icon%2Fno-profile-picture-icon-11.jpg&f=1&nofb=1&ipt=346291de618ab601869dda2b92366d832aeabb011a81e8347b4992f269940537&ipo=images"
                                    alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                    style="width: 150px; z-index: 1">
                                @if ($isOwner)
                                    <a href="/{{ $userInfo->nom_usu }}/settings" class="btn btn-outline-dark"
                                        style="z-index: 1;">
                                        Editar perfil
                                    </a>
                                    <a href="/{{ $userInfo->nom_usu }}/notifications"
                                        class="btn btn-outline-dark" style="z-index: 1; margin-top:15px">Notificaciones</a>
                                @endif
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5> {{ $userInfo->nom_usu }} </h5>
                                <p>{{$per->nom_per}} {{$per->apellidos}}</p>
                            </div>
                        </div>
                        <div class="p-4 text-black">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div>
                                    <p class="mb-1 h5">{{ $numberPublications }}</p>
                                    <p class="small text-muted mb-0">Fotos</p>
                                </div>
                                <div class="px-3">
                                    <p class="mb-1 h5">{{ $followers }}</p>
                                    <p class="small text-muted mb-0">Seguidores</p>
                                </div>
                                <div>
                                    <p class="mb-1 h5">{{ $following }}</p>
                                    <p class="small text-muted mb-0">Siguiendo</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5">
                                <p class="lead fw-normal mb-1">Sobre mi</p>
                                <div class="p-4 bg-gradient rounded-3 shadow">
                                    {{ $user->description }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0">Fotos recientes</p>
                                <p class="mb-0"><a href="#!" class="text-muted">Enseñar todo</a></p>
                            </div>
                            <div class="row">
                                @foreach ($publications as $publication)
                                    <div class="col-lg-6 mb-2 pr-lg-1">
                                        <a href="/{{ $userInfo->nom_usu }}/publication/{{ $publication->id_pub }}">
                                            <img src="data:image/png;base64,{{ base64_encode($publication->cont_pub) }}"
                                                alt="publicaciones" class="img-fluid rounded shadow-sm"
                                                style="width: 100%; height: 100%">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
