@extends('layouts.base', ['title' => 'New publication'])

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center align-items-center mt-2 pt-2">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New publication</div>
                <div class="panel-body
                        @if ($errors->any())
                            alert alert-danger
                        @endif
                    ">
                    @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <form class="form-horizontal" method="POST" action="/publication/new/{{ session()->get('user')->id_usu}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group
                                @if ($errors->has('title'))
                                    has-error
                                @endif
                            ">
                            <label for="title" class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group
                                @if ($errors->has('description'))
                                    has-error
                                @endif
                            ">
                            <label for="description" class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="descripcion" required>{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group
                                @if ($errors->has('image'))
                                    has-error
                                @endif
                            ">
                            <label for="image" class="col-md-4 control-label">Image</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control" name="contenido" required>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="form-group
                                @if ($errors->has('submit'))
                                    has-error
                                @endif
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