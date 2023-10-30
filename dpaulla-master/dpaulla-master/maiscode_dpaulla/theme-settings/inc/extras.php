<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package rockcontent

 
 */


if ( ! function_exists('rock_get_social_networks')) {
    function rock_get_social_networks()
    {
        $networks = array('facebook', 'twitter', 'instagram', 'pinterest', 'youtube', 'linkedin', 'whatsapp');
        $social   = array();
        foreach ($networks as $network) {
            $link = get_theme_mod('social_' . $network);
            if ( ! empty($link)) {
                $social[] = array(
                    'slug' => $network,
                    'url'  => $link
                );
            }
        }

        return $social;
    }
}

if ( ! function_exists('rock_map_social_icon')) {
    function rock_map_social_icon($slug)
    {
        switch ($slug) {
            case 'facebook':
                return 'fa-facebook-official';
                break;
            case 'twitter':
                return 'fa-twitter';
                break;
            case 'instagram':
                return 'fa-instagram';
                break;
            case 'linkedin':
                return 'fa-linkedin';
                break;
            case 'pinterest':
                return 'fa-pinterest';
                break;
            case 'youtube':
                return 'fa-youtube-play';
                break;
            case 'whatsapp':
                return 'fa-whatsapp';
                break;
        }
    }
}
