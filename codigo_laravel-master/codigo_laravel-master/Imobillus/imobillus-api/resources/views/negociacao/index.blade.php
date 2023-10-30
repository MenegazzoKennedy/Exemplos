@extends('layouts.app', ["titulo" => "Mais Code Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Negociações</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Negociações</li>
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
                <div class="card-body">
                    <div class="mx-auto pull-right">
                        <div class="">
                            <form action="{{ route('dashboard.negociacao.index') }}" method="GET" role="search">
                                <div class="input-group">
                                    <a href="{{ route('dashboard.negociacao.index') }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" title="Refresh page">
                                                <span class="fas fa-sync-alt"></span>
                                            </button>
                                        </span>
                                    </a>
                                    <input type="text" class="form-control" name="term" placeholder="Search  dashboard.negociacao" id="term">
                                    
                                    <div class="form-group">                                            
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option value="cliente">Cliente</option>
                                            <option value="imovel">Imóvel</option>
                                            <option value="corretor">Corretor</option>
                                        </select>
                                    </div>
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="submit" title="Search">
                                            <span class="fas fa-search"></span>
                                        </button>
                                    </span>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col" style="max-width: 250px !important;">Cliente</th>
                                <th scope="col" style="max-width: 250px !important;">Imóvel</th>
                                <th scope="col" style="max-width: 250px !important;">Corretor</th>
                                <th scope="col">Status</th>
                                <th scope="col"><div class="text-right"> Ação </div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($negociacao as $documento)
                            
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
                                    <form action="{{ route('dashboard.negociacao.destroy', $documento->id) }}" method="POST"  method="POST" class="lancamento_form_{{$documento->id}}">
                                        @csrf
                                        {{ method_field('DELETE') }}


                                        <a href="{{ route('dashboard.negociacao.show', $documento->id) }}" class="btn waves-effect waves-light btn-rounded btn-outline-info">Ver Documentos</a>
                                        

                                        
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
            {{ $negociacao->links() }}
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