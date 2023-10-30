<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="robots" content="follow,all" />
    <meta http-equiv="Content-Language" content="pt-br" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.png" type="image/png"/>

    <?php wp_head(); ?>
    <?php echo get_option('tag_head'); ?>
</head>
<body <?php body_class(); ?>>
    <?php echo get_option('tag_body'); ?>

    <header id="secHeader"> 
        <!-- Desktop -->
        <div class="d-none d-lg-block sec-header-desktop">
            <div class="container header-desktop">
                <div class="row sec-header-desktop-row">
                   <div class="col-2 sec-header-desktop-col-2">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Logo-Dpaula.png" alt="<?php bloginfo('name'); ?>" class="align-middle" alt="">
                        </a>
                   </div>         
                    <div class="menu-link col-10">
                        <?php
                        $defaults = array(
                            'theme_location'  => 'header-menu',
                            'container'       => false,
                            'menu_class'      => 'list-inline list-unstyled box-menu-header',
                            'menu_id'         => 'menu',
                            'echo'            => true
                        );
                        wp_nav_menu($defaults);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .btn_header_menu .fa-times{
                font-size: 1.5em;
                width: 1em;
            }
        </style>
        <!-- Mobile -->
        <nav class="navbar navbar-expand-lg navbar-dark d-lg-none sec-header-mobile">
            <a class="navbar-brand" href="#">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/Logo-Dpaula.png" alt="<?php bloginfo('name'); ?>" class="align-middle" alt="">
            </a>
          <button class="navbar-toggler sec-header-mobile-btn btn_header_menu" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <i class="fas navbar-toggler-icon"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <?php
                $defaults = array(
                    'theme_location'  => 'header-menu',
                    'container'       => false,
                    'menu_class'      => 'list-inline list-unstyled box-menu-header',
                    'menu_id'         => 'menu',
                    'echo'            => true
                );
                wp_nav_menu($defaults);
                ?>
            </div>
          </div>
        </nav>
        <?php
        function collapseMenu(){
        ?>
        <script type="text/javascript">
            $('.btn_header_menu').click(function(){
                if ($(this).find('i').hasClass("fa-times") && !$("#secHeader .sec-header-mobile .btn_header_menu").hasClass("collapsed")) { //se tem olho aberto
                    $(this).find('i').removeClass("fa-times"); //remove classe olho fechado
                    $(this).find('i').addClass("navbar-toggler-icon"); //coloca classe olho fechado
                } else { //senão
                    $(this).find('i').removeClass("navbar-toggler-icon"); //remove classe olho fechado
                    $(this).find('i').addClass("fa-times"); //coloca classe olho fechado
                }
            }); 
            $(document).ready(function(){
                var scroll = $(window).scrollTop();
                if (scroll > 20) { 
                    $('#secHeader .sec-header-desktop').addClass('sec-header-desktop-baixo');
                }
                $(window).scroll(function() {
                    scroll = $(window).scrollTop();
                    if (scroll > 20) { 
                        $('#secHeader .sec-header-desktop').addClass('sec-header-desktop-baixo');
                    }else{
                        $('#secHeader .sec-header-desktop').removeClass('sec-header-desktop-baixo');
                    }
                });
            });
        </script>
        <?php
        }
        add_action('wp_footer','collapseMenu',300);?>
    </header><!--fim header-->