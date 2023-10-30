<?php
/**
* Template Name: Página Home
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header();?>
<section id="sec_home">
    <div class="sec_home_img" style="background-image:url('<?php the_post_thumbnail_url()?>');"></div>
    <div class="container sec_home_container">
        <div class="sec_home_titulo"><?php the_content(); ?></div>
        <div class="row sec_home_row">
            <?php 
            $args_servicos = array(
                'post_type' => 'servicos',
                'order' => 'ASC',
            );
            $i = 0;
            $all_servico = new WP_Query($args_servicos);
            if ($all_servico->have_posts()) : while ($all_servico->have_posts()) : $all_servico->the_post();                 
                if($i == 2){ ?>
                    <div class="col-md-4 col-12 bg-<?php echo get_field('cor')?> sec_home_col">
                <?php 
                $i = 0;
                }else{ ?>
                    <div class="col-md-4 col-12 bg-<?php echo get_field('cor')?> sec_home_margem sec_home_col">
                <?php } 
                $i++; 
                ?>                
                    <img src="<?php the_post_thumbnail_url()?>">
                    <h2><?php the_field('subtitulo'); ?></h2>
                    <p><?php echo get_field('descricao'); ?></p>
                </div>                
            <?php endwhile; endif;?> 
        </div> 
    </div> 
</section>
<?php
get_footer(); ?>