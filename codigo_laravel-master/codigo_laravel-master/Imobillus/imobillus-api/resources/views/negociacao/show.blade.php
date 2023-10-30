@extends('layouts.app', ["titulo" => "Mais Code Editar Roles"])


@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Ver Negociação</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <a href="{{ route('dashboard.negociacao.index') }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">< Voltar</a>                
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
                   
                    @foreach ($negociacao as $documento)
                    
                        <h5>Cliente:</h5>
                        <p style="max-width: 250px !important;">{{ $documento->cliente[0]['user']['name']}} - {{ $documento->cliente[0]['user']['email']}} </p>

                        <h5>Imóvel:</h5>
                        <p style="max-width: 250px !important;">{{ $documento->imovel[0]['titulo'] }}</p>
                        
                        <h5>Corretor:</h5>
                        <p style="max-width: 250px !important;">{{ $documento->corretor[0]['users']['name'] }} - {{ $documento->corretor[0]['users']['email'] }}</p>
                        
                        <h5>Documentos:</h5>
                        @foreach ($documento->documentos as $doc)
                        <p><a href="{{ $doc->documento }}" target="_blank" class="btn waves-effect waves-light btn-rounded btn-outline-success">{{ $doc->documento }}</a></p>
                        @endforeach
                    </tr>
                    @endforeach
                        
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
