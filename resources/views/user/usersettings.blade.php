@extends('layouts.base', ['title' => 'Settings'])

@section('content')
    <section>
        <div class="container ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5">Modificar el perfil</h1>
                            <form action="/{{ $userInfo->nom_usu }}/settings" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="nom_per" name="nom_per"
                                            placeholder="Introduce tu nombre" value="{{ $userInfo->nom_per }}">
                                        <label for="nombre" class="form-label">   Nombre</label>
                                    </div>

                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                                            placeholder="Introduce tus apellidos" value="{{ $userInfo->apellidos }}">
                                        <label for="apellidos" class="form-label">   Apellidos</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="telf" name="telf"
                                        placeholder="Introduzca un teléfono" maxlength="9" value="{{ $userInfo->telf }}">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="nacimiento" name="nacimiento"
                                        value={{ $userInfo->nacimiento }}>
                                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="mail" name="mail"
                                        placeholder="Introduzca un email" value="{{ $userInfo->mail }}">
                                    <label for="mail" class="form-label">Email</label>
                                </div>
                                <div class="row">
                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="text" class="form-control" id="nom_usu" name="nom_usu"
                                            placeholder="Introduce tu nombre" value={{ $userInfo->nom_usu }}>
                                        <label for="nombre" class="form-label">   Usuario</label>
                                    </div>

                                    <div class="form-floating col-md-6 mb-3">
                                        <input type="password" class="form-control" id="pass" name="pass"
                                            placeholder="Introduzca una contraseña" value={{ $userInfo->pass }}>
                                        <label for="contrasena" class="form-label">   Contraseña</label>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="description" name="description" style="height: 100px">{{ $userInfo->description }}</textarea>
                                    <label for="description" class="form-label">Descripción</label>
                                </div>

                                <div class="row mb-3">
                                    <div class="form-group ">
                                        <label for="perfil" class="control-label">Imagen de perfil</label>
                                        <input id="perfil" type="file" class="form-control" name="perfil">
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Modificar
                                    </button>
                                </div>
                            </form>
                            <hr>
                            <form action="/{{ $userInfo->nom_usu }}/account/delete" method="POST">
                                @csrf
                                <div class="d-grid">
                                    <button class="btn btn-danger btn-login text-uppercase fw-bold" type="submit"
                                        id="eliminar">
                                        Eliminar cuenta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

@endsection
