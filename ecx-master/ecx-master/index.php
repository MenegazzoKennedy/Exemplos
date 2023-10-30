<?php 
/**
 * Template Name: Página Home
 *
 * @package WordPress
 * @author Mais Code Tecnologia
 * @since First Version
 */

get_header(); 
    get_template_part('inc/template', 'destaque');
    get_template_part('inc/template', 'beneficios');
    get_template_part('inc/template', 'funcionamento');
    get_template_part('inc/template', 'contact');
get_footer(); ?>
