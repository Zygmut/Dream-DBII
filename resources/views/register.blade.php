@extends('layouts.login', ['title' => 'Register'])
@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 fs-5 ">Registro</h1>
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="/register" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Introduce tu nombre">
                                        <label for="nombre" class="form-label">   Nombre</label>
                                    </div>

                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                                            placeholder="Introduce tus apellidos">
                                        <label for="apellidos" class="form-label">   Apellidos</label>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        placeholder="Introduzca un teléfono" maxlength="9">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="dni" class="form-control" id="dni" name="dni"
                                        placeholder="Introduzca su dni" maxlength="9">
                                    <label for="dni" class="form-label">DNI</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="mail" name="mail"
                                        placeholder="Introduzca un email">
                                    <label for="mail" class="form-label">Email</label>
                                </div>

                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario"
                                            placeholder="Introduzca un nombre de usuario">
                                        <label for="nombreUsuario" class="form-label">   Nombre de usuario</label>
                                    </div>

                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="password" class="form-control" id="contrasena" name="contrasena"
                                            placeholder="Introduzca una contraseña">
                                        <label for="contrasena" class="form-label">   Contraseña</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-group ">
                                        <label for="perfil" class="control-label">Imagen de perfil</label>
                                        <input id="perfil" type="file" class="form-control" name="perfil">
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Registrarse
                                    </button>
                                </div>
                                <hr class="my-4">
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-login text-uppercase fw-bold">
                                        <a href="/login" class="nav-link">Iniciar sesión</a>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
