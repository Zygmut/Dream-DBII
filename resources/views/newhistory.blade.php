@extends('layouts.base', ['title' => 'Nueva historia'])

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-2 pt-2">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Nueva historia</div>
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
                        <form class="form-horizontal" method="POST" action="/history/new/{{ session()->get('user')->id_usu }}"
                            enctype="multipart/form-data">
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
                                @if ($errors->has('description')) has-error @endif
                            ">
                                <label for="description" class="col-md-4 control-label">Estado</label>
                                <div class="col-md-6">
                                    <select name="estado" id="estado" class="form-control">
                                        <option value="1">Privada</option>
                                        <option value="0">Pública</option>
                                    </select>
                                </div>
                            </div>
                            <div
                                class="form-group
                                @if ($errors->has('image')) has-error @endif
                            ">
                                <label for="image" class="col-md-4 control-label">Portada </label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
