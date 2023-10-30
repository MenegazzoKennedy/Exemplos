 <section id="sec-funcionamento">
 	<div class="container">
 		<div class="row">
	 		<div class="col-12 funcionamento-conteudo">
	 			<label><?php the_field("subtitulo_funcionamento"); ?></label>
	 			<h3><?php the_field("titulo_funcionamento"); ?></h3>
	 			<p><?php the_field("descricao_funcionamento"); ?></p>
	 		</div>
	 		<div class="col-12 funcionamento-timeline">
	 			<div class="funcionamento-timeline-conteudo">
	 				<?php
	 					$arrayTimeline = get_field("timeline_funcionamento");
	 					foreach($arrayTimeline as $timeline){?>
	 						<div>
			 					<h4><?php echo $timeline['primeiro_numero_timeline_funcionamento'];?><span></span><?php echo $timeline['segundo_numero_timeline_funcionamento'];?></h4>
			 					<span><?php echo $timeline["descricao_timeline_funcionamento"]; ?></span>
			 				</div>
	 				<?php }
						?>						
	 				<img src="<?php the_field('background_timeline_funcionamento'); ?>">
	 			</div>
	 		</div>
	 		<div class="col-12 funcionamento-arrastar">
	 			<div class="funcionamento-arrastar-seta">
		 			<i class="fas fa-chevron-left"></i>
	 			</div>
	 			<span>Arraste para o lado</span>
	 		</div>
	 		<div class="col-12 funcionamento-mensagem">
	 			<h2><?php the_field('background_fundo_funcionamento_texto'); ?></h2>
	 		</div>
	 	</div>
 	</div>
 </section> 
 <style type="text/css">
 	#sec-funcionamento .funcionamento-mensagem{
 		background-image: url("<?php the_field('background_fundo_funcionamento'); ?>");
 	}
 	#sec-funcionamento .funcionamento-timeline{
		scrollbar-color: #ffffff26 #fff0;
		scrollbar-width: thin;

	}
	#sec-funcionamento .funcionamento-timeline::-webkit-scrollbar{
		height: 5px;
	}
	#sec-funcionamento .funcionamento-timeline::-webkit-scrollbar-track {
		background: #fff0;  
	}
	#sec-funcionamento .funcionamento-timeline::-webkit-scrollbar-thumb {
		background-color: #ffffff26;
		border-radius: 20px;
	}
	@media (max-width: 425px) {
		#sec-funcionamento .funcionamento-timeline{
			scrollbar-color: #fff0 #fff0;
		}
		#sec-funcionamento .funcionamento-timeline::-webkit-scrollbar-thumb {
			background-color: #fff0;
		}
	}
 </style>
