@extends('layouts.base', ['title' => 'Home'])

@section('content')
<div class="container px-4 py-5">
    <h2 class="pb-2 border-bottom text-center">
        Indice 
    </h2>
    <div class="row pt-2 mt-4">
        <div class="col-sm-6 m-auto">
            <div class="d-flex justify-content-center">
                <button class="btn btn-secondary mx-3">
                    <a href="/register" class="nav-link">
                        Registrarse
                    </a>
                </button>
                <button class="btn btn-secondary mx-3">
                    <a href="/login" class="nav-link">
                        Iniciar sesión
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection