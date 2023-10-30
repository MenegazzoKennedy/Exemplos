<?php
/**
* Template Name: Página de Contato
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header();
if (have_posts()) : 
    while (have_posts()) : the_post();
        get_template_part( 'inc/template', 'title' );
        get_template_part( 'inc/template', 'contact' );
    endwhile; 
endif;

  

get_footer(); ?>