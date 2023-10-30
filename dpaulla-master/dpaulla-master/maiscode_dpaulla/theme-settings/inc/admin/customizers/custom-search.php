<?php
/**
 * Add support to social networks fields on customizer.
 *
 * A new section named "Erro 404" is created on customizer.
 */
if ( ! function_exists('maiscode_search_customize_register')) {
    /**
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function maiscode_seacrh_customize_register($wp_customize)
    {
        $wp_customize->add_section('maiscode_theme_search_options', array(
            'title'       => __('Pesquisa', 'maiscode'),
            'capability'  => 'edit_theme_options',
            'description' => __('Editar Pesquisa', 'maiscode'),
            'priority'    => 160, 
        ));

          //Título Encontrado

          $wp_customize->add_setting('titulo_search', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_search', array(
            'section' => 'maiscode_theme_search_options',
            'label'   => esc_html__('Título', 'theme'),
            'type'    => 'text',
        )));
        // Título Não Encontrado
        $wp_customize->add_setting('titulo_nf_search', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_nf_search', array(
            'section' => 'maiscode_theme_search_options',
            'label'   => esc_html__('Título - Não econtrado', 'theme'),
            'type'    => 'text',
        )));

    }
} // endif function_exists( 'maiscode_seacrh_customize_register' ).
add_action('customize_register', 'maiscode_seacrh_customize_register');

/*
-------------------COMO UTILIZAR OS LINKS -----------------

            echo get_theme_mod('imagem_search' )

*/
