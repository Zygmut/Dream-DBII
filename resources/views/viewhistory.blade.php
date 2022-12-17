@extends('layouts.base', ['title' => 'Nueva historia'])

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-2 pt-2">
        <div class="col col-lg-9 col-xl-7 ">
            <div class="card">
                <div class="card-block">
                    <div class="timeline-details">
                        <div class="bg-white p-2">
                            <span class="fw-bold">{{ $userInfo->nom_usu }}
                            </span>
                            <span>{{ $story->desc_his }}</span>
                            <p class="text-muted">{{ date('d-m-Y', strtotime($story->fecha_his)) }}</p>
                        </div>
                        <div class="card-block user-box p-0">

                            @if ($isOwner)
                                <span class="float-end">
                                    <a href="/{{ session('user')->nom_usu }}/story/{{ $story->id_his }}/edit"
                                        class="btn btn-primary btn-sm waves-effect waves-light px-3">
                                        @csrf
                                        <button type="submit" style="all: unset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16"
                                                style="height:1em; width:1em; top: -.125em; position: relative;">
                                                <path
                                                    d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                            </svg>
                                            Editar
                                        </button>
                                    </a>
                                    <form action="/{{ session('user')->nom_usu }}/story/{{ $story->id_his }}/delete"
                                        method="POST" class="btn btn-danger btn-sm waves-effect waves-light">
                                        @csrf
                                        <button type="submit" style="all: unset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                class="mr-10" fill="currentColor" class="bi bi-trash3-fill"
                                                viewBox="0 0 16 16"
                                                style="height:1em; width:1em; top: -.125em; position: relative;">
                                                >
                                                <path
                                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                            </svg>
                                            Borrar
                                        </button>
                                    </form>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Imagenes -->
                @if (count($publicaciones) > 0)
                    @foreach ($publicaciones as $publicacion)
                        <div class="col-lg-6 mb-2 pr-lg-1 mx-auto">
                            <a href="/{{ $userInfo->nom_usu }}/publication/{{ $publicacion->id_pub }}?in=0">
                                <img src="data:image/png;base64,{{ base64_encode($publicacion->cont_pub) }}"
                                    alt="publicaciones" class="img-fluid rounded shadow-sm ">
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="mb-2 pr-lg-1 mt-2 pt-2">
                        <h1 class="card-title text-center">No hay publicaciones</h1>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
