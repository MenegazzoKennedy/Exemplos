@extends('layouts.app', ["titulo" => "Mais Code Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Documentos</h1>
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
                                <th scope="col" style="max-width: 250px !important;">Nome</th>
                                <th scope="col" style="max-width: 500px !important;">Caminho</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div class="text-right"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $documento)
                            
                            <tr>
                                <th>{{$documento->id }}</th>
                                <td style="max-width: 250px !important;">{{ $documento->descricao }}</td>
                                <td style="max-width: 500px !important;">{{ $documento->url_modelo }}</td>
                                @if ($documento->status == 1)             
                                    <td>Ativo</td>  
                                @else  
                                    <td>Inativo</td> 
                                @endif                         
                                <td>
                                <div class="box_ctas btn-list text-right">
                                    <form action="{{ route('dashboard.usuarios.destroy', $documento->id) }}" method="POST"  method="POST" class="lancamento_form_{{$documento->id}}">
                                        @csrf
                                        {{ method_field('DELETE') }}


                                        <a href="{{ route('dashboard.documento.edit', $documento->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>

                                        

                                        <button type="submit" class="d-none btn waves-effect waves-light btn-rounded btn-outline-danger">Deletar Full</button>


                                        {{-- <span class="btn waves-effect waves-light btn-rounded btn-outline-danger lancamento-deletar" data-urldelete="{{ route('dashboard.usuarios.destroy', $documento->id) }}" data-idusuario="{{$documento->id}}">Deletar</span> --}}

                                        @if ($documento->status == 1)       
                                            <a href="{{ route('dashboard.documentoStatus', [$documento->id, 0]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-danger">Inativar</a>
                                        @else  
                                            <a href="{{ route('dashboard.documentoStatus', [$documento->id, 1]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-success" style="padding: 6px 16.594px;">Ativar</a>
                                        @endif    
                                    </form>
                                </div> 
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            {{ $documentos->links() }}
        </div>
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }


.items-center svg {
    overflow: hidden;
    vertical-align: middle;
    width: 22px;
}
</style>

@endsection

@section('javascript')


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