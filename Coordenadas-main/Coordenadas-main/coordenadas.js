/**
 * ARGUMENTOS
 * 
 * elemento = string contendo o caminho do elemento que será ultilazado para ser feito os calculos - Exemplo = #ID .CLASSE > div 
 * multiplo = podeconter varias linhas - TRUE ou FALSE - default FALSE
 * quantidade_linhas = quantidade de linhas que pode ter - default 3
 * carga = JSON com os dados para já serem carregados - default null
 * modificar = se vai ser aceito a mudança dos pontos - default false
 * 
 */
function gerarCoordenadas($args){ 
    var elementoExterno = $args['elemento'];
    if($args['multiplo'] != null && $args['multiplo'] != undefined){
        var multiplo = $args['multiplo'];
        if($args['quantidade_linhas'] != null && $args['quantidade_linhas'] != undefined){
            var quantidade_linhas = $args['quantidade_linhas'];
        }else{
            var quantidade_linhas = 3;
        }
    }else{
        var multiplo = false;
        var quantidade_linhas = null;
    }
    if($args['carga'] != null && $args['carga'] != undefined){
        var carga = $args['carga'];
    }else{
        carga = null;
    }
    if($args['modificar'] != null && $args['modificar'] != undefined){
        var modificar = $args['modificar'];
    }else{
        modificar = false;
    }
	
    const geradorCoordenadas = (function(){
        function gerar(caminho, caminhoPai, carga = null, indece = 0, modificar = false){
            var index = -1
            var isMouseDown = false;
            var isMouseDownMouve = false;
            var pontoAtivo = null;
            var pontosObj = {};
            var pontosObjArrayExemplo = {
                "indexAtual" : "teste",
                "indexAnterior" : "teste",
                "indexProximo" : "teste",
                "titulo" : "",
                "url" : "",
                "top" : 0,
                "left" : 0,
                "is_linha" : false
            };
            var indexAnterior = null;
            if(carga != null && carga[0] != undefined){
                for(let obj in carga){
                    
                    classe = "ponto";
                    if(carga[obj].url == "" && carga[obj].titulo == ""){
                        classe = classe+" vazio";
                    }
                    ponto = jQuery("<a class='"+classe+" ultimo-ponto' data-index='"+carga[obj].indexAtual+"' data-anterio='"+indexAnterior+"' data-proximo='null' href='"+carga[obj].url+"'><span>"+carga[obj].titulo+"</span></a>").css({"left" : carga[obj].left, "top" : carga[obj].top});
                    jQuery(caminho).append(ponto);
                    
                    jQuery(caminho+" a[data-index = '"+indexAnterior+"']").removeClass("ultimo-ponto");
                    pontosObj[carga[obj].indexAtual] = carga[obj]
                    if(!carga[obj].is_linha){
                        indexAnterior = carga[obj].indexAtual;
                    }
                    index = carga[obj].indexAtual;
                }
                for(let obj in carga){
                    if(carga[obj].indexAnterior != null){
                        criarLinha(carga[obj].indexAnterior, carga[obj].indexAtual);
                    }
                }
            }
            if(modificar){
                jQuery(caminho).mousedown(function() {
                    
                    isMouseDown = true;
                    pontoAtivo = null;
                });
                jQuery(document).mouseup(function() {
                    isMouseDown = false;
                    pontoAtivo = null;
                });
                jQuery(caminho).mousemove(function(e) {
                    if (isMouseDown) {
                        var elementoClicado = jQuery(e.target);
                        if(elementoClicado.is(".ponto") && elementoClicado.parent().is(caminho)){
                            if(pontoAtivo == null){
                                pontoAtivo = elementoClicado.data("index");
                            }
                        }
                        if(pontoAtivo != null && !elementoClicado.is(".ponto") && !elementoClicado.is(".linha")){
                            isMouseDownMouve = true;
                            jQuery(caminhoPai).addClass("movimentando");
                            var elementoPai = jQuery(caminhoPai); 
                            var posicaoPai = elementoPai.position(); 
                            var mouseX = e.offsetX; 
                            var mouseY = e.offsetY;
                            if((posicaoPai.top + elementoPai.height() >= e.pageY) && (posicaoPai.left + elementoPai.width() >= e.pageX) &&
                            (posicaoPai.top < e.pageY) && (posicaoPai.left < e.pageX)
                            ){
                                jQuery(caminho+" .ponto[data-index = '"+pontoAtivo+"']").css({"left" : mouseX, "top" : mouseY});
                                pontosObj[pontoAtivo].top = mouseY;
                                pontosObj[pontoAtivo].left = mouseX;
                                deletarLinha(pontosObj[pontoAtivo].indexAnterior, pontosObj[pontoAtivo].indexProximo, false);
                                if(pontosObj[pontoAtivo].indexAnterior != null){
                                    criarLinha(pontosObj[pontoAtivo].indexAnterior, pontoAtivo);
                                }
                                if(pontosObj[pontoAtivo].indexProximo != null){
                                    criarLinha(pontoAtivo, pontosObj[pontoAtivo].indexProximo);
                                }
                            }
                        }
                    }else{
                        isMouseDownMouve = false;

                    jQuery(caminhoPai).removeClass("movimentando");
                    }
                });
                jQuery(document).on("click", function(e){
                    var elementoClicado = jQuery(e.target);
                    if(elementoClicado.is(".finalizar")){
                        var savedJson = localStorage.getItem('mc_coordenadas');
                        if(savedJson == null || savedJson == 'null'){
                            savedJson = {};
                        }else{
                            savedJson = JSON.parse(savedJson);
                        }
                        savedJson[indece] = pontosObj;
                        savedJson = JSON.stringify(savedJson);
                        localStorage.setItem('mc_coordenadas', savedJson);
                    }else if(!isMouseDownMouve){
                        if(elementoClicado.is(caminho)){
                            index++;
                            ponto = jQuery("<a class='ponto ultimo-ponto' data-index='"+index+"' data-anterior='"+indexAnterior+"'> </a>").css({"left" : e.offsetX, "top" : e.offsetY});
                            jQuery(caminho).append(ponto);
                            jQuery(caminho+" a[data-index = '"+indexAnterior+"']").removeClass("ultimo-ponto");

                            pontosObjArrayExemplo = {
                                "indexAtual" : index,
                                "indexAnterior" : indexAnterior,
                                "indexProximo" : null,
                                "titulo" : "",
                                "url" : "",
                                "top" : e.offsetY,
                                "left" : e.offsetX,
                                "is_linha" : false
                            };
                            jQuery(caminho).append('<div class="data-pontos"><div><label>Titulo:</label><input type="text" class="titulo"><label>URL:</label><input type="text" class="url"><button data-index="'+index+'">Salvar</button></div></div>');
                            if(indexAnterior != null){
                                criarLinha(indexAnterior, index);
                                pontosObj[indexAnterior].indexProximo = index;
                            }
                            indexAnterior = index;
                            pontosObj[index] = pontosObjArrayExemplo;

                            
                        }else if(elementoClicado.is(".ponto") && elementoClicado.parent().is(caminho)){
                            e.preventDefault();
                            deletarPonto(elementoClicado.data("index"));
                        }else if(elementoClicado.is(".linha") && elementoClicado.parent().is(caminho)){
                            index++;
                            var elementoPai = jQuery(caminhoPai); 
                            var posicaoPai = elementoPai.position(); 
                            var mouseX = e.pageX - posicaoPai.left; 
                            var mouseY = e.pageY - posicaoPai.top;
                            ponto = jQuery("<a class='ponto' data-index='"+index+"' data-anterior='"+elementoClicado.data('anterior')+"' data-proximo='"+elementoClicado.data('atual')+"' />").css({"left" : mouseX, "top" : mouseY});
                            jQuery(caminho).append(ponto);
                            jQuery(caminho+" a[data-index = '"+elementoClicado.data('anterior')+"']").removeClass("ultimo-ponto");
                            pontosObjArrayExemplo = {
                                "indexAtual" : index,
                                "indexAnterior" : elementoClicado.data('anterior'),
                                "indexProximo" : elementoClicado.data('atual'),
                                "titulo" : "",
                                "url" : "",
                                "top" : mouseY,
                                "left" : mouseX,
                                "is_linha" : true
                            };
                            jQuery(caminho).append('<div class="data-pontos"><div><label>Titulo:</label><input type="text" class="titulo"><label>URL:</label><input type="text" class="url"><button data-index="'+index+'">Salvar</button></div></div>');
                            pontosObj[index] = pontosObjArrayExemplo;
                            pontosObj[elementoClicado.data('anterior')].indexProximo = index;
                            pontosObj[elementoClicado.data('atual')].indexAnterior = index;
                            criarLinha(elementoClicado.data('anterior'), index);
                            criarLinha(index, elementoClicado.data('atual'));
                            jQuery(elementoClicado).remove();
                        }else if(elementoClicado.is(".data-pontos button") && elementoClicado.parents(caminho)[0] != undefined){
                            index = elementoClicado.data("index");
                            elementoPai = elementoClicado.parent();
                            titulo = elementoPai.find(".titulo").val();
                            url = elementoPai.find(".url").val();
                            if(titulo != "" || url != ""){
                                pontosObj[index].titulo = titulo;
                                pontosObj[index].url = url;
                                jQuery(caminho+" .ponto[data-index='"+index+"']").append("<span>"+titulo+"</span>");
                                jQuery(caminho+" .ponto[data-index='"+index+"']").prop("href", url);
                            }else{
                                jQuery(caminho+" .ponto[data-index='"+index+"']").addClass("vazio");
                            }
                            elementoPai.parent().remove();
                        }else if(elementoClicado.is(".data-pontos") && elementoClicado.parents(caminho)[0] != undefined){
                            elementoClicado.remove();
                        }
                    }
                })
            }
            function criarLinha(indexAterior, indexAtual){
                anterior = jQuery(caminho+" .ponto[data-index = '"+indexAterior+"']");
                atual = jQuery(caminho+" .ponto[data-index = '"+indexAtual+"']");
                var pos1 = anterior.position();
                var pos2 = atual.position();
                var top = pos1.top + (anterior.height() / 2);
                var left = pos1.left + (anterior.width() / 2);
                var width = Math.sqrt(Math.pow(pos2.left - pos1.left, 2) + Math.pow(pos2.top - pos1.top, 2));
                var transform = 'rotate(' + Math.atan2(pos2.top - pos1.top, pos2.left - pos1.left) + 'rad)';
                var linha = jQuery('<div class="linha" data-anterior="'+indexAterior+'" data-atual="'+indexAtual+'"></div>');
                linha.css({
                    top: top,
                    left: left,
                    width: width,
                    transform: transform
                });
                jQuery(caminho).append(linha);
            }
            function deletarPonto(index){
                if(pontosObj[index].indexAnterior != null){
                    pontosObj[pontosObj[index].indexAnterior].indexProximo = pontosObj[index].indexProximo;
                }
                if(pontosObj[index].indexProximo != null){
                    pontosObj[pontosObj[index].indexProximo].indexAnterior = pontosObj[index].indexAnterior;
                    jQuery(caminho+" a[data-index = '"+pontosObj[index].indexProximo+"']").removeClass("ultimo-ponto");
                }else{
                    indexAnterior = pontosObj[index].indexAnterior;
                }
                deletarLinha(pontosObj[index].indexAnterior, pontosObj[index].indexProximo);
                delete pontosObj[index];
                jQuery(caminho+" .ponto[data-index = "+index+"]").remove();
            }
            function deletarLinha(anterior = null, atual = null, criar = true){
                if(anterior != null){
                    jQuery(caminho+" .linha[data-anterior = "+anterior+"]").remove();
                }
                if(atual != null){
                    jQuery(caminho+" .linha[data-atual = "+atual+"]").remove();
                }
                if(anterior != null && atual != null && criar){
                    criarLinha(anterior, atual);
                }
            }
        }
        return {
            gerar: gerar,
          };
    })();

    if(carga != null){
        carga_array = JSON.parse(carga);
    }else{
        carga_array = null;
    }
    if(modificar){
        jQuery("<button class='finalizar'>Finalizar</button>").insertAfter(elementoExterno);
    }
    if(multiplo){
        select = jQuery("<select />").addClass("select-coordenadas");
        
        for(i = 0; i < quantidade_linhas; i++){
            newDiv = jQuery("<div />").addClass(elementoExterno.replace(".", "")+i).css({"width" : "100%", "height" : "100%", "position" : "absolute", "top" : 0, "left" : 0})
            option = jQuery("<option />").val(i).text("Linha "+i);
            jQuery(elementoExterno).css("margin", "0");
            jQuery(elementoExterno).append(newDiv);
            if(carga_array != null && carga_array[i] != undefined){
                geradorCoordenadas.gerar(elementoExterno+i, elementoExterno, carga_array[i], i, modificar);
            }else{
                geradorCoordenadas.gerar(elementoExterno+i, elementoExterno, null, i, modificar);
            }
            select.append(option);
        }
        if(modificar){
            select.insertAfter(elementoExterno);
            select.on("change", function(){
                jQuery(elementoExterno+">div").css("z-index", 0);
                jQuery(elementoExterno+" "+elementoExterno+jQuery(this).val()).css("z-index", 1)
            });
            select.change();
        }
    }else{
        geradorCoordenadas.gerar(elementoExterno, elementoExterno, carga, 0, modificar);
    }
    
}