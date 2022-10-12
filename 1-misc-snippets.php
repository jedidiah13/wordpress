<?php
/* add css animation sheet */
add_action( 'wp_enqueue_scripts', 'wpb_animate_styles' ); 
function wpb_animate_styles() { 
	wp_enqueue_style( 'animate-css', get_stylesheet_directory_uri() . '/css/animate.css', '3.5.0', 'all'); 
}
/********************************************************************************************/

/* enqueue copy to clipboard js */
add_action( 'wp_enqueue_scripts', 'load_responsive_javascript' );
function load_responsive_javascript() { 
	wp_enqueue_script( 'clipboard', get_stylesheet_directory_uri() . '/js/clipboard.js', array( 'jquery' ), '1.0.0' ); 
}

/********************************************************************************************/

// add revision support
add_filter( 'woocommerce_register_post_type_product', 'wpse_modify_product_post_type' );
function wpse_modify_product_post_type( $args ) { 
	$args['supports'][] = 'revisions'; 
	return $args;
}
/********************************************************************************************/

/* add shop base area for tax calculation */
add_filter( 'woocommerce_countries_base_postcode', 'create_zip' );
function create_zip() { return "37388"; }
add_filter( 'woocommerce_countries_base_postcode', 'create_city' );
function create_city() { return "TULLAHOMA"; }

/********************************************************************************************/

// manually remove reviews tab
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) { 
		unset($tabs['reviews']); 
		return $tabs; 
}

/********************************************************************************************/

// ensure black ops font is working throughout
add_action( 'wp_enqueue_scripts', 'add_google_fonts' );
function add_google_fonts() { 
	wp_enqueue_style( 'add_google_fonts', 'https://fonts.googleapis.com/css?family=Black+Ops+One&display=swap', false ); 
}

/********************************************************************************************/

/* remove price for out of stock items */
add_filter( "woocommerce_variable_sale_price_html", "theanand_remove_prices", 10, 2 );
add_filter( "woocommerce_variable_price_html", "theanand_remove_prices", 10, 2 );
add_filter( "woocommerce_get_price_html", "theanand_remove_prices", 10, 2 );
function theanand_remove_prices( $price, $product ) {
    if (  ! is_admin() && ! $product->is_in_stock() ) { $price = ""; } return $price; 
}

/********************************************************************************************/

// remove the display of the short description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

/********************************************************************************************/

/* hide add to cart button for item id 65139 SKU 1975-F, general listing for poly boxes */
add_filter('woocommerce_is_purchasable', 'my_woocommerce_is_purchasable', 10, 2);
function my_woocommerce_is_purchasable($is_purchasable, $product) {
	//
	return ($product->id == 65139 ? false : $is_purchasable);
}

/********************************************************************************************/
// add ebay order number to search data for admin orders
add_filter( 'woocommerce_shop_order_search_fields', 'woocommerce_shop_order_search_order_total' );
   function woocommerce_shop_order_search_order_total( $search_fields ) {
       $search_fields[] = '_ebayID'; // add ebay order number to search
	   $search_fields[] = '_ccrID'; // add ebay order number to search
       return $search_fields;
}
/********************************************************************************************/
add_filter( 'woocommerce_email_order_items_table', 'sww_add_images_woocommerce_emails', 10, 2 );
function sww_add_images_woocommerce_emails( $output, $order ) {
	// set a flag so we don't recursively call this filter
	static $run = 0;
	// if we've already run this filter, bail out
	if ( $run ) { return $output; }
	$args = array(
		'show_image'   	=> true,
		'image_size'    => array( 100, 100 ),
		'show_sku'      => true,
	);
	// increment our flag so we don't run again
	$run++;
	// if first run, give WooComm our updated table
	return $order->email_order_items_table( $args );
}
/********************************************************************************************/
?>