<?php

    /**
     * Véritable fichier commun à tous
     * au sein du thème.
     */

    $_GET       = array_map('stripslashes_deep', $_GET);
    $_POST      = array_map('stripslashes_deep', $_POST);
    $_COOKIE    = array_map('stripslashes_deep', $_COOKIE);
    $_SERVER    = array_map('stripslashes_deep', $_SERVER);
    $_REQUEST   = array_map('stripslashes_deep', $_REQUEST);

    define('THEME_PATH', get_template_directory() . '/');
    define('THEME_URI', get_template_directory_uri() . '/');

    define('THEME_CSS_URI', THEME_URI . 'assets/css/');
    define('THEME_JS_URI', THEME_URI . 'assets/js/');
    define('THEME_IMG_URI', THEME_URI . 'assets/img/');

    $custom_logo_id = get_theme_mod( 'custom_logo' ); $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    define('LOGO_URI', $image[0]);


    /**
 * Includes
 */
    require_once THEME_PATH . 'class/shortcodes.php';

    /**
     * Supports
     */
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    /**
     * Charger les scripts / styles principaux
     */
    add_action('wp_enqueue_scripts', function(){
       wp_enqueue_style("google-font", "https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800");
       wp_enqueue_style('style', THEME_CSS_URI . 'normalize.css');
       wp_enqueue_style('normalize', THEME_CSS_URI . 'style.css');
       wp_enqueue_style('fontello', THEME_CSS_URI . 'fontello/css/fontello.css');
       wp_enqueue_style('custom', THEME_URI . 'style.css');

        wp_enqueue_script('jquery');
        wp_enqueue_script('custom', THEME_JS_URI . 'script.js');
    });

    /**
     * Menu principal
     */
    register_nav_menu('Menu principal', 'Menu principal');



