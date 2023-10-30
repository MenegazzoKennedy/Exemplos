@extends('layouts.app', ["titulo" => "Onliner Manager Denúncias"])

@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Anúncios</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Anúncios</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')
<div class="container-fluid" id="publicacoes-list">
    <div class="row">   
        <div class="col-12">
            <form id="postEdit" action="{{ route('dashboard.anuncios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Descricao</span>
                    </div>
                    <textarea name="texto" placeholder="Descrição do Anúncio" class="form-control @error('descricao') is-invalid @enderror" style="min-height: 37px;"></textarea>
                </div> 
                <div class="input-group mb-3">
                    <div class="midia input-group-prepend">
                        <span class="input-group-text">Mídia</span>
                    </div>
                    <div class="form-control">                        
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="midia[]" onchange="renoear()" accept="image/png, image/jpeg, video/mp4"  multiple>
                        <label id="label" class="custom-file-label" for="exampleInputFile" placeholder="inputMidias"></label>
                    </div> 
                </div> 
                <div class="input-group mb-3">
                    <div class="midia input-group-prepend">
                        <span class="input-group-text">Tags</span>
                    </div>
                    <div class="form-control  tags-selects p-0 h-auto">
                        <div class="form-control tags-selects-present h-auto pt-1"></div>
                        <select class="custom-select" id="selectTag" name="tags[]" multiple>
                            @foreach($tags as $key => $tag)
                                <option value="{{$tag->tag}}" class="option{{$key}}">{{$tag->tag}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="midia input-group-prepend">
                        <span class="input-group-text">Nova Tag</span>
                    </div>
                    <input type="text" id="novaTag" placehoder="tag" class="form-control @error('descricao') is-invalid @enderror">
                </div>
                <div class="form-actions">
                    <div class="text-right">
                        <button type="submit" class="btn btn-success lancamento-deletar">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .midia{
        z-index: 2;
    }
    .tags-selects{
        flex: 1 1 auto;
    }
    .tags-selects .tags-selects-present{
        border-bottom: unset;
        max-height: 60px !important;
        min-height: 40px !important;
        overflow-x: auto;
    }
    .tags-selects-present span{
        margin-right: 5px;
        background: #e96a4b;
        padding: 3px;
        color: #fff;
        border-radius: 50px;
        display: inline-block;
    }
    .tags-selects-present span span{
        cursor: pointer;
    }
</style>
@endsection

@section('javascript')
    <script>
        let valTag = [];
        function renoear(posicao){
            $('#label').text($('#exampleInputFile').val());
        }
        function sapanClick(valortag){
            var indiceTag = valTag.indexOf(valortag);
            if(indiceTag == -1){
                valTag.push(valortag);
                
            }else{
                valTag.splice(indiceTag, 1);
                $('#selectTag option[value='+valortag+']').prop('selected', false);
            }
            $(".tags-selects-present span").remove();
            valTag.forEach(function(valor, i) {
                $('#selectTag option[value='+valor+']').prop('selected', 'selected');
                $(".tags-selects-present").append('<span>#'+valor+'<span onclick="sapanClick(`'+valor+'`)">x</span></span>');
            })
        }
        $('#novaTag').keypress(function(e) {
            if(e.which == 32){
                var valorNovaTag = $('#novaTag').val();
                document.getElementById('novaTag').value = null;
                if($('#selectTag option[value='+valorNovaTag+']')[0] == undefined){
                    $("#selectTag").append('<option value="'+valorNovaTag.trim()+'">'+valorNovaTag+'</option>');
                }
                sapanClick(valorNovaTag.trim());
            };
        });
        $(document).on('click', '#selectTag option', function(){
            var indiceTag = valTag.indexOf(this.value);
            if(indiceTag == -1){
                valTag.push(this.value);
                
            }else{
                valTag.splice(indiceTag, 1);
                $('#selectTag option[value='+this.value+']').prop('selected', false);
            }
            $(".tags-selects-present span").remove();
            valTag.forEach(function(valor, i) {
                $('#selectTag option[value='+valor+']').prop('selected', 'selected');
                $(".tags-selects-present").append('<span>#'+valor+'<span onclick="sapanClick(`'+valor+'`)">x</span></span>');
            })
        })
    </script>
@endsection