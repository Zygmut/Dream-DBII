@extends('layouts.base', ['title' => 'Editar publicación'])

@section('content')
    <section>
        <div class="container py-5 h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Editar Publicación</h1>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="/{{ session()->get('user')->nom_usu }}/publication/{{$publicacion->id_pub}}/edit" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-floating mb-3 @if ($errors->has('description')) has-error @endif ">
                                    <textarea class="form-control" id="description" name="descripcion" style="height: 100px" required>{{ $publicacion->desc_pub }}</textarea>
                                    <label for="description" class="form-label">Descripción</label>
                                </div>

                                <div class="row mb-3 @if ($errors->has('image')) has-error @endif">
                                    <div class="form-group ">
                                        <label for="image" class="control-label">Imagen </label>
                                        <input id="image" type="file" class="form-control" name="contenido" >
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Editar publicación
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
