@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar Produto</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="" class="text-muted">Produto</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>        
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-none">Grid With Row Label</h4>
                    <form action="{{ route('dashboard.produtos.update', ['produto' => $produto->id]) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row cadastro">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descricao</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $produto->descricao }}" placeholder="Central" aria-label="Username" aria-describedby="basic-addon1" name="descricao">
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
