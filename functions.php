<?php

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
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


// this will remove the post meta info from the blog listing page *AND* the single post page
function remove_post_meta(){
	remove_action( 'storefront_single_post', 'storefront_post_meta', 20 );
	remove_action( 'storefront_loop_post', 'storefront_post_meta', 20 );
}
add_action( 'wp_head', 'remove_post_meta' );



// function remove_blog_nav(){
// 	remove_action( 'storefront_single_post_bottom', 'storefront_post_nav', 10 );
// }
// add_action( 'wp_head', 'remove_blog_nav' );


function remove_comments(){
	remove_action( 'storefront_single_post_bottom', 'storefront_display_comments', 20 );
}
add_action( 'wp_head', 'remove_comments' );



function remove_footer_credit(){
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
}
add_action( 'wp_head', 'remove_footer_credit' );



// this will remove the order comments ... also needed to comment out line in form-shipping.php to get rid of the heading
// also removing the company name field on checkout page.
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);
     unset($fields['shipping']['shipping_company']);
     unset($fields['billing']['billing_company']);
     return $fields;
}