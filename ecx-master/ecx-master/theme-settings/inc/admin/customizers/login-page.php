<?php
/**
 * Add support to social networks fields on customizer.
 *
 * A new section named "Page Login" is created on customizer.
 */
if ( ! function_exists('maiscode_login_page_customize_register')) {
    /**
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function maiscode_login_page_customize_register($wp_customize)
    {
        $wp_customize->add_section('maiscode_theme_login_options', array(
            'title'       => __('Page Login', 'maiscode'),
            'capability'  => 'edit_theme_options',
            'description' => __('Editar menu de Login', 'maiscode'),
            'priority'    => 160,
        ));


        // Logo
   
        $wp_customize->add_setting( 'logo_login',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw'
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_login',
           array(
              'label' => __( 'Logo' ),
              'section' => 'maiscode_theme_login_options',
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


        // Imagem de Fundo
        $wp_customize->add_setting( 'imagem_fundo_login',
           array(
              'default' => '',
              'transport' => 'refresh',
              'sanitize_callback' => 'esc_url_raw',
              
           )
        );
         
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'imagem_fundo_login',
           array(
              'label' => __( 'Imagem de Fundo' ),
              'section' => 'maiscode_theme_login_options',
              'button_labels' => array( // Optional.
                 'select' => __( 'Select Image' ),
                 'change' => __( 'Change Image' ),
                 'remove' => __( 'Remove' ),
                 'default' => __( 'Default' ),
                 'placeholder' => __( 'No image selected' ),
                 'frame_title' => __( 'Select Image' ),
                 'frame_button' => __( 'Choose Image' ),
                 'type' => 'url'
              )
           )
        ) );


        // Cor Primaria

        $wp_customize->add_setting( 'background_color', array(
            'transport' => 'refresh',
            'sanitize_callback'    => 'sanitize_hex_color_no_hash',
            'sanitize_js_callback' => 'maybe_hash_hex_color',
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
            'label'   => 'Cor Primaria',
            'section' => 'maiscode_theme_login_options',
        )));

          // Cor Secundaria

          $wp_customize->add_setting( 'form_color', array(
            'transport' => 'refresh',
            'sanitize_callback'    => 'sanitize_hex_color_no_hash',
            'sanitize_js_callback' => 'maybe_hash_hex_color',
        ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'form_color', array(
            'label'   => 'Cor Secundaria',
            'section' => 'maiscode_theme_login_options',
        )));

          // Cor Fonte

           $wp_customize->add_setting( 'font_color', array(
            'transport' => 'refresh',
            'sanitize_callback'    => 'sanitize_hex_color_no_hash',
            'sanitize_js_callback' => 'maybe_hash_hex_color',
          ));
         $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_color', array(
            'label'   => 'Cor Fonte',
            'section' => 'maiscode_theme_login_options',
          )));
   
    }

} // endif function_exists( 'maiscode_theme_customize_register' ).
add_action('customize_register', 'maiscode_login_page_customize_register');


/*
-------------------COMO UTILIZAR OS LINKS -----------------

            echo get_theme_mod('social_exemplo' )
            echo get_theme_mod('background_color' );

*/



function loginpage_script_admin() {
  wp_enqueue_script( 'my-custom-script-loginpage', get_template_directory_uri() . '/theme-settings/inc/admin/customizers/js/loginpage.js' );
}
add_action('customize_controls_print_styles', 'loginpage_script_admin');