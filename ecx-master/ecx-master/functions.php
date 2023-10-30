<?php
	
  // Clean up wp_head
    // Remove Really simple discovery link
    remove_action('wp_head', 'rsd_link');
    // Remove Windows Live Writer link
    remove_action('wp_head', 'wlwmanifest_link');
    // Remove the version number
    remove_action('wp_head', 'wp_generator');

    // Remove curly quotes
    remove_filter('the_content', 'wptexturize');
    remove_filter('comment_text', 'wptexturize');

    // Allow HTML in user profiles
    remove_filter('pre_user_description', 'wp_filter_kses');

    //Optimize Database
    function optimize_database(){
        global $wpdb;
        $all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A);
        foreach ($all_tables as $tables){
            $table = array_values($tables);
            $wpdb->query("OPTIMIZE TABLE ".$table[0]);
        }
    }

    function simple_optimization_cron_on(){
        wp_schedule_event(time(), 'daily', 'optimize_database');
    }

    function simple_optimization_cron_off(){
        wp_clear_scheduled_hook('optimize_database');
    }
    register_activation_hook(__FILE__,'simple_optimization_cron_on');
    register_deactivation_hook(__FILE__,'simple_optimization_cron_off');

    // Logout url link

    add_filter( 'login_headerurl', 'custom_logout' );
    function custom_logout($url) {
      return home_url('/');
    }

    // Google Maps
    //----------------------------------------//
    function my_acf_google_map_api( $api ){
      
      $api['key'] = get_option('api_maps');
      
      return $api;
      
    }

    add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

    
    // Sidebar
        if (function_exists('register_sidebar')) {
        	register_sidebar(array(
        		'name' => 'Sidebar Widgets',
        		'id'   => 'sidebar-widgets',
        		'description'   => 'These are widgets for the sidebar.',
        		'before_widget' => '<div id="%1$s" class="widget %2$s">',
        		'after_widget'  => '</div>',
        		'before_title'  => '<h2>',
        		'after_title'   => '</h2>'
        	));
        }
    
    // Menu Register
        function register_my_menus() {
            register_nav_menus(
              array(
                'header-menu' => __( 'Header Menu' ),
                'extra-menu' => __( 'Extra Menu' )
              )
            );
        }
        add_action( 'init', 'register_my_menus' );

    // Themes Supports
       remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

	//Let WordPress manage the document title. / By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
    	add_theme_support('title-tag');

	// Thumbnail Support and Sizes
		add_theme_support('post-thumbnails');

	// Image sets
		if(isset($content_width)){
			$content_width = 1170; //pixels - Max Bootstrap width
		}



    // Script Register
        function theme_name_scripts() {
            wp_deregister_script('jquery');
            //Bootstrap 4.0.0
            wp_enqueue_style( 'mainStyle', get_template_directory_uri() . '/css/stylesheet.concat.min.css' );
            wp_enqueue_style( 'mainStyle-2', get_template_directory_uri() . '/css/stylesheet-2.css' );
            //Jquery 3.3.1.min - popper.js/1.12.9 - bootstrap/4.0.0
            wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/concat.min.js', array(), '1.0.0', true );
            //wp_enqueue_script('google-map-api','https://maps.googleapis.com/maps/api/js?key='.get_option('api_maps').'',array(), '1.0.0', false);
        }


        add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );


    //Include to Custom Posts Types
      include (TEMPLATEPATH . '/theme-settings/cpt.php' );
      include (TEMPLATEPATH . '/theme-settings/social-settings.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/wp-login-style.php' );
      //include (TEMPLATEPATH . '/theme-settings/pw-validator.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/extras.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/social-networks.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/login-page.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/erro-404.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/footer-custumize.php' );
      include (TEMPLATEPATH . '/theme-settings/inc/admin/customizers/custom-search.php' );
      //include (TEMPLATEPATH . '/theme-settings/widgets.php' );


      // Wp-Login.php customization stylesheet
         /* function my_login_stylesheet() {
              wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/style-login.css' );
          }
          add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );*/

      // Change the footer text
          function wptutsplus_admin_footer_text () {
              echo 'Tema desenvolvido por <br><a target="_blank" href="http://www.maiscode.com.br"><img src="' . get_template_directory_uri() . '/img/maiscode.png"></a>';
          }
          add_filter( 'admin_footer_text', 'wptutsplus_admin_footer_text' );
          
      // Admin styles
          function wptutsplus_admin_styles() {
              wp_register_style( 'wptuts_admin_stylesheet', get_template_directory_uri() . '/css/style-login.css' );
              wp_enqueue_style( 'wptuts_admin_stylesheet' );
          }
          add_action( 'admin_enqueue_scripts', 'wptutsplus_admin_styles' );
      

      // Custom Dashboard Widget
          add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
          function my_custom_dashboard_widgets() {
              global $wp_meta_boxes;
              wp_add_dashboard_widget('custom_help_widget', 'Área de Suporte', 'custom_dashboard_help');
          }
        // Dashboard Box
           function custom_dashboard_help() { ?>
              <h2 style="font-weight: 700!important; text-transform: uppercase;">Suporte  <strong>MAISCODE</strong></h2>
              <p>Precisa de Ajuda? Entre em contato com nosso suporte <a href="mailto:suporte@maiscode.com.br">contato@maiscode.com.br</a> ou <a target="_blank" href="http://www.maiscode.com.br">click aqui</a> para acessar nosso site ou nos de uma ligada <a href="#">(67) 3211-8509</a> . Estamos a sua disposição para te ajudar.</p>
              <p><strong>Equipe MaisCode</strong></p>
          <?php }
