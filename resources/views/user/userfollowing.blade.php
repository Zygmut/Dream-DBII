@extends('layouts.base', ['title' => 'Following'])

@section('content')
    @foreach ($following as $user)
        @include('components.miniprofile', ['user' => $user])
    @endforeach
@endsection
