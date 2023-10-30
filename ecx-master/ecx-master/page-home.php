<?php 
/**
 * Template Name: Página Home
 *
 * @package WordPress
 * @author Mais Code Tecnologia
 * @since First Version
 */

get_header(); 
    if(get_field('exibir_destaque') == 'exibir'){
        get_template_part('inc/template', 'destaque');
    }
    if(get_field('exibir_beneficios') == 'exibir'){
        get_template_part('inc/template', 'beneficios');
    }
    if(get_field('exibir_funcionamento') == 'exibir'){
        get_template_part('inc/template', 'funcionamento');
    }
    if(get_field('exibir_contato') == 'exibir'){
        get_template_part('inc/template', 'contact');
    }
get_footer(); ?>
