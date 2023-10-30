@extends('layouts.app', ["titulo" => "MaisCode Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Imóveis</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Imóveis</li>
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
                                <th scope="col" style="max-width: 600px">Título</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div class="text-right"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                            
                            <tr>
                            <th scope="row">{{$produto->id }}</th>
                                <td  style="max-width: 600px">{{ $produto->titulo }}</td>
                                @if ($produto->status == 1)             
                                    <td>Ativo</td>  
                                @else  
                                    <td>Inativo</td> 
                                @endif
                                                                 
                                <td>
                                    @if (Auth::id() == 1)
                                    <div class="box_ctas btn-list text-right">
                                        <form action="{{ route('dashboard.produtos.destroy', $produto->id) }}" method="POST"  method="POST" class="lancamento_form_{{$produto->id}}">
                                            @csrf
                                            {{ method_field('DELETE') }}


                                            <a href="{{ route('dashboard.produtos.edit', $produto->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>

                                            

                                            <button type="submit" class="d-none btn waves-effect waves-light btn-rounded btn-outline-danger">Deletar Full</button>


                                            {{-- <span class="btn waves-effect waves-light btn-rounded btn-outline-danger lancamento-deletar" data-urldelete="{{ route('dashboard.categoria.destroy', $produto->id) }}" data-idusuario="{{$produto->id}}">Deletar</span> --}}

                                            @if ($produto->status == 1)       
                                                <a href="{{ route('dashboard.produtoStatus', [$produto->id]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-danger">Inativar</a>
                                            @else  
                                                <a href="{{ route('dashboard.produtoStatus', [$produto->id]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-success" style="padding: 6px 16.594px;">Ativar</a>
                                            @endif    
                                        </form>
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
        <div class="card col-12 d-block d-sm-block d-md-none users_admin text-center"> 
            <hr>           
            <div class="row">
            
            </div>
           
        </div>
        <div class="col-12">
            {{ $produtos->links() }}
        </div>
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
</style>
@endsection

@section('javascript')


<script>
    $(document).ready(function(){
        $('.w-5').css({'width':'25px'})
    })
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