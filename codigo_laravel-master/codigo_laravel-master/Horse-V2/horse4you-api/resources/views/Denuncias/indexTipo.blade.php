@extends('layouts.app', ["titulo" => "Onliner Manager Tipo Denúncias"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Tipo Denúncias</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Tipo Denúncias</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
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
                                <th scope="col">Descricao</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div class="text-right"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tipoDenuncias as $tipoDenuncia)
                            
                            <tr>
                                <td scope="row">{{$tipoDenuncia->id }}</td>
                                <td>{{ $tipoDenuncia->descricao  }}</td>                                      
                                <td>@if($tipoDenuncia->status == 0)
                                    Inativo
                                    @elseif($tipoDenuncia->status == 1)
                                    Ativo
                                    @endif
                                </td>                                      
                                <td>
                                    <a href="{{ route('dashboard.editTipo', $tipoDenuncia->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info float-right">Editar</a>
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
                    @foreach ($tipoDenuncias as $tipoDenuncia)
                        <h3>{{ $tipoDenuncia->id }}</h3>
                        <p>{{ $tipoDenuncia->descricao }}</p> 
                        <p>@if($tipoDenuncia->status == 0)
                            Inativo
                            @elseif($tipoDenuncia->status == 1)
                            Ativo
                            @endif
                        </p> 
                        <a href="{{ route('dashboard.editTipo', $tipoDenuncia->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>
                        <hr>   
                    @endforeach                           
                    
                </div>
            </div>
           
        </div>
        <div class="col-12 tipoDenunciaLinks">
            {{ $tipoDenuncias->links() }}
        </div>
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
   .tipoDenunciaLinks svg{
        max-width:40px;
   }
</style>
@endsection

@section('javascript')


<script>

    
</script>
@endsection