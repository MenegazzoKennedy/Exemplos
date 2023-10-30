<?php
function my_custom_login_stylesheet() { 


    if(!get_theme_mod( 'logo_login' )){
      $logoLogin =  get_bloginfo('template_url') . "/img/logoOriginal.png";
    }else{
      $logoLogin = get_theme_mod( 'logo_login' );
    }
    if(!get_theme_mod( 'imagem_fundo_login' )){
      $imagemFundo =  get_bloginfo('template_url') . "/img/fotoFundo.png";
    }else{
      $imagemFundo = get_theme_mod( 'imagem_fundo_login' );
    }

    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' ); ?>
    <style type="text/css">
        .login h1 a {
          background-image: url(<?php echo $logoLogin; ?> )!important;
          background-position: center bottom!important;
          z-index: 1000;
          height:64px!important;
          width:255px!important;
          background-size: 200px 35px!important;
          background-repeat: no-repeat;
          padding-bottom: 30px!important;
        }
        .login form{
          background:  #<?php echo get_theme_mod('form_color'); ?> !important;
          border: 1px solid #<?php echo get_theme_mod('form_color'); ?> !important;
        }
        .wp-core-ui .button-primary{
          background: #<?php echo get_theme_mod('background_color'); ?> !important;
          border: 1px solid #<?php echo get_theme_mod('background_color'); ?> !important;
        }
       
        body, .login #backtoblog a, .login #nav, .login #nav a, .wp-core-ui .button-primary{
          color: #<?php echo get_theme_mod('font_color'); ?> !important;
        }
        body.login div#login {
          position: absolute;
          left: 60%;
          padding: 0;
        } 
        body.login {
          background-image: url(<?php echo $imagemFundo; ?> );
          background-repeat: no-repeat;
          background-size: 50%;
          background-color: #<?php echo get_theme_mod('background_color'); ?> ;
          background-position-x: initial;
        }
        @media (max-width: 767px){
          body.login{
            background-size: cover;
            width: 100%;
          }
          body.login div#login {
              position: unset;
              left: auto;
              padding: 8% 0 0;
          }
        } 
    </style>
<?php
}

//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'my_custom_login_stylesheet' );