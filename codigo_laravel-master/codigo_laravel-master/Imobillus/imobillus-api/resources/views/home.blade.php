@extends('layouts.app')

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1>Início</h1>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset("img/bem-vindo.png") }}" alt="Bem-vindo(a)" class="img-bemvindo">
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body suporte">
                    <dl class="dl-horizontal">
                    <dt>SUPORTE MAISCODE</dt><br>
                    <dd>Precisa de Ajuda? Entre em contato com nosso suporte <a href="mailto:suporte@maiscode.com.br" target="_blank">suporte@maiscode.com.br</a> ou <a href="https://maiscode.com.br/" target="_blank">clique aqui</a> para acessar nosso site ou nos de uma ligada (67) 3211-8509 . Estamos a sua disposição para te ajudar.</dd>
                    <dt>Equipe MaisCode</dt>
                </dl>
            </div>
            </div>
        </div>
    </div>
</div>
<style>
.img-bemvindo{width: 100%;}

.suporte dl {
    margin-bottom: 8px;
}
</style>
@endsection
