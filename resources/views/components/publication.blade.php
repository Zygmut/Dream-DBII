<div class="col-10 col-sm-10 col-xl-11 p-l-5 p-b-35">
    <div class="card">
        <div class="card-block post-timelines">
            <div class="chat-header f-w-600">{{ $user->nom_usu }}</div>
            <div class="social-time text-muted">{{ $publication->fecha_pub }}</div>
        </div>
        <img src="data:image/png;base64,{{ base64_encode($publication->cont_pub) }}" class="img-fluid width-100"
            alt="">
        <div class="card-block">
            <div class="timeline-details">
                <div class="chat-header">{{ $user->nom_usu }} publicó esta foto el día
                    {{ date('d-m-Y', strtotime($publication->fecha_pub)) }}</div>
                <p class="text-muted">{{ $publication->desc_pub }}</p>
            </div>
        </div>
        <div class="card-block b-b-theme b-t-theme social-msg">
            <a href="#"> <i class="icofont icofont-comment text-muted"></i> <span class="b-r-muted">Comments
                    ({{ $numOfComments }})</span></a>
            <a href="#"> <i class="icofont icofont-share text-muted"></i> <span>RT (10)</span></a>
        </div>
        <div class="card-block user-box">
            <div class="pb-2"> <span class="f-14"><a href="#">Comments ({{ $numOfComments }})</a></span><span
                    class="f-right"> see all comments</span></div>
            @foreach ($comments as $comment)
                <div class="media m-b-20">
                    <a class="media-left" href="#">
                        <img class="media-object img-radius m-r-20"
                            @if ($comment->foto_perfil == null) src="/img/default_profile.jpg"
                        @else
                            src="data:image/png;base64,{{ base64_encode($comment->foto_perfil) }}" @endif
                            alt="Generic placeholder image">
                    </a>
                    <div class="media-body b-b-muted social-client-description">
                        <div class="chat-header">{{ $comment->nom_usu }}<span
                                class="text-muted">{{ $comment->fecha_com }}</span></div>
                        <p class="text-muted">{{ $comment->cont_com }}</p>
                    </div>
                </div>
            @endforeach
            <div class="media">
                <a class="media-left" href="#">
                    <img class="media-object img-radius m-r-20"
                        @if (session('user')->foto_perfil == null) src="/img/default_profile.jpg"
                    @else
                        src="data:image/png;base64,{{ base64_encode(session('user')->foto_perfil) }}" @endif
                        alt="Generic placeholder image">
                </a>
                <div class="media-body">
                    <form action="/{{ $user->id_usu }}/comment/newcomment/{{ $publication->id_pub }}" method="POST">
                        @csrf
                        <div class="mt-1">
                            <textarea rows="5" cols="5" class="form-control" name="comentario" placeholder="Escribe un comentario"></textarea>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light mt-2">
                                Comentar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
