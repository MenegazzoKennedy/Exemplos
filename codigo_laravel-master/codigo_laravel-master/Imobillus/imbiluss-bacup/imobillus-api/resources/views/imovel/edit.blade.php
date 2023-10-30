@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar Imóvel</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="" class="text-muted">Imóvel</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>        
    </div>
</div>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('dashboard.produtos.update', ['produto' => $produto->id]) }}" method="POST" id="editarForm"  enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            <div class="row cadastro">
                <div class="col-8">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Título</span>
                        </div>
                        <input type="text" class="form-control" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="titulo" value="{{ $produto->titulo }}">
                    </div>        
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Descrição</span>
                        </div>
                        <textarea class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1" name="descricao" style="min-height: 37px;">{{ $produto->descricao }}</textarea>
                    </div>   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <label class="input-group-text labelSelect" for="inputGroupDestaque1">Destaque</label>
                        </div>
                        <select class="custom-select" id="inputGroupDestaque1" name="destaque">
                        <option>Selecione</option>
                        @if($produto->destaque == 1){
                            <option selected value="1">Sim</option>
                            <option value="0">Não</option>
                        @elseif($produto->destaque == 0){
                            <option value="1">Sim</option>
                            <option selected value="0">Não</option>
                        @else
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        @endif
                        </select>
                    </div> 
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Slug</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1" name="slug" value="{{ $produto->slug }}">
                    </div>   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor R$</span>
                        </div>
                        <input type="number" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" name="valorProduto" value="{{ $produto->valor }}">
                    </div>   
    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tipo</span>
                        </div>
                        <input type="text" class="form-control" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="tipo" value="{{ $produto->tipo }}">
                    </div>    
    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <label class="input-group-text labelSelect" for="inputGroupDestaque2">Fonte</label>
                        </div>
                        <select class="custom-select" id="inputFonte" name="fonte">
                            <option>Selecione</option>
                            @foreach ($fontes as $key => $fonte)
                                @if($produto->fonte == $key)
                                    <option selected value="{{$key}}">{{$fonte}}</option>
                                @else
                                    <option value="{{$key}}">{{$fonte}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>  
    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Detalhes</span>
                        </div>
                        <input type="text" class="form-control" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="detalhe" value="{{ $produto->detalhes }}">
                    </div>  
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Status</span>
                        </div>
                        <select class="custom-select" id="inputGroupDestaque2" name="status">
                            <option>Selecione</option>
                            @if($produto->status == 1){
                                <option selected value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            @elseif($produto->status == 0){
                                <option value="1">Ativo</option>
                                <option selected value="0">Inativo</option>
                            @else
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            @endif
                        </select>
                    </div> 
                    <div class="col-5">
                        <h2>Endereço</h2>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Bairro</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Central" aria-label="Username" aria-describedby="basic-addon1" name="bairro" value="{{ $produto->bairro }}">
                    </div>  
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Logradouro</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Rua do Jacintos" aria-label="Username" aria-describedby="basic-addon1" name="logradouro" value="{{ $produto->logradouro }}">
                    </div>    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Numero</span>
                        </div>
                        <input type="number" class="form-control" placeholder="670" aria-label="Username" aria-describedby="basic-addon1" name="numero" value="{{ $produto->numero }}">
                    </div>  
                </div>   
                <div class="col-4 colSlecao">
                    <div class="tiposProdutoArea">
                        <span class="input-group-text">Tipos</span>
                        <div id="tiposProdutos">
                            <?php $contenTipo = json_decode($contenTipo, true);
                                $tiposComtem = [];
                                $i = 0;
                                foreach ($contenTipo as $key => $tipoContem) {
                                    $tiposComtem[] = $tipoContem['tipo_id'];
                                    $i++;
                                };
                            ?>
                            @foreach ($tipos as $tipo)
                                <div class="form-check">
                                    
                                    @if(in_array($tipo->id,$tiposComtem))
                                        <input checked class="form-check-input" type="checkbox" name="tipos[]" value="{{$tipo->id}}">
                                    @else
                                        <input class="form-check-input" type="checkbox" name="tipos[]" value="{{$tipo->id}}">
                                    @endif
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
                            <?php $i = 2; ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="exampleInputFile1">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile1" name="inpuMidias[1]" onchange="renoear(1, 1)">
                                                <label id="label1" class="custom-file-label" for="exampleInputFile1" ></label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="midia_destaque[1]" value="1">
                                        <label class="form-check-label" for="flexCheckDefault">Destaque</label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" name="add_Midia" id="add_Midia" class="btn btn-success">Adicionar</button>
                                </td>
                            </tr>
                            @foreach ($midias as $midia)
                                <input name="midiasCadastradas[$i]" value="{{$midia->url_midia}}" class="d-none">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="exampleInputFile{{$i}}">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile{{$i}}" name="inpuMidias[{{$i}}]" onchange="renoear({{$i}}, 1)">
                                                    <label id="label{{$i}}" class="custom-file-label" for="exampleInputFile{{$i}}" >{{$midia->url_midia}}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            @if($midia->is_destaque == 1)
                                                <input class="form-check-input" type="checkbox" name="midia_destaque[{{$i}}]" value="1" checked>
                                            @else
                                                <input class="form-check-input" type="checkbox" name="midia_destaque[{{$i}}]" value="1">
                                            @endif
                                            <label class="form-check-label" for="flexCheckDefault">Destaque</label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" name="remove_Midia" id="" class="btn btn-danger remove_Midia">Remover</button>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h2>Caracteristicas</h2>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped" id="caracteristicas_form">
                        @if (!isset($caracteristicaTable[0]))
                            <thead>
                                <tr>
                                    <td width="10%">Descrição</td><td width="90%">
                                        <select class="custom-select" id="inputDescricao1" name="descricaoCaracteristica[1]" onchange="outraDescricao(1)">
                                            @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                    <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                            @endforeach
                                            <option value="Outro">Outro</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="d-none" id="descricaoinput1">
                                    <td width="10%">Outra Descrição</td>
                                    <td width="90%">
                                        <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao21" name="descricaoCaracteristica2[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Ícone</td>
                                    <td width="90%">
                                        <input type="text" class="form-control" placeholder="area_util" aria-label="Username" aria-describedby="basic-addon1" id="valorIcone" name="iconeCaracteristica[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Valor R$</td>
                                    <td width="90%">
                                        <input type="number" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Quantidade</td>
                                    <td width="90%">
                                        <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[1]">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">É distancia?</td>
                                    <td width="90%">
                                        <select class="custom-select" id="distanciaCaracteristicas" name="distanciaCaracteristicas[1]">
                                                <option selected value="sim">Sim</option>
                                                <option value="nao">Não</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Ação</td>
                                    <td width="90%">
                                        <button type="button" name="add_Caracteristica" class="btn btn-success" id="add_Caracteristica">Adicionar</button>
                                    </td>
                                </tr>
                            </thead>
                        @else
                            <?php $i = 1; ?>
                            @foreach ($caracteristicaTable as $caracteristica)
                                <thead>
                                    <tr>
                                        <td width="10%">Descrição</td><td width="90%">
                                            <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outraDescricao({{$i}})">
                                                <?php $caracEncontrada = false; ?>
                                                @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                    @if($caracteristicaEnum == $caracteristica->descricao)
                                                        <option selected value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        <?php $caracEncontrada = true; ?>
                                                    @else
                                                        <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                    @endif
                                                @endforeach
                                                @if($caracEncontrada)
                                                    <option value="Outro">Outro</option>
                                                @else
                                                    <option selected value="Outro">Outro</option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    @if(!$caracEncontrada)
                                        <tr id="descricaoinput{{$i}}">
                                    @else
                                        <tr class="d-none" id="descricaoinput{{$i}}">
                                    @endif
                                        <td width="10%">Outra Descrição</td>
                                        <td width="90%">
                                            <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="10%">Ícone</td>
                                        <td width="90%">
                                            <input type="text" class="form-control" placeholder="area_util" aria-label="Username" aria-describedby="basic-addon1" id="valorIcone" name="iconeCaracteristica[{{$i}}]" value="{{$caracteristica->icone}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Valor R$</td>
                                        <td width="90%">
                                            <input type="number" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Quantidade</td>
                                        <td width="90%">
                                            <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                            value="{{$caracteristica->quantidade}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">É distancia?</td>
                                        <td width="90%">
                                            <select class="custom-select" id="distanciaCaracteristicas" name="distanciaCaracteristicas[{{$i}}]">
                                                @if($caracteristica->is_coord == 1)
                                                    <option selected value="sim">Sim</option>
                                                    <option value="nao">Não</option>
                                                @else
                                                    <option value="sim">Sim</option>
                                                    <option selected value="nao">Não</option>
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Ação</td>
                                        <td width="90%">
                                            @if ($i > 1)   
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>
                                            @else
                                                <button type="button" name="add_Caracteristica" class="btn btn-success" id="add_Caracteristica">Adicionar</button>
                                            @endif                                            
                                        </td>
                                    </tr>
                                </thead>
                                <?php $i++; ?>
                            @endforeach
                        @endif
                    </table>
                </div>
                <div class="col-12 d-grid">
                    <button onclick="submeterForm()" type="button" class="btn btn-dark btnCadastrar">Cadastrar</button>
                    <button type="button" class="btn btn-primary btnCadastrar mr-2 d-none" onclick="adionarCaracteristica()">Adicionar Caracteristica</button>
                </div>
            </div>
        </form>                
    </div>
    <style>
        .input-group-text {
            min-width: 100px;
        }
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
            height: 85%;
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
    
    </style>
    @endsection
@section('javascript')
<script>
    arrayUrl = [];
    arrayDestauqe = [];
</script>
@foreach ($midias as $key => $fonte)
    <script>
        arrayUrl[{{$key}}] = '{{$fonte->url_midia}}'
        arrayDestauqe[{{$key}}] = '{{$fonte->is_destaque}}'
    </script>
@endforeach
<script>
    arrayCaracteristicas = [];
</script>
@foreach ($caracteristicasEnum as $key => $fonte)
    <script>
        arrayCaracteristicas[{{$key}}] = '{{$fonte}}'
    </script>
@endforeach

<script>
    let inputMidiaModificado = "";
    let inputMidiaCadastrada = "";
    let quantidadeCont = '<input name="quantidadeCont" value="{{$i}}" class="d-none">';
    function renoear(posicao, i){
        if(i == 2){
            nome = $('#label'+posicao).text()
            inputMidiaModificado +='<input name="midiasCadastradasModicadas['+posicao+']" value="'+nome+'" class="d-none">';
        }
        $('#label'+posicao).text($('#exampleInputFile'+posicao).val());
    }
    function submeterForm(){
        $('#midias_form').append(inputMidiaCadastrada);
        $('#midias_form').append(inputMidiaModificado);
        $('#midias_form').append(quantidadeCont);
        $('#editarForm').submit()
    }
    
    function outraDescricao(i){
        console.log("descricaoinput"+i)
        var descricao = $("#inputDescricao"+i).val() 
        console.log(descricao)
        if(descricao == "Outro"){
            $("#descricaoinput"+i).removeClass('d-none')
        }else{
            $("#descricaoinput"+i).addClass('d-none')
        }
    }
    $(document).ready(function(){
        //bloco repetidor midia
        var count_Midia = {{$i}};

        function dynamic_field_Midias(number_Midia, midias ,destaque)
        {
            html_midia = '<tr>';
            html_midia += '<td><div class="form-group"><label for="exampleInputFile'+count_Midia+'">File input</label><div class="input-group"><div class="custom-file"><input type="file" class="custom-file-input" id="exampleInputFile'+count_Midia+'" name="inpuMidias['+count_Midia+']" onchange="renoear('+count_Midia+', 1)"><label id="label'+count_Midia+'" class="custom-file-label" for="exampleInputFile'+count_Midia+'"></label></div><div class="input-group-append"><span class="input-group-text">Upload</span></div></div></div></td>';
            html_midia += '<td><div class="form-check"><input class="form-check-input" type="checkbox" name="midia_destaque['+count_Midia+']" value="1"><label class="form-check-label" for="flexCheckDefault">Destaque</label></div></td>';
            html_midia += '<td><button type="button" name="remove_Midia" id="" class="btn btn-danger remove_Midia">Remover</button></td></tr>';
            $('#midias_form').append(html_midia);
        }

        $(document).on('click', '#add_Midia', function(){
            count_Midia++;
            dynamic_field_Midias(count_Midia);
        });

        $(document).on('click', '.remove_Midia', function(){
            count_Midia--;
            valorMidiaremover = $(this).closest("tr").find('.custom-file-label').text()
            console.log(valorMidiaremover);
            console.log(inputMidiaCadastrada);
            html_retirado = '<input name="midiasCadastradas['+$(this).val()+']" value="'+valorMidiaremover+'" class="d-none">'
            inputMidiaCadastrada = inputMidiaCadastrada.replace(html_retirado, "")
            console.log(inputMidiaCadastrada);
            console.log($(this).val());
            $(this).closest("tr").remove();
        });

        //fim bloco repetidor midia
        //bloco repetidor midia
        var count_Caracteristica = {{$i}};


        function dynamic_field_Caracteristicas(){      
            htmlCaracteristica = '<thead><tr><td width="10%">Descrição</td><td width="90%"><select class="custom-select" id="inputDescricao'+count_Caracteristica+'" name="descricaoCaracteristica['+count_Caracteristica+']" onchange="outraDescricao('+count_Caracteristica+')">';
            arrayCaracteristicas.forEach(function(nome, i) {
                htmlCaracteristica += '<option value="'+nome+'">'+nome+'</option>';
            })
            htmlCaracteristica += '<option value="Outro">Outro</option></select></td></tr>'
            
            htmlCaracteristica += '<tr class="d-none" id="descricaoinput'+count_Caracteristica+'"><td width="10%">Outra Descrição</td><td width="90%"><input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao'+count_Caracteristica+'" name="descricaoCaracteristica['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">Ícone</td><td width="90%"><input type="text" class="form-control" placeholder="area_util" aria-label="Username" aria-describedby="basic-addon1" id="valorIcone" name="iconeCaracteristica['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">Valor R$</td><td width="90%"><input type="number" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">Quantidade</td><td width="90%"><input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">É distancia?</td><td width="90%"><select class="custom-select" id="distanciaCaracteristicas" name="distanciaCaracteristicas['+count_Caracteristica+']"><option selected value="sim">Sim</option><option value="nao">Não</option></select></td></tr>'
            
            htmlCaracteristica += '<tr><td width="10%">Ação</td><td width="90%"><button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button></td></tr></thead>'                

            $('#caracteristicas_form').append(htmlCaracteristica);
        }

        $(document).on('click', '#add_Caracteristica', function(){
            count_Caracteristica++;
            quantidadeCont = '<input name="quantidadeCont" value="'+count_Caracteristica+'" class="d-none">';
            dynamic_field_Caracteristicas(count_Caracteristica);
        });

        $(document).on('click', '.remove_Caracteristica', function(){
            count_Caracteristica--;
            quantidadeCont = '<input name="quantidadeCont" value="'+count_Caracteristica+'" class="d-none">';
            $(this).closest("thead").remove();
        });

        //fim bloco repetidor caracteristica
    });
</script>
@endsection
