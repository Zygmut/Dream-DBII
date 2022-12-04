@extends('layouts.base', ['title' => 'Home'])

@push('styles')
<link rel="stylesheet" href="{{URL::asset('css/app.css')}}">
@endpush

@section('content')
<div class="container py-5 px-4">
    <div class="mx-auto">
        <!-- Profile widget -->
        <div class="bg-white shadow rounded overflow-hidden">
            <div class="row">
                <div class="col-sm-4 px-4 pt-0 pb-4 cover">
                    <div class="media align-items-end profile-head">
                        <div class="profile mr-3">
                            <svg class="rounded mb-2 img-thumbnail" id="Layer_1" enable-background="new 0 0 512 512" height="150" viewBox="0 0 512 512" width="150" xmlns="http://www.w3.org/2000/svg">
                                <path d="m256 0c-141.159 0-256 114.841-256 256s114.841 256 256 256 256-114.841 256-256-114.841-256-256-256zm0 482c-57.644 0-110.306-21.704-150.273-57.355 41.437-37.026 94.233-57.245 150.273-57.245s108.837 20.219 150.272 57.244c-39.966 35.652-92.628 57.356-150.272 57.356zm171.309-78.757c-67.061-60.563-141.513-65.843-171.309-65.843-29.884 0-104.264 5.308-171.31 65.842-34.067-39.579-54.69-91.046-54.69-147.242 0-124.617 101.383-226 226-226s226 101.383 226 226c0 56.197-20.623 107.663-54.691 147.243z" />
                                <path d="m256 80.333c-52.644 0-95.333 42.595-95.333 95.334v32.133c0 52.645 42.595 95.334 95.333 95.334 52.644 0 95.333-42.595 95.333-95.334v-32.133c0-52.653-42.602-95.334-95.333-95.334zm65.333 127.467c0 36.084-29.196 65.334-65.333 65.334-35.494 0-65.333-28.684-65.333-65.334v-32.133c0-36.651 29.842-65.334 65.333-65.334 36.079 0 65.333 29.192 65.333 65.334z" />
                            </svg>
                        </div>
                        <div class="media-body mb-5 text-black">
                            <a href="/{{$userInfo->nombreUsuario}}/edit" class="btn btn-outline-dark btn-sm btn-block">
                                Edit profile
                            </a>
                            <h4 class="mt-0 mb-0">{{$userInfo->nombreUsuario}}</h4>
                            <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i>Universidad de las Islas Baleares</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 bg-light p-4 d-flex justify-content-center text-center align-items-center">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$numberPublications}}</h5><small class="text-muted"> <i class="fas fa-image mr-1"></i>Photos</small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$followers}}</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Followers</small>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="font-weight-bold mb-0 d-block">{{$following}}</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Following</small>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4 px-4 py-3 d-flex flex-column justify-content-center align-items-center">
                    <h5 class="mb-0">Bio</h5>
                    <div class="p-4 bg-light">
                        <p class="font-italic mb-0">{{$user->descripcion}}</p>
                    </div>
                </div>
            </div>
            <div class="py-4 px-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Recent photos</h5><a href="#" class="btn btn-link text-muted">Show all</a>
                </div>
                <div class="row">
                    @foreach($publications as $publication)
                    <div class="col-lg-6 mb-2 pr-lg-1">
                        <a href="/{{$userInfo->nombreUsuario}}/publication/{{$publication->idPublicacion}}">
                            <img src="data:image/png;base64,{{base64_encode($publication->contenido)}}" alt="publicaciones" class="img-fluid rounded shadow-sm">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection