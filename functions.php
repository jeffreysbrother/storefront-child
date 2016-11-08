<?php
function my_theme_enqueue_styles() {

    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
