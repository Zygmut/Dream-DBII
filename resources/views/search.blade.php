@extends('layouts.base', ['title' => 'Search'])

@section('content')
    <!-- Search Page-->
    <div class="row">
        <div class="col-md-12">
            <h1>Search</h1>
            <form action="/{{ session('user')->nom_usu }}/search" method="GET">
                <div class="form-group">
                    <input type="text" name="q" id="query" class="form-control" placeholder="Search"
                        value="{{ request()->input('query') }}">
                </div>
                <div class="form-group py-2 my-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    @if (count($users) > 0)
                        <h3>Usuarios ({{ count($users) }})</h3>
                        <div class="row">
                            @foreach ($users as $user)
                                @include('components.miniprofile', ['user' => $user])
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
