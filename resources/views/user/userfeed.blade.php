@extends('layouts.base', ['title' => $user->nom_usu])

@section('content')
    @foreach ($publications as $publication)
        <p>{{ $publication->desc_pub }}</p>
    @endforeach
@endsection
