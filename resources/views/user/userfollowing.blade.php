@extends('layouts.base', ['title' => 'Following'])

@section('content')
    <div class="row col-md-12">
        <h1>Siguiendo</h1>
        @foreach ($following as $user)
            @include('components.miniprofile', ['user' => $user])
        @endforeach
    </div>
@endsection
