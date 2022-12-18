@extends('layouts.base', ['title' => 'Notificaciones'])

@section('content')
    <section>
        <div class="container py-5 ">
            <div class="row h-100">
                <div class="col-md-9 mx-auto">
                    <div class="card shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">

                            @if (count($notificaciones) > 0)
                                <h1 class="card-title text-center mb-5 ">Notificaciones</h1>
                                <div class="d-flex flex-md-column">
                                    @foreach ($notificaciones as $mensaje)
                                        @include('components.notificacion', [
                                            'user' => $user,
                                            'mensaje' => $mensaje,
                                        ])
                                    @endforeach
                                </div>
                            @else
                            <h1 class="text-center">No tienes notificaciones</h1>
                            <p class="text-muted text-center mb-0">Vuelve más tarde</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
