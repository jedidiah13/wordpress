<?php
/** Code to make a custom meta input fields for products */
/** Jedidiah Fowler */
// Display Fields using WooCommerce Action Hook 
add_action( 'woocommerce_product_options_general_product_data', 'woocom_general_product_data_custom_field' );
add_action( 'woocommerce_product_options_shipping', 'woocom_shipping_product_data_custom_field' );
add_action( 'woocommerce_product_options_inventory_product_data', 'woocom_inventory_product_data_custom_field' );
// Create a custom text fields
// general product tab boxes
function woocom_general_product_data_custom_field() 
{ 
	// Brand Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ccrind_brand', 
			'label' => __( 'Brand:', 'woocommerce' ), 
			'placeholder' => 'Product brand here...', 
			'desc_tip' => 'true', 
            'description' => __( 'The Brand or Manufacturer of the item.', 'woocommerce' ) 
		) 
	);
	
	// MPN Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ccrind_mpn', 
			'label' => __( 'MPN or Model:', 'woocommerce' ), 
			'placeholder' => 'Model or mpn of the item...', 
			'desc_tip' => 'true', 
            'description' => __( 'The model number or mpn of the item.', 'woocommerce' ) 
		) 
	);
	
	// Warehouse Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_warehouse_loc', 
			'label' => __( 'WH Location:', 'woocommerce' ), 
			'placeholder' => 'Examples: D12, plant 2, etc...', 
			'desc_tip' => 'true', 
            'description' => __( 'Where is the item located in our facilities.', 'woocommerce' ) 
		) 
	);
	
	// Preparer Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_preparers_initials', 
			'label' => __( 'Lister:', 'woocommerce' ), 
			'placeholder' => 'Initials', 
			'desc_tip' => 'true', 
            'description' => __( 'These are the initials of the person who initially created the product.', 'woocommerce' ) 
		) 
	);
	
	// Preparer Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_tested', 
			'label' => __( 'Tested?:', 'woocommerce' ), 
			'placeholder' => 'Current tested status... tested, untested, etc...', 
			'desc_tip' => 'true', 
            'description' => __( 'Indicates if the item has been tested or not, with clarification if necessary.', 'woocommerce' ) 
		) 
	);
	
	// Video Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_video', 
			'label' => __( 'Video Link:', 'woocommerce' ), 
			'placeholder' => 'Paste Youtube link here...', 
			'desc_tip' => 'true', 
            'description' => __( 'Youtube link to video of the item.', 'woocommerce' ) 
		) 
	);
	
	// 360 Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_threesixty', 
			'label' => __( '360 Link:', 'woocommerce' ), 
			'placeholder' => 'Paste Auto 3D Direct (Fyuse) link here...', 
			'desc_tip' => 'true', 
            'description' => __( 'Fyuse link to 360 degree interaction with the item.', 'woocommerce' ) 
		) 
	);
	
	// Auction Tracking Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_auction', 
			'label' => __( 'Auction:', 'woocommerce' ), 
			'placeholder' => 'Auction Company for item...', 
			'desc_tip' => 'true', 
            'description' => __( 'Place the name of the Auction Company this item is listed under here.', 'woocommerce' ) 
		) 
	);
	// Auction Date Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_auction_date', 
			'type' => 'date', 
			'label' => __( 'Auction Date:', 'woocommerce' ), 
			'placeholder' => 'Date of Auction or sent to Auction...', 
			'desc_tip' => 'true', 
            'description' => __( 'Insert the date the item was sent to the auction company or the actual auction sale date here.', 'woocommerce' ) 
		) 
	);
	global $woocommerce, $post;
       $checkbox_value = get_post_meta( $post->ID, '_dnl_eBay', true );
       if( empty( $checkbox_value ) ){
       $checkbox_value = '';
       }
        woocommerce_wp_checkbox( 
        array( 
            'id'            => '_dnl_eBay', 
            'label'         => __('Do Not List on eBay', 'woocommerce' ), 
            'description'   => __( 'If checked, do not list on eBay', 'woocommerce' ),
            'value'         => $checkbox_value,
            )
        );
	// external url Text Field 
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ext_url', 
			'label' => __( 'External URL:', 'woocommerce' ), 
			'placeholder' => 'Paste MS Sales external url link here...', 
			'desc_tip' => 'true', 
            'description' => __( 'MS Sales link to the item.', 'woocommerce' ) 
		) 
	);
}
// shipping product tab boxes
function woocom_shipping_product_data_custom_field() 
{
    // Custom Shipping Required Text Field
	woocommerce_wp_text_input(
		array( 
			'id' => '_customship', 
			'label' => __( 'Custom Shipping Required', 'woocommerce' ), 
			'placeholder' => 'Enter 2 for local pickup only, 1 for custom shipping required, 3 for wire / cash only, leave empty for neither', 
			'desc_tip' => 'true', 
            'description' => __( 'Enter 2 for local pickup only, 1 for custom shipping required, 3 for wire / cash only, leave empty for neither, use 4 to label an item as not available', 'woocommerce' ) 
		) 
	);
    // pallet fee text field
    woocommerce_wp_text_input(
        array(
            'id' => '_cratefee', 
			'label' => __( 'Pallet Fee', 'woocommerce' ), 
			'placeholder' => '', 
			'desc_tip' => 'true', 
            'description' => __( 'If the item requires a special fee for being prepared for shipping, enter it here.', 'woocommerce' )
        )
    );
}
// inventory product tab boxes
function woocom_inventory_product_data_custom_field() { 
	// general extra data for any product text field
	woocommerce_wp_textarea_input(
		array( 
			'id' => '_extra_info', 
			'label' => __( 'Additional Info:', 'woocommerce' ), 
			'placeholder' => '', 
			'desc_tip' => 'true', 
            'description' => __( 'Add any item additional information here, for internal staff use.', 'woocommerce' ) 
		) 
	);
	
	// fixing data for any product text field
	woocommerce_wp_textarea_input(
		array( 
			'id' => '_fix_info', 
			'label' => __( 'Fixing Info:', 'woocommerce' ), 
			'placeholder' => '', 
			'desc_tip' => 'true', 
            'description' => __( 'Add any item fixing information here, for internal staff use. Type "clear" to empty out.', 'woocommerce' ) 
		) 
	);
}
// advanced area additional meta boxes
add_action( 'woocommerce_product_options_advanced', 'ccrind_adv_product_options');
function ccrind_adv_product_options(){
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_lsn', 
			'label' => __( 'LSN Account:', 'woocommerce' ), 
			'placeholder' => 'lsn1, lsn20, ccrind05, etc...', 
			'desc_tip' => 'true', 
            'description' => __( 'List the name of the account the item is listed under.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_lsnlink', 
			'label' => __( 'LSN Link:', 'woocommerce' ), 
			'placeholder' => 'http link to the item on LSN...', 
			'desc_tip' => 'true', 
            'description' => __( 'Put the http link to the item on LSN in this field.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_lsn_cost', 
			'label' => __( 'LSN Cost:', 'woocommerce' ), 
			'placeholder' => 'total amount spend on paid ad', 
			'desc_tip' => 'true', 
            'description' => __( 'List the total cost we have paid for LSN ads here.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_fbmp', 
			'label' => __( 'FBMP Link:', 'woocommerce' ), 
			'placeholder' => 'http link, multi (m), or exclude (x)...', 
			'desc_tip' => 'true', 
            'description' => __( 'Put the http link to the item on FBMP in this field. multi for multi product. exclude to exclude from listing.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_fbmp_cost', 
			'label' => __( 'FBMP Paid Cost:', 'woocommerce' ), 
			'placeholder' => 'total amount spend on boost', 
			'desc_tip' => 'true', 
            'description' => __( 'List the total cost we have paid for FBMP Boosting here.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_cl', 
			'label' => __( 'CL Link:', 'woocommerce' ), 
			'placeholder' => 'http link, http link, multi (m), or exclude (x)...', 
			'desc_tip' => 'true', 
            'description' => __( 'Put the http link to the item on CL in this field. m for multi product. x for no posting.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_cl_cost', 
			'label' => __( 'CL Paid Cost:', 'woocommerce' ), 
			'placeholder' => 'total amount spend on paid CL listings', 
			'desc_tip' => 'true', 
            'description' => __( 'List the total cost we have paid for CL listings here.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_cost', 
			'label' => __( 'Cost Paid:', 'woocommerce' ), 
			'placeholder' => 'Enter price here...', 
			'desc_tip' => 'true', 
            'description' => __( 'The Cost CCRIND paid for the item.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_select( 
		array( 
			'id' => '_soldby', 
			'label' => __( 'Sold by:', 'woocommerce' ), 
			'desc_tip' => 'true', 
            'description' => __( 'Put ws for webstore (wso for order but unpaid), ebay (ebayo for order but unpaid), fb for facebook, lsn, qbo (qboo for order but unpaid), auc (auco for sent but unsold) for auction.  This specifies which channel is credited with the sale.', 'woocommerce' ),
			'options' => array(
				''   => __( '', 'woocommerce' ),
				'ws'   => __( 'ws', 'woocommerce' ),
				'wso'   => __( 'ws', 'woocommerce' ),
				'ebay'   => __( 'ebay', 'woocommerce' ),
				'ebayo'   => __( 'ebay', 'woocommerce' ),
				'qbo'   => __( 'qbo', 'woocommerce' ),
				'qboo'   => __( 'qbo', 'woocommerce' ),
				'fb' => __( 'fb', 'woocommerce' ),
				'lsn'   => __( 'lsn', 'woocommerce' ),
				'auc' => __( 'auc', 'woocommerce' ),
				'auco' => __( 'auc', 'woocommerce' ),
				'keep' => __( 'keep', 'woocommerce' ),
				'fix' => __( 'fix', 'woocommerce' ),
				'scrap' => __( 'scrap', 'woocommerce' ),
			) 
		) 
	);
	
	// admin fields only
	if( current_user_can('administrator') )
	{
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ebayclass', 
			'label' => __( 'eBay Classified Link:', 'woocommerce' ), 
			'placeholder' => 'http link, multi (m), or exclude (x)...', 
			'desc_tip' => 'true', 
            'description' => __( 'Put the http link to the item on eBay Classified in this field. "multi" for multi product. "exclude" to exclude from listing.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ebayclass_cost', 
			'label' => __( 'eBay Classified Paid Cost:', 'woocommerce' ), 
			'placeholder' => 'total amount spend on ad', 
			'desc_tip' => 'true', 
            'description' => __( 'List the total cost we have paid for eBay Classified Ad here.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_solddate', 
			'label' => __( 'Sold date:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set when Sold by: is set.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_gallery_image_ids', 
			'label' => __( 'Image IDs:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set when an item is updated or published.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_product_tier', 
			'label' => __( 'Product Tier for Google Ads:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set when meta data is processed.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ccrind_price', 
			'label' => __( 'Meta Price for Google Ads:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set when product_tier is set.', 'woocommerce' ) 
		) 
	);
	
	// textarea to contain the entire short description with keywords
	woocommerce_wp_textarea_input(
		array( 
			'id' => '_sdcp', 
			'label' => __( 'Excerpt:', 'woocommerce' ), 
			'placeholder' => '', 
			'desc_tip' => 'true', 
			'class' => 'sdcp',
			'height' => '200px',
            'description' => __( 'This field contains the short description with category keywords appended. Autogenerated, do not edit.', 'woocommerce' ) 
		) 
	);
	
	woocommerce_wp_text_input( 
		array( 
			'id' => '_ebay_paid', 
			'label' => __( 'Meta Field to Mark as Paid for eBay order:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set in code.', 'woocommerce' ) 
		) 
	);
	woocommerce_wp_text_input( 
		array( 
			'id' => '_saved_ebay_transaction_id', 
			'label' => __( 'Meta Field to save ID from Paypal or CC for eBay order:', 'woocommerce' ), 
			'placeholder' => 'This field is set automatically.', 
			'desc_tip' => 'true', 
            'description' => __( 'This field is automatically set in code.', 'woocommerce' ) 
		) 
	);
		
	global $current_user;
	wp_get_current_user();
	$email = $current_user->user_email;
	if ($email == "dan@ccrind.com")
	{
		// textarea to contain dan's own personal memos
		woocommerce_wp_textarea_input(
		array( 
			'id' => '_note_dan', 
			'label' => __( 'Dan\'s Notes:', 'woocommerce' ), 
			'placeholder' => '', 
			'desc_tip' => 'true', 
			'class' => 'sdcp',
			'height' => '300px',
            'description' => __( 'This field contains a personal notes for the user Dan Tobitt', 'woocommerce' ) 
		) 
		);
	}
		
	}
}

// Hook to save the data value from the custom fields 
add_action( 'woocommerce_process_product_meta', 'woocom_save_general_proddata_custom_field', 10, 3 );
add_action( 'woocommerce_process_product_meta', 'woocom_save_shipping_proddata_custom_field' );
add_action( 'woocommerce_process_product_meta', 'woocom_save_inventory_proddata_custom_field' );
/** Hook callback function to save custom fields information (general tab)*/
function woocom_save_general_proddata_custom_field( $post_id ) 
{
	global $product;
	$tableupdate = array();
  // Save Text Brand
  $text_field = $_POST['_ccrind_brand'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_ccrind_brand', esc_attr( $text_field ) );
     update_post_meta( $post_id, '_ebay_brand', esc_attr( $text_field ) );
	 //update_post_meta( $post_id, 'itmSpecs_value_Brand', esc_attr( $text_field ) );
  }
	// Save Text MPN MODEL
  $text_field = $_POST['_ccrind_mpn'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_ccrind_mpn', esc_attr( $text_field ) );
	 update_post_meta( $post_id, '_ebay_mpn', esc_attr( $text_field ) );
  }
	// Save Text Location
  $text_field = $_POST['_warehouse_loc'];
  $text_field = strtoupper($text_field);
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_warehouse_loc', esc_attr( $text_field ) );
  }
	// Save Text Lister
  $text_field = $_POST['_preparers_initials'];
  $text_field = strtoupper($text_field);
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_preparers_initials', esc_attr( $text_field ) );
  }
	// Save Tested field
  $text_field = $_POST['_tested'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_tested', esc_attr( $text_field ) );
  }
	// Save Text YT Video
  $text_field = $_POST['_video'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_video', esc_attr( $text_field ) );
  }
	// Save Text Fyuse link
  $text_field = $_POST['_threesixty'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_threesixty', esc_attr( $text_field ) );
  }
	// Save Text Auction
  $text_field = $_POST['_auction'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_auction', esc_attr( $text_field ) );
  }
	// Save Text Auction date
  $text_field = $_POST['_auction_date'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_auction_date', esc_attr( $text_field ) );
  }

  // Checkbox
        $_checkbox = $_POST['_dnl_eBay'];
        update_post_meta( $post_id, '_dnl_eBay', $_checkbox );
	
  // Save external url
  $text_field = $_POST['_ext_url'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_ext_url', esc_attr( $text_field ) ); }
	
	// save product_tier and _ccrind_price
  	$price = $_POST['_regular_price'];
	$pricetier = "";
	
	if ( $price < 250 ){
		$pricetier = "u250";
	}
	elseif ( $price < 500 ){
		$pricetier = "u500";
	}
	elseif ( $price < 1000 ){
		$pricetier = "u1000";
	}
	else {
		$pricetier = "";
	}
	
	if( ! empty( $price ) || empty( $price ) ) {
		update_post_meta($post_id, '_product_tier', esc_attr( $pricetier ) );
		update_post_meta($post_id, '_ccrind_price', esc_attr( $price ) );
	}
}
//(shipping tab)
function woocom_save_shipping_proddata_custom_field( $post_id ) {
  // Save Text Field
  $text_field = $_POST['_customship'];
  $wgt = $_POST['_weight'];
  update_post_meta( $post_id, '_weight', wc_clean( $wgt ) );
  if ( $wgt > 99 || $wgt = "" || $wgt == 0 )
  {
	 if ( $text_field == "" ) { $text_field = 1; }
  }
	
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_customship', esc_attr( $text_field ) );
  }
    
  // Save Text Field2
  $text_field = $_POST['_cratefee'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $post_id, '_cratefee', esc_attr( $text_field ) );
  }
}
//(inventory tab)
function woocom_save_inventory_proddata_custom_field( $post_id ) {

	global $product;
  // Save extra info Field
  $textarea_field = $_POST['_extra_info'];
  if( ! empty( $textarea_field ) || empty( $textarea_field ) ) {
     update_post_meta( $post_id, '_extra_info', esc_attr( $textarea_field ) );
  }
	// Save fix info Field
  $textarea_field = $_POST['_fix_info'];
  if( ! empty( $textarea_field ) || empty( $textarea_field ) ) {
     update_post_meta( $post_id, '_fix_info', esc_attr( $textarea_field ) );
  }
}

// save the advanced meta box area data
add_action( 'woocommerce_process_product_meta', 'advanced_save_fields', 10, 2 );
function advanced_save_fields( $id, $post ){
	
	// Save Text Field LSN
  $text_field = $_POST['_lsn'];
  $text_field = strtolower($text_field);
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_lsn', esc_attr( $text_field ) );
  }
	// Save Text Field LSN Link
  $text_field = $_POST['_lsnlink'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_lsnlink', esc_attr( $text_field ) );
  }
	// Save Text Field LSN Cost
  $text_field = $_POST['_lsn_cost'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
	  
     update_post_meta( $id, '_lsn_cost', esc_attr( $text_field ) );
  }
	// Save Text Field FBMP Link
  $text_field = $_POST['_fbmp'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_fbmp', esc_attr( $text_field ) );
  }
	// Save Text Field FBMP Link
  $text_field = $_POST['_fbmp_cost'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_fbmp_cost', esc_attr( $text_field ) );
  }
	// Save Text Field CL Link
  $text_field = $_POST['_cl'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_cl', esc_attr( $text_field ) );
  }
	// Save Text Field CL Cost Link
  $text_field = $_POST['_cl_cost'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_cl_cost', esc_attr( $text_field ) );
  }
	// Save Text Field EBAY CLASSIFIED Link
  $text_field = $_POST['_ebayclass'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
	  
     update_post_meta( $id, '_ebayclass', esc_attr( $text_field ) );
  }
	// Save Text Field EBAY CLASSIFED COST
  $text_field = $_POST['_ebayclass_cost'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_ebayclass_cost', esc_attr( $text_field ) );
  }
	// Save Text Field Cost
  $text_field = $_POST['_cost'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_cost', esc_attr( $text_field ) );
  }
	// Save Text Field Sold by
  $text_field = $_POST['_soldby'];
  $text_field = strtolower($text_field);
  $text_field2 = date(get_option('date_format'));
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_soldby', esc_attr( $text_field ) );
	 update_post_meta( $id, '_solddate', esc_attr( $text_field2 ) );
  }
	
	// Save Text Field 
  $text_field = $_POST['_ebay_paid'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_ebay_paid', esc_attr( $text_field ) );
  }
	// Save Text Field 
  $text_field = $_POST['_saved_ebay_transaction_id'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_saved_ebay_transaction_id', esc_attr( $text_field ) );
  }
	
	// Save Text Field 
  $text_field = $_POST['_note_dan'];
  if( ! empty( $text_field ) || empty( $text_field ) ) {
     update_post_meta( $id, '_note_dan', esc_attr( $text_field ) );
  }
}

/** end code for custom fields - Jedidiah Fowler */
/*************************************************************************************************************************/
?>