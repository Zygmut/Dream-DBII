@extends('layouts.base', ['title' => $user->nom_usu])

@section('content')
    @if (request()->in == null)
        @include('components.publicacion', [
            'publication' => $publication,
            'user' => $user,
            'comments' => $comments,
            'numOfComments' => $numOfComments,
            'inHistory' => false,
        ])
    @else
        @include('components.publicacion', [
            'publication' => $publication,
            'user' => $user,
            'comments' => $comments,
            'numOfComments' => $numOfComments,
            'inHistory' => true,
        ])
    @endif
@endsection
