@extends('layouts.base', ['title' => $user->nombreUsuario])

@section('content')
@foreach ($publications as $publication)
<p>{{ $publication->descripcion}}</p>
@endforeach
@endsection