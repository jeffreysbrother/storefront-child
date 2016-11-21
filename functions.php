<?php
/**
 * Optimize WooCommerce Scripts
 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
 */
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
 
function child_manage_woocommerce_styles() {
	//remove generator meta tag
	remove_action('wp_head', 'wp_generator');
	//first check that woo exists to prevent fatal errors
	if ( function_exists( 'is_woocommerce' ) ) {
	 	//dequeue scripts and styles
		 if ( is_page_template( 'template-front-nasty.php' ) ) {
			 wp_dequeue_style( 'storefront-woocommerce-style' );
			 wp_dequeue_style( 'jvcf7_style' );
			 wp_dequeue_style( 'mashsb-styles' );
			 wp_dequeue_style( 'socicon' );
			 wp_dequeue_style( 'genericons' );
			 wp_dequeue_style( 'fontawesome' );
			 wp_dequeue_script( 'wc-add-to-cart' );
			 wp_dequeue_script( 'wc-cart-fragments' );
			 wp_deregister_script( 'jquery-blockui' );
			 wp_dequeue_script( 'storefront-header-cart' );
			 wp_dequeue_script( 'jquery-form' );
			 wp_dequeue_script( 'jvcf7_jquery_validate' );
			 wp_dequeue_script( 'jvcf7_validation_custom' );
			 remove_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		 }
	 }
}



/**
 * Remove Contact Form 7 scripts + styles unless we're on the contact page
 * 
 */
add_action( 'wp_enqueue_scripts', 'ac_remove_cf7_scripts' );

function ac_remove_cf7_scripts() {
	if ( !is_page('contact') ) {
		wp_deregister_style( 'contact-form-7' );
		wp_deregister_script( 'contact-form-7' );
	}
}



 // Move jQuery to the footer. 
function wpse_173601_enqueue_scripts() {
    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );
    wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'wpse_173601_enqueue_scripts' );



// this removes some inline styles but not all woocommerce styles, I guess
function hondaross_remove_storefront_standard_functionality() {
	set_theme_mod('storefront_styles', '');
	set_theme_mod('storefront_woocommerce_styles', '');  
}
add_action( 'init', 'hondaross_remove_storefront_standard_functionality' );



// this will dequeue the main styles.css file, since I'm using the compiled scss in css/main.css
function project_dequeue_styles() {
    wp_dequeue_style( 'storefront-child-style' );
    wp_deregister_style( 'storefront-child-style' );
}
add_action( 'wp_print_styles', 'project_dequeue_styles' );



function hondaross_enqueue_styles() {
    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/css/main.css',
        array( 'storefront-style', 'bootstrap_styles', 'storefront-woocommerce-style' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'hondaross_enqueue_styles' );



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

