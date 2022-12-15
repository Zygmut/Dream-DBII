@extends('layouts.login', ['title' => 'Login'])

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 fs-5 ">EPS Red Social</h1>
                            <form action="/login" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Introduzca el nombre de usuario">
                                    <label for="username">Usuario</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Instroduzca la contraseña">

                                    <label for="password">Contraseña</label>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Iniciar
                                        sesión</button>
                                </div>
                                <hr class="my-4">
                                <div class="d-grid">
                                    <button class="btn btn-secondary btn-login text-uppercase fw-bold">
                                        <a href="/register" class="nav-link">Registrarse</a>
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
