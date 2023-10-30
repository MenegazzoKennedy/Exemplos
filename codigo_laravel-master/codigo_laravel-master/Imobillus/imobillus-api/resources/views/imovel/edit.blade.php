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
<script>
    function colocarCheck(indce, k){
        if(k == 1){
            document.querySelector('.midia_destaque'+indce).checked = true;
            document.querySelector('.midia_destaque'+indce).val = 1;
        }else{
            document.querySelector('.midia_destaque'+indce).val = 0;

        }
    }
</script>
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
                        <input type="text" class="form-control" placeholder="1" aria-label="Username" aria-describedby="basic-addon1" name="titulo" onkeyup ="apresentarSlug()" value="{{ $produto->titulo }}">
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
                        <input type="text" class="form-control" placeholder="Slug" aria-label="Username" aria-describedby="basic-addon1" onkeyup ="apresentarSlug()" id="slugUrl" name="slug" value="{{ $produto->slug }}">
                    </div>   
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Valor R$</span>
                        </div>
                        <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" onkeyup="editarMoeda()" aria-describedby="basic-addon1" id="valorImovel" name="valorProduto" value="{{ $produto->valor }}">
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
                        <textarea name="detalhe" placeholder="1" class="form-control @error('detalhe') is-invalid @enderror" value="{{ $produto->detalhes }}" style="min-height: 37px;">{{ $produto->detalhes }}</textarea>
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
                            <span class="input-group-text">Estado</span>
                        </div>
                        <select class="custom-select @error('fonte') is-invalid @enderror" id="estadoId" name="estado" onchange="trazerCidades()">
                            <option value="pular" selected>Selecione</option>
                            @foreach ($estados as $key => $estado)
                                @if($estado->id == $estado_id)
                                    <option value="{{$estado->id}}" selected>{{$estado->name}}</option>
                                @else
                                    <option value="{{$estado->id}}">{{$estado->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cidade</span>
                        </div>
                        <select class="custom-select @error('fonte') is-invalid @enderror" id="inputCidade" name="cidade" onchange="trazerBairros()">
                            <option value="pular">Selecione</option>
                            @foreach ($cidades as $key => $cidade)
                                @if($cidade->id == $cidade_id)
                                    <option value="{{$cidade->id}}" selected>{{$cidade->name}}</option>
                                @else
                                    <option value="{{$cidade->id}}">{{$cidade->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>  
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Bairro</span>
                        </div>
                        <select class="custom-select @error('bairro') is-invalid @enderror" id="inputBairro" name="bairro" value="{{ old('bairro') }}">
                            <option value="pular">Selecione</option>
                            @foreach ($bairros as $key => $bairro)
                                @if($bairro->id == $bairro_id)
                                    <option value="{{$bairro->id}}" selected>{{$bairro->name}}</option>
                                @else
                                    <option value="{{$bairro->id}}">{{$bairro->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>  
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Logradouro</span>
                        </div>
                        <input type="text" class="form-control @error('logradouro') is-invalid @enderror" placeholder="Rua do Jacintos" aria-label="Username" aria-describedby="basic-addon1" name="logradouro" value="{{$produto->logradouro}}">
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
                        <input type="number" class="form-control @error('numero') is-invalid @enderror" placeholder="670" aria-label="Username" aria-describedby="basic-addon1" name="numero" value="{{ $produto->numero }}">
                        @error('numero')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">CEP</span>
                        </div>
                        <input type="tell" class="form-control @error('numero') is-invalid @enderror" placeholder="00000-000" aria-label="Username" aria-describedby="basic-addon1" id="cepImovel" name="cep" value="{{ $produto->cep }}" onkeyup="editarCep()" maxlength="9">
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
                            <?php $i = 0; ?>
                            <?php $destaqe = []; ?>

                            @foreach ($midias as $midia)
                                <tr>
                                    <input name="midiasCadastradas[{{$i}}]" value="{{$midia->url_midia}}" class="d-none midiasCadastradas[{{$i}}]">
                                    <td>
                                        <div class="form-group">
                                            <label for="exampleInputFile{{$i}}">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="text" name='idMidia[{{$i}}]' class="idMidia d-none" value="{{$midia->id}}">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile{{$i}}" name="inpuMidias[{{$i}}]" onchange="renoear({{$i}}, 2, 1)">
                                                    <label id="label{{$i}}" class="custom-file-label" for="exampleInputFile{{$i}}">{{$midia->url_midia}}</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="selectDestaque selectDestaque{{$i}} form-check-input midia_destaque midia_destaque{{$i}}" type="checkbox" name="midia_destaque[{{$i}}]" onchange="trocar({{$i}})" value="1" onclick="manterUnicoSelect({{$i}})">
                                            <?php
                                                echo "<script>colocarCheck(".$i.",".$midia->is_destaque.")</script>"; 
                                            ?>
                                            <label class="form-check-label" for="flexCheckDefault" >Destaque</label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" name="remove_Midia" value="{{$i}}" class="btn btn-danger remove_Midia">Remover</button>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                        <tr id="add_Midiatr">
                            <td width="0%"></td>
                            <td width="0%"></td>
                            <td>
                                <button type="button" name="add_Midia" id="add_Midia" class="btn btn-success">Adicionar</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12">
                    <h2>Caracteristicas</h2>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped" id="caracteristicas_form">
                        @if (isset($caracteristicaTable[0]))
                            <?php $i = 1; ?>
                            @foreach ($caracteristicaTable as $caracteristica)
                                @if($caracteristica->descricao  == "AreaUtil")
                                    <thead class="caracteristica">
                                        <tr>
                                            <td width="10%">Descrição</td><td width="90%">
                                                <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outroAppend({{$i}})">
                                                    <?php $caracEncontrada = false; ?>
                                                    @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                        @if($caracteristicaEnum =="AreaUtil")
                                                            <option selected value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @else
                                                            <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="Outro">Outro</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="d-none" id="descricaoinput{{$i}}">
                                            <td width="10%">Outra Descrição</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                            </td>
                                        </tr>
                                        <tr class="valorCaracteristicasclass">
                                            <td width="10%">Valor em M<sup>2</sup></td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                            </td>
                                        </tr>
                                        <tr class="d-none quantidade">
                                            <td width="10%">Quantidade</td>
                                            <td width="90%">
                                                <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                value="{{$caracteristica->quantidade}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">Ação</td>
                                            <td width="90%">
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>                                         
                                            </td>
                                        </tr>
                                    </thead>
                                @elseif($caracteristica->descricao  == "latitude" || $caracteristica->descricao  == "longitude")
                                    <thead class="caracteristica">
                                        <tr>
                                            <td width="10%">Descrição</td><td width="90%">
                                                <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outroAppend({{$i}})">
                                                    <?php $caracEncontrada = false; ?>
                                                    @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                        @if($caracteristicaEnum == $caracteristica->descricao)
                                                            <option selected value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @else
                                                            <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="Outro">Outro</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="d-none" id="descricaoinput{{$i}}">
                                            <td width="10%">Outra Descrição</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                            </td>
                                        </tr>
                                        <tr class="valorCaracteristicasclass">
                                            <td width="10%">Valor</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                            </td>
                                        </tr>
                                        <tr class="d-none quantidade">
                                            <td width="10%">Quantidade</td>
                                            <td width="90%">
                                                <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                value="{{$caracteristica->quantidade}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">Ação</td>
                                            <td width="90%">
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>                                         
                                            </td>
                                        </tr>
                                    </thead>
                                @elseif($caracteristica->descricao  == "Youtube" || $caracteristica->descricao  == "Tour360")
                                    <thead class="caracteristica">
                                        <tr>
                                            <td width="10%">Descrição</td><td width="90%">
                                                <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outroAppend({{$i}})">
                                                    <?php $caracEncontrada = false; ?>
                                                    @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                        @if($caracteristicaEnum == $caracteristica->descricao)
                                                            <option selected value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @else
                                                            <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="Outro">Outro</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="d-none" id="descricaoinput{{$i}}">
                                            <td width="10%">Outra Descrição</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                            </td>
                                        </tr>
                                        <tr class="valorCaracteristicasclass">
                                            <td width="10%">@if($caracteristica->descricao  == "Youtube") Link do video @elseif($caracteristica->descricao  == "Tour360") Link do Tour 360 @endif</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                            </td>
                                        </tr>
                                        <tr class="d-none quantidade">
                                            <td width="10%">Quantidade</td>
                                            <td width="90%">
                                                <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                value="{{$caracteristica->quantidade}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">Ação</td>
                                            <td width="90%">
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>                                         
                                            </td>
                                        </tr>
                                    </thead>
                                @elseif($caracteristica->descricao  == "Banheiros" || $caracteristica->descricao  == "Garagem" || $caracteristica->descricao  == "Lavanderia" || $caracteristica->descricao  == "Suíte" || $caracteristica->descricao  == "Quartos" || $caracteristica->descricao  == "Unidades" )
                                    <thead class="caracteristica">
                                        <tr>
                                            <td width="10%">Descrição</td>
                                            <td width="90%">
                                                <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outroAppend({{$i}})">
                                                    <?php $caracEncontrada = false; ?>
                                                    @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                        @if($caracteristicaEnum == $caracteristica->descricao)
                                                            <option selected value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @else
                                                            <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                        @endif
                                                    @endforeach
                                                    <option value="Outro">Outro</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="d-none" id="descricaoinput{{$i}}">
                                            <td width="10%">Outra Descrição</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                            </td>
                                        </tr>
                                        <tr class="d-none valorCaracteristicasclass">
                                            <td width="10%">Valor</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                            </td>
                                        </tr>
                                        @if($caracteristica->descricao  == "Garagem")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de vagas</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @elseif($caracteristica->descricao  == "Banheiros")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de banheiros</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @elseif($caracteristica->descricao  == "Lavanderia")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de lavanderias</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @elseif($caracteristica->descricao  == "Suíte")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de suites</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @elseif($caracteristica->descricao  == "Quartos")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de quartos</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @elseif($caracteristica->descricao  == "Unidades")
                                            <tr class="quantidade">
                                                <td width="10%">Quantidade de unidades</td>
                                                <td width="90%">
                                                    <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                    value="{{$caracteristica->quantidade}}">
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td width="10%">Ação</td>
                                            <td width="90%">
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>                                         
                                            </td>
                                        </tr>
                                    </thead>
                                    
                                @else
                                    <thead class="caracteristica">
                                        <tr>
                                            <td width="10%">Descrição</td><td width="90%">
                                                <select class="custom-select" id="inputDescricao{{$i}}" name="descricaoCaracteristica[{{$i}}]" onchange="outroAppend({{$i}})">
                                                    <?php $caracEncontrada = false; ?>
                                                    @foreach ($caracteristicasEnum as $caracteristicaEnum)
                                                        <option value="{{$caracteristicaEnum}}">{{$caracteristicaEnum}}</option>
                                                    @endforeach
                                                        <option selected value="Outro">Outro</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="descricaoinput{{$i}}">
                                            <td width="10%">Outra Descrição</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1" id="inputDescricao2{{$i}}" name="descricaoCaracteristica2[{{$i}}]" @if(!$caracEncontrada) value="{{$caracteristica->descricao}}" @endif>
                                            </td>
                                        </tr>
                                        <tr class="valorCaracteristicasclass">
                                            <td width="10%">Valor</td>
                                            <td width="90%">
                                                <input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica[{{$i}}]" value="{{$caracteristica->valor}}">
                                            </td>
                                        </tr>
                                        <tr class="quantidade">
                                            <td width="10%">Quantidade</td>
                                            <td width="90%">
                                                <input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade[{{$i}}]"
                                                value="{{$caracteristica->quantidade}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="10%">Ação</td>
                                            <td width="90%">
                                                <button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button>                                         
                                            </td>
                                        </tr>
                                    </thead>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        @endif
                        <tr id="add_Caracteristicatr">
                            <td width="0%"></td>
                            <td width="100%">
                                <button type="button" name="add_Caracteristica" class="btn btn-success" id="add_Caracteristica">Adicionar</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 d-grid">
                    <button onclick="submeterForm()" type="button" class="btn btn-dark btnCadastrar">Atualizar</button>
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
        #add_Caracteristicatr td:first-child, #add_Midiatr td:first-child{
            border-right: none !important;
        }
        #add_Caracteristicatr td:nth-child(2), #add_Midiatr td:nth-child(2){
            border-left: none !important;
        }
        #add_Caracteristicatr td:nth-child(2) button, #add_Midiatr td:nth-child(2) button{
            float: right !important;
        }
    </style>
    @endsection
@section('javascript')
<script>
    arrayTipos = [];
</script>
@foreach ($caracteristicasEnum as $key => $fonte)
    <script>
        arrayTipos[{{$key}}] = '{{$fonte}}'
    </script>
@endforeach
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
    function manterUnicoSelect(numero){
        let selects = document.querySelectorAll('.selectDestaque');
        let i;
        let estado;
        if(document.querySelector('.selectDestaque'+numero).checked){
            estado=true;
        }else{
            estado=false;
        }
        for(i = 0; i < selects.length; i++){
            selects[i].checked = false;
        }
        document.querySelector('.selectDestaque'+numero).checked = estado;
    }
    let inputMidiaModificado = "";
    let inputMidiaCadastrada = "";
    let quantidadeCont = '<input name="quantidadeCont" value="{{$i}}" class="d-none">';
    
    function apresentarSlug(){
        let texto = event.target.value;
        let textoRefeiro = texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^\w\-]+/g, '-').toLowerCase();
        $('#slugUrl').val(textoRefeiro);
    }
    function editarMoeda(){
        let texto = $('#valorImovel').val();
        texto = texto.replace(/\D/g, "");
        let newTexto = "";
        quant = texto.length;
        entrar = true;
        
        for (var member in texto) {
            if(quant-member == 2){
                newTexto = newTexto.concat("."+texto[member]);
            }else{
                newTexto = newTexto.concat(texto[member]);
            }
        }
        var numero = parseFloat(newTexto).toFixed(2).split('.');
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
        document.getElementById('valorImovel').value = numero.join(',');
    }
    
    function trocar(event){
        if ($('.midia_destaque'+event).prop("checked")) {
                $('.midia_destaque'+event).val(1);
        } else {
            $('.midia_destaque'+event).val(0);
        }
    }
    function renoear(posicao, i, l ){        
        if(i == 2){
            nome = $('#label'+posicao).text()
            inputMidiaModificado +='<input name="midiasCadastradasModicadas['+posicao+']" value="'+nome+'" class="d-none">';
        }
        if(l == 1){
            $('#label'+posicao).text($('#exampleInputFile'+posicao).val());
        }
    }
    function submeterForm(){
        let valorSubmit = document.getElementById('valorImovel').value;
        if(valorSubmit.length > 0){
            valorSubmit = valorSubmit.toString();
            valorSubmit = valorSubmit.replaceAll('.','');
            valorSubmit = valorSubmit.replaceAll(',','');
            document.getElementById('valorImovel').value = valorSubmit;
        }
        $('#midias_form').append(inputMidiaCadastrada);
        $('#midias_form').append(inputMidiaModificado);
        $('#midias_form').append(quantidadeCont);
        $('#editarForm').submit()
    }
    
    function outraDescricao(i){
        var descricao = $("#inputDescricao"+i).val() 
        if(descricao == "Outro"){
            $("#descricaoinput"+i).removeClass('d-none')
        }else{
            $("#descricaoinput"+i).addClass('d-none')
        }
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
            }else if(descricao == "Youtube" || descricao == "Tour360"){
                if(descricao == "Youtube"){
                    thead.find('.valorCaracteristicasclass').removeClass('d-none');
                    thead.find('.valorCaracteristicasclass').children('td').eq(0).html('Link do video');
                    thead.find('.quantidade').addClass('d-none');
                }else if(descricao == "Tour360"){
                    thead.find('.valorCaracteristicasclass').removeClass('d-none');
                    thead.find('.valorCaracteristicasclass').children('td').eq(0).html('Link do Tour 360');
                    thead.find('.quantidade').addClass('d-none');
                }
            }else if(descricao == "Banheiros" || descricao == "Garagem" || descricao == "Lavanderia" || descricao == "Suíte" || descricao == "Quartos" || descricao == "Unidades"){
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
                }else if(descricao == "Unidades"){
                    thead.find('.quantidade').children('td').eq(0).html('Quantidade de unidades');
                }
            }
        }
    }
    $(document).ready(function(){
        editarMoeda();
        //bloco repetidor midia
        var count_Midia = {{$i}};
        var midia_excluir = 0;

        function dynamic_field_Midias(number_Midia, midias ,destaque)
        {
            html_midia = '<tr>';
            html_midia += '<td><div class="form-group"><label for="exampleInputFile'+count_Midia+'">File input</label><div class="input-group"><div class="custom-file"><input type="file" class="custom-file-input" id="exampleInputFile'+count_Midia+'" name="inpuMidias['+count_Midia+']" onchange="renoear('+count_Midia+', 1, 1)"><label id="label'+count_Midia+'" class="custom-file-label" for="exampleInputFile'+count_Midia+'"></label></div><div class="input-group-append"><span class="input-group-text">Upload</span></div></div></div></td>';
            html_midia += '<td><div class="form-check"><input class="selectDestaque selectDestaque'+count_Midia+' form-check-input" type="checkbox" name="midia_destaque['+count_Midia+']" value="1" onclick="manterUnicoSelect('+count_Midia+')"><label class="form-check-label" for="flexCheckDefault">Destaque</label></div></td>';
            html_midia += '<td><button type="button" name="remove_Midia" value="'+count_Midia+'" class="btn btn-danger remove_Midia">Remover</button></td></tr>';
            $('#midias_form').append(html_midia);
        }

        $(document).on('click', '#add_Midia', function(){
            count_Midia++;
            dynamic_field_Midias(count_Midia);
        });

        $(document).on('click', '.remove_Midia', function(){
            count_Midia--;
            $(this).closest("tr").remove();
            valorMidiaremover = $(this).closest("tr").find('.idMidia').val()
            if(valorMidiaremover){
                html_retirado = '<input name="midiaRemovida['+midia_excluir+']" value="'+valorMidiaremover+'" class="d-none midiasCadastradas['+$(this).val()+']">';
                inputMidiaCadastrada = inputMidiaCadastrada+""+html_retirado;
                midia_excluir++;
            }
            
        });

        //fim bloco repetidor midia
        //bloco repetidor midia
        var count_Caracteristica = {{$i}};


        function dynamic_field_Caracteristicas(){      
            htmlCaracteristica = '<thead class="caracteristica"><tr><td width="10%">Descrição</td><td width="90%"><select class="custom-select" id="inputDescricao'+count_Caracteristica+'" name="descricaoCaracteristica['+count_Caracteristica+']" onchange="outroAppend('+count_Caracteristica+')">';
            arrayTipos.forEach(function(nome, i) {
                htmlCaracteristica += '<option value="'+nome+'">'+nome+'</option>';
            })
            htmlCaracteristica += '<option value="Outro">Outro</option></select></td></tr>';

            htmlCaracteristica += '<tr class="d-none" id="descricaoinput'+count_Caracteristica+'"><td width="10%">Outra Descrição</td><td width="90%"><input type="text" class="form-control" placeholder="Descrição" aria-label="Username" aria-describedby="basic-addon1"  name="descricaoCaracteristica2['+count_Caracteristica+']"></td></tr>';

            htmlCaracteristica += '</tr><tr class="valorCaracteristicasclass"><td width="10%">Valor em M<sup>2</sup></td><td width="90%"><input type="text" class="form-control" placeholder="50.000,00" aria-label="Username" aria-describedby="basic-addon1" id="valorCaracteristicas" name="valorCaracteristica['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr class="d-none quantidade"><td width="10%">Quantidade</td><td width="90%"><input type="number" class="form-control" placeholder="5" aria-label="Username" aria-describedby="basic-addon1" id="quantidadeCaracteristicas" name="quantidade['+count_Caracteristica+']"></td></tr>'

            htmlCaracteristica += '<tr class="d-none distanciaCaracteristicasclass"><td width="10%">É distancia?</td><td width="90%"><select class="custom-select" id="distanciaCaracteristicas" name="distanciaCaracteristicas['+count_Caracteristica+']"><option selected value="sim">Sim</option><option value="nao">Não</option></select></td></tr>'

            htmlCaracteristica += '<tr><td width="10%">Ação</td><td width="90%"><button type="button" name="remove_Caracteristica" class="btn btn-danger remove_Caracteristica">Remover</button></td></tr>'

            $('#add_Caracteristicatr').closest('tbody').before(htmlCaracteristica);
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
