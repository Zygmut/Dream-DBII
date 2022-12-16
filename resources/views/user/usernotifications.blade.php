@extends('layouts.base', ['title' => 'Notificaciones'])

@section('content')
    <!-- Notifications -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Notificaciones</div>
                    <div class="panel-body">
                        @if (count($notificaciones) > 0)
                            <ul class="list-group">
                                @foreach ($notificaciones as $notificacion)
                                    <li class="list-group list-group-item-info">
                                        <a href="/{{ $notificacion->link }} ">
                                            {{ $notificacion->cont_men }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No tienes ninguna notificación pendiente.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
