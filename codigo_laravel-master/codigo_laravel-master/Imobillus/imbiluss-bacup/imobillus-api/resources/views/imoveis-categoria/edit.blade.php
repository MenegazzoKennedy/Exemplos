@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Categoria</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Categorias</li>
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
                    <form action="{{ route('dashboard.categoria.update', ['categorium' => $tipo->id]) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row cadastro">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descricao</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $tipo->descricao }}" placeholder="Central" aria-label="Username" aria-describedby="basic-addon1" name="descricao">
                                </div>  
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Slug</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $tipo->slug }}" placeholder="Central" aria-label="Username" aria-describedby="basic-addon1" name="slug">
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
