@extends('layouts.base', ['title' => 'Editar historia'])

@section('content')
    <section>
        <div class="container py-5 h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-sm-9 col-md-7 col-lg-7 mx-auto">
                    <div class="card border-0 shadow-lg rounded-3 my-5 bg-light">
                        <div class="card-body p-4 p-sm-5">
                            <h1 class="card-title text-center mb-5 ">Editar Historia</h1>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="/{{ $userInfo->nom_usu }}/story/{{ $idHistoria }}/edit"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div
                                    class="form-floating
                                @if ($errors->has('description')) has-error @endif">
                                    <textarea id="description" class="form-control" name="descripcion" required>{{ $history->desc_his }}</textarea>
                                    <label for="description" class="col-md-4 control-label">Description</label>
                                </div>

                                <div class="row mt-3">
                                    <div
                                        class="form-group col-md-6
                                @if ($errors->has('description')) has-error @endif">
                                        <label for="description" class="col-md-4 control-label">Estado</label>
                                        <div class=" mb-3">
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="privada" @if ($history->estado_his == 'privada') selected @endif>
                                                    Privada
                                                </option>
                                                <option value="publica" @if ($history->estado_his == 'publica') selected @endif>
                                                    Pública
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div
                                        class="form-group col-md-6
                                @if ($errors->has('image')) has-error @endif">
                                        <label for="image" class="control-label">Portada</label>
                                        <input id="image" type="file" class="form-control" name="contenido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="publicaciones" class="col-md-6 control-label">Publicaciones</label>
                                    <select name="publicaciones[]" id="publicaciones" class="form-control" multiple>
                                        @foreach ($publicaciones as $publicacion)
                                            <option value="{{ $publicacion->id_pub }}"
                                                @if (in_array($publicacion->id_pub, $publicacionesDeLaHistoria)) selected @endif>
                                                {{ $publicacion->desc_pub }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">
                                        Editar historia
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Editar historia</div>
                        <div
                            class="panel-body
                        @if ($errors->any()) alert alert-danger @endif
                    ">
                            @if ($errors->any())
    <ul>
                                    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                                </ul>
    @endif
                            <form class="form-horizontal" method="POST"
                                action="/{{ $userInfo->nom_usu }}/story/{{ $idHistoria }}/edit"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div
                                    class="form-group
                                @if ($errors->has('description')) has-error @endif
                            ">
                                    <label for="description" class="col-md-4 control-label">Description</label>
                                    <div class="col-md-6">
                                        <textarea id="description" class="form-control" name="descripcion" required>{{ $history->desc_his }}</textarea>
                                    </div>
                                </div>
                                <div
                                    class="form-group
                                @if ($errors->has('description')) has-error @endif
                            ">
                                    <label for="description" class="col-md-4 control-label">Estado</label>
                                    <div class="col-md-6">
                                        <select name="estado" id="estado" class="form-control">
                                            <option value="privada" @if ($history->estado_his == 'privada') selected @endif>Privada
                                            </option>
                                            <option value="publica" @if ($history->estado_his == 'publica') selected @endif>Pública
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="form-group
                                @if ($errors->has('image')) has-error @endif
                            ">
                                    <label for="image" class="col-md-4 control-label">Portada</label>
                                    <div class="col-md-6">
                                        <input id="image" type="file" class="form-control" name="contenido">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="publicaciones" class="col-md-4 control-label">Añadir publicaciones</label>
                                    <div class="col-md-6">
                                        <select name="publicaciones[]" id="publicaciones" class="form-control" multiple>
                                            @foreach ($publicaciones as $publicacion)
    <option value="{{ $publicacion->id_pub }}"
                                                    @if (in_array($publicacion->id_pub, $publicacionesDeLaHistoria)) selected @endif>
                                                    {{ $publicacion->desc_pub }}
                                                </option>
    @endforeach
                                        </select>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    -->
@endsection
