@extends('layouts.base', ['title' => 'New publication'])

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Nueva Publicación</h1>
                            <!--
                                <form class="form-horizontal" method="POST"
                                    action="/publication/new/{{ session()->get('user')->id_usu }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div
                                        class="form-group
                                @if ($errors->has('description')) has-error @endif
                            ">
                                        <label for="description" class="col-md-4 control-label">Description</label>
                                        <div class="col-md-6">
                                            <textarea id="description" class="form-control" name="descripcion" required>{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group
                                @if ($errors->has('image')) has-error @endif
                            ">
                                        <label for="image" class="col-md-4 control-label">Image</label>
                                        <div class="col-md-6">
                                            <input id="image" type="file" class="form-control" name="contenido" required>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group
                                @if ($errors->has('submit')) has-error @endif
                            ">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                Create
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            -->

                            <form action="/publication/new/{{ session()->get('user')->id_usu }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-floating mb-3 @if ($errors->has('description')) has-error @endif ">
                                    <textarea class="form-control" id="description" name="descripcion" style="height: 100px" required>{{ old('description') }}</textarea>
                                    <label for="description" class="form-label">Descripción</label>
                                </div>

                                <div class="row mb-3 @if ($errors->has('image')) has-error @endif">
                                    <div class="form-group col-md-6">
                                        <label for="image" class="control-label">Imagen </label>
                                        <input id="image" type="file" class="form-control" name="contenido" required>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Subir publicación
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
