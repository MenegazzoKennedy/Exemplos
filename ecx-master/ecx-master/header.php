<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="robots" content="follow,all" />
    <meta http-equiv="Content-Language" content="pt-br" />
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/shotcut.png" type="image/png"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style type="text/css">
        @font-face {
            font-family: 'Zurich Lt BT';
            src: url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/ZuricLt__.woff') format('woff'), 
                url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/ZuricLt__.ttf')  format('truetype'); 
        }
        @font-face {
            font-family: 'Zurich BT';
            src: url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/ZuricRm__.woff') format('woff'), 
                url('<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/ZuricRm__.ttf')  format('truetype'); 
        }
       
    </style>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    
    <?php echo get_option('tag_head'); ?>
</head>

<body <?php body_class(); ?>>
    <?php echo get_option('tag_body');
    if(get_field('exibir_topo') == 'exibir'){
        get_template_part( 'inc/template', 'header'); 
    }
?>