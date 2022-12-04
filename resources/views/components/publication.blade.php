<div class="col-10 col-sm-10 col-xl-11 p-l-5 p-b-35">
    <div class="card">
        <div class="card-block post-timelines">
            <div class="chat-header f-w-600">{{$user->nombreUsuario}}</div>
            <div class="social-time text-muted">{{$publication->fecha}}</div>
        </div>
        <img src="data:image/png;base64,{{base64_encode($publication->contenido)}}" class="img-fluid width-100" alt="">
        <div class="card-block">
            <div class="timeline-details">
                <div class="chat-header">{{$user->nombreUsuario}} publicó esta foto el día {{date("d-m-Y",strtotime($publication->fecha))}}</div>
                <p class="text-muted">{{$publication->descripcion}}</p>
            </div>
        </div>
        <div class="card-block b-b-theme b-t-theme social-msg">
            <a href="#"> <i class="icofont icofont-comment text-muted"></i> <span class="b-r-muted">Comments ({{$numOfComments}})</span></a>
            <a href="#"> <i class="icofont icofont-share text-muted"></i> <span>RT (10)</span></a>
        </div>
        <div class="card-block user-box">
            <div class="pb-2"> <span class="f-14"><a href="#">Comments ({{$numOfComments}})</a></span><span class="f-right"> see all comments</span></div>
            <p>{{$comments}}</p> 
            @foreach ($comments as $comment)
            <div class="media m-b-20">
                <a class="media-left" href="#">
                    <img class="media-object img-radius m-r-20" src="data:image/png;base64,{{base64_encode($comment->fotoPerfil)}}" alt="Generic placeholder image">
                </a>
                <div class="media-body b-b-muted social-client-description">
                    <div class="chat-header">{{$comment->nombreUsuario}}<span class="text-muted">{{$comment->fecha}}</span></div>
                    <p class="text-muted">{{$comment->contenido}}</p>
                </div>
            </div>
            @endforeach
            <div class="media">
                <a class="media-left" href="#">
                    <img class="media-object img-radius m-r-20" src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="Generic placeholder image">
                </a>
                <div class="media-body">
                    <form class="/{{$user->idUsuario}}/comment/newcomment/{{$publication->idPublicacion}}" method="POST">
                        <div class="mt-1">
                            <textarea rows="5" cols="5" class="form-control" name="comentario" placeholder="Escribe un comentario"></textarea>
                            <div class="text-right m-t-20"><a href="#" class="btn btn-primary waves-effect waves-light my-2">Post</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>