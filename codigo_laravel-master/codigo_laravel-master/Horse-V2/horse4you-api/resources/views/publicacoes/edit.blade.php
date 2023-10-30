@extends('layouts.app', ["titulo" => "Onliner Manager Denúncias"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Publicações</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Publicações</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid" id="publicacoes-list-single">
    <div class="row">   
        <div class="col-12">
            <div class="row">   
                <div class="col-12">
                    <div class="back-publi">
                        <div class="header-user">
                            <img src="{{$post[0]->user->avatar}}">
                            <span>{{$post[0]->user->name}}</span>
                            <p>{{$post[0]->texto}}</p>
                        </div>
                        @if(isset($post[0]->post_imagens[0]))
                            <div class="slider-all">
                                <div class="slider-img">
                                    @foreach($post[0]->post_imagens as $imagem)
                                        <img class="tam-imagem" src="{{$imagem}}">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(isset($post[0]->post_videos[0]))
                            <div class="slider-all">
                                <div class="slider-video">
                                    @foreach($post[0]->post_videos as $video)
                                        <video width="320" height="240" controls="controls">
                                            <source src="{{$video}}" type="video/mp4">
                                            <object data="" width="320" height="240">
                                                <embed width="320" height="240" src="{{$video}}">
                                            </object>
                                        </video>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(isset($post[0]->tags[0]))
                            <div class="tags">
                                @foreach($post[0]->tags as $key => $tag)
                                    @if(isset($post[0]->tags[$key + 1]))
                                        <span>#{{$tag->tag}},</span>
                                    @else
                                        <span>#{{$tag->tag}}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="mens-comm">
                            <i class="fas fa-heart"></i>
                            <span>{{$post[0]->countlikes}}</span>

                            <button type="button" class="btn" data-toggle="modal" data-target="#modalComentarios">
                                <i class="fas fa-comment-alt"></i>
                                <span>@if(isset($post[0]->comments[0])) 
                                        {{ count($post[0]->comments)}} 
                                    @else 
                                        0 
                                    @endif
                                </span>
                            </button>
                            <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            @if(isset($post[0]->comments[0]))
                                                @foreach($post[0]->comments as $comment)
                                                    <div class="header-user-modal">
                                                        <img src="{{$comment->user[0]->avatar}}">
                                                        <span>{{$comment->user[0]->name}}</span>
                                                    </div>
                                                    <p>{{$comment->texto}}</p>

                                                    <i class="fas fa-heart mens-comm-interno"></i>
                                                    <span> {{$comment->countlikescomment}}</span>
                                                    <p>{{count($comment->reply)}} respostas do comentário.</p>
                                                    @if(isset($comment->reply[0]))
                                                        <div class="comments-reply">
                                                            @foreach($comment->reply as $reply)
                                                                <div>
                                                                    <img src="{{$reply->user[0]->avatar}}">
                                                                    <span>{{$reply->user[0]->name}}</span>
                                                                </div>
                                                                <p>{{$reply->texto}}</p>
                                                                <i class="fas fa-heart"></i>
                                                                <span> {{$reply->countlikescomment}}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <h2>Esse post não possui comentarios</h2>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                        <div class="btn-funcoes">
                            @if($post[0]->status == 0)
                                <a href="{{ route('dashboard.publicacoes.edit', $post[0]->id) }}" class="btn btn-outline-success">Ativar Post</a>
                            @else
                                <a href="{{ route('dashboard.publicacoes.edit', $post[0]->id) }}" class="btn btn-outline-danger">Desativar Post</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #publicacoes-list-single .back-publi{
        width: 370px;
        margin: 0 auto;
        background: #f1f1f1;
        border-radius: 20px;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    #publicacoes-list-single .tam-imagem{
        width: 100%;
        height: auto;
        object-fit: contain;
    }
    #publicacoes-list-single .slider-all, #publicacoes-list-single .tags{
        width: 300px;
        height: auto;
        margin: 0 auto;
        position: relative;
    }
    #publicacoes-list-single .tags span{
        color:#ee6c4d !important;
    }
    #publicacoes-list-single .slider-all div{
       width: 100%;
    }
    #publicacoes-list-single .slick-dots{
       right: 0;
       bottom: 0 !important;
       z-index: 999;
    }
    #publicacoes-list-single .slick-prev::before, .slick-next::before {
        color:#ee6c4d !important;
    }
    #publicacoes-list-single .header-user img{
        width: 50px;
        height: 50px;
        display: inline-block;
        border-radius: 80px;
    }
    #publicacoes-list-single .header-user video{
        width: 50px;
        height: 50px;
        display: inline-block;
        border-radius: 80px;
    }
    #publicacoes-list-single .header-user span{
        display: inline-block;
        font-size: 20px;
        margin-top: 25px;
    }
    #publicacoes-list-single .header-user{
        width: 300px;
        margin: 0 auto;
    } 
    #publicacoes-list-single .header-user p{
        margin-top: 10px;
    }
    #publicacoes-list-single .mens-comm{
        width: 300px;
        margin: 5px auto 0 auto;
    }
    #publicacoes-list-single .mens-comm i{
        color: #ee6c4d;
        font-size: 15px;
    }
    #publicacoes-list-single .mens-comm-interno{
        padding-left: 30px;
    }
    #publicacoes-list-single .btn-funcoes{
        width: fit-content;
        margin: 0 auto;
    }
    #publicacoes-list-single #modalComentarios .modal-body .header-user-modal img,
    #publicacoes-list-single #modalComentarios .modal-body .comments-reply img{
        width: 25px;
        height: 25px;
        display: inline-block;
        border-radius: 80px;
    }
    #publicacoes-list-single #modalComentarios .modal-body .header-user-modal span{
        display: inline-block;
        font-size: 12px;
        margin-top: 25px;
    }
    #publicacoes-list-single #modalComentarios .modal-body .comments-reply i{
        margin: 0 0 20px 30px;
    }
    #publicacoes-list-single #modalComentarios .modal-body .comments-reply span{
        display: inline-block;
        font-size: 12px;
        margin: 0;
    }
    #publicacoes-list-single #modalComentarios .modal-body p,
    #publicacoes-list-single #modalComentarios .comments-reply{
        padding-left: 30px;
    }
    #publicacoes-list-single #modalComentarios .modal-body p{
        margin-bottom: 0; 
    }
</style>
@endsection
@section('javascript')
<script>
    var $jq = jQuery.noConflict();
    $jq(document).ready(function() {
        $jq('.slider-img').slick({
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true, 
        });
        $jq('.slider-video').slick({
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true, 
        });
    });
</script>
@endsection