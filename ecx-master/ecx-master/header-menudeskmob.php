<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="robots" content="follow,all" />
    <meta http-equiv="Content-Language" content="pt-br" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.png" type="image/png"/>

    <?php wp_head(); ?>
    <?php echo get_option('tag_head'); ?>
</head>

<body <?php body_class(); ?>>
    <?php echo get_option('tag_body'); ?>

    <header id="secHeader"> 
        <!-- Desktop -->
        <div class="d-none d-lg-block">
            <div class="container header-desktop">
                <div class="row">
                   <div class="col-2">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>" class="align-middle" alt="">
                        </a>
                   </div>         
                    <div class="menu-link col-8">
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
                    <div class="col-2 search-home">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
            <a class="navbar-brand" href="#">
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/maiscode.png" alt="<?php bloginfo('name'); ?>" class="align-middle" alt="">
            </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
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
    </header><!--fim header-->
