<?php
/**
* Template Name: Página de Sobre
*
* @package WordPress
* @author Mais Code Tecnologia
* @since First Version
*/
get_header();
if (have_posts()) : 
    while (have_posts()) : the_post();
        get_template_part( 'inc/template', 'title' );
        get_template_part( 'inc/template', 'about' );
        get_template_part( 'inc/template', 'about-extra' );
    endwhile; 
endif;
get_footer(); ?>