@extends('layouts.app', ["titulo" => "MaisCode Usuários"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Olá, <?php echo $nome; ?></h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-7">
            <div class="card p-3 fonSize" style="height: 200px">
                <h2><strong style="text-transform: uppercase">Sua loja em números</strong></h2>  
                <h4>Ultimas 24hrs</h4>      
                <h3>EM CONSTRUÇÂO</h3>      
                <a href="">Ver todos os números -></a> 
            </div>
            <div class="card p-3 fonSize">
                <h2><strong style="text-transform: uppercase">Como Melhorar</strong></h2> 
                <h4>CATÁLOGO</h4>
                <h3>EM CONSTRUÇÂO</h3>
                <a href="">Ver produtos sem estoque -></a>        
            </div>
        </div>
        <div class="col-5">
            <div class="card p-3 fonSize">
                <h2><strong style="text-transform: uppercase">Status da plataforma</strong></h2>  
                <h3>EM CONSTRUÇÂO</h3>
                <a href="">Ver status detalhado -></a>        
            </div>
            <div class="card p-3 fonSize">
                <h2><strong style="text-transform: uppercase">Comunicados</strong></h2>      
                <h4>Últimas atualizações da Plataforma</h4>
                <h3>EM CONSTRUÇÂO</h3>
                <a href="">Ver mais comunicados -></a>    
            </div>
        </div>
        
    </div>
</div>

<style>
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
   }
   .fonSize{
       position: relative;
   }
   .fonSize h2{
       font-size: 1.5rem;
   }
   .fonSize h4{
       font-size: 0.8rem;
   }
   .fonSize h3{
       font-size: 1rem;
   }
   .fonSize a{
       position: absolute;
       bottom: 0;
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