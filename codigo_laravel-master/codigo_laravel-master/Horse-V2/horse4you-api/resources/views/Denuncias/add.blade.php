@extends('layouts.app', ["titulo" => "MaisCode Denúncias"])

@section('content-breadcrumb')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Cadastrar Tipo Denúncias</h1>
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
    <form action="{{ route('dashboard.denuncia.store') }}" method="post" id="cadastraForm" enctype="multipart/form-data">
        @csrf
        <div class="row cadastro">
            <div class="col-12">    
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Descrição</span>
                    </div>
                    <textarea name="descricao" placeholder="Descrição" class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}" style="min-height: 37px;"></textarea>
                    @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>   
            </div>  
            
            <div class="col-12 d-grid">
                <button type="submit" class="btn btn-dark btnCadastrar float-right">Cadastrar</button>
            </div>
        </div>
    </form>
</div>



@endsection

@section('javascript')

@endsection