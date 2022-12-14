@extends('layouts.base', ['title' => $user->nom_usu])

@section('content')
<div class="d-flex justify-content-center align-items-center mt-2 pt-2">
    @include('components.publication', ['publication' => $publication, 'user' => $user, 'comments' => $comments, 'numOfComments' => $numOfComments])
</div>
@endsection