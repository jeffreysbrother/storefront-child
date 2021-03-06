<?php


// get rid of wp_embed and other mystery thing
// I think removing these had a very big effect on load time
// but taking them out was causing an error in the queries plugin (the debugging one)

// function jc_deregister_scripts(){
  // wp_deregister_script( 'wp-embed' );
  // wp_deregister_script( 'storefront-skip-link-focus-fix' );
// }
// add_action( 'wp_footer', 'jc_deregister_scripts' );



// remove gravity form bootstrapper styles and scripts
function jc_remove_gravityforms_style() {
	// remove bootstrap cuz I already loaded that shit
	wp_dequeue_style('bootstrap_min_style');

	// I think I need this one...so hidden forms remain hidden
	// wp_dequeue_style('gforms_bootstrapper_style');

	// might need this gforms bootstrapper js
	// wp_dequeue_script('gforms_bootstrapper_js');

	// want to eliminate bootstrap.min.js...but how? YAY!!
	wp_dequeue_script('bootstrap_min_js');
}
add_action('wp_print_styles', 'jc_remove_gravityforms_style');



// load gform bootstrapper stuff conditionally (only on contact-us page)
function conditional_gform_bootstrapper() {
	if ( !is_page( 'contact-us' ) ) {
		wp_dequeue_style('gforms_bootstrapper_style');
		wp_dequeue_script('gforms_bootstrapper_js');
	}
}
add_action('wp_print_styles', 'conditional_gform_bootstrapper');



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



function hondaross_enqueue_styles_and_js() {
    wp_enqueue_style( 'bootstrap_styles', get_stylesheet_directory_uri() . "/vendor/bootstrap/css/bootstrap.min.css");
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/css/main.css',
        array( 'storefront-style', 'bootstrap_styles', 'storefront-woocommerce-style', 'gforms_bootstrapper_style'),
        wp_get_theme()->get('Version')
    );
    // wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . "/js/scripts.js", array( 'jquery' ), true );
}
add_action( 'wp_enqueue_scripts', 'hondaross_enqueue_styles_and_js' );



//  removing jquery-blockui was causing an error in the queries plugin (the debugging one)
function lean_pages_dequeue() {
	if ( is_page_template( 'template-front-nasty.php' ) ) {
		wp_dequeue_style( 'mashsb-styles' );
		wp_dequeue_style( 'socicon' );
		wp_dequeue_style( 'genericons' );
		wp_dequeue_style( 'fontawesome' );
		wp_dequeue_style( 'storefront-fonts' );
		// wp_deregister_script( 'jquery-blockui' );
	}
}
add_action( 'wp_enqueue_scripts', 'lean_pages_dequeue', 99 );

function lean_pages_dequeue_woo_storefront() {
	if ( is_page_template( 'template-front-nasty.php' ) ) {
		// dequeue storefront woo styles
	   	wp_dequeue_style('storefront-woocommerce-style');
	   	wp_deregister_style('storefront-woocommerce-style');
	   	// dequeue storefront styles
	   	wp_dequeue_style('storefront-style');
	   	wp_deregister_style('storefront-style');
	   	// re-enqueue custom styles for lean pages WITHOUT storefront/woo dependencies
	   	wp_dequeue_style( 'child-style' );
	   	wp_deregister_style( 'child-style' );
	   	wp_enqueue_style( 'child-style',
        	get_stylesheet_directory_uri() . '/css/main.css',
        	array( 'bootstrap_styles' ),
       		wp_get_theme()->get('Version')
    	);
	}
}
add_action('wp_enqueue_scripts','lean_pages_dequeue_woo_storefront', 25);

function child_manage_woocommerce_styles_lean() {
	//remove generator meta tag
	remove_action('wp_head', 'wp_generator');
	//first check that woo exists to prevent fatal errors
	if ( function_exists( 'is_woocommerce' ) ) {
	 	//dequeue scripts and styles if using some given template
		 if ( is_page_template( 'template-front-nasty.php' ) ) {
			 wp_dequeue_script( 'wc-add-to-cart' );
			 wp_dequeue_script( 'wc-cart-fragments' );
			 wp_dequeue_script( 'storefront-header-cart' );

		 }
	 }
}
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles_lean', 99 );



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
