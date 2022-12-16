@extends('layouts.base', ['title' => 'Following'])



@section('content')
    <section>
        <div class="container py-5 ">
            <div class="row h-100">
                <div class="col-md-9  mx-auto">
                    <div class="card shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Siguiendo</h1>

                            <div class="row d-flex">
                                @foreach ($following as $user)
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
