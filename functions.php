<?php
function my_theme_enqueue_styles() {
	// enqueue bootstrap css
    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
    // enqueue child theme css
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



function remove_search(){
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
}
add_action( 'wp_head', 'remove_search' );



function remove_breadcrumbs(){
	remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 10 );
}
add_action( 'wp_head', 'remove_breadcrumbs' );



// function remove_product_sidebar(){
// 	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
// }
// add_action( 'wp_head', 'remove_product_sidebar' );



// function remove_related_products(){
// 	remove_action( 'woocommerce_after_single_product_summary hook', 'woocommerce_output_related_products', 20 );
// }
// add_action( 'wp_head', 'remove_related_products' );