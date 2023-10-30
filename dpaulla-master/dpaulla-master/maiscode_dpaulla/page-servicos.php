<?php
/**
* Template Name: Página Serviços
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header();?>
<style type="text/css">
	.slick-prev:before {
    	content: '←';
		background-image: url('<?php echo esc_url( get_template_directory_uri() ) ;?>/img/arrow-prev.png') !important;
		background-position: center;
	    background-repeat: no-repeat;
	    background-size: contain;
	    color: #fff0;
	}
	.slick-next:before {
		content: '→';
		background-image: url('<?php echo esc_url( get_template_directory_uri() ) ;?>/img/arrow-after.png') !important;
		background-position: center;
	    background-repeat: no-repeat;
	    background-size: contain;
	    color: #fff0;
	}
</style>
<section id="sec_servico">
    <div class="sec_servico_img" style="background-image:url('<?php the_post_thumbnail_url()?>');"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 sec_servico_container">
            
                <?php the_content(); ?> 
               
            </div>
        </div>
    </div>
</section>

<section id="sec_servico_grupo">
    <div class="container">
        <div class="row">
            <?php 
            $args_servicos = array(
                'post_type' => 'servicos',
                'order' => 'ASC',
            );
            $i = 0;
            $j = 0;
            $k = 0;
            $all_servico = new WP_Query($args_servicos);
            if ($all_servico->have_posts()) : while ($all_servico->have_posts()) : $all_servico->the_post();                 
                if($i == 2){ ?>
                    <div class="col-md-4 col-12 bg-<?php echo get_field('cor')?> sec_servico_col">
                    <div>
                <?php 
                $i = 0;
                }else{ ?>
                    <div class="col-md-4 col-12 bg-<?php echo get_field('cor')?> sec_servico_col sec_servico_margem">
                	<div class="sec_servico_margem_padding">              
                <?php } 
                $i++; 
                $j++; 
                ?>  
	                    <img src="<?php the_post_thumbnail_url()?>">
	                    <h2><?php the_field('subtitulo'); ?></h2>
	                    <p><?php echo get_field('descricao'); ?></p>
	                </div>
                    <button type="button" data-toggle="modal" data-target="#modal-servico-<?php echo $j;?>" class="sec_servico_btn">Saber mais</button>
                </div>   
                <div class="modal fade sec_servico_modal" id="modal-servico-<?php echo $j;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true"><img src="<?php echo esc_url( get_template_directory_uri() ) ;?>/img/fechar-simbolo-de-botao-circular.png"></span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<div class="container">
				      		<div class="row">
				      			<div class="col-12 col-sm-12 col-md-12 col-lg-6 offset-lg-0 bg-<?php echo get_field('cor')?> modal-body-titulo">
							      	<img src="<?php the_post_thumbnail_url()?>">
				                    <p><?php echo get_field('descricao'); ?></p>
				      			</div>
				      			<div class="col-12 col-sm-12 col-md-12 col-lg-4 offset-lg-1">
							      	<?php 
							      	$imagens = get_field('galeria');
							      	if (count($imagens) > 0){
								      	$divImagens = ""; 
								      	foreach ($imagens as $imagem) {?>
								      		<?php 
								      		$divImagens = $divImagens.'<div class="item modal-body-imagem"><img src="'.$imagem["imagem"].'"/></div>';
								      		?>
								      	<?php } 
								      	$k++;?>
								      	<div class="slider-for slider-for-<?php echo $k; ?>">
								      		<?php
								      			echo $divImagens;
								      		?>
								      	</div>
								      	<div class="slider-nav slider-nav-<?php echo $k; ?>">
								      		<?php
								      			echo $divImagens;
								      		?>
								      	</div>
								    <?php 
									} ?>
				      			</div>
				      		</div>
				      	</div>
				      </div>
				    </div>
				  </div>
				</div>          
            <?php 
        endwhile; endif;?> 
        </div>
    </div>
</section>
<?php
    function chamarSlider(){
    	global $k;
?>
<script type="text/javascript">
	index = <?php echo $k;?>;
	i = 0;
	for(i = 1 ; i <= index; i++){
		$('.slider-for-'+i).slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  arrows: false,
		  fade: true,
		  asNavFor: '.slider-nav-'+i,
		   autoplay: true
		});
		$('.slider-nav-'+i).slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			asNavFor: '.slider-for-'+i,
			dots: false,
			centerMode: true,
			focusOnSelect: true,
		  	responsive: [
				{
			    	breakpoint: 769,
			    	settings: {
			    		slidesToShow: 4,
			    	}
			  	},
			  	{
			    	breakpoint: 426,
			    	settings: {
			    		slidesToShow: 3,
			    		arrows: false,
			    	}
			  	},
			  	{
			    	breakpoint: 376,
			    	settings: {
			    		slidesToShow: 2,
			    		arrows: false,
			    	}
			  	},
			  	{
			    	breakpoint: 320,
			    	settings: {
			    		slidesToShow: 3,
			    		arrows: false,
			    		centerMode: false,
			    	}
			  	}	
			]
		});
	}
	
</script>
<?php
        }
        add_action('wp_footer','chamarSlider',300);?>
<?php
get_footer(); ?>