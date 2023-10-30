<?php
/**
 * Add support to social networks fields on customizer.
 *
 * A new section named "Redes Sociais" is created on customizer.
 */
if ( ! function_exists('maiscode_social_networks_customize_register')) {
    /**
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function maiscode_social_networks_customize_register($wp_customize)
    {
        $wp_customize->add_section('maiscode_theme_social_options', array(
            'title'       => __('Redes Sociais', 'maiscode'),
            'capability'  => 'edit_theme_options',
            'description' => __('Links para as redes sociais', 'maiscode'),
            'priority'    => 160,
        ));

        // Facebook
        $wp_customize->add_setting('social_facebook', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_facebook', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Facebook', 'theme'),
            'type'    => 'text',
        )));

        // Twitter
        $wp_customize->add_setting('social_twitter', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_twitter', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Twitter', 'theme'),
            'type'    => 'text',
        )));

        // Instagram
        $wp_customize->add_setting('social_instagram', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_instagram', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Instagram', 'theme'),
            'type'    => 'text',
        )));

        // Linkedin
        $wp_customize->add_setting('social_linkedin', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_linkedin', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Linkedin', 'theme'),
            'type'    => 'text',
        )));

        // Pinterest
        $wp_customize->add_setting('social_pinterest', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_pinterest', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Pinterest', 'theme'),
            'type'    => 'text',
        )));

        // Youtube
        $wp_customize->add_setting('social_youtube', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_youtube', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('Youtube', 'theme'),
            'type'    => 'text',
        )));

        // WhatsApp
        $wp_customize->add_setting('social_whatsapp', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'social_whatsapp', array(
            'section' => 'maiscode_theme_social_options',
            'label'   => esc_html__('WhatsApp', 'theme'),
            'type'    => 'text',
        )));

        /*
       $wp_customize->add_setting('social_whatsapp_img', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize, 
                'social_whatsapp_img',
                array(
                    'label'      => __( 'Upload a NOME CAMPO', 'theme_name' ),
                    'section'    => 'maiscode_theme_social_options',
                    'settings'   => 'social_whatsapp_img',
                    'context'    => 'your_setting_context' 
                )
            )
        );  */
        
    }
} // endif function_exists( 'maiscode_theme_customize_register' ).
add_action('customize_register', 'maiscode_social_networks_customize_register');


/*
-------------------COMO UTILIZAR OS LINKS -----------------

            echo get_theme_mod('social_exemplo' )

*/
