@extends('layouts.base', ['title' => 'Followers'])

@section('content')
    @foreach ($followers as $user)
        @include('components.miniprofile', ['user' => $user])
    @endforeach
@endsection
