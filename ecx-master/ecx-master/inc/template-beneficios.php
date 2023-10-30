<section id="sec-beneficio">
	<div class="container">
		<div class="row">
			<div class="col-12 beneficio-titulo">
				<div class="row">
					<div class="col-xl-7 col-lg-8 col-12">
						<h2><?php the_field('texto_beneficios'); ?></h2>
					</div>
					<div class="col-xl-5 col-lg-4 beneficio-titulo-direito">
						<div>
							<img src="<?php the_field('icone_beneficios'); ?>">
							<span><?php the_field('texto_icone_beneficios'); ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-7 order-lg-1 order-2">
				<div class="beneficio-escolha">
					<span class="beneficio-escolha-selecionado" onclick="showItens(1)"><?php the_field('titulo_rh'); ?></span>
					<span onclick="showItens(2)"><?php the_field('titulo_colaborador'); ?></span>
					<label class="beneficio-escolha-traco"></label>
				</div>
				<div class="beneficio-itens">
					<div class="beneficio-itens-rh">
						<?php 
							$arrayRH = get_field('rh_beneficios');
							foreach($arrayRH as $rh){?>
								<div>
									<img src="<?php echo $rh['cta_rh_beneficio_icone']; ?>">
									<span><?php echo $rh['cta_rh_beneficio_texto']; ?></span>
								</div>
							<?php }
						?>
						
					</div>

					<div class="beneficio-itens-colaborador" style="display: none;">
						<?php 
							$arrayColaborador = get_field('colaborador_beneficios');
							foreach($arrayColaborador as $colaborador){?>
								<div>
									<img src="<?php echo $colaborador['cta_colaborador_beneficio_icone']; ?>">
									<span><?php echo $colaborador['cta_colaborador_beneficio_texto']; ?></span>
								</div>
							<?php }
						?>
					</div>
					<?php 
						if(get_field('exibir_contato') == 'exibir'){ ?>
							<a href="<?php the_field('colaborador_beneficios_link'); ?>" onclick="showItensContact(<?php the_field('colaborador_beneficios_acao'); ?>, 1)" class="btn"><?php the_field('colaborador_beneficios_link_texto'); ?></a>
					<?php }else{
					?>
							<a href="<?php the_field('colaborador_beneficios_link'); ?>" class="btn"><?php the_field('colaborador_beneficios_link_texto'); ?></a>
					<?php } ?>
					
				</div>
			</div>
			<div class="col-xl-6 col-lg-5 order-lg-2 order-1 beneficio-imagem">
				<img src="<?php the_field('imagem_beneficios'); ?>">
			</div>
		</div>
	</div>
</section>
<style type="text/css">
	@media (max-width: 992px) {
		#sec-beneficio .beneficio-imagem::before{
			content: "";
			    background: transparent linear-gradient( 180deg, #FFFFFF00 0, #FFFFFF 80%) 0% 0% no-repeat padding-box;
		}
	}
</style>
<?php 
function menuScriptBeneficio(){ ?>

	<script type="text/javascript">
		var terminado = true;
		var largura = window.screen.width;
	   	function showItens(item){
	   		elements = document.querySelectorAll("#sec-beneficio .beneficio-escolha span");
	   		label = document.querySelector("#sec-beneficio .beneficio-escolha label");
	   		if(terminado){
	   			terminado = false;
		   		if(item == 1){
		   			elements[0].classList.add("beneficio-escolha-selecionado");
		   			elements[1].classList.remove("beneficio-escolha-selecionado");
		   			label.classList.remove("beneficio-escolha-label");
		   			$(".beneficio-itens-colaborador").fadeOut(function(){
		   				$(".beneficio-itens-rh").fadeIn(function(){
		   					terminado = true;
		   				});
		   			});
		   			$("#sec-beneficio .beneficio-itens a").text("<?php the_field('colaborador_beneficios_link_texto'); ?>");
		   			$("#sec-beneficio .beneficio-itens a").attr('href', "<?php the_field('colaborador_beneficios_link'); ?>");		   			
		   			<?php 
						if(get_field('exibir_contato') == 'exibir'){ ?>
		   				$("#sec-beneficio .beneficio-itens a").attr('onclick', "showItensContact(<?php the_field('colaborador_beneficios_acao'); ?>, 1)");
		   			<?php } ?>
		   			if(largura > 768){
		   				$("#sec-beneficio .beneficio-itens a").css("width","198px");
		   			}
		   		}else{
		   			elements[0].classList.remove("beneficio-escolha-selecionado");
		   			elements[1].classList.add("beneficio-escolha-selecionado");
		   			label.classList.add("beneficio-escolha-label");
		   			$(".beneficio-itens-rh").fadeOut(function(){
			   			$(".beneficio-itens-colaborador").fadeIn(function(){
		   					terminado = true;
			   			});
		   			});
		   			$("#sec-beneficio .beneficio-itens a").text("<?php the_field('colaborador_rh_link_texto'); ?>");
		   			$("#sec-beneficio .beneficio-itens a").attr('href', "<?php the_field('colaborador_rh_link'); ?>");
		   			<?php 
						if(get_field('exibir_contato') == 'exibir'){ ?>
		   				$("#sec-beneficio .beneficio-itens a").attr('onclick', "showItensContact(<?php the_field('colaborador_rh_acao'); ?>, 1)");
		   			<?php } ?>
		   			if(largura > 768){
		   				$("#sec-beneficio .beneficio-itens a").css("width","231px");
		   			}
		   		}
		   	}
	   	}
	</script>

<?php }
add_action('wp_footer', 'menuScriptBeneficio', 959231) ?>