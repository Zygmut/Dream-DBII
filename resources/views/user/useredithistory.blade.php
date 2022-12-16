@extends('layouts.base', ['title' => 'Editar historia'])

@section('content')
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
                            action="/{{ $userInfo->nom_usu }}/story/{{ $idHistoria }}/edit" enctype="multipart/form-data">
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
@endsection
