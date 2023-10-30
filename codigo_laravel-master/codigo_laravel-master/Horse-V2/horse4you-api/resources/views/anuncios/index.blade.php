@extends('layouts.app', ["titulo" => "Onliner Manager Denúncias"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Anúncios</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Anúncios</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')
<div class="container-fluid" id="publicacoes-list">
    <div class="row">   
        <div class="col-12">
        <div class="row">   
            @foreach($anuncios as $key => $post)
                <div class="col-12">
                    <div class="back-publi">
                        <div class="header-user header-{{$key}}">
                            <img src="{{$post->user->avatar}}">
                            <span>{{$post->user->name}}</span>
                            <p>{{$post->texto}}</p>
                        </div>
                        @if(isset($post->post_imagens[0]))
                            <div class="slider-all">
                                <div class="slider-post">
                                    @foreach($post->post_imagens as $imagem)
                                        <img class="tam-imagem" src="{{$imagem}}">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($post->post_videos != null)
                            <div class="slider-all">
                                <div class="slider-video slider-post">
                                    @foreach($post->post_videos as $video)
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
                        @if(isset($post->tags[0]))
                            <div class="tags">
                                @foreach($post->tags as $keyTag => $tag)
                                    @if(isset($post->tags[$keyTag + 1]))
                                        <span>#{{$tag->tag}},</span>
                                    @else
                                        <span>#{{$tag->tag}}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="mens-comm">
                            <i class="fas fa-heart"></i>
                            <span>{{$post->countlikes}}</span>
                            <i class="fas fa-comment-alt"></i>
                            <span>@if(isset($post->comments[0])) 
                                    {{ count($post->comments)}} 
                                @else 
                                    0 
                                @endif</span>
                        </div>
                    
                        <div class="btn-funcoes">
                            @if($post->status == 0)
                                <a href="{{ route('dashboard.anuncios.edit', $post->id) }}" class="btn btn-outline-success">Ativar Post</a>
                            @else
                                <a href="{{ route('dashboard.anuncios.edit', $post->id) }}" class="btn btn-outline-danger">Desativar Post</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="col-12 anunciosLinks">
            {{ $anuncios->links() }}
        </div>
    </div>
</div>

<style>
     @media(max-width: 320px){
        #publicacoes-list .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
    }
    #publicacoes-list .back-publi{
        width: 370px;
        margin: 0 auto;
        background: #f1f1f1;
        border-radius: 20px;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    #publicacoes-list .anunciosLinks svg{
        max-width:40px;
    }
    #publicacoes-list .tam-imagem{
        width: 100%;
        height: auto;
        object-fit: contain;
    }
    #publicacoes-list .slider-all,  #publicacoes-list .tags{
        width: 300px;
        height: auto;
        margin: 0 auto;
        position: relative;
    }
    #publicacoes-list .tags span{
        color:#ee6c4d !important;
    }
    #publicacoes-list .slider-all div{
       width: 100%;
    }
    #publicacoes-list .slick-dots{
       right: 0;
       bottom: 0 !important;
       z-index: 999;
    }
    #publicacoes-list .slick-prev::before, .slick-next::before {
        color:#ee6c4d !important;
    }
    #publicacoes-list .header-user img{
        width: 50px;
        height: 50px;
        display: inline-block;
        border-radius: 80px;
    }
    #publicacoes-list .header-user span{
        display: inline-block;
        font-size: 20px;
        margin-top: 25px;
    }
    #publicacoes-list .header-user{
        width: 300px;
        margin: 0 auto;
    } 
    #publicacoes-list .header-user p{
        margin-top: 10px;
    }
    #publicacoes-list .mens-comm{
        width: 300px;
        margin: 5px auto 0 auto;
    }
    #publicacoes-list .mens-comm i{
        color: #ee6c4d;
        font-size: 15px;
    }
    #publicacoes-list .btn-funcoes{
        width: fit-content;
        margin: 0 auto;
    }
</style>
@endsection

@section('javascript')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script>
        $('.slider-post').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: true,
            arrows: true
        });
        let valTag = [];
        function renoear(posicao){
            $('#label').text($('#exampleInputFile').val());
        }
        function sapanClick(valortag){
            var indiceTag = valTag.indexOf(valortag);
            if(indiceTag == -1){
                valTag.push(valortag);
                
            }else{
                valTag.splice(indiceTag, 1);
                $('#selectTag option[value='+valortag+']').prop('selected', false);
            }
            $(".tags-selects-present span").remove();
            valTag.forEach(function(valor, i) {
                $('#selectTag option[value='+valor+']').prop('selected', 'selected');
                $(".tags-selects-present").append('<span>#'+valor+'<span onclick="sapanClick(`'+valor+'`)">x</span></span>');
            })
        }
        $('#novaTag').keypress(function(e) {
            if(e.which == 32){
                var valorNovaTag = $('#novaTag').val();
                document.getElementById('novaTag').value = null;
                if($('#selectTag option[value='+valorNovaTag+']')[0] == undefined){
                    $("#selectTag").append('<option value="'+valorNovaTag.trim()+'">'+valorNovaTag+'</option>');
                }
                sapanClick(valorNovaTag.trim());
            };
        });
        $(document).on('click', '#selectTag option', function(){
            var indiceTag = valTag.indexOf(this.value);
            if(indiceTag == -1){
                valTag.push(this.value);
                
            }else{
                valTag.splice(indiceTag, 1);
                $('#selectTag option[value='+this.value+']').prop('selected', false);
            }
            $(".tags-selects-present span").remove();
            valTag.forEach(function(valor, i) {
                $('#selectTag option[value='+valor+']').prop('selected', 'selected');
                $(".tags-selects-present").append('<span>#'+valor+'<span onclick="sapanClick(`'+valor+'`)">x</span></span>');
            })
        })
    </script>
@endsection