@extends('layouts.app', ["titulo" => "Onliner Manager Denúncias"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Denúncias</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Denúncias</li>
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
            <div class="mx-auto pull-right">
                <div class="float-right">
                    <form action="{{ route('dashboard.denuncia.index') }}" method="GET" role="search">
                        @csrf
                        <div class="input-group">                                    
                            <div class="form-group">                                            
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="usuario" @if($denuncias['tipo'] == 'Usuario') selected @endif>Usuario</option>
                                    <option value="post" @if($denuncias['tipo'] == 'Post') selected @endif>Post</option>
                                    <option value="comentario" @if($denuncias['tipo'] == 'Comentario') selected @endif>Comentario</option>
                                </select>
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="submit" title="Search">
                                    <span class="fas fa-search"></span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 d-none d-sm-none d-md-block">
            <div class="card">
                <div class="card-body d-none">
                    <h4 class="card-title">Hoverable Rows</h4>
                    <h6 class="card-subtitle">Add <code>.table-hover</code> to enable a hover state on table
                        rows within a <code>&lt;tbody&gt;</code>.</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Usuario Denunciante</th>
                                <th scope="col">{{$denuncias['tipo']}}</th>
                                <th scope="col">Categoria da Denuncia</th>
                                <th scope="col">Denuncia</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($denuncias['data'] as $denuncia)
                            
                            <tr>
                            <th scope="row">{{$denuncia->id }}</th>
                                <td>{{ $denuncia->denuciador }}</td>
                                <td>{{ $denuncia->denunciado  }}</td> 
                                <td>{{ $denuncia->categoriaAppend }}</td> 
                                <td>{{ $denuncia->denuncia }}</td>                                      
                                <td>@if($denuncia->status == 0)
                                    Não moderado
                                    @elseif($denuncia->status == 1)
                                    Ativo
                                    @elseif($denuncia->status == -1)
                                    Inativo
                                    @endif
                                </td>                                      
                                <td>
                                    <a href="{{ route('dashboard.denuncia.edit', $denuncia->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Moderar</a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card col-12 d-block d-sm-block d-md-none users_admin text-center"> 
            <hr>           
            <div class="row">
                <div class="col-12">
                    @foreach ($denuncias['data'] as $denuncia)
                        <h3>{{ $denuncia->id }}</h3>
                        <h3>{{ $denuncia->id_user_denunciante  }}</h3>
                        <h3>{{ $denuncia->denunciado }}</h3>
                        <h3>{{ $denuncia->categoria  }}</h3>
                        <p>{{ $denuncia->denuncia }}</p> 
                        <div class="box_ctas btn-list">
                            
                                <a href="{{ route('dashboard.denuncia.edit', $denuncia->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>

                        </div> 
                        <hr>   
                    @endforeach                           
                    
                </div>
            </div>
           
        </div>
        <div class="col-12 denunciaLinks">
            {{ $denuncias['data']->links() }}
        </div>
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
   .denunciaLinks svg{
        max-width:40px;
   }
</style>
@endsection

@section('javascript')


<script>

    
</script>
@endsection