<?php
// Change the look of the MS Sales single product page
add_filter( 'woocommerce_product_meta_start', 'default_short_description_external', 10, 1);
function default_short_description_external( )
{
    global $product;
	
	$sku = $product->get_sku();
	$ft = substr($sku, 0, 2);
	$id = $product->id;
	
	// for external products handle differetly
	if( $ft == "MS" )
	{
		$link = get_post_meta( $id, '_ext_url', true );
		$loc = get_post_meta( $id, '_warehouse_loc', true );
		
		if ( substr($loc, 0, 2) == "MS" ) {
			$start = "<h4 style=\"color: #73505B; font-size:20px; line-height:28px;\">* Price does not include applicable taxes * <br>
			<br><span style=\"color: #969696; font-size:16px; line-height:28px;\">More pictures and information found at mainstsales.com</span>
			<br><a class='single_item_ext_url' href='$link'>SEE ON MAIN STREET SALES</a><br>
			<br><span style=\"color: #969696; font-size:16px; line-height:28px;\">Located in Huntland, TN</span>
			<br><span style=\"color: #969696; font-size:16px; line-height:28px;\">Contact to Buy:</span>
			<br><a class=\"call-button\" href=\"tel:9318105053\">Call 931-810-5053</a>
			<br>
			<br><a class=\"email-button\" href=\"mailto:info@mainstsales.com\">Email info@mainstsales.com</a>
			<br>
			<br><a class=\"contact-button\" href=\"https://www.mainstsales.com/contact/\" rel=\"noopener noreferrer\" target=\"_blank\">Fill Out Contact Form</a></h4>
			<span style=\"color: #969696; font-size:16px; line-height:28px;\">Please mention the SKU number below.</span>";
		}
		else {
			$start = "<h4 style=\"color: #73505B; font-size:20px; line-height:28px;\">* Price does not include applicable taxes * <br>
			<br><span style=\"color: #969696; font-size:16px; line-height:28px;\">Located in Tullahoma, TN</span>
			<br><span style=\"color: #969696; font-size:16px; line-height:28px;\">Contact to Buy:</span>
			<br><a class=\"call-button\" href=\"tel:9315634704\">Call (931) 563-4704</a>
			<br>
			<br><a class=\"email-button\" href=\"mailto:sales@ccrind.com\">Email sales@ccrind.com</a>
			<br>
			<br><a class=\"contact-button\" href=\"https://www.ccrind.com/contact/\" rel=\"noopener noreferrer\" target=\"_blank\">Fill Out Contact Form</a></h4>
			<span style=\"color: #969696; font-size:16px; line-height:28px;\">Please mention the SKU number below.</span>";
		}
        
		echo $start;
		echo "<br><br><br>";
	}
}

/* removed the add to cart button throughout woocommerce for MAIN STREET Sales products - Jedidiah 8-9-19, updated 1-27-22 */
add_filter( 'woocommerce_is_purchasable', 'pm_sales_item_sale_button_removal', 10, 2);
function pm_sales_item_sale_button_removal($is_purchaseable, $product)
{
	$sku = $product->get_sku();
	$ft = substr($sku, 0, 2);
	$custom = get_post_meta( $product->get_id(), '_customship', true );
	
	if( $ft == "MS" || $custom == 4 ) {
		$is_purchaseable = false; }
	//if( $custom == 4 ) {
	//	$is_purchaseable = false; }
	
	return $is_purchaseable;
}
?>