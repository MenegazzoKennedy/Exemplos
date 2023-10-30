@extends('layouts.app', ["titulo" => "Onliner Manager Editar Roles"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Edição de Tipos de Denúncias</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.tipoDenuncia') }}">Tipo Denúncias</a></li>
                <li class="breadcrumb-item active">Edição de Tipos de Denúncias</li>
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
                    <form action="{{ route('dashboard.updateTipo', $tipoDenuncia->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row cadastro">
                            <div class="col-12">  
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descrição</span>
                                    </div>
                                    <textarea name="descricao" placeholder="Descrição" class="form-control @error('descricao') is-invalid @enderror" style="min-height: 37px;">{{$tipoDenuncia->descricao}}</textarea>
                                    @error('descricao')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>   
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Status</span>
                                    </div>
                                    <div class="form-control">
                                        <input type="radio" id="ativar" @if($tipoDenuncia->status == 1) checked @endif name="status" value="1">
                                        <label for="ativar">Ativar</label>
                                        <input type="radio" id="desativar" @if($tipoDenuncia->status == 0) checked @endif name="status" value="0">
                                        <label for="desativar">Destivar</label>
                                    </div>
                                </div>   
                            </div>  
                            
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-dark btnCadastrar float-right">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
