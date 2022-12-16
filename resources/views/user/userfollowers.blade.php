@extends('layouts.base', ['title' => 'Followers'])

@section('content')
    <div class="row col-md-12">
        <h1>Seguidores</h1>
        @foreach ($followers as $user)
            @include('components.miniprofile', ['user' => $user])
        @endforeach
    </div>
@endsection
