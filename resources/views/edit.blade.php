@extends('layouts.base', ['title' => 'Edit profile'])

@section('content')
<!-- Show the user's data -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Edit profile</h1>
            <form action="/{{ $user->nom_usu}}/edit" method="post">
                @csrf
                <div class="form-group
                    @if ($errors->has('nombre'))
                        has-error
                    @endif
                ">
                    <label for="nombre">Name</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $user->nom_usu}}">
                    @if ($errors->has('nombre'))
                    <span class="help-block
                            @if ($errors->has('nombre'))
                                text-danger
                            @endif
                        ">
                        {{ $errors->first('nombre') }}
                    </span>
                    @endif
                </div>
                <div class="form-group
                    @if ($errors->has('username'))
                        has-error
                    @endif
                ">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ $user->nom_usu}}">
                    @if ($errors->has('username'))
                    <span class="help-block
                            @if ($errors->has('username'))
                                text-danger
                            @endif
                        ">
                        {{ $errors->first('username') }}
                    </span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection