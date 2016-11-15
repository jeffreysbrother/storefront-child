<?php

// This is how we would dequeue JavaScript. Not sure what the diff is between dequeue and deregister
// function remove_unnecessary_scripts() {
//     wp_dequeue_script( 'storefront-navigation' );
//     wp_deregister_script( 'storefront-navigation' );
//     wp_dequeue_script( 'storefront-skip-link-focus-fix' );
//     wp_deregister_script( 'storefront-skip-link-focus-fix' );
// }
// add_action( 'wp_print_scripts', 'remove_unnecessary_scripts' );


function my_theme_enqueue_styles() {
    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
    wp_enqueue_style( 'compiled_scss', get_stylesheet_directory_uri() . "/css/main.css");
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



add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	// this will remove the order comments ... also needed to comment out line in form-shipping.php to get rid of the heading
	// also removing the company name field on checkout page.
    unset($fields['order']['order_comments']);
    unset($fields['shipping']['shipping_company']);
    unset($fields['billing']['billing_company']);
    // hide all the other ones too, since we're only selling a digital download at the moment


    return $fields;

}



// this removes the reviews tab functionality
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
	    unset($tabs['reviews']);
	    return $tabs;
}
// relatedly, doing the above makes the "description" tab unnecessary, even though we still want to see the actual product description itself. so in the CSS file, we will hide .description_tab



// remove upsells (not working, so i'll do it with CSS) and related products
function eliminate_upsells() {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}
add_action('wp_head', 'eliminate_upsells');



// remove default sorting dropdown in StoreFront Theme ... on Shop page (before and after products)
function delay_remove() {
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}
add_action('init','delay_remove');



// remove handheld footer
function jk_remove_storefront_handheld_footer_bar() {
  remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
}
add_action( 'init', 'jk_remove_storefront_handheld_footer_bar' );



// remove sidebar on product page
function remove_storefront_sidebar_product_page() {
	if ( is_product() ) {
		remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
	}
}
add_action( 'get_header', 'remove_storefront_sidebar_product_page' );



// remove sidebar on shop page, apparently this is different than removing this on the product page, because here we cannot use is_product() or is_page()
function remove_storefront_sidebar_shop_page() {
	if( function_exists( 'is_shop' ) ) {
    	remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
	}
}
add_action( 'get_header', 'remove_storefront_sidebar_shop_page' );

