@extends('layouts.base', ['title' => 'Settings'])

@section('content')
{{$userInfo->nombreUsuario}}
{{$userInfo->nombre}}
{{$userInfo->apellidos}}
{{$userInfo->mail}}
{{$userInfo->fechaNacimiento}}
{{$userInfo->descripcion}}
@endsection
