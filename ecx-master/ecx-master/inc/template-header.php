<header id="header-cabecalho">
    <div class="container">
	    <div class="row">
	    	<div class="col-md-2 col-12">
	            <div class="header-logo">
	                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	                    <img src="<?php the_field('logo_topo') ?>" alt="">
	                </a>
	            </div>
	    	</div>
	    	 <div class="col-md-10 col-12 header-botao">
                <?php 
                    $btns = get_field("cta_topo"); 
                    foreach($btns as $btn){
						if(get_field('exibir_contato') == 'exibir'){ ?>
                        	<a href="#contact-form" class="btn btn-outline-warning" onclick="showItensContact(<?php echo $btn['acao']; ?>, 1)" ><?php echo $btn['cta_texto']; ?></a>   
                    <?php }else{ ?>
                    		<a href="#contact-form" class="btn btn-outline-warning"><?php echo $btn['cta_texto']; ?></a>    
                    	<?php }
                    }
                ?>
	    	 </div>
	    </div>
	</div>
</header>