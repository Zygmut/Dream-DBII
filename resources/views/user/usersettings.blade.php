@extends('layouts.base', ['title' => 'Settings'])

@section('content')
{{$userInfo->nom_usu}}
{{$userInfo->nom_per}}
{{$userInfo->apellidos}}
{{$userInfo->mail}}
{{$userInfo->nacimiento}}
{{$userInfo->description}}
@endsection
