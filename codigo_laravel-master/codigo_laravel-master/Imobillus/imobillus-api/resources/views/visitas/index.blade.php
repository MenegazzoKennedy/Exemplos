@extends('layouts.app', ["titulo" => "Mais Code Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Visitas</h1>
            {{$visitas}}
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Visítas</li>
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
                                <th scope="col">Data</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Corretor</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div style="margin-left: 30%;"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitas as $visita)
                            <tr>
                                <th>{{$visita->id }}</th>  
                                <td>{{$visita->data }}</td>
                                <td>@if(isset($visita->produto[0]['titulo'])) {{$visita->produto[0]['titulo'] }} @endif</td>
                                <td>@if(isset($visita->cliente[0]['user']['name'])) {{$visita->cliente[0]['user']['name'] }} @endif</td>
                                <td>@if(isset($visita->corretor[0]['users']['name'])) {{$visita->corretor[0]['users']['name'] }} @endif</td>
                                @if ($visita->status == 1)             
                                    <td>Ativo</td>  
                                @else  
                                    <td>Inativo</td> 
                                @endif
                                <td>
                                    @if (Auth::id() == 1)
                                    <div class="box_ctas btn-list text-right">
                                        <a href="{{ route('dashboard.visita.edit', $visita->id ) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>

                                        @if ($visita->status == 1)       
                                            <a href="{{ route('dashboard.visitaStatus', $visita->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-danger">Inativar</a>
                                        @else  
                                            <a href="{{ route('dashboard.visitaStatus', $visita->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-success">Ativar</a>
                                        @endif  
                                    </div> 
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            {{ $visitas->links() }}
        </div>
    </div>
</div>
<?php $visitas;?>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
</style>
@endsection

@section('javascript')
<style>
.items-center svg {
    overflow: hidden;
    vertical-align: middle;
    width: 22px;
}
</style>

<script>
    $(".lancamento-deletar").click(function(){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Você tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $('#overlay_site').show();
                var token = $('.lancamento_form_'+$(this).data('idusuario')+' input[name="_token"]').val();
                $('<form action="'+$(this).data('urldelete')+'" method="POST"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="_method" value="DELETE"></form>').appendTo('body').submit();                  
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                'Este usuário está seguro :)',
                'error'
                )                
            }
        });

    });
</script>
@endsection