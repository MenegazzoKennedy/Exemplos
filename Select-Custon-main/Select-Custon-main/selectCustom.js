/*
	Criado por Kennedy Menegazzo Mello de Carvalho;
	E-Mail: kennedymenegazzo@gmail.com;
	Data de Criação: 25/11/2021;
	Data da Ultima Modificalçao: 28/04/2022


	LEGENDA:

	idSelect => Id do Select do Form(html);
	isMultiplie => TRUE para Select multiplo e FALSE para Select normal(padrão = FALSE);
	isOptionSelect => Apresenta os option selecionados(padrão = "TRUE"); 
	msgBoxSelecao => Mensagem que aparecera caso não tenha nenhum option selecionado(padrão = "Selecione");
	contadorOption => Contador de options(padrão = FALSE);
	idSufixo => Sufixo dos IDs das divs que serão criadas(padrão = "");
	idPrefixo => Prefixo dos IDs das divs que serão criadas(padrão = "");
	classSufixo => Sufixo das Classes das divs que serão criadas(padrão = "");
	classPrefixo => Prefixo das Classes das divs que serão criadas(padrão = "");
	classArrow => Classe do Icone que aparecera na Box de Seleção(padrão = "fa fa-arrow" do Font Awesome);
	isCheckOption => Insere check nos options(padrão = FALSE);
	vecolidadeAbertura => Velocidade que a caixa de option abre e fecha em mile-segundos(padrão = 500);
	isCampoInput => insere um campo de input que ao escrever é salvo no select;

	*/
	function selectCustom(array, funcaoCallback = null) {
		if (!(typeof array['idSelect'] === "undefined")) {
			var idSelect = array['idSelect'];
			var isOptionSelected = [];
			if (!(typeof jQueryMC("#" + idSelect)[0] === "undefined")) {
				if (typeof array['isMultiplie'] === "undefined") {
					var isMultiplie = false;
				} else {
					if (array['isMultiplie']) {
						var isMultiplie = true;
					} else {
						var isMultiplie = false;
					}
				}
				if (typeof array['msgBoxSelecao'] === "undefined") {
					var msgBoxSelecao = "Selecione";
				} else {
					var msgBoxSelecao = array['msgBoxSelecao'];
				}
				if (typeof array['contadorOption'] === "undefined") {
					var contadorOption = false;
				} else {
					if (array['contadorOption']) {
						var contadorOption = true;
						var quantidadeSelecionada = 0;
					} else {
						var contadorOption = false;
					}
				}
				if (typeof array['isOptionSelect'] === "undefined") {
					var isOptionSelect = true;
				} else {
					if (array['isOptionSelect']) {
						var isOptionSelect = true;
					} else {
						var isOptionSelect = false;
					}
				}
				if (typeof array['isCheckOption'] === "undefined") {
					var isCheckOption = false;
				} else {
					if (array['isCheckOption']) {
						var isCheckOption = true;
					} else {
						var isCheckOption = false;
					}
				}
				if (typeof array['idSufixo'] === "undefined") {
					var idSufixo = "";
				} else {
					var idSufixo = array['idSufixo'];
				}
				if (typeof array['idPrefixo'] === "undefined") {
					var idPrefixo = "";
				} else {
					var idPrefixo = array['idPrefixo'];
				}
				if (typeof array['classSufixo'] === "undefined") {
					var classSufixo = "";
				} else {
					var classSufixo = array['classSufixo'];
				}
				if (typeof array['classPrefixo'] === "undefined") {
					var classPrefixo = "";
				} else {
					var classPrefixo = array['classPrefixo'];
				}
				if (typeof array['classArrow'] === "undefined") {
					var classArrow = "fa fa-chevron-down";
				} else {
					var classArrow = array['classArrow'];
				}
				if (typeof array['vecolidadeAbertura'] === "undefined") {
					var vecolidadeAbertura = 500;
				} else {
					var vecolidadeAbertura = array['vecolidadeAbertura'];
				}
				if (typeof array['isCampoInput'] === "undefined") {
					var isCampoInput = false;
				} else {
					if (array['isCampoInput']) {
						var isCampoInput = true;
						isMultiplie = true;
					} else {
						var isCampoInput = false;
					}
				}

				jQueryMC("#" + idSelect).val('');
				if (isMultiplie == true) {
					jQueryMC("#" + idSelect).prop("multiple", true);
				}
				var selectDiv = jQueryMC("<div class='contact-caixa-fora'></div>").insertAfter("#" + idSelect);
				selectDiv.html("<div id='" + idPrefixo + "caixaSelecionado" + idSufixo + "' class='contact-caixa-select'></div><div id='" + idPrefixo + "caixaSelecao" + idSufixo + "' class='contact-caixa-selecao'></div>");
				var idSelecionado = idPrefixo + "caixaSelecionado" + idSufixo;
				var idCaixaSelecao = idPrefixo + "caixaSelecao" + idSufixo;
				jQueryMC("#" + idSelect).css("display", "none");
				jQueryMC("#" + idCaixaSelecao).css("display", "none");
				var objTeste = document.querySelectorAll("#" + idSelect + " option");
				var valueSelect = jQueryMC("#" + idSelect).val();
				var quantidaObjTeste = objTeste.length;
				var html = "";
				var valorSelected = jQueryMC("#" + idSelect+' option[selected]').val();
				var optionSelected = null;
				if(isCampoInput){
					jQueryMC("#" + idSelecionado).html('<input type="text" class="'+ idPrefixo + 'input'+ idSufixo +'" ><i class="setaPeriodo ' + classArrow + '"></i><p>' + msgBoxSelecao + '</p>');
					jQueryMC("#" + idSelecionado).addClass("contact-caixa-select-input");
				}else{
					if (contadorOption) {
						jQueryMC("#" + idSelecionado).html('<p>' + msgBoxSelecao + '</p><span>' + quantidadeSelecionada + '</span/><i class="setaPeriodo ' + classArrow + '"></i>');
					} else {
						jQueryMC("#" + idSelecionado).html('<p>' + msgBoxSelecao + '</p><i class="setaPeriodo ' + classArrow + '"></i>');
					}
				}
				for (var i = 0; i < quantidaObjTeste; i++) {
					if (html == "") {
						if (isCheckOption) {
							html = "<div class='selectOption " + classPrefixo + "selectOption" + classSufixo + "' data-value='" + objTeste[i].value + "' data-text='" + objTeste[i].innerHTML + "' ><label></label><a href='#'>" + objTeste[i].innerHTML + "</a> </div>";
						} else {
							html = "<div class='selectOption " + classPrefixo + "selectOption" + classSufixo + "' data-value='" + objTeste[i].value + "' data-text='" + objTeste[i].innerHTML + "' ><a href='#'>" + objTeste[i].innerHTML + "</a> </div>";
						}
					} else {
						if (isCheckOption) {
							html += "<div class='selectOption " + classPrefixo + "selectOption" + classSufixo + "' data-value='" + objTeste[i].value + "' data-text='" + objTeste[i].innerHTML + "' ><label></label><a href='#'>" + objTeste[i].innerHTML + "</a> </div>";
						} else {
							html += "<div class='selectOption " + classPrefixo + "selectOption" + classSufixo + "' data-value='" + objTeste[i].value + "' data-text='" + objTeste[i].innerHTML + "' ><a href='#'>" + objTeste[i].innerHTML + "</a> </div>";
						}
					}
				}
				jQueryMC("#" + idCaixaSelecao).html(html);

				jQueryMC("." + classPrefixo + "selectOption" + classSufixo + " a").on("click", function (element) {
					element.preventDefault();
					clickInLink(jQueryMC(this));
					
				});
				jQueryMC(document).on("click", function (e) {
					clickInWindow(e.target);
				});
				if(isCampoInput){
					document.querySelector("#"+idPrefixo + "caixaSelecionado" + idSufixo + " ." + idPrefixo + 'input'+ idSufixo).addEventListener("keypress", function(event) {
						jQueryMC("#" + idCaixaSelecao).slideDown();
						texto = this.value;
						if(texto == ""){
							jQueryMC("#" + idCaixaSelecao + " ." + classPrefixo + "selectOption" + classSufixo).css("display", "block");
						}else{
							var vOption = verificaOption(texto);
							if (event.key === "Enter") {
								event.preventDefault();
								if(!vOption['existe']){
									if(vOption.identico == null){
										jQueryMC("#" + idSelect).append("<option value='"+texto+"'>"+texto+"</option>");
										var newOption = jQueryMC("#" + idCaixaSelecao).append("<div class='selectOption " + classPrefixo + "selectOption" + classSufixo + "' data-value='" + texto + "' data-text='" + texto + "' ><a href='#'>" + texto + "</a> </div>");
										newOption = newOption.find(".selectOption." + classPrefixo + "selectOption"+ classSufixo + ":last-child a");

										newOption.on("click", function (element) {
											element.preventDefault();
											clickInLink(jQueryMC(this));
										});
										newOption.click();
									}
								}else{
									if(vOption.identico != null){
										vOption.identico.find("a").click();
									}
								}
							}
						}
					});
					document.querySelector("#"+idPrefixo + "caixaSelecionado" + idSufixo + " ." + idPrefixo + 'input'+ idSufixo).addEventListener("keyup", function(event) {
						verificaOption(this.value);
					})
				}
				if(valorSelected != "undefined"){
					jQueryMC("."+classPrefixo + "selectOption" + classSufixo + "[data-value='"+valorSelected+"'] a").click();
				}
				function verificaOption(texto){
					var texto = texto.toUpperCase();
					var option = jQueryMC("#" + idCaixaSelecao + " ." + classPrefixo + "selectOption" + classSufixo);
					option.css("display", "none");
					var existe = false;
					var identico = null;
					option.each(function(){
						dataValue = jQueryMC(this).data("value").toUpperCase();
						dataText = jQueryMC(this).data("text").toUpperCase();
						if(dataValue.indexOf(texto) > -1 || dataText.indexOf(texto) > -1){
							jQueryMC(this).css("display", "block");
							existe = true;
						}
						if(dataValue == texto){
							identico = jQueryMC(this);
						}
					});
					if(existe){
						return { existe : true, identico : identico};
					}else{
						return { existe : false, identico : null};
					}
				}
				function clickInLink(elemento){

					var elementPai = elemento.closest("." + classPrefixo + "selectOption" + classSufixo + "");
					var select = jQueryMC('#' + idSelect);
					if (isOptionSelect) {
						if (isOptionSelect) {
							var textoHtml = jQueryMC("#" + idSelecionado + " p").html();
						}else{
							var textoHtml = jQueryMC("#" + idSelecionado + " p").text();
						}
					}

					if (isMultiplie == true) {
						elemento.toggleClass("active");
						elementPai.toggleClass("option-active");
						var valorSelect = select.val();
						if (valorSelect) {

							index = valorSelect.toString().indexOf(elementPai.data("value"));
							if (index == -1) {
								valorSelect.push(elementPai.data("value"));
								if (isOptionSelect) {
									if (textoHtml == msgBoxSelecao) {
										if(isCampoInput){
											textoHtml = "<label>"+elementPai.data("text")+"</label>";
										}else{
											textoHtml = elementPai.data("text");
										}
									} else {
										if(isCampoInput){
											textoHtml = textoHtml + "<label>" + elementPai.data("text") + "</label>";
										}else{
											textoHtml = textoHtml + ", " + elementPai.data("text");
										}
									}
									textoHtml = textoHtml.replaceAll(", ,", ",");
								}
							} else {
								valorSelect.splice(index, 1);
								if (isOptionSelect) {
									if(isCampoInput){
										textoHtml = textoHtml.replaceAll("<label>"+elementPai.data("text")+"</label>", "");
										textoHtml = textoHtml.replaceAll(", ,", ",");
									}else{								
										textoHtml = textoHtml.replaceAll(elementPai.data("text") + ", ", "");
										textoHtml = textoHtml.replaceAll(elementPai.data("text"), "");
										textoHtml = textoHtml.replaceAll(", ,", ",");
									}
									if (textoHtml == "") {
										textoHtml = msgBoxSelecao;
									}
								}
							}
							select.val(valorSelect);
						}

					} else {
						jQueryMC("." + classPrefixo + "selectOption" + classSufixo + " a").removeClass("active");
						elemento.addClass("active");
						select.val(elementPai.data("value"));
						if (isOptionSelect) {
							textoHtml = elementPai.data("text");
						}
					}
					quantidadeSelecionada = jQueryMC("." + classPrefixo + "selectOption" + classSufixo + " a.active").length;
					if (isOptionSelect) {
						jQueryMC("#" + idSelecionado + " p").html(textoHtml);
					}
					if (contadorOption) {
						jQueryMC("#" + idSelecionado + " span").text(quantidadeSelecionada);
					}
					if (elementPai.data("value") == "") {
						jQueryMC("#" + idSelecionado).removeClass("selectNotNull");
					} else {
						jQueryMC("#" + idSelecionado).addClass("selectNotNull");
					}
					select.find('option[value="' + elementPai.data("value") + '"]').change();
				}
				function clickInWindow(target){
					if(isOptionSelect){		   			
						texto = jQueryMC("#"+idPrefixo + "caixaSelecionado" + idSufixo + " ." + idPrefixo + 'input'+ idSufixo).val();
						if(texto == ""){
							jQueryMC("#" + idCaixaSelecao + " ." + classPrefixo + "selectOption" + classSufixo).css("display", "block");
						}
					}
					jQueryMC('#' + idCaixaSelecao).each(function () {
						var $this = jQueryMC(this);
						var dropdown = $this.parent().find('#' + idSelecionado);
						var dropdownp = dropdown.find("p");
						var dropdowni = dropdown.find("i");
						var dropdownInp = dropdown.find("input");
						if (dropdown[0] == target || dropdownp[0] == target || dropdowni[0] == target || dropdownInp[0] == target) {
							if (jQueryMC(this).css("display") == "none") {
								jQueryMC("#" + idSelecionado).toggleClass("selectAberto");
								jQueryMC(this).slideToggle();
							} else {
								jQueryMC(this).slideToggle(vecolidadeAbertura, function () {
									jQueryMC("#" + idSelecionado).toggleClass("selectAberto");
								});
							}
						} else {
							if (isMultiplie == true) {
								if (typeof jQueryMC("#" + idCaixaSelecao).find(target)[0] === "undefined") {
									jQueryMC(this).slideUp(vecolidadeAbertura, function () {
										jQueryMC("#" + idSelecionado).removeClass("selectAberto");
									});
								}
							} else {
								jQueryMC(this).slideUp(vecolidadeAbertura, function () {
									jQueryMC("#" + idSelecionado).removeClass("selectAberto");
								});
							}
						}
					});
				}

			}
			if(funcaoCallback != null){
				funcaoCallback();
			}
		}
	}