@extends('layouts.app', ["titulo" => "MaisCode Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Tags</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="">Filtrar status...</option>
                    <option value="{{ route('dashboard.tags.index') }}/pendente">Pendente</option>
                    <option value="{{ route('dashboard.tags.index') }}/ativo">Ativo</option>
                    <option value="{{ route('dashboard.tags.index') }}/inativo">Inativo</option>
                  </select>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Tags</li>
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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Total Usuários</th>
                                <th scope="col">Total Post</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div class="text-right"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tagsApp)
                            
                            <tr>
                            <th scope="row">{{$tagsApp->id }}</th>
                                <td>{{ $tagsApp->tag }}</td>
                                <td>{{ $tagsApp->TotalUser }}</td>
                                <td>{{ $tagsApp->TotalPost }}</td>
                                @if ($tagsApp->status == 1)             
                                    <td class="text-primary">Pendente</td>  
                                @elseif ($tagsApp->status == 0)             
                                    <td class="text-success">Ativo</td>  
                                @else 
                                    <td class="text-danger">Inativo</td> 
                                @endif
                                                                 
                                <td>
                                    
                                    <div class="box_ctas btn-list text-right">
                                        <form action="{{ route('dashboard.tags.destroy', $tagsApp->id) }}" method="POST"  method="POST" class="lancamento_form_{{$tagsApp->id}}">
                                            @csrf
                                            {{ method_field('DELETE') }}


                                            <a href="{{ route('dashboard.tags.edit', $tagsApp->id) }}" class="d-none btn waves-effect waves-light btn-rounded btn-outline-info">Editar</a>

                                            

                                            <button type="submit" class="d-none btn waves-effect waves-light btn-rounded btn-outline-danger">Deletar Full</button>


                                            {{-- <span class="btn waves-effect waves-light btn-rounded btn-outline-danger lancamento-deletar" data-urldelete="{{ route('dashboard.tags.destroy', $tagsApp->id) }}" data-idusuario="{{$tagsApp->id}}">Deletar</span> --}}
                                            @if ($tagsApp->status == 1)
                                                <a href="{{ route('dashboard.tagStatus', [$tagsApp->id, -1]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-danger">Inativar</a>
                                                <a href="{{ route('dashboard.tagStatus', [$tagsApp->id, 0]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-success" style="padding: 6px 16.594px;">Ativar</a>
                                            @elseif ($tagsApp->status == 0)       
                                                <a href="{{ route('dashboard.tagStatus', [$tagsApp->id, -1]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-danger">Inativar</a>
                                            @else
                                                <a href="{{ route('dashboard.tagStatus', [$tagsApp->id, 0]) }}" class="btn waves-effect waves-light btn-rounded btn-outline-success" style="padding: 6px 16.594px;">Ativar</a>
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
        <div class="card col-12 d-block d-sm-block d-md-none users_admin text-center"> 
            <hr>           
            <div class="row">
            
            </div>
           
        </div>
        <div class="col-12 tagsLinks">
            {{ $tags->links() }}
        </div>
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
   .tagsLinks svg{
        max-width:40px;
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