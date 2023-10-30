@extends('layouts.app', ["titulo" => "Onliner Manager Editar Roles"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Moderação de Denúncias</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('dashboard.denuncia.index') }}">Denúncias</a></li>
                <li class="breadcrumb-item active">Moderação</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-none">Grid With Row Label</h4>
                    <form id="postEdit" action="{{ route('dashboard.denuncia.update', $denuncia->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <p class="">Id: <strong>{{ $denuncia->id }}</strong></p>
                        <p class="">Usuário Denunciante: <strong>{{ $denuncia->denuciador }}</strong></p>
                        <p class="">{{ $denuncia->tipoDenunciado }} <strong>{{ $denuncia->denunciado }}</strong></p>
                        <p class="">Categoria da Denúncia: <strong>{{ $denuncia->categoriaAppend }}</strong></p>
                        <p class="">Denúncia: <strong>{{ $denuncia->denuncia }}</strong></p>
                        <input type="radio" id="ativar" @if($denuncia->status == 1) checked @endif name="status" value="1">
                        <label for="ativar">Ativar</label><br>
                        <input type="radio" id="desativar" @if($denuncia->status == -1) checked @endif name="status" value="-1">
                        <label for="desativar">Destivar</label><br>
                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-success lancamento-deletar">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if(isset($denuncia->denunciadoArray[0]->user) && !isset($denuncia->denunciadoArray[0]->post))
                            <?php $mensagem = 'post';?>
                            <div class="col-12">
                                <h2>Detalhes do Post</h2>
                                <p class="">Usuário Criador do Post : <strong>{{ $denuncia->denunciadoArray[0]->user->id }} - {{$denuncia->denunciadoArray[0]->user->name}}</strong></p>
                                
                                <p class="">Conteúdo do Post : <strong>{{ $denuncia->denunciadoArray[0]->texto }}</strong></p>
                                <p class="">Quantidade de Denúncias: <strong>{{ count($denunciado) + 1 }}</strong></p>
                                <div>
                            </div>
                            @if(isset($denuncia->denunciadoArray[0]->post_imagens[0]))
                                <h2>Imagens do Post</h2>
                                <div class="col-12 imagens-post slider-post">
                                    @foreach($denuncia->denunciadoArray[0]->post_imagens as $imagem)
                                    <img src="{{$imagem}}">
                                    @endforeach
                                </div>
                            @endif
                            @if(isset($denuncia->denunciadoArray[0]->post_videos[0]))
                                <h2>Vídeos do Post</h2>
                                <div class="col-12 slider-post">
                                    @foreach($denuncia->denunciadoArray[0]->post_videos as $video)
                                    <video width="320" height="240" controls="controls">
                                        <source src="{{$video}}" type="video/mp4">
                                        <object data="" width="320" height="240">
                                            <embed width="320" height="240" src="{{$video}}">
                                        </object>
                                    </video>
                                    @endforeach
                                </div>
                            @endif
                        @elseif(isset($denuncia->denunciadoArray[0]->user) && isset($denuncia->denunciadoArray[0]->post))
                        <?php $mensagem = 'comentario';?>
                            <div class="col-12">
                                <h2>Detalhes do Comentario</h2>
                                <p class="">Usuario Criado do Comentario : <strong>{{ $denuncia->denunciadoArray[0]->user[0]->id }} - {{$denuncia->denunciadoArray[0]->user[0]->name}}</strong></p>
                                
                                <p class="">Conteudo do Comentario : <strong>{{ $denuncia->denunciadoArray[0]->texto }}</strong></p>
                                <div>
                            </div>
                        @else
                        <?php $mensagem = 'usuario';?>
                            <div class="col-12">
                                <h2>Detalhes do Usuario Denunciado</h2>
                                <p class="">Nome: <strong>{{ $denuncia->denunciadoArray[0]->name }}</strong></p>
                                <p class="">Email: <strong>{{ $denuncia->denunciadoArray[0]->email }}</strong></p>
                                <p class="">Telefone: <strong>{{ $denuncia->denunciadoArray[0]->telefone }}</strong></p>
                                <p class="">Aniversário: <strong>{{ $denuncia->denunciadoArray[0]->aniversario }}</strong></p>
                                <p class="">Quátidade de Denúncias: <strong>{{ count($denunciado) + 1 }}</strong></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(isset($denunciado[0]))
            <div class="col-12 p-0">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if(isset($denuncia->denunciadoArray[0]->user) && !isset($denuncia->denunciadoArray[0]->post))
                                @if(isset($denunciado[0]))
                                    <div class="col-12">
                                        <h2>Outras Denuncias</h2>
                                    </div>
                                    <div id="accordion" class="col-12 p-0">
                                        <div class="card">
                                            @foreach($denunciado as $key => $denunciad)
                                                <div class="card-header" id="heading{{$key}}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <p class="">Id: <strong>{{ $denunciad->id }}</strong></p>
                                                        <p class="">Usuário Denunciante: <strong>{{ $denunciad->denuciador }}</strong></p>
                                                        <p class="">{{ $denunciad->tipoDenunciado }} <strong>{{ $denunciad->denunciado }}</strong></p>
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        <p class="">Denúncia: <strong>{{ $denunciad->denuncia }}</strong></p>
                                                        @if($denunciad->status == 0)
                                                            <label>Não moderado</label>
                                                        @elseif($denunciad->status == 1)
                                                            <label>Ativo</label>
                                                        @elseif($denunciad->status == -1)
                                                            <label>Inativo</label>
                                                        @endif      
                                                        <td>
                                                            <a href="{{ route('dashboard.denuncia.edit', $denunciad->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Moderar</a>
                                                        </td>                                  
                                                    </div>
                                                </div>                
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @elseif(isset($denuncia->denunciadoArray[0]->user) && isset($denuncia->denunciadoArray[0]->post))
                                @if(isset($denunciado[0]))
                                    <div class="col-12">
                                        <h2>Outras Denuncias</h2>
                                    </div>
                                    <div id="accordion" class="col-12 p-0">
                                        <div class="card">
                                            @foreach($denunciado as $key => $denunciad)
                                                <div class="card-header" id="heading{{$key}}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <p class="">Id: <strong>{{ $denunciad->id }}</strong></p>
                                                        <p class="">Usuário Denunciante: <strong>{{ $denunciad->denuciador }}</strong></p>
                                                        <p class="">{{ $denunciad->tipoDenunciado }} <strong>{{ $denunciad->denunciado }}</strong></p>
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        <p class="">Denúncia: <strong>{{ $denunciad->denuncia }}</strong></p>
                                                        @if($denunciad->status == 0)
                                                            <label>Não moderado</label>
                                                        @elseif($denunciad->status == 1)
                                                            <label>Ativo</label>
                                                        @elseif($denunciad->status == -1)
                                                            <label>Inativo</label>
                                                        @endif      
                                                        <td>
                                                            <a href="{{ route('dashboard.denuncia.edit', $denunciad->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Moderar</a>
                                                        </td>                                  
                                                    </div>
                                                </div>                
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                            @if(isset($denunciado[0]))
                                    <div class="col-12">
                                        <h2>Outras Denuncias</h2>
                                    </div>
                                    <div id="accordion" class="col-12 p-0">
                                        <div class="card">
                                            @foreach($denunciado as $key => $denunciad)
                                                <div class="card-header" id="heading{{$key}}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <p class="">Id: <strong>{{ $denunciad->id }}</strong></p>
                                                        <p class="">Usuário Denunciante: <strong>{{ $denunciad->denuciador }}</strong></p>
                                                        <p class="">{{ $denunciad->tipoDenunciado }} <strong>{{ $denunciad->denunciado }}</strong></p>
                                                        <p class="">Categoria da Denúncia: <strong>{{ $denunciad->categoriaAppend }}</strong></p>
                                                        <p class="">Denúncia: <strong>{{ $denunciad->denuncia }}</strong></p>
                                                        @if($denunciad->status == 0)
                                                            <label>Não moderado</label>
                                                        @elseif($denunciad->status == 1)
                                                            <label>Ativo</label>
                                                        @elseif($denunciad->status == -1)
                                                            <label>Inativo</label>
                                                        @endif      
                                                        <td>
                                                            <a href="{{ route('dashboard.denuncia.edit', $denunciad->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Moderar</a>
                                                        </td>                                  
                                                    </div>
                                                </div>                
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
   .imagens-post img, .slider-post video{
        max-width:340px;
        height: 240px;
   }
   .slick-prev{
        left: -10px !important;
   }
   .slick-prev:before {
    	content: '←';
        color: #343a40 !important;
   
    }
    .slick-next{
        right: -10px !important;
    }
   .slick-next:before {
		content: '→';
        color: #343a40 !important;
    }
</style>   
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
        $(".lancamento-deletar").click(function($e){
            $e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

            swalWithBootstrapButtons.fire({
                title: 'Você tem certeza?',
                text: "Esse {{$mensagem}} possui outras denúncias! A sua ação pode mudar conclusões chegadas em outras denúncias.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Sim, salvar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    $('#postEdit').submit();                    
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado'
                    )                
                }
            });

    });
    </script>
@endsection
@endsection