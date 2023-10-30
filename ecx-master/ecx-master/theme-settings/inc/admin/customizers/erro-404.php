<?php
/**
 * Add support to social networks fields on customizer.
 *
 * A new section named "Erro 404" is created on customizer.
 */
if ( ! function_exists('maiscode_erro404_customize_register')) {
    /**
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function maiscode_erro404_customize_register($wp_customize)
    {
        $wp_customize->add_section('maiscode_theme_404_options', array(
            'title'       => __('Erro 404', 'maiscode'),
            'capability'  => 'edit_theme_options',
            'description' => __('Editar Erro 404 - Pagina não Encontrada', 'maiscode'),
            'priority'    => 160,
        ));


        // Imagem
   
        $wp_customize->add_setting( 'imagem_404',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw'
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'imagem_404',
           array(
              'label' => __( 'Imagem Erro' ),
              'description' => esc_html__( 'This is the description for the Image Control' ),
              'section' => 'maiscode_theme_404_options',
              'button_labels' => array( // Optional.
                 'select' => __( 'Select Image' ),
                 'change' => __( 'Change Image' ),
                 'remove' => __( 'Remove' ),
                 'default' => __( 'Default' ),
                 'placeholder' => __( 'No image selected' ),
                 'frame_title' => __( 'Select Image' ),
                 'frame_button' => __( 'Choose Image' ),
              )
           )
        ) );

          //Título
          $wp_customize->add_setting('titulo_404', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_404', array(
            'section' => 'maiscode_theme_404_options',
            'label'   => esc_html__('Título', 'theme'),
            'type'    => 'text',
        )));
        // Título Botão
        $wp_customize->add_setting('titulo_btn_404', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_btn_404', array(
            'section' => 'maiscode_theme_404_options',
            'label'   => esc_html__('Título Botão', 'theme'),
            'type'    => 'text',
        )));

        //Link Botão
        $wp_customize->add_setting('link_404', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_404', array(
            'section' => 'maiscode_theme_404_options',
            'label'   => esc_html__('Link Botão', 'theme'),
            'type'    => 'text',
        )));


   
    }
} // endif function_exists( 'maiscode_erro404_customize_register' ).
add_action('customize_register', 'maiscode_erro404_customize_register');


/*
-------------------COMO UTILIZAR OS LINKS -----------------

            echo get_theme_mod('imagem_404' )

*/
