@extends('layouts.app', ["titulo" => "MaisCode Usuários"])

@section('content-breadcrumb')


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Cadastrar Imóvel</h1>
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
    <form action="{{ route('dashboard.cadastrar-imovel') }}" method="post" id="cadastraForm" enctype="multipart/form-data">
        @csrf
        <div class="row cadastro">
            <div class="col-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Título</span>
                    </div>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="titulo" value="{{ old('titulo') }}">
                    @error('titulo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>        
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Descrição</span>
                    </div>
                    <input type="text" class="form-control @error('descricao') is-invalid @enderror" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" name="descricao" value="{{ old('descricao') }}">
                    @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>   
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <label class="input-group-text labelSelect" for="inputGroupDestaque1">Destaque</label>
                    </div>
                    <select class="custom-select @error('destaque') is-invalid @enderror" id="inputGroupDestaque1" name="destaque">                  
                    <option value="0" selected>Não</option>
                    <option value="1">Sim</option>
                    </select>
                    @error('destaque')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> 
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Url</span>
                    </div>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1" name="slug" value="{{ old('slug') }}">
                    @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>   
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Valor R$</span>
                    </div>
                    <input type="number" class="form-control @error('valorProduto') is-invalid @enderror" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" name="valorProduto" value="{{ old('valorProduto') }}">
                    @error('valorProduto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>    

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <label class="input-group-text labelSelect" for="inputGroupDestaque2">Fonte</label>
                    </div>
                    <select class="custom-select @error('fonte') is-invalid @enderror" id="inputDescricao" name="fonte">
                        <option selected>Selecione</option>
                        @foreach ($fontes as $key => $fonte)
                            <option value="{{$key}}">{{$fonte}}</option>
                        @endforeach
                    </select>
                    @error('fonte')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Detalhes</span>
                    </div>
                    <input type="text" class="form-control @error('detalhe') is-invalid @enderror" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="detalhe" value="{{ old('detalhe') }}">
                    @error('detalhe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  
                
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="custom-select" id="inputGroupDestaque2" name="status">
                        <option value="1" selected>Ativo</option>
                        <option value="0">Inativo</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> 
                <div class="col-5">
                    <h2>Endereço</h2>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Estado</span>
                    </div>
                    <select class="custom-select @error('fonte') is-invalid @enderror" id="estadoId" name="estado" onchange="trazerCidades()">
                        <option value="pular" selected>Selecione</option>
                        @foreach ($estados as $key => $estado)
                            <option value="{{$estado->id}}">{{$estado->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Cidade</span>
                    </div>
                    <select class="custom-select @error('fonte') is-invalid @enderror" id="inputCidade" name="cidade" onchange="trazerBairros()">
                        <option selected>Selecione</option>
                    </select>
                </div>  
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Bairro</span>
                    </div>
                    <select class="custom-select @error('bairro') is-invalid @enderror" id="inputBairro" name="bairro" value="{{ old('bairro') }}">
                        <option selected>Selecione</option>
                    </select>
                </div>  
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Logradouro</span>
                    </div>
                    <input type="text" class="form-control @error('logradouro') is-invalid @enderror" placeholder="Rua do Jacintos" aria-label="Username" aria-describedby="basic-addon1" name="logradouro" value="{{ old('logradouro') }}">
                    @error('logradouro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>    
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Numero</span>
                    </div>
                    <input type="number" class="form-control @error('numero') is-invalid @enderror" placeholder="670" aria-label="Username" aria-describedby="basic-addon1" name="numero" value="{{ old('numero') }}">
                    @error('numero')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>  
            </div>   
            <div class="col-4 colSlecao">
                <div class="tiposProdutoArea">
                    <span class="input-group-text">Tipos</span>
                    <div id="tiposProdutos">
                        @foreach ($tipos as $tipo)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipos[]" value="{{$tipo->id}}">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$tipo->descricao}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <h2>Mídias</h2>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">Foto</th>
                            <th width="40%"></th>
                            <th width="10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="midias_form">

                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <h2>Caracteristicas</h2>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-striped" id="caracteristicas_form">
                <tr id="add_Caracteristicatr">
                    <td width="0%"></td>
                    <td width="100%">
                        <button type="button" name="add_Caracteristica" class="btn btn-success" id="add_Caracteristica">Adicionar</button>
                    </td>
                </tr>
                </table>
            </div>

            
            <div class="col-12 d-grid">
                <button onclick="submeterForm()" type="button" class="btn btn-dark btnCadastrar">Cadastrar</button>
            </div>
        </div>
    </form>
</div>



<style>
    input[type='file'] {
        display: none
    }
    @media(max-width: 320px){
       .page-wrapper>.container-fluid {
           padding: 35px 10px;
       }
    }
    .labelSelect{
        font-weight: normal !important;
    }
    .tiposProdutoArea ,.caracteristicasProdutoArea{
        height: 100%;
    }
    .tiposProdutoArea .input-group-text, .caracteristicasProdutoArea .input-group-text{
        border-radius: 0.25rem 0.25rem 0 0;
    }
    .tiposProdutoArea #tiposProdutos,.caracteristicasProdutoArea #caracteristicasProdutos{
        padding: 0.375rem 0 0.75rem 0.75rem;
        background: white;
        border: 1px solid #ced4da;
        border-radius: 0 0 0.25rem 0.25rem;
        height: 94%;
        overflow: auto;
    }
    .tiposProdutoArea{
        padding-bottom: 5px;
    }
    .caracteristicasProdutoArea{
        padding-top: 5px;
    }
    /* .colSlecao{
        height: 460px;
    } */
    .btnCadastrar{
        font-size: larger;
        margin-bottom: 5px;
        float: right;
    }
    .lista-caracterisiticas .card-header{
        background: #e9ecef !important; 
        color: #495057 !important;
        padding: 6px 12px; 
        position: relative;
    }
    .lista-caracterisiticas .card-title{
        margin: 0; 
        font-size: 0.9rem; 
        position: absolute; 
        top: 25%;
    }
    .lista-caracterisiticas .fasIcone{
        color: #495057 !important;
    }
    .lista-caracterisiticas .card-body{
        display: none;  
        padding: 0px;
    }
    .lista-caracterisiticas .list-group{
        border: none;
    }
    .lista-caracterisiticas .input-group-text{
        width: 100px; 
        border-radius: 0;
        border-bottom: none;
    }
    .lista-caracterisiticas .form-control{
        border-radius: 0;
        border-bottom: none;
        background: #fff !important;
    }
    .lista-caracterisiticas .input-group-text-final{
        width: 100px;  
        border-radius: 0 0.25rem 0.25rem 0;
        border-bottom: none;
    }
    .lista-caracterisiticas .form-control-final{
        border-radius: 0 0.25rem 0.25rem 0;
        border-bottom: none;    
    }
    .lista-caracterisiticas .collapsed-card{
        margin: 0 !important;
    }

    #cadastraForm .cadastro .input-group-prepend{
        width: 15%;
    }

    #cadastraForm .cadastro .input-group-prepend .input-group-text, #cadastraForm .cadastro .input-group-prepend label.input-group-text.labelSelect{
        width: 100%;
    }
    #add_Caracteristicatr td:first-child{
        border-right: none !important;
    }
    #add_Caracteristicatr td:nth-child(2){
        border-left: none !important;
    }
    #add_Caracteristicatr td:nth-child(2) button{
        float: right !important;
    }
</style>
@endsection

@section('javascript')
<script>
    arrayTipos = [];
</script>
@foreach ($tiposEnum as $key => $fonte)
    <script>
        arrayTipos[{{$key}}] = '{{$fonte}}'
    </script>
@endforeach
<script>
    let quantidadeCont = '<input name="quantidadeCont" value="1" class="d-none">';
    function submeterForm(){
        $('#midias_form').append(quantidadeCont);
        $('#cadastraForm').submit()
    }
    function trazerCidades(){
        let id = $('#estadoId').val();
        if(id != 'pular'){
            // alert(id);
            $.ajax({
                url: '{{route("dashboard.imovel-estado")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    $('#inputCidade').empty();
                    $('#inputCidade').append($('<option>').val('pular').text('Selecione'));
                    $('#inputBairro').empty();
                    $('#inputBairro').append($('<option>').val('pular').text('Selecione'));
                    res_success[0]['cidades'].forEach(function(cidade, i) {
                        $('#inputCidade').append($('<option>').val(cidade.id).text(cidade.name));
                    })
                },
                error: function (result) {
                    //chega aqui se foi erro	
                    console.log(result);					
                }
			});
        }
    }
    function trazerBairros(){
        let id = $('#inputCidade').val();
        if(id != 'pular'){
            // alert(id);
            $.ajax({
                url: '{{route("dashboard.imovel-cidade")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    $('#inputBairro').empty();
                    $('#inputBairro').append($('<option>').val('pular').text('Selecione'));
                    res_success[0]['bairros'].forEach(function(bairro, i) {
                        $('#inputBairro').append($('<option>').val(bairro.id).text(bairro.name));
                    })
                    console.log(res_success[0]['bairros']);
                },
                error: function (result) {
                    //chega aqui se foi erro	
                    console.log(result);					
                }
			});
        }
    }
    function outroAppend(i){
        var descricao = $("#inputDescricao"+i).val();
        var thead = $("#inputDescricao"+i).closest('.caracteristica');
        if(descricao == "Outro"){
            $("#descricaoinput"+i).removeClass('d-none');
            thead.find('.valorCaracteristicasclass').removeClass('d-none');
            thead.find('.quantidade').removeClass('d-none');
            thead.find('.quantidade').children('td').eq(0).html('Quantidade');
            thead.find('.valorCaracteristicasclass').children('td').eq(0).html('Valor');
        }else{
            $("#descricaoinput"+i).addClass('d-none')
            if(descricao == "AreaUtil"){
                thead.find('.valorCaracteristicasclass').removeClass('d-none');
                thead.find('.quantidade').addClass('d-none');
                thead.find('.valorCaracteristicasclass').children('td').eq(0).html('Valor em M<sup>2</sup>');
            }else if(descricao == "latitude" || descricao == "longitude"){
                thead.find('.valorCaracteristicasclass').removeClass('d-none');
                thead.find('.valorCaracteristicasclass').children('td').eq(0).html('Valor');
                thead.find('.quantidade').addClass('d-none');
            }else if(descricao == "Banheiros" || descricao == "Garagem" || descricao == "Lavanderia" || descricao == "Suíte" || descricao == "Quartos"){
                thead.find('.valorCaracteristicasclass').addClass('d-none');
                thead.find('.quantidade').removeClass('d-none');
                if(descricao == "Garagem"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de vagas');
                }else if(descricao == "Banheiros"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de banheiros');
                }else if(descricao == "Lavanderia"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de lavanderias');
                }else if(descricao == "Suíte"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de suites');
                }else if(descricao == "Quartos"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de quartos');
                }
            }
        }
    }
    function renoear(posicao){
        $('#label'+posicao).text($('#exampleInputFile'+posicao).val());
    }
    $(document).ready(function(){
        //bloco repetidor midia
        var count_Midia = 1;

        dynamic_field_Midias(count_Midia);

        function dynamic_field_Midias(number_Midia)
        {
            html_midia = '<tr>';
            html_midia += '<td><div class="form-group"><label for="exampleInputFile'+count_Midia+'">File input</label><div class="input-group"><div class="custom-file"><input type="file" class="custom-file-input" id="exampleInputFile'+count_Midia+'" name="inpuMidias['+count_Midia+']" onchange="renoear('+count_Midia+')"><label id="label'+count_Midia+'" class="custom-file-label" for="exampleInputFile'+count_Midia+'"></label></div><div class="input-group-append"><span class="input-group-text">Upload</span></div></div></div></td>';
            html_midia += '<td><div class="form-check"><input class="form-check-input" type="checkbox" name="midia_destaque['+count_Midia+']" value="1"><label class="form-check-label" for="flexCheckDefault">Destaque </label></div></td>';
            if(number_Midia > 1)
            {
                html_midia += '<td><button type="button" name="remove_Midia" id="" class="btn btn-danger remove_Midia">Remover</button></td></tr>';
                $('#midias_form').append(html_midia);
            }
            else
            {   
                html_midia += '<td><button type="button" name="add_Midia" id="add_Midia" class="btn btn-success">Adicionar</button></td></tr>';
                $('#midias_form').html(html_midia);
            }
        }

        $(document).on('click', '#add_Midia', function(){
            count_Midia++;
            dynamic_field_Midias(count_Midia);
        });

        $(document).on('click', '.remove_Midia', function(){
            count_Midia--;
            $(this).closest("tr").remove();
        });

        //fim bloco repetidor midia

        //bloco repetidor midia
        var count_Caracteristica = 1;

        dynamic_field_Caracteristicas(count_Caracteristica);
        
        function dynamic_field_Caracteristicas(){      
            htmlCaracteristica = '<thead class="caracteristica"><tr><td width="10%">Descrição</td><td width="90%"><select class="custom-select" id="inputDescricao'+count_Caracteristica+'" name="descricaoCaracteristica['+count_Caracteristica+']" onchange="outroAppend('+count_Caracteristica+')">';
            arrayTipos.forEach(function(nome, i) {
                console.log("Descrição"+nome);
                htmlCaracteristica += '<option value="'+nome+'">'+nome+'</option>';
            })
            htmlCaracteristica += '<option value="Outro">Outro</option></select></td></tr>';

            htmlCaracteristica += '<tr class="d-none" id="descricaoinput'+count_Caracteristica+'"><td width="10%">Outra Descrição</td><td width="90%"><input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao'+count_Caracteristica+'" name="descricaoCaracteristica2['+count_Caracteristica+']"></td></tr>';

            htmlCaracteristica += '</tr><tr class="valorCaracteristicasclass"><td width="10%">Valor em M<sup>3</sup></td><td width="90%"><input type="number" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr class="d-none quantidade"><td width="10%">Quantidade</td><td width="90%"><input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr class="d-none distanciaCaracteristicasclass"><td width="10%">É distancia?</td><td width="90%"><select class="custom-select" id="distanciaCaracteristicas" name="distanciaCaracteristicas['+count_Caracteristica+']"><option selected value="sim">Sim</option><option value="nao">Não</option></select></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">Ação</td><td width="90%"><button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button></td></tr>'

            $('#add_Caracteristicatr').closest('tbody').before(htmlCaracteristica);
        }

        $(document).on('click', '#add_Caracteristica', function(){
            count_Caracteristica++;
            quantidadeCont = '<input name="quantidadeCont" value="'+count_Caracteristica+'" class="d-none">'
            dynamic_field_Caracteristicas(count_Caracteristica);
        });

        $(document).on('click', '.remove_Caracteristica', function(){
            count_Caracteristica--;
            quantidadeCont = '<input name="quantidadeCont" value="'+count_Caracteristica+'" class="d-none">'
            $(this).closest("thead").remove();
        });

        //fim bloco repetidor caracteristica
    })

     $(document).ready(function(){
        $('.w-5').css({'width':'25px'})
        $('#inputDescricao').on('change', function() {
            if(this.value == "Outro"){
                $('#descricaoinput').removeClass('d-none')
            }else{
                $('#descricaoinput').addClass('d-none')
            }
        });
        var $input    = document.getElementById('fileIcone'),
        $fileName = document.getElementById('file-name');

        $input.addEventListener('change', function(){
        $fileName.textContent = this.value;
        });
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