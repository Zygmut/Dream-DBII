@extends('layouts.base', ['title' => session()->get('user')->nom_usu])

@push('head')
    <meta http-equiv="refresh" content="30">
@endpush

@section('content')
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-9">
                    <div class="card shadow-lg rounded-3 bg-light">
                        <div class="card-body p-4 text-black">
                            @if ($publications->count() > 0)
                                <h1 class="card-title text-center mb-5 ">Publicaciones</h1>
                                <div class="row">
                                    @foreach ($publications as $publication)
                                        @include('components.feedpublication', [
                                            'publication' => $publication,
                                        ])
                                    @endforeach
                                </div>
                            @else
                                <h2 class="lead fw-normal mb-3 text-center fw-bold">No hay publicaciones</h2>
                                <p class="text-muted text-center mb-0">Vuelve más tarde</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
