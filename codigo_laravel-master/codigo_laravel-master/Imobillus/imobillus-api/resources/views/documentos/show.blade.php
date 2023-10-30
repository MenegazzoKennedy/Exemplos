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
                <a href="{{ route('dashboard.documento.index') }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">< Voltar</a>                
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
                    <tbody>
                        @foreach ($documentos as $documento)
                        
                        <tr>
                            <th>{{$documento->id }}</th>
                            <td style="max-width: 250px !important;">{{ $documento->cliente[0]['user']['name']}}</td>
                            <td style="max-width: 250px !important;">{{ $documento->imovel[0]['titulo'] }}</td>
                            <td style="max-width: 250px !important;">{{ $documento->corretor[0]['users']['name'] }}</td>
                            @if ($documento->status == "aguardando_revisao")             
                                <td>aguardando_revisao</td>  
                            @else  
                                <td>arquivos_invalidos</td> 
                            @endif                         
                            <td>
                            <div class="box_ctas btn-list text-right">
                              
                            </div> 
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
