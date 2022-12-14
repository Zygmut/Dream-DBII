@extends('layouts.base', ['title' => 'Settings'])

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center ">Modificar el perfil</h1>
                            <!--
                                            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                                                    class="rounded-circle mt-5" src="https://i.imgur.com/0eg0aG0.jpg" width="90"><span
                                                    class="font-weight-bold">John
                                                    Doe</span><span class="text-black-50">john_doe12@bbb.com</span><span>United
                                                    States</span>
                                            </div>
                                        -->
                            <form action="/{{ $userInfo->nom_usu }}/settings" method="POST">
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

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Modificar
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
    <div class="col-md-8 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                src="https://i.imgur.com/0eg0aG0.jpg" width="90"><span class="font-weight-bold">John
                Doe</span><span class="text-black-50">john_doe12@bbb.com</span><span>United States</span></div>
    </div>
    <div class="col-md-8">
        <div class="p-3 py-5">

            <form action="/{{ $userInfo->nom_usu }}/settings" method="POST">
                @csrf
                <div class="row">
                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" class="form-control" id="nom_usu" name="nom_usu"
                            placeholder="Introduce tu nombre" value={{ $userInfo->nom_per }}>
                        <label for="nombre" class="form-label">   Nombre</label>
                    </div>

                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            placeholder="Introduce tus apellidos" value={{ $userInfo->apellidos }}>
                        <label for="apellidos" class="form-label">   Apellidos</label>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="telf" name="telf"
                        placeholder="Introduzca un teléfono" maxlength="9" value={{ $userInfo->telf }}>
                    <label for="telefono" class="form-label">Teléfono</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="nacimiento" name="nacimiento"
                        value={{ $userInfo->nacimiento }}>
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="mail" name="mail"
                        placeholder="Introduzca un email" value={{ $userInfo->mail }}>
                    <label for="mail" class="form-label">Email</label>
                </div>
                <div class="form-group">
                    <label for="nom_usu">Nombre de usuario</label>
                    <input type="text" class="form-control" id="nom_usu" name="nom_usu"
                        value="{{ $userInfo->nom_usu }}">
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $userInfo->description }}</textarea>
                </div>
                <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="button">Save
                        Profile</button></div>
        </div>
    </div>
    <!-- Formulario de edición de datos de usuario -->
    <form action="/{{ $userInfo->nom_usu }}/settings" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom_usu">Nombre de usuario</label>
            <input type="text" class="form-control" id="nom_usu" name="nom_usu" value="{{ $userInfo->nom_usu }}">
        </div>
        <div class="form-group">
            <label for="nom_per">Nombre</label>
            <input type="text" class="form-control" id="nom_per" name="nom_per" value="{{ $userInfo->nom_per }}">
        </div>
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos"
                value="{{ $userInfo->apellidos }}">
        </div>
        <div class="form-group">
            <label for="mail">Correo electrónico</label>
            <input type="email" class="form-control" id="mail" name="mail" value="{{ $userInfo->mail }}">
        </div>
        <div class="form-group">
            <label for="nacimiento">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="nacimiento" name="nacimiento"
                value="{{ $userInfo->nacimiento }}">
        </div>
        <div class="form-group">
            <label for="nacimiento">Teléfono</label>
            <input type="tel" class="form-control" id="telf" name="telf" maxlength="9"
                value="{{ $userInfo->telf }}">
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $userInfo->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
