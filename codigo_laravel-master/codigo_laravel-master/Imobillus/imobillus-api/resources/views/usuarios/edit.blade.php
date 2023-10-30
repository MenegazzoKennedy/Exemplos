@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Usuário</h1>
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
    <form action="{{ route('dashboard.usuarios.update', ['usuario' => $usuario->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}
        <div class="row cadastro">
            <div class="col-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Nome</span>
                    </div>
                    <input type="text" class="form-control" placeholder="nome" aria-label="Username" aria-describedby="basic-addon1" name="nome" value="{{ $usuario->name }}">
                </div>   
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">E-Mail</span>
                    </div>
                    <input type="text" class="form-control" placeholder="email" aria-label="Username" aria-describedby="basic-addon1" name="email" value="{{ $usuario->email }}">
                </div>
                <?php $entrar = false; ?>
                @foreach($usuario->roles as $roleUser)
                    @if($roleUser->name == "cliente")
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">CPF</span>
                            </div>
                            <input type="text" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="cpf"  @if(isset($usuario->clientes[0]->cpf)) value="{{ $usuario->clientes[0]->cpf }}" @endif>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de Nascimento</span>
                            </div>
                            <input type="date" class="form-control" placeholder="20/02/1979" aria-label="Username" aria-describedby="basic-addon1" name="nascimento"  @if(isset($usuario->clientes[0]->nascimento)) value="{{ $usuario->clientes[0]->nascimento }}" @endif >
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Telefone</span>
                            </div>
                            <input type="text" class="form-control" placeholder="(67) 99999-9999" aria-label="Username" aria-describedby="basic-addon1" name="telefone"  @if(isset($usuario->clientes[0]->telefone)) value="{{ $usuario->clientes[0]->telefone }}" @endif >
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Termos Servico</span>
                            </div>

                            <textarea name="termos_servico" placeholder="Termos Servico" class="form-control @error('detalhe') is-invalid @enderror"  @if(isset($usuario->clientes[0]->termos_servico)) value="{{ $usuario->clientes[0]->termos_servico }}" @endif style="min-height: 37px;"> @if(isset($usuario->clientes[0]->termos_servico)) {{ $usuario->clientes[0]->termos_servico }} @endif</textarea>
                        </div>
                       
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Corretoes</span>
                            </div>
                            <span class="custom-select @error('fonte') is-invalid @enderror" id="inputCorretoresCliente" name="corretores">
                                @if(isset($corretorPreferido)) {{ $usuario->corretorPreferido }} @endif
                            </span>
                        </div>        
                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Imagem Cliente</span>
                            </div>
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto1" name="fotoCliente" onchange="renoear(1)">
                                    <label class="custom-file-label" id="labelFoto1" for="foto1">@if(isset($usuario->clientes[0]->url_foto)) {{$usuario->clientes[0]->url_foto }} @endif</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                        </div>
                        <?php $entrar = true; ?>
                    @endif
                    @if($roleUser->name == "corretor")
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Creci</span>
                            </div>
                            <input type="text" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="creci"  @if(isset($usuario->corretores[0]->creci)) value="{{ $usuario->corretores[0]->creci }}" @endif>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Banco</span>
                            </div>
                            <input type="text" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="banco"  @if(isset($usuario->corretores[0]->banco)) value="{{ $usuario->corretores[0]->banco }}" @endif>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Agencia</span>
                            </div>
                            <input type="text" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="agencia"  @if(isset($usuario->corretores[0]->agencia)) value="{{ $usuario->corretores[0]->agencia }}" @endif>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tipo Conta</span>
                            </div>
                            <input type="number" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="tipo_conta"  @if(isset($usuario->corretores[0]->tipo_conta)) value="{{ $usuario->corretores[0]->tipo_conta }}" @endif>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Pix</span>
                            </div>
                            <input type="text" class="form-control" placeholder="000.000.000-00" aria-label="Username" aria-describedby="basic-addon1" name="pix"  @if(isset($usuario->corretores[0]->pix)) value="{{ $usuario->corretores[0]->pix }}" @endif>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Biografia</span>
                            </div>
                            <textarea name="biografia" placeholder="Biografia" class="form-control @error('detalhe') is-invalid @enderror"  @if(isset($usuario->corretores[0]->biografia)) value="{{ $usuario->corretores[0]->biografia }}" @endif style="min-height: 37px;"> @if(isset($usuario->corretores[0]->biografia)) {{ $usuario->corretores[0]->biografia }} @endif</textarea>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Estado</span>
                            </div>
                            <select class="custom-select @error('fonte') is-invalid @enderror" id="estadoId" name="estado[]" onchange="trazerCidades()">
                                <option value="pular" selected>Selecione</option>
                                @foreach ($estados as $key => $estado)
                                    <option value="{{$estado->id}}"
                                    @if(isset($idEstado))
                                        @if($key == $idEstado) 
                                            selected 
                                        @endif 
                                    @endif>{{$estado->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cidade</span>
                            </div>
                            <select class="custom-select @error('fonte') is-invalid @enderror" id="inputCidade" name="cidade" onchange="trazerBairros()">
                                <option value="pular" selected>Selecione</option>
                                @if(isset($cidades))
                                    @foreach ($cidades as $key => $cidade)
                                        <option value="{{$cidade->id}}"
                                        @if(isset($idCidade))
                                            @if($cidade->id == $idCidade) 
                                                selected 
                                            @endif 
                                        @endif>{{$cidade->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>  
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Bairro</span>
                            </div>
                            <select  class="custom-select @error('bairro') is-invalid @enderror chosen-select" id="inputBairro" name="bairro[]" value="{{ old('bairro') }}"  multiple>
                                <option>Selecione</option>
                                @if(isset($idCidade))
                                    @if(isset($cidades))
                                        @foreach($cidades as $cidade)
                                            @if($cidade['id'] == $idCidade)
                                                @foreach ($cidade['bairros'] as $key => $bairro)
                                                    <option value="{{$bairro->id}}"
                                                    @if(isset($usuario['corretores'][0]['bairros'][0]))
                                                        @foreach ($usuario['corretores'][0]['bairros'] as $key => $bairrocadastrados)
                                                            @if($bairro->id == $bairrocadastrados['id']) 
                                                                selected 
                                                            @endif 
                                                        @endforeach
                                                    @endif>{{$bairro->name}}</option>
                                                @endforeach
                                            @endif 
                                        @endforeach
                                    @endif 
                                @endif 
                            </select>
                        </div>               
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Região</span>
                            </div>
                            <select  class="custom-select @error('bairro') is-invalid @enderror chosen-select" id="inputRegiao" name="regiao[]" multiple>
                                <option>Selecione</option>
                                @if(isset($idCidade))
                                    @if(isset($cidades))
                                        @foreach($cidades as $cidade)
                                            @if($cidade['id'] == $idCidade)
                                                @foreach ($cidade['regioes'] as $key => $regiao)
                                                    <option value="{{$regiao->id}}"
                                                    @if(isset($usuario['corretores'][0]['regioes'][0]))
                                                        @foreach ($usuario['corretores'][0]['regioes'] as $key => $regiaocadastrados)
                                                            @if($regiao->id == $regiaocadastrados['id']) 
                                                                selected 
                                                            @endif 
                                                        @endforeach
                                                    @endif>{{$regiao->name}}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>               
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Imagem Corretor</span>
                            </div>
                            <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="foto2" name="fotoCorretor" onchange="renoear(2)">
                                    <label class="custom-file-label" id="labelFoto2" for="foto">@if(isset($usuario->corretores[0]->url_foto)) {{$usuario->corretores[0]->url_foto }} @endif</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            
                        </div>
                        <?php $entrar = true; ?>
                    @endif
                @endforeach
               
            </div>
            <div class="col-4 colSlecao">
           
                <div class="tiposProdutoArea">
                    <span class="input-group-text">Tipo</span>
                    <div class="tiposProdutos">
                        @foreach ($roles as $role)
                            <div class="form-check">
                            
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input" id="role_{{ $role->id }}" {{ $usuario->hasAnyRole($role->name) ? 'checked':'' }}>
                                <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($entrar)
                    <div class="tiposProdutoArea mb-4">
                        <span class="input-group-text">Genero</span>
                        <div class="tiposProdutos">
                            @foreach ($generos as $key => $genero)
                                <div class="form-check">
                                    <input type="radio" name="genero" value="{{ $key+1 }}" class="form-check-input"
                                    @if($roleUser->name == 'corretor' && isset($usuario['corretores'][0]['genero']))
                                        @if($usuario['corretores'][0]['genero'] ==  $key+1)
                                            checked 
                                        @endif
                                    @elseif($roleUser->name == 'cliente' && isset($usuario['clientes'][0]['genero']))
                                        @if($usuario['clientes'][0]['genero'] ==  $key+1)
                                            checked 
                                        @endif
                                    @endif>
                                    <label class="form-check-label">{{ $genero }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-12 d-grid">
                <button type="submit" class="btn btn-dark btnCadastrar">Atualizar</button>
            </div>
        </div>

    </form>
                
</div>

<style>
.tiposProdutoArea {
    height: 46%;
}
.tiposProdutoArea  .tiposProdutos{
    padding: 0.375rem 0 0.75rem 0.75rem;
    background: white;
    border: 1px solid #ced4da;
    border-radius: 0 0 0.25rem 0.25rem;
    height: 94%;
    width: 100%;
    overflow: auto;
}
.btnCadastrar{
    float: right;
}

.select-checkbox option::before {
  content: "\2610";
  width: 1.3em;
  text-align: center;
  display: inline-block;
}
.select-checkbox option:checked::before {
  content: "\2611";
}
</style>
@endsection
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
    let valBairro = [];
    let valRegiao = [];
     function renoear(i){  
        $('#labelFoto'+i).text($('#foto'+i).val());
    }
    function trazerCidades(){
        let id = $('#estadoId').val();
        if(id != 'pular'){
            // alert(id);
            $.ajax({
                url: '{{route("dashboard.user-estado")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    valBairro = [];
                    valRegiao = [];
                    $('#inputCidade').empty();
                    $('#inputCidade').append($('<option>').val('pular').text('Selecione'));
                    $('#inputBairro').empty();
                    $('#inputBairro').append($('<option>').val('pular').text('Selecione'));
                    $('#inputRegiao').empty();
                    $('#inputRegiao').append($('<option>').val('pular').text('Selecione'));
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
    function trazerCidades2(){
        let id = $('#estadoIdClientes').val();
        if(id != 'pular'){
            // alert(id);
            $.ajax({
                url: '{{route("dashboard.user-estado")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    $('#inputCidadeCliente').empty();
                    $('#inputCidadeCliente').append($('<option>').val('pular').text('Selecione'));
                    $('#inputBairroClientes').empty();
                    $('#inputBairroClientes').append($('<option>').val('pular').text('Selecione'));
                    res_success[0]['cidades'].forEach(function(cidade, i) {
                        $('#inputCidadeCliente').append($('<option>').val(cidade.id).text(cidade.name));
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
                url: '{{route("dashboard.user-cidade")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    valBairro = [];
                    valRegiao = [];
                    $('#inputBairro').empty();
                    $('#inputBairro').append($('<option >').val('pular').text('Selecione'));
                    $('#inputRegiao').empty();
                    $('#inputRegiao').append($('<option >').val('pular').text('Selecione'));
                    $('#inputBairro').prop({'size': 3, 'multiple': true})
                    $('#inputRegiao').prop({'size': 3, 'multiple': true})
                    res_success[0]['bairros'].forEach(function(bairro, i) {
                        $('#inputBairro').append($('<option>').val(bairro.id).text(bairro.name));
                    })
                    res_success[0]['regioes'].forEach(function(regiao, i) {
                        $('#inputRegiao').append($('<option>').val(regiao.id).text(regiao.name));
                    })
                },
                error: function (result) {
                    //chega aqui se foi erro	
                    console.log(result);					
                }
			});
        }
    }
    function trazerBairros2(){
        let id = $('#inputCidadeCliente').val();
        if(id != 'pular'){
            // alert(id);
            $.ajax({
                url: '{{route("dashboard.user-cidade")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    $('#inputBairroClientes').empty();
                    $('#inputBairroClientes').append($('<option >').val('pular').text('Selecione'));
                    res_success[0]['bairros'].forEach(function(bairro, i) {
                        $('#inputBairroClientes').append($('<option>').val(bairro.id).text(bairro.name));
                    })
                },
                error: function (result) {
                    //chega aqui se foi erro	
                    console.log(result);					
                }
			});
        }
    }

    function trazerCorretores(){
        let id = $('#inputBairroClientes').val();
        if(id != 'pular'){
            $.ajax({
                url: '{{route("dashboard.user-corretor")}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id' : id
                    },
                success: function (res_success) {
                    $('#inputCorretoresCliente').empty();
                    $('#inputCorretoresCliente').append($('<option >').text('Selecione'));
                    res_success[0]['corretores'].forEach(function(coretor, i) {
                        $('#inputCorretoresCliente').append($('<option>').val(coretor.id).text(coretor.name));
                    })
                },
                error: function (result) {
                    //chega aqui se foi erro	
                    console.log(result);					
                }
            });
        }
    }
    
    $(document).on('click', '#inputBairro option', function(){
        var indiceBairro = valBairro.indexOf(this.value);
        if(indiceBairro == -1){
            valBairro.push(this.value);
            
        }else{
            valBairro.splice(indiceBairro, 1);
            $('#inputBairro option[value='+this.value+']').prop('selected', false);
        }
        valBairro.forEach(function(valor, i) {
            $('#inputBairro option[value='+valor+']').prop('selected', 'selected');
        })
    })
    $(document).on('click', '#inputRegiao option', function(){
        var indiceRegiao = valRegiao.indexOf(this.value);
        if(indiceRegiao == -1){
            valRegiao.push(this.value);
            
        }else{
            valRegiao.splice(indiceRegiao, 1);
            $('#inputRegiao option[value='+this.value+']').prop('selected', false);
        }
        valRegiao.forEach(function(valor, i) {
            $('#inputRegiao option[value='+valor+']').prop('selected', 'selected');
        })
    })
    

</script>
