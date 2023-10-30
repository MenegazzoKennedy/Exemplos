<section id="sec-contact">
    <div class="container">
        <div class="row">
            <div class="col-12 contact-titulo">
                <label><?php the_field('subtitulo_contato'); ?></label>
                <h2><?php the_field('titulo_contato'); ?></h2>
            </div>
            <div class="col-lg-6 col-12 contact-box">
                <div class="contact-box-interna"> 
                    <?php
                        $arrayContato = get_field("caracteristicas_contato");
                        foreach($arrayContato as $contato){?>
                            <div>
                                <img src="<?php echo $contato['icone_caracteristicas_contato']; ?>">
                                <h4><?php echo $contato['titulo_caracteristicas_contato']; ?></h4>
                                <span><?php echo $contato['descricao_caracteristicas_contato']; ?></span>
                            </div>
                    <?php }
                        ?>  
                </div>
            </div>
            <div class="col-lg-6 col-12 contact-form" id="contact-form">
                <div class="contact-escolha">
                    <span class="contact-escolha-selecionado" onclick="showItensContact(1,0)"><?php the_field('botao_rh_contato'); ?></span>
                    <span onclick="showItensContact(2,0)"><?php the_field('botao_funcionario_contato'); ?></span>
                    <label class="contact-escolha-traco"></label>
                </div>
                <div class="contact-itens">
                    <div class="contact-itens-colaborador" style="display: none">
                        <?php
                            $idFormColaborador = get_field('formulario_funcionario_contato');
                            $formColaborador = "[contact-form-7 id='".$idFormColaborador[0]."']";
                            echo do_shortcode($formColaborador);
                        ?>
                    </div>
                    <div class="contact-itens-rh">
                        <?php
                            $idFormRH = get_field('formulario_rh_contato');
                            $formRH = "[contact-form-7 id='".$idFormRH[0]."']";
                            echo do_shortcode($formRH);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
function menuScriptContact(){ ?>

    <script type="text/javascript">
        var terminado = true;
        var largura = window.screen.width;
        function showItensContact(item, local){
            elements = document.querySelectorAll("#sec-contact .contact-escolha span");
            label = document.querySelector("#sec-contact .contact-escolha label");
            if(terminado){
                terminado = false;
                if(item == 1){
                    elements[0].classList.remove("contact-escolha-selecionado");
                    elements[1].classList.add("contact-escolha-selecionado");
                    label.classList.add("contact-escolha-label");
                    $(".contact-itens-rh").fadeOut(function(){
                        $(".contact-itens-colaborador").fadeIn(function(){
                            terminado = true;
                        });
                    });
                }else{
                    elements[0].classList.add("contact-escolha-selecionado");
                    elements[1].classList.remove("contact-escolha-selecionado");
                    label.classList.remove("contact-escolha-label");
                    $(".contact-itens-colaborador").fadeOut(function(){
                        $(".contact-itens-rh").fadeIn(function(){
                            terminado = true;
                        });
                    });
                }
            }
            if(local == 1){
                setTimeout(function() {
                    window.history.pushState("", "Title", window.location.pathname);
                }, 300);
            }
        }

        var selects = $("#sec-contact .contact-form p select");
        for(var i = 0; i < selects.length; i++){
            slectId = selects[i].id;
            var selectDiv = $("<div class='contact-caixa-fora'></div>").insertAfter(selects[i]);
            selectDiv.html("<div id='caixaSelecionado"+slectId+"' class='contact-caixa-select'></div><div id='caixaSelecao"+slectId+"' class='contact-caixa-selecao'></div>");
            selectCustom(slectId, "caixaSelecionado"+slectId, "caixaSelecao"+slectId);
        }
        function selectCustom(idSelect, idSelecionado, idCaixaSelecao){
                jQuery("#"+idSelect).css("display", "none");
                jQuery("#"+idCaixaSelecao).css("display", "none");
                var objTeste = document.querySelectorAll("#"+idSelect+" option");
                var quantidaObjTeste = objTeste.length;
                var html = "";
                for(var i = 0; i < quantidaObjTeste; i++){
                    if(i == 0){
                        jQuery("#"+idSelecionado).html('<p>'+objTeste[i].innerHTML+'</p><i class="setaPeriodo fas fa-chevron-down"></i>');
                    }
                    if(html == ""){
                        html = "<div class='selectOption selectOption"+idSelect+"' data-value='"+objTeste[i].value+"' data-text='"+objTeste[i].innerHTML+"' ><a href='#'>"+objTeste[i].innerHTML+ "</a> </div>";
                    }else{
                        html += "<div class='selectOption selectOption"+idSelect+"' data-value='"+objTeste[i].value+"' data-text='"+objTeste[i].innerHTML+"'><a  href='#'>"+objTeste[i].innerHTML+"</a></div>";
                    }
                }
                jQuery("#"+idCaixaSelecao).html(html);
                jQuery(".selectOption"+idSelect+" a").click(function(element){
                    element.preventDefault();
                    var elementPai = jQuery(this).closest(".selectOption"+idSelect+"");
                    var select = jQuery('#'+idSelect);
                    var valorSelect = select.val();
                    select.val(elementPai.data("value"));
                    jQuery("#"+idSelecionado+" p").html(elementPai.data( "text"));
                    if(elementPai.data("value") == ""){
                        jQuery("#"+idSelecionado).removeClass("selectNotNull");
                    }else{
                        jQuery("#"+idSelecionado).addClass("selectNotNull");
                    }
                });

                jQuery(document).click(function(e) {
                    var target = e.target;
                    jQuery('#'+idCaixaSelecao).each(function() {
                        var $this = jQuery(this);
                        var dropdown = $this.parent().find('#'+idSelecionado);
                        var dropdownp = dropdown.find("p");
                        var dropdowni = dropdown.find("i");
                        if (dropdown[0] == target || dropdownp[0] == target || dropdowni[0] == target){
                            if(jQuery(this).css("display") == "none"){
                                jQuery("#"+idSelecionado).toggleClass("selectAberto");
                                jQuery(this).delay(500).slideToggle();
                            } else{
                                jQuery(this).slideToggle("slow", function(){
                                    jQuery("#"+idSelecionado).toggleClass("selectAberto");
                                });
                            }
                        }else{
                            jQuery(this).slideUp("slow", function(){
                                jQuery("#"+idSelecionado).removeClass("selectAberto");
                            });
                        }
                    });
                });
            }

        if(largura <= 991){
            mudarPlacehoders();
        }    
        function mudarPlacehoders(){
            var inputs = $("#sec-contact .contact-form .contact-itens input");
            var quantInputs = inputs.length;
            for(var i = 0; i < quantInputs; i++){
                var newPlaceholder = $(inputs[i]).data("placeholder");
                if(typeof newPlaceholder != 'undefined'){
                    $(inputs[i]).attr("placeholder",newPlaceholder);
                }
            }
        }
    </script>

<?php }
add_action('wp_footer', 'menuScriptContact', 1111) ?>