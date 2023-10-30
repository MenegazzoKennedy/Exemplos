<?php
/**
* Template Name: Página O Grupo
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header();?>
<section id="sec_grupo">
    <div class="sec_grupo_img" style="background-image:url('<?php the_post_thumbnail_url()?>');"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 offset-md-0">
                <h1 class="sec_grupo_titulo"><?php echo the_field('sub_titulo'); ?></h1> 
            </div>
        </div>
    </div>
</section>
<section id="sec_grupo_conteudo">
	<div class="container"> 
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 offset-md-0 sec_grupo_conteudo_container">
            	<h2 class="sec_grupo_titulo"><?php echo the_field('titulo'); ?></h2> 
            	<div class="sec_grupo_descricao">
            		<?php the_content(); ?>            			
            	</div> 
            </div>
            <div class="col-12 col-sm-12 col-md-4 offset-md-1">
            	<div class="sec_grupo_conteudo_diferenciais">
		        	<h2><?php echo get_field('titulo_missao'); ?></h2>
		        	<p><?php echo get_field('descricao_missao'); ?></p>
            	</div>
            	<div class="sec_grupo_conteudo_diferenciais">
		        	<h2><?php echo get_field('titulo_visao'); ?></h2>
		        	<p><?php echo get_field('descricao_visao'); ?></p>
            	</div>
            	<div class="sec_grupo_conteudo_diferenciais">
		        	<h2><?php echo get_field('titulo_valor'); ?></h2>
		        	<p><?php echo get_field('descricao_valor'); ?></p>
            	</div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer(); ?>