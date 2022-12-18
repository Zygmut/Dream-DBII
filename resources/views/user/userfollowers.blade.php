@extends('layouts.base', ['title' => 'Followers'])

@section('content')
    <section>
        <div class="container py-5 ">
            <div class="row h-100">
                <div class="col-md-9  mx-auto">
                    <div class="card shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Seguidores</h1>

                            <div class="row d-flex">
                                @foreach ($followers as $user)
                                    @include('components.miniprofile', ['user' => $user])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
