<?php
/**
 * Add support to social networks fields on customizer.
 *
 * A new section named "Rodape" is created on customizer.
 */
if ( ! function_exists('maiscode_custom_footer_customize_register')) {
    /**
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function maiscode_custom_footer_customize_register($wp_customize)
    {
        $wp_customize->add_section('maiscode_theme_custom_footer_options', array(
            'title'       => __('Cabeçalho e rodapé', 'maiscode'),
            'capability'  => 'edit_theme_options',
            'description' => __('Editar as logos e os links do rodapé', 'maiscode'),
            'priority'    => 161,
        ));

        // Logo Cabeçalho
   
        $wp_customize->add_setting( 'logo_header',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw'
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_header',
           array(
              'label' => __( 'Logo do Cabeçalho' ),
              'description' => esc_html__( 'This is the description for the Image Control' ),
              'section' => 'maiscode_theme_custom_footer_options',
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

        // Logo Esquerda
   
        $wp_customize->add_setting( 'logo_left_footer',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw'
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_left_footer',
           array(
              'label' => __( 'Logo da Esquerda' ),
              'description' => esc_html__( 'This is the description for the Image Control' ),
              'section' => 'maiscode_theme_custom_footer_options',
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

        //Link Logo Esquerda
        $wp_customize->add_setting('link_logo_esquerda_footer', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_logo_esquerda_footer', array(
            'section' => 'maiscode_theme_custom_footer_options',
            'label'   => esc_html__('Link da logo esquerda', 'theme'),
            'type'    => 'text',
        )));

        //Texto do Copyright
          $wp_customize->add_setting('copyright_footer', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_footer', array(
            'section' => 'maiscode_theme_custom_footer_options',
            'label'   => esc_html__('Texto Copyright', 'theme'),
            'type'    => 'text',
        )));

        // Logo Direita
   
        $wp_customize->add_setting( 'logo_right_footer',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw'
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_right_footer',
           array(
              'label' => __( 'Logo da Direita' ),
              'description' => esc_html__( 'This is the description for the Image Control' ),
              'section' => 'maiscode_theme_custom_footer_options',
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

         //Link Logo direita
         $wp_customize->add_setting('link_logo_direita_footer', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_logo_direita_footer', array(
            'section' => 'maiscode_theme_custom_footer_options',
            'label'   => esc_html__('Link da logo direita', 'theme'),
            'type'    => 'text',
        )));

        

        //   //Título
        //   $wp_customize->add_setting('titulo_footer', array(
        //     'default'           => '',
        //     'sanitize_callback' => 'sanitize_text_field',
        //     'transport'         => 'refresh',
        // ));

        // $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_footer', array(
        //     'section' => 'maiscode_theme_custom_footer_options',
        //     'label'   => esc_html__('Título', 'theme'),
        //     'type'    => 'text',
        // )));
        // // Título Botão
        // $wp_customize->add_setting('titulo_btn_footer', array(
        //     'default'           => '',
        //     'sanitize_callback' => 'sanitize_text_field',
        //     'transport'         => 'refresh',
        // ));

        // $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'titulo_btn_footer', array(
        //     'section' => 'maiscode_theme_custom_footer_options',
        //     'label'   => esc_html__('Título Botão', 'theme'),
        //     'type'    => 'text',
        // )));

        // //Link Botão
        // $wp_customize->add_setting('link_footer', array(
        //     'default'           => '',
        //     'sanitize_callback' => 'sanitize_text_field',
        //     'transport'         => 'refresh',
        // ));

        // $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'link_footer', array(
        //     'section' => 'maiscode_theme_custom_footer_options',
        //     'label'   => esc_html__('Link Botão', 'theme'),
        //     'type'    => 'text',
        // )));


   
    }
} // endif function_exists( 'maiscode_custom_footer_customize_register' ).
add_action('customize_register', 'maiscode_custom_footer_customize_register');


/*
-------------------COMO UTILIZAR OS LINKS -----------------

            echo get_theme_mod('imagem_404' )

*/
