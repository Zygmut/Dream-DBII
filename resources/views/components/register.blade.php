<div class="container px-4 py-5">
    <h2 class="pb-2 border-bottom text-center">
        Registrarse
    </h2>
    <div class="row pt-2 mt-4">
        <div class="col-sm-6 m-auto">
            <form action="/register" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduzca su nombre">
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Introduzca apellidos">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Introduzca un teléfono">
                </div>
                <div class="mb-3">
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                </div>
                <div class="mb-3">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Introduzca un email">
                </div>
                <div class="mb-3">
                    <label for="nombreUsuario" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Introduzca un nombre de usuario">
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Introduzca una contraseña">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary w-25 m-2">
                        <a href="/login" class="nav-link">
                            Ir a iniciar sesión
                        </a>
                    </button>
                    <button type="submit" class="btn btn-outline-secondary w-25 m-2">
                        Registarse
                    </button>
                </div>
                <!-- Show the success message if the user has been registered -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <!-- Show the error message if the user has not been registered -->
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </form>
        </div>
    </div>
</div>