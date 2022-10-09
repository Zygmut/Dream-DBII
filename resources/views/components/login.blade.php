<div class="container px-4 py-5">
    <h2 class="pb-2 border-bottom text-center">
        Iniciar sesión
    </h2>
    <div class="row pt-2 mt-4">
        <div class="col-sm-6 m-auto">
            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Nombre usuario</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Introduzca el nombre de usuario">
                </div>
                <div class="mb-3">
                    <label for="horarivet" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Introduzca la contraseña">
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-secondary w-25 m-2">
                        <a href="/register" class="nav-link">
                            Ir a registarse
                        </a>
                    </button>
                    <button type="submit" class="btn btn-outline-secondary w-25 m-2">
                        Iniciar sesión
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>