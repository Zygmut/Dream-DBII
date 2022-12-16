@extends('layouts.base', ['title' => 'Search'])

@section('content')
    <section>
        <div class="container py-5 ">
            <div class="row h-100">
                <div class="col-md-9 mx-auto">
                    <div class="card shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Buscador de usuarios</h1>

                            <form class="d-flex mb-5" action="/{{ session('user')->nom_usu }}/search" method="GET">
                                <input type="text" name="q" id="query" class="form-control me-1"
                                    placeholder="Search" value="{{ $data }}">
                                <button type="submit" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                            </form>

                            @if (count($users) > 0)
                                <div class="d-flex row">
                                    @foreach ($users as $user)
                                        @include('components.miniprofile', ['user' => $user])
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
