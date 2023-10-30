@extends('layouts.app', ["titulo" => "Mais Code Editar Roles"])


@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Documento</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Documentos</li>
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
                    <form action="{{ route('dashboard.visita.update', ['visitum' => $visita->id]) }}" method="POST" id="editarForm"  enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}
                        <?php 
                            $dataTime = explode(" ", $visita->data);
                            $endereco = "Cidade ".$bairro->cidade->name.", Bairro ".$bairro->name.", Rua ".$produto->logradouro.", Numero ".$produto->numero;
                        ?>
                        <div class="row cadastro">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cliente</span>
                                    </div>
                                    <span class="form-control">@if($cliente[0]['user']) {{ $cliente[0]['user']['name'] }} @endif</span>
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Produto</span>
                                    </div>
                                    <span class="form-control">@if($produto) {{ $produto['titulo'] }} @endif</span>
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Endereço da Visita</span>
                                    </div>
                                    <span class="form-control">@if($produto) {{ $endereco }} @endif</span>
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Data</span>
                                    </div>
                                    <input type="date" class="form-control" value="{{ $dataTime[0] }}" placeholder="Central" aria-label="data" aria-describedby="basic-addon1" name="data">
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Hora</span>
                                    </div>
                                    <input type="time" class="form-control" value="{{ $dataTime[1] }}" placeholder="Central" aria-label="data" aria-describedby="basic-addon1" name="hora">
                                </div>  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Corretor</span>
                                    </div>
                                    <select class="custom-select" id="corretor" name="corretor">
                                        <option @if(is_null($corretor)) selected @endif>Selecione</option>
                                            @foreach ($corretores as $cor)
                                                <option @if(!is_null($corretor)) @if($corretor[0]->id == $cor->id) selected @endif @endif value="{{$cor->id}}">{{$cor['users']->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>                  

                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
