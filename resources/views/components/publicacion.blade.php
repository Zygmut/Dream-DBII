<div class="d-flex justify-content-center align-items-center mt-2 pt-2">
    <div class="col col-lg-9 col-xl-7 ">
        <div class="card">
            <img src="data:image/png;base64,{{ base64_encode($publication->cont_pub) }}"
                class="img-fluid width-100 rounded-top" alt="publicacion">
            <div class="card-block">
                <div class="timeline-details">
                    <div class="bg-white p-2">
                        <span class="fw-bold">{{ $user->nom_usu }}
                        </span>
                        <span>{{ $publication->desc_pub }}</span>
                        <p class="text-muted">{{ date('d-m-Y', strtotime($publication->fecha_pub)) }}</p>
                    </div>
                    <div class="card-block user-box p-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chat-left-dots-fill" viewBox="0 0 16 16"
                            style="height:1em; width:1em;  position: relative;">
                            >
                            <path
                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg> <span class="pb-2 f-14 ml-10">Comentarios ({{ $numOfComments }})</span>
                        <span class="float-end">
                            @if (!$isOwner)
                                @if (!$inHistory)
                                    <form action="/{{ session('user')->nom_usu }}/rt/{{ $publication->id_pub }}"
                                        method="POST" class="btn btn-primary btn-sm waves-effect waves-light">
                                        @csrf
                                        <button type="submit" style="all: unset">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                class="mr-10" fill="currentColor" class="bi bi-share-fill"
                                                viewBox="0 0 16 16"
                                                style="height:1em; width:1em; top: -.125em; position: relative;">
                                                >
                                                <path
                                                    d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z" />
                                            </svg> Compartir
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="/{{ session('user')->nom_usu }}/publication/{{ $publication->id_pub }}/edit"
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
                                <form
                                    action="/{{ session('user')->nom_usu }}/publication/{{ $publication->id_pub }}/delete"
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
                            @endif
                        </span>
                        <hr>
                        @foreach ($comments as $comment)
                            @include('components.comment', ['info' => $comment])
                        @endforeach
                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="media-object img-radius m-r-20 rounded-3"
                                    @if (session('user')->foto_perfil == null) src="/img/default_profile.jpg"
                @else
                    src="data:image/png;base64,{{ base64_encode(session('user')->foto_perfil) }}" @endif
                                    alt="Generic placeholder image">
                            </a>
                            <div class="media-body">
                                <form action="/{{ $user->id_usu }}/comment/newcomment/{{ $publication->id_pub }}"
                                    method="POST">
                                    @csrf
                                    <div class="mt-1">
                                        <textarea rows="5" cols="5" class="form-control" name="comentario" placeholder="Escribe un comentario"
                                            maxlength="255"></textarea>
                                        <button type="submit"
                                            class="btn btn-primary btn-sm waves-effect waves-light mt-2">
                                            Comentar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
