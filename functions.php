<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 ); 
// END ENQUEUE PARENT ACTION
/********************************************************************************************/

// add short misc snippets code (seperate code file reference) 
require_once( __DIR__ . '/ccrind-functions/1-misc-snippets.php');
// remove top admin bar links (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/remove-top-admin-links.php');
// admin notice to help with searches (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/general-admin-notices.php');
// code to add / update / save our own custom meta fields to our woocommerce products
require_once( __DIR__ . '/ccrind-functions/custom-meta-fields.php');
// code to document content changes to products (underlines additions, strikethrough removals) (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/document-product-changes.php');
// code to show custom order fields on admin order page (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/order-custom-meta-fields.php');
// code to create custom meta fields on the checkout page (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/checkout-custom-fields.php');
// code to auto generate the short description from other data (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/generate-prefill-and-short-desc.php');
// code to add content (title, youtube, etc) to listings new style  (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/add-content-new-style.php');
// code to change the disclaimer at the bottom of products (ccr and pm) (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/ccr-disclaimer.php');
// code to change pmsales products style (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/ms-sales-products-style.php');
// code to order status processing, pending, on-hold, complete, cancelled, etc (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/order-status-update-bare.php');
// code to hold ebay order at processing status once set as such (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/ebay-hold-processing.php');
// code to alter search on admin lists, mainly product searches (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/search-mods.php');
// code to style css items (seperate code file reference)
require_once( __DIR__ . '/ccrind-functions/css-style-main.php');
// code to handle the pressing of the update button for both orders and products
require_once( __DIR__ . '/ccrind-functions/update-button.php');
// code to handle adding filters to the products backend
require_once( __DIR__ . '/ccrind-functions/filters-products.php');
	
/********************************************************************************************/
/**
 * Font Awesome Kit Setup
 * 
 * This will add your Font Awesome Kit to the front-end, the admin back-end,
 * and the login screen area.
 */
if (! function_exists('fa_custom_setup_kit') ) {
  function fa_custom_setup_kit($kit_url = '') {
    foreach ( [ 'wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts' ] as $action ) {
      add_action(
        $action,
        function () use ( $kit_url ) {
          wp_enqueue_script( 'font-awesome-kit', $kit_url, [], null );
        }
      );
    }
  }
}
fa_custom_setup_kit('https://kit.fontawesome.com/5f86af4456.js');
/********************************************************************************************/

// Add recipient to customer invoice for processing orders
add_filter( 'woocommerce_email_recipient_customer_invoice', 'send_email_customer_invoice_all', 10, 2 );
function send_email_customer_invoice_all( $recipient, $order = false ) {
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) 
        return $recipient;
        
		$add_emails = get_post_meta( $order->get_id(), '_add_emails', true );
        $recipient .= ",$add_emails";
    
    return $recipient;
}

/********************************************************************************************/
/* use customship code 4 for items thate are unavailable (mass sending to Compass) */
add_action( 'woocommerce_single_product_summary', 'custom_before_add_to_cart_btn' );
function custom_before_add_to_cart_btn() {
	global $product;
	$custom = get_post_meta( $product->get_id(), '_customship', true );
	if( $custom == 4 ) {
		echo "<p style='font-size: 24px;'>* Item Currently Unavailable *</p><br>"; }
	if ( $custom == 5 ) {
		if ( $product->get_id() == 146062 )
		{
			// for CCR 15844 only
			echo "<p style='font-size: 22px;'>* Please contact us directly to Buy *</p>";
			echo "<p style='font-size: 22px;'>* Customer must setup own shipping or arrange for Local Pickup *</p>";
			echo "<p style='font-size: 24px;'>Call: <a href='tel:9315634704'>931-563-4704</a></p>";
			echo "<p style='font-size: 24px;'>Email: <a href='mailto:sales@ccrind.com'>sales@ccrind.com</a></p><br>";
		}
		else {
		echo "<p style='font-size: 22px;'>* Please contact us directly to Buy *</p>";
		echo "<p style='font-size: 24px;'>Call: <a href='tel:9315634704'>931-563-4704</a></p>";
		echo "<p style='font-size: 24px;'>Email: <a href='mailto:sales@ccrind.com'>sales@ccrind.com</a></p><br>"; }
	}
	if ( $custom == 6 ) {
		$GDLot = get_post_meta( $product->get_id(), '_govdeals', true );
		echo "<p style='font-size: 22px;'>* Item under Auction at GovDeals *</p>";
		echo "<p style='font-size: 20px;'><a href='https://www.govdeals.com/index.cfm?fa=Main.Item&acctid=25092&itemid=$GDLot' rel='noopener noreferrer' target='_blank'>Click HERE to visit GovDeals auction.</a></p><br>";
	}
	
	$id = $product->get_id();
	if( $id == 114741 ) {
		echo "<p style='font-size: 24px;'>* Please see the last 2 pictures (ORDER FORM) to see all the options available and prices. Final price may vary from the above $275 listed price. *</p><br>"; }
}
/*************************************************************************************************************************/

/* change the image size on the ADMIN list of products - Jedidiah 7-30-19 */
add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() {
  echo '<style>
    table.wp-list-table td.column-thumb img {
    max-width: 150px;
    max-height: 150px;
	}
	table.wp-list-table .column-thumb {
    width: 152px;
	}
	table.wp-list-table .column-name {
    width: 15%;
	}
  </style>';
}
/*************************************************************************************************************************/

/* prevent saving as pending (and therefor publish) of item if fields are not filled out validation 
add_action('save_post_product', 'completion_validator', 10, 3);
function completion_validator($post_id, $post, $update) 
{
    // don't do on autosave or when new posts are first created
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || $post->post_status == 'auto-draft' )
	{
		return $post_id;
	}
	
	// don't do if not a product
	$type = get_post_type($post_id);
	if ( $type == 'product' )
	{
		// init completion marker (add more as needed) FLAG
    	$brand_missing = false;
		$mpn_missing = false;
		$uncategorized = false;

    	// retrieve meta to be validated
		$brand = $_POST['_ccrind_brand'];
		$mpn = $_POST['_ccrind_mpn'];
		// retrieve post categories
		$terms = $_POST['product_cat'];
		foreach ( $terms as $term ) {
			$categories[] = $term->slug;
		}
	
    	// just checking it's not empty - you could do other tests...
    	if ( empty( $brand ) ) {
        	$brand_missing = true;
    	}
		if ( empty( $mpn ) ) {
        	$mpn_missing = true;
    	}
		// check for uncategorized category
		if ( in_array( 'uncategorized', $categories ) ) 
		{
			$uncategorized = true;
		}

    // on attempting to save as pending - check for completion and intervene if necessary
    if ( ( isset( $_POST['pending'] ) || isset( $_POST['save'] ) ) && $_POST['post_status'] == 'pending' ) 
	{
        //  don't allow publishing while any of these are incomplete
		// brand is missing
        if ( $brand_missing ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications', json_encode(array('error', '<font color="red"><b>Brand</b></font> missing from Product data, General tab. <font color="red">NOT PENDING</font>. Sent to <font color="red">DRAFT</font> Status.', FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
		// mpn is missing
		if ( $mpn_missing ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications2', json_encode(array('error', '<font color="red"><b>MPN or Model</b></font> missing from Product data, General tab. <font color="red">NOT PENDING</font>. Sent to <font color="red">DRAFT</font> Status.', FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
		// if uncategorized is a category
		if ( $uncategorized ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications3', json_encode(array('error', '<font color="red"><b>Uncategorized</b></font> is checked in Product categories. <font color="red">NOT PUBLISHED</font>. Sent to <font color="red">DRAFT</font> Status.', FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
    }
	
	// on attempting to publish - check for completion and intervene if necessary
    if ( ( isset( $_POST['publish'] ) || isset( $_POST['save'] ) ) && $_POST['post_status'] == 'publish' ) 
	{
        //  don't allow publishing while any of these are incomplete
		// if brand incomplete
        if ( $brand_missing ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications', json_encode(array('error', '<font color="red"><b>Brand</b></font> missing from Product data, General tab. <font color="red">NOT PUBLISHED</font>. Sent to <font color="red">PENDING</font> Status.', FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
		// if mpn incomplete
		if ( $mpn_missing ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications2', json_encode(array('error', "<font color=\"red\"><b>MPN or Model</b></font> missing from Product data, General tab. <font color=\"red\">NOT PUBLISHED</font>. Sent to <font color=\"red\">PENDING</font> Status.", FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
		// if uncategorized is a category
		if ( $uncategorized ) 
		{
            global $wpdb;
            $wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $post_id ) );
            // filter the query URL to change the published message
            add_filter( 'redirect_post_location', create_function( '$location','return add_query_arg("message", "4", $location);' ) );
			
			update_option('my_notifications3', json_encode(array('error', '<font color="red"><b>Uncategorized</b></font> is checked in Product categories. <font color="red">NOT PUBLISHED</font>. Sent to <font color="red">PENDING</font> Status.', FALSE)));
            # And redirect
            header('Location: '.get_edit_post_link($post_id, 'redirect'));
        }
  
    } // close on attempting to publish - check for completion and intervene if necessary
		
	} // close if product code
}

/**
*   Shows custom notifications on wordpress admin panel
*
add_action( 'admin_notices', 'my_notification' );
function my_notification() {
    $notifications = get_option('my_notifications');
	$note2 = get_option('my_notifications2');
	$note3 = get_option('my_notifications3');
	$note4 = get_option('my_notifications4');

    if (!empty($notifications)) {
        $notifications = json_decode($notifications);
        #notifications[0] = (string) Type of notification: error, updated or update-nag
        #notifications[1] = (string) Message
        #notifications[2] = (boolean) is_dismissible?
        switch ($notifications[0]) {
            case 'error': # red
            case 'updated': # green
            case 'update-nag': # ?
                $class = $notifications[0];
                break;
            default:
                # Defaults to error just in case
                $class = 'error';
                break;
        }

        $is_dismissable = "";
        if (isset($notifications[2]) && $notifications[2] == true)
            $is_dismissable = 'is_dismissable';

        echo '<div class="'.$class.' notice '.$is_dismissable.'">';
           echo '<p>'.$notifications[1].'</p>';
        echo '</div>';

        # Let's reset the notification
        update_option('my_notifications', false);
    }
	
	if (!empty($note2)) {
        $note2 = json_decode($note2);
        #$note2[0] = (string) Type of notification: error, updated or update-nag
        #$note2[1] = (string) Message
        #$note2[2] = (boolean) is_dismissible?
        switch ($note2[0]) {
            case 'error': # red
            case 'updated': # green
            case 'update-nag': # ?
                $class = $note2[0];
                break;
            default:
                # Defaults to error just in case
                $class = 'error';
                break;
        }

        $is_dismissable = "";
        if (isset($note2[2]) && $note2[2] == true)
            $is_dismissable = 'is_dismissable';

        echo '<div class="'.$class.' notice '.$is_dismissable.'">';
           echo '<p>'.$note2[1].'</p>';
        echo '</div>';

        # Let's reset the notification
        update_option('my_notifications2', false);
    }
	
	if (!empty($note3)) {
        $note3 = json_decode($note3);
        #$note3[0] = (string) Type of notification: error, updated or update-nag
        #$note3[1] = (string) Message
        #$note3[2] = (boolean) is_dismissible?
        switch ($note3[0]) {
            case 'error': # red
            case 'updated': # green
            case 'update-nag': # ?
                $class = $note3[0];
                break;
            default:
                # Defaults to error just in case
                $class = 'error';
                break;
        }

        $is_dismissable = "";
        if (isset($note3[2]) && $note3[2] == true)
            $is_dismissable = 'is_dismissable';

        echo '<div class="'.$class.' notice '.$is_dismissable.'">';
           echo '<p>'.$note3[1].'</p>';
        echo '</div>';

        # Let's reset the notification
        update_option('my_notifications3', false);
    }
}
/* end product validation for publishing */
/*************************************************************************************************************************/

/* add mobile contact form notice between product start and product description */
add_action( 'woocommerce_share', 'add_mobile_contact' );
function add_mobile_contact()
{
	global $product;
	$id = $product->get_id();
	$sku = $product->get_sku();

	echo '<div class="mobile_contact"><br>
			<br>
			If you have any questions or concerns regarding this product (<span style="color:#a08100">SKU: ' . $sku . '</span>), please use the <a href="#contact_form_link">Contact Form</a> located below the "Related Products" section, call, or email.<br>
			<br>
			<a class="contact_scroll_link" href="#contact_form_link">GO TO CONTACT FORM</a><br>
			<a class="contact_button_desk" href="tel:9315634704" rel="nofollow">CALL (931) 563-4704</a><br>
			<a class="contact_button_desk2" href="mailto:sales@ccrind.com">EMAIL sales@ccrind.com</a><br>
			<a class="cat_scroll_link" href="#cat_link">SEE ALL PRODUCT CATEGORIES</a></div>';
}
/*************************************************************************************************************************/
/** code to change the appearance of the single product page in the webstore */
/** Jedidiah Fowler */
// youtube link add button, add category button
add_action( 'woocommerce_after_add_to_cart_button', 'add_video' );
function add_video()
{
	global $product;
	$id = $product->get_id();
	$vlink = get_post_meta( $id, '_video', true );
	
	echo "<br><br><br>";
	
	if ( $vlink != "" )
	{
			echo "<br>
			<a class='admin_link_yt_single'
			href='$vlink' rel='noopener noreferrer' target='_blank'>WATCH VIDEO OF ITEM</a>";
	}

	$postProductTerm = wp_get_post_terms( $id, 'product_cat' );
	
	if ($postProductTerm && ! is_wp_error ( $postProductTerm ) )
	{
		$postCat = array_shift( $postProductTerm );
		$primary_cat_slug = $postCat->slug;
		$href = "https://ccrind.com/product-category/";
		$newhref = $href . $primary_cat_slug . "/";
		$line = "See all our $postCat->name";
		$line = strtoupper($line);
		
		echo "<br><br>
			<a class='category-button'
			href='$newhref' rel='noopener noreferrer' target='_blank'>$line</a>";
	}
}
/*************************************************************************************************************************/

// put the category button after Related Products too
add_action( 'woocommerce_after_single_product', 'add_category' );
function add_category()
{
	global $product;
	$id = $product->get_id();
	$sku = $product->get_sku();
	
	$postProductTerm = wp_get_post_terms( $id, 'product_cat' );
	
	if ($postProductTerm && ! is_wp_error ( $postProductTerm ) )
	{
		$postCat = array_shift( $postProductTerm );
		$primary_cat_slug = $postCat->slug;
		$href = "https://ccrind.com/product-category/";
		$newhref = $href . $primary_cat_slug . "/";
		$line = "See all our $postCat->name";
		$line = strtoupper($line);
		
		// include id for mobile scroll link
		echo "<br><br>
			<a id='contact_form_link' class='category-button'
			href='$newhref' rel='noopener noreferrer' target='_blank'>$line</a>
			<br>";
	}
	
	if ($sku != "")
	{
		echo '<br>
			<p class="new-sku-bottom" id="copysku">SKU: ' . $sku . '</p>
			<br>';
	}
}
/*************************************************************************************************************************/

// meta data add
add_action( 'woocommerce_product_meta_start', 'add_condition' );
function add_condition()
{
    global $product;
    $condition = 0;
	$customship = 0;
	$shipclass = $product->get_shipping_class();
    $id = $product->get_id();
    $sku = $product->get_sku();
    $condition = $condition + get_post_meta( $id, '_ebay_condition_id', true );
    $condition_desc = get_post_meta( $id, '_ebay_condition_description', true );
	$location = get_post_meta( $id, '_warehouse_loc', true );
	$customship = $customship + get_post_meta( $id, '_customship', true );
	
	if ( $shipclass == "free_shipping" )
	{
		echo "<strong><h2>FREE SHIPPING</h2></strong>";
		echo "<br>";
	}
	
	if (  $customship === 2 )
	{
		if( has_term( 'furniture', 'product_cat', $post_id )) { 
			echo "<strong><h4 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>CASH PAYMENT ONLY FOR THIS ITEM</h4></strong>"; 
			echo "<strong><h4 style='font-family: \"Black Ops One\",Helvetica,sans-serif; font-size:16px;'>CONTACT US DIRECTLY TO ARRANGE ORDER</h4></strong>"; 
			echo "<strong><h4 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>CALL: <a href='tel:9215634704'>(931) 563-4704</a></h4></strong>"; 
			echo "<strong><h4 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>EMAIL: <a href='mailto:sales@ccrind.com'>sales@ccrind.com</a></h4></strong>"; 
		}
		echo "<strong><h2 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>LOCAL PICKUP ONLY</h2></strong>";
		if ( $id == 146062 ) {
			echo "<strong><h2 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>However, you can setup your own shipping through UPS, FedEx, USPS, etc.</h2></strong>";
		}
		else { echo "<strong><h2 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>NO SHIPPING FOR THIS ITEM</h2></strong>"; }
		echo "<br>";
	}
	
	if( has_term( 'forklifts', 'product_cat', $post_id ))
	{ 
		echo "<strong><h2 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>IF LP FUELED, TANK NOT INCLUDED</h2></strong>";
	}
	
	if (  $customship === 3 )
	{
		echo "<strong><h2 style='font-family: \"Black Ops One\",Helvetica,sans-serif;'>WIRE / CASH PAYMENT ONLY</h2></strong>";
		echo "<br>";
	}
	
    $translate = "";
    if ( $condition === 3000 ) { $translate = "Used"; }
    if ( $condition === 7000 ) { $translate = "Item untested, working condition unknown.  Selling as For Parts or Not Working.  May or may not work."; }
    if ( $condition === 1500 ) { $translate = "New other"; }
    if ( $condition === 2500 ) { $translate = "Seller refurbished"; }
    if ( $condition === 1000 ) { $translate = "New"; }
    
	if ( $sku != "" )
    {
        echo "<span class='new-sku'>SKU: " . $sku . "</span>";
        echo "<br>";
    }
	if (  $customship === 4 )
	{
		$qty = $product->get_stock_quantity();
		echo "Qty: $qty";
		echo "<br><br>";
	}
    if ( $translate != "" )
    {
        echo "<font color='#C40808'><b>Item Condition:</b></font>  $translate";
        echo "<br>";
    }
    if ( $condition_desc != "" )
    {
        echo "<font color='#C40808'><b>Condition Description:</b></font>  $condition_desc";
		echo "<br>";
    }
	if ( $location != "" )
	{
		echo "<br>";
		echo "Warehouse Location: $location";
        echo "<br>";
		echo "<br>";
	}
}
/* end of single product page change appearance code*/
/*************************************************************************************************************************/

// change the additional information tab
add_action( 'woocommerce_product_additional_information_heading', 'add_custom_text_to_tab', 98 );
function add_custom_text_to_tab( $tabs )
{
	echo "<h3>Additional Information</h3>";
	echo "<br>";
	echo "<b>Weight and Dimensions are the minimum values for the item when shipped.</b>";
	
}
/* end code for appearance change */
/*************************************************************************************************************************/

/** code to change the login message for anyone using the site */
/** Jedidiah Fowler */
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );
 
function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );
 
	if ( 0 != $user_id ) {
		/* Add the "My Account" menu */
		$avatar = get_avatar( $user_id, 28 );
		/** the login greeting change is here */
		$howdy = sprintf( __('Logged in as: %1$s'), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';
 
		$wp_admin_bar->add_menu( array(
			'id' => 'my-account',
			'parent' => 'top-secondary',
			'title' => $howdy . $avatar,
			'href' => $profile_url,
			'meta' => array(
			'class' => $class,
			),) );
	}
}
/* end code for change login message */
/********************************************************************************************/
/* Hide shipping rates when necessary * Jedidiah Fowler */
function my_hide_shipping_when_missinginfo( $rates, $package ) {
	// modify rates if ccrindshipping is an option, hide all but local and ccrindshipping
  	if ( isset( $rates['ccrindshipping'] ) ) {
		unset( $rates['yrc_Freight'] ); unset( $rates['wf_shipping_ups:01'] ); unset( $rates['wf_shipping_ups:02'] ); unset( $rates['wf_shipping_ups:03'] ); unset( $rates['wf_shipping_ups:11'] ); unset( $rates['wf_shipping_ups:12'] ); unset( $rates['wf_shipping_ups:65'] ); unset( $rates['wf_shipping_ups:M2'] ); unset( $rates['wf_shipping_ups:M3'] ); } // close if ( isset( $rates['ccrindshipping'] ) )
	
	if ( isset( $rates['localpickuponly'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['wirecashonly'] );
		unset( $rates['local_pickup:23'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
    }
	if ( isset( $rates['wirecashonly'] ) ) 
    {
		unset( $rates['localpickuponly'] );
		unset( $rates['ccrindshipping'] );
		unset( $rates['local_pickup:23'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
    }
	// flat_rate:27 corresponds to Flat Rate USPS 9.99 shipping class
	if ( isset( $rates['flat_rate:27'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['localpickuponly'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
		unset( $rates['flat_rate:30'] );
		unset( $rates['flat_rate:32'] );
    }
	// flat_rate:30 corresponds to Flat Rate USPS 15.99 shipping class
	if ( isset( $rates['flat_rate:30'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['localpickuponly'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
		unset( $rates['flat_rate:27'] );
		unset( $rates['flat_rate:32'] );
    }
	// flat_rate:32 corresponds to Flat Rate USPS 19.99 shipping class
	if ( isset( $rates['flat_rate:32'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['localpickuponly'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
		unset( $rates['flat_rate:30'] );
		unset( $rates['flat_rate:27'] );
    }
	// flat_rate:25 corresponds to Flat Rate USPS shipping class
	if ( isset( $rates['flat_rate:25'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['localpickuponly'] );
  		unset( $rates['yrc'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
    }
	// yrc corresponds to LTL freight shipping class
	if ( isset( $rates['yrc_Freight'] ) ) 
    {
		unset( $rates['ccrindshipping'] );
		unset( $rates['localpickuponly'] );
        unset( $rates['wf_shipping_ups:01'] );
        unset( $rates['wf_shipping_ups:02'] );
        unset( $rates['wf_shipping_ups:03'] );
        unset( $rates['wf_shipping_ups:11'] );
        unset( $rates['wf_shipping_ups:12'] );
        unset( $rates['wf_shipping_ups:65'] );
        unset( $rates['wf_shipping_ups:M2'] );
        unset( $rates['wf_shipping_ups:M3'] );
    }
	return $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_missinginfo', 10, 2 );
/*  end code for hiding shipping rates */
/********************************************************************************************/

/* Filter payment gateways if Invoice is required*/
add_filter( 'woocommerce_available_payment_gateways', 'my_custom_available_payment_gateways' );
function my_custom_available_payment_gateways( $gateways ) 
{
	$chosen_shipping_rates = ( isset( WC()->session ) ) ? WC()->session->get( 'chosen_shipping_methods' ) : array();
	// When 'ccrindshipping' has been chosen as shipping rate
	if ( in_array( 'ccrindshipping', $chosen_shipping_rates ) && is_checkout() && ! is_wc_endpoint_url( 'order-pay' ) ) {
		// Remove payment gateways
		unset( $gateways['paypal'] );
		unset( $gateways['ppcp'] );
		unset( $gateways['ppcp-gateway'] );
		unset( $gateways['angelleye_ppcp'] );
		unset( $gateways['quickbookspay'] );
		unset( $gateways['intuit_qbms_credit_card'] );
		unset( $gateways['intuit_payments_credit_card'] );
		unset( $gateways['stripe'] );} /* close if ( in_array( */
	// When 'localpickuponly' has been chosen as shipping rate
	if ( in_array( 'localpickuponly', $chosen_shipping_rates ) && is_checkout() && ! is_wc_endpoint_url( 'order-pay' ) ) {
		// Remove payment gateways
		unset( $gateways['paypal'] );
		unset( $gateways['ppcp'] );
		unset( $gateways['ppcp-gateway'] );
		unset( $gateways['angelleye_ppcp'] );
		unset( $gateways['quickbookspay'] );
		unset( $gateways['intuit_qbms_credit_card'] );
		unset( $gateways['intuit_payments_credit_card'] ); 
		unset( $gateways['stripe'] );} /* close if ( in_array( */
	// When 'wirecashonly' has been chosen as shipping rate
	if ( in_array( 'wirecashonly', $chosen_shipping_rates ) && is_checkout() && ! is_wc_endpoint_url( 'order-pay' ) ) {
		// Remove payment gateways
		unset( $gateways['paypal'] );
		unset( $gateways['ppcp'] );
		unset( $gateways['ppcp-gateway'] );
		unset( $gateways['angelleye_ppcp'] );
		unset( $gateways['quickbookspay'] );
		unset( $gateways['intuit_qbms_credit_card'] );
		unset( $gateways['intuit_payments_credit_card'] ); 
		unset( $gateways['stripe'] );} /* close if ( in_array( */
	// When 'YRC-Freight' has been chosen as shipping rate
	if ( is_wc_endpoint_url( 'order-pay' ) ) {
		// Remove payment gateways
		unset( $gateways['cod'] ); } /* close if ( is_wc_endpoint_url( */
	return $gateways; 
} /* close function my_custom_available_payment_gateways */
/********************************************************************************************/
// add new badge to newly listed items (30 days)
add_action( 'woocommerce_before_shop_loop_item_title', 'new_badge_shop_page', 3 );      
function new_badge_shop_page() {
   global $product;
   $newness_days = 30;
   $created = strtotime( $product->get_date_created() );
   if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
      echo '<span class="itsnew onsale">' . esc_html__( 'New Item', 'woocommerce' ) . '</span>'; } /* close if ( ( time() */
}
/********************************************************************************************/
// Code to clear default shipping option.
add_filter( 'woocommerce_shipping_chosen_method', '__return_false', 99);
// Code to clear default payment option.
add_filter( 'pre_option_woocommerce_default_gateway' . '__return_false', 99 );
// hide all payment methods except INVOICE for custom shipping items
add_filter( 'woocommerce_available_payment_gateways', 'hide_payments' );
function hide_payments( $available_gateways ) 
{
	// trigger for customers only
   if ( ! is_checkout() && ! is_wc_endpoint_url( 'order-pay' ) ) { return $available_gateways; }
   if ( ! is_admin() ) 
   {
	  if ( WC()->session->get( 'chosen_shipping_methods' ) != "" ) {
      	$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
      	$chosen_shipping = $chosen_methods[0];
      	if ( isset( $available_gateways['cod'] ) && 0 === strpos( $chosen_shipping, 'ccrindshipping' ) ) 
	  	{
         	unset( $available_gateways['intuit_payments_credit_card'] );
		 	unset( $available_gateways['quickbookspay'] );
		 	unset( $available_gateways['paypal'] );
			unset( $available_gateways['ppcp'] );
			unset( $available_gateways['ppcp-gateway'] );
		 	unset( $available_gateways['angelleye_ppcp'] );
      	}
	  }
   }
   return $available_gateways;
}
/*************************************************************************************************************************/

/** code to add a crating fee to the checkout page 
add_action( 'woocommerce_cart_calculate_fees', 'wc_add_cratefee');
function wc_add_cratefee()
{
    global $woocommerce;
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) { return; }
	//$cratefee = 0;
    //$prod_cratefee = 0;
	$chosen_shipping_methods = WC()->session->get( 'chosen_shipping_methods' );
	if (strpos($chosen_shipping_methods[0], 'local') !== false) 
	{
		/*foreach( $woocommerce->cart->get_cart() as $item )
    	{
        	$prod_id = $item['product_id'];
        	$prod_cratefee = $prod_cratefee + get_post_meta($prod_id, '_cratefee', true);
        	$cratefee = $cratefee + $prod_cratefee;
        	$prod_cratefee = 0;
    	}
		$cratefee = $cratefee - (2 * $cratefee);
		if ($cratefee != 0){
        	$woocommerce->cart->add_fee( 'Crating Fee Removed', $cratefee, true, 'standard' );
    	} 
		return;
	}
    $cratefee = 0;
    $prod_cratefee = 0;
    foreach( $woocommerce->cart->get_cart() as $item )
    {
        $prod_id = $item['product_id'];
        $prod_cratefee = $prod_cratefee + get_post_meta($prod_id, '_cratefee', true);
        $cratefee = $cratefee + $prod_cratefee;
        $prod_cratefee = 0;
    }
    //if ($cratefee != 0) { $woocommerce->cart->add_fee( 'Crating Fee Total', $cratefee, true, 'standard' ); }  
}
/* end of crating fee code */
/*************************************************************************************************************************/
/* code to add to ups shipping rates */
add_filter( 'woocommerce_package_rates', 'woocommerce_package_rates' );
function woocommerce_package_rates( $rates ) 
{
	/* percentage increase
    $inc = 20; // 20%

    foreach($rates as $key => $rate ) {
        $rates[$key]->cost = $rates[$key]->cost + ( $rates[$key]->cost * ( $inc / 100 ) );
    }*/
	/* flat rate increase by tier */
	foreach($rates as $key => $rate ) {
		if ($rates[$key]->cost >= 0.01 && $rates[$key]->cost < 10.00 )
		{	
			// account for usps flat rate item
			if ( isset( $rates['flat_rate:27'] ) ) { /* do nothing */ }
			else { $rates[$key]->cost = $rates[$key]->cost + 5; }
		}
		else if ($rates[$key]->cost >= 10.00 && $rates[$key]->cost < 20.00 )
		{
			// account for usps flat rate item
			if ( isset( $rates['flat_rate:30'] ) || isset( $rates['flat_rate:32'] ) ) { /* do nothing */ } 
			else { $rates[$key]->cost = $rates[$key]->cost + 8; }
		}
		else if ($rates[$key]->cost >= 20.00 && $rates[$key]->cost < 50.00 ){
			$rates[$key]->cost = $rates[$key]->cost + 12;
		}
		else if ($rates[$key]->cost >= 50.00 && $rates[$key]->cost < 100.00 ){
			$rates[$key]->cost = $rates[$key]->cost + 16;
		}
		else if ($rates[$key]->cost >= 100.00 ){
			$rates[$key]->cost = $rates[$key]->cost + 20;
		}
    }
    return $rates;
}
/*************************************************************************************************************************/
/* code to add columns to display on product page for woocommerce admin column
/  Jedidiah Fowler 3-1-18 */
add_filter( 'manage_product_posts_columns', 'edit_product_columns' );
function edit_product_columns( $columns ) 
{	
	global $current_user;
	wp_get_current_user();
	$email = $current_user->user_email;
	
	$columns['custom_image'] = __( '<span class="wc-image tips">Image</span>');
	$columns['updateall'] = __( 'Update ALL');
	$columns['cond_test'] = __( 'Condition / Test Info / Add. Info');
	$columns['_price_cost'] = __( 'Price / Cost');
	$columns['_stock_status_combine'] = __( 'SKU / Stock / Status');
	$columns['cat_date_modifier'] = __( 'Categories / Date Modified');
    $columns['_warehouse_loc'] = __( 'WH Loc / Lister / Logs' );
    $columns['_ccrind_brand'] = __( 'Brand / Model / GSF' );
	$columns['item_stats'] = __( 'L x W x H / LBS / Pallet Fee' );
	$columns['product_shipping_class'] = __( 'ShipClass / CustomShip? / FrgtClass' );
	$columns['_auction'] = __('Auction / Date');
	$columns['_fi'] = __('Ft. Img');
	$columns['_video'] = __('Video');
	$columns['_sales_channel_links'] = __('Links');
	$columns['links_input'] = __('Links Input');
	$columns['_excerpt'] = __('Excerpt Display / Keyword Terms');
	$columns['_fix_info'] = __('Fixing Notes');
	if ($email == "dan@ccrind.com")
	{
	$columns['_note_dan'] = __('Dan\'s Notes');
	}
	
	$columns['_soldby'] = __('Sold by:');
	$columns['_linkboxes'] = __('Edit Links');
	$columns['generate_quote'] = __('Generate Quote');
	
    return $columns;
}

// add the data to the columns added above
add_action( 'manage_product_posts_custom_column', 'wooadmin_add_columns', 10, 2 );
function wooadmin_add_columns( $column, $postid ) 
{
	global $current_user;
	wp_get_current_user();
	$email = $current_user->user_email;
	
    global $product;
	
	$sku = get_post_meta( $postid, '_sku', true );
	if ( $column == '_sku' ) 
    {
		$link = get_permalink($postid);
		echo "<a class='admin_link_skulink' href='$link' rel='noopener noreferrer' target='_blank' title='$link'>
				<div class='admin_link_sku'>
					$sku
			  	</div>
			  </a>";
    }
	if ( $column == 'custom_image' )
    {
		$searchlink = "https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product";
		if ( has_post_thumbnail( $postid ) )
		{
			$image = wp_get_attachment_url( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
			echo "<a href=\"$searchlink\"  rel=\"noopener noreferrer\" target=\"_blank\">
				<img width=\"180\" src=\"$image\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" loading=\"lazy\">";
			echo "<br>";
		}
	}
	if ( $column == 'updateall' )
    {
        // hidden button to allow to work on first item in list
		echo "<form method='post' action=''>
			  	<input type='hidden' name='postidfirst' value='$postid'>
			  	<button type='submit' name='testbuttonhidden' style='display:none;'></button>
			  </form>";
		// condition testing change fields and change button
		echo "<form method='post' action=''>
			  	<input type='hidden' name='postidall' value='$postid'>";
		
		echo "	<div style='text-align:center;'><button type='submit' name='postall' class='postall' title='Update all inputs on the product.'></button></div>";
			
		echo "<br><select id='formaction' name='formaction' class='formaction'>
					<option value=''></option>
        			<option value='sold'>Sold</option>
        			<option value='oos'>OoS</option>
        			<option value='uqty'>Qty</option>
   				</select>";
		echo "<br><div style='text-align:center;'><input type='checkbox' id='mybulkedit' name='mybulkedit' class='mybulkeditbox' value='1'>
  			  <br><label for='mybulkedit' class='mybulkeditl'>Bulk Edit</label></div>";
		
		/*echo "<br><div style='text-align:center;'><input type='checkbox' id='newbulkedit[]' name='newbulkedit[]' class='newbulkeditbox[]' value='$postid'>
  			  <br><label for='newbulkedit[]' class='newbulkeditl[]'>New Bulk Edit (testing)</label></div>";*/
		
			 // </form>";
    }
	if ( $column == 'cond_test' ) 
	{
		$condition = 0; $ccode = intval( get_post_meta( $postid, '_ebay_condition_id', true ));
		$condition = $condition + $ccode;
		// translate the ebay condition number to a readable word
		$translate = "";
   		if ( $condition === 3000 ){ $translate = "Used" ;}
    	if ( $condition === 7000 ){ $translate = "For Parts"; }
        if ( $condition === 1500 ){ $translate = "New other"; }
    	if ( $condition === 2500 ){ $translate = "Seller refurbished"; }
    	if ( $condition === 1000 ) { $translate = "New"; }
		if ( $translate != "" ) { echo "<b>CONDITION:</b><br><input type='text' class='condinput' name='condinput'  placeholder='$translate'
			title='Enter 0 = For Parts &#013; 1 = Used &#013; 2 = New other &#013; 3 = New &#013; 4 = Seller refurbished'>"; } // &#013; = newline char
		else { echo "<b>CONDITION:</b><br><input type='text' class='condinput' name='condinput' placeholder='-' title='Enter 0 = For Parts &#013; 1 = Used &#013; 2 = New other &#013; 3 = New &#013; 4 = Seller refurbished'>"; }

		if ( get_post_meta( $postid, '_tested', true ) != "" ) { echo "TEST INFO:<br><div class='testinput'><textarea id='testinput' class='testinput' name='testinput' rows='3' title='Enter current testing status here.' style='color:#8d8d8d; font-weight:bold; font-size:12px;'>" . get_post_meta( $postid, '_tested', true ) . "</textarea></div>"; }
		else { echo "<bCONDITION:</b<br><div class='testinput'><textarea id='testinput' class='testinput' name='testinput' rows='3' placeholder='-' title='Enter current testing status here.' style='color:#8d8d8d; font-weight:bold; font-size:12px;'></textarea></div>"; }
		
		$addinfo = get_post_meta($postid,'_extra_info',true);
		if ($addinfo != ""){
			echo "<b>ADD. INFO:</b<br><div class='addinfodisplay'><textarea id='addinfodisplay' class='addinfodisplay' name='addinfodisplay' rows='4' title='Enter additional information here.' style='color:#8d8d8d; font-weight:bold; font-size:12px;'>" . get_post_meta( $postid, '_extra_info', true ) . "</textarea></div>"; 
		}
		else {
			echo "<bADD. INFO:</b<br><div class='addinfodisplay'><textarea id='addinfodisplay' class='addinfodisplay' name='addinfodisplay' rows='4' placeholder='Add. Info' title='Enter additional information here.' style='color:#3b5897; font-weight:bold; font-size:12px;'></textarea></div>";
		}
	}
	if ( $column == '_price_cost' ) 
    {
		$regprice = $product->get_regular_price();
		$saleprice = $product->get_sale_price();
        $cost = intval( get_post_meta( $postid, '_cost', true ) ) + intval( get_post_meta( $postid, '_lsn_cost', true ) ) + intval( get_post_meta( $postid, '_fbmp_cost', true ) ) + intval( get_post_meta( $postid, '_cl_cost', true ) );
		if( $saleprice == "" ) 
		{
			if ($regprice != "") { echo "<input type='text' class='postregprice' name='postregprice'  placeholder='$" . number_format($regprice, 2, '.', ',') . "'>"; }
			else { echo "<input type='text' class='postregprice' name='postregprice'  placeholder='-'>"; }
		}
		else 
		{
			if ($regprice != "") { echo "<input type='text' class='postregpricestrike' name='postregprice' placeholder='$" . number_format($regprice, 2, '.', ',') . "'>"; }
			else { echo "<input type='text' class='postregprice' name='postregprice'  placeholder='-'>"; }
		}
		if ($saleprice != "") { echo "<input type='text' class='postsaleprice' name='postsaleprice' title='Sale Price: enter 0 or clear to remove' placeholder='$" . number_format($saleprice, 2, '.', ',') . "'>"; }
		else { echo "<input type='text' class='postsalepricee' name='postsalepricee' title='Sale Price: enter 0 or clear to remove' placeholder='(Sale Price)'>"; }
		if ($cost != "") { echo "<input type='text' class='postcost' name='postcost' title='Item Cost: enter 0 or clear to remove' placeholder='$" . number_format($cost, 2, '.', ',') . "'>"; }
		else { echo "<input type='text' class='postcoste' name='postcoste' title='Item Cost: enter 0 or clear to remove' placeholder='(Cost)'>"; }
		// search orders for the product link
		echo "<br><br><div style='line-height: 1.2; color: #ffffff; text-align: center;'>";
		echo "<button class='btn s_ord_prod_link' onclick=\"window.open('https://ccrind.com/wp-admin/edit.php?s=$sku&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1&orderidfirst=62910&action2=-1','_blank');\" type='button' alt='Search Orders for this Product'></button>";
		echo "<p style='margin-left: 5px; margin-top:-17px;'>Search Orders<p></div>";
		// generate contact log
		$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
		$cl = get_post_meta($postid,'_contact_log_made',true);
		if ( current_user_can('administrator') ) {
			//echo "<br>contact log value: $cl<br>";
		}
		if ($cl) {
			echo "<br><div style='line-height: 1.2; color: #ffffff; text-align: center;'>";
			echo "<button class='btn contact_log_link' onclick=\"window.open('https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html','_blank');\" type='button' alt='Open Contact Log'></button>";
			echo "<p style='margin-left: 5px; margin-top:-17px;'>Contact Log<p></div>";
			
		}
		else {
			echo "<br><div><label for='clcreate' class='clcreateboxl'>Create Contact Log?</label>
				<input type='checkbox' id='clcreate' name='clcreate' class='clcreatebox' value='1'></div>";
		}
    }
	if ( $column == '_stock_status_combine' ) 
    {
		$sku = get_post_meta( $postid, '_sku', true );
		$link = get_permalink($postid);
		echo "<a class='admin_link_skulink' id='admin_link_skulink$postid' href='$link' rel='noopener noreferrer' target='_blank' title='$link'>
				<div class='admin_link_sku'>
					$sku
			  	</div>
			  </a>";
		echo "<br>";
		
        $stock = $product->get_stock_quantity();
		$total = 1;
		if ($product->is_type( 'variable' ))
    	{
      		$available_variations = $product->get_available_variations();
			$build = "";
			$total = 0;
        	foreach ($available_variations as $key => $value)
        	{
            	$variation_id = $value['variation_id'];
				$attribute_size = $value['attributes']['attribute_size'];
            	$variation_obj = new WC_Product_variation($variation_id);
				$stockQty = $variation_obj->get_stock_quantity();
				$build = $build . $attribute_size . ": " . $stockQty . "\n";
				$total = $total + $stockQty;
        	}
			$stock = substr($build, 0, -1);
    	}
		$status = $product->get_status();
		
		if ($stock > 0 && $total > 0)
		{
			if ($status === "private") { echo "<textarea name='postqty' class='postqty private' id='postqty'  placeholder='In stock ($stock)'></textarea>"; }
			else if ($status === "publish")
			{
				echo "<textarea name='postqty' class='postqty publish' id='postqty'  placeholder='In stock ($stock)'></textarea>";
			}
			else if ($status === "pending")
			{	
				echo "<textarea name='postqty' class='postqty pending' id='postqty'  placeholder='In stock ($stock)'></textarea>";
			}
			else if ($status === "draft")
			{	
				echo "<textarea name='postqty' class='postqty draft' id='postqty'  placeholder='In stock ($stock)'></textarea>";
			}
		}
		else
		{
			echo "<textarea name='postqty' class='postqty' id='postqty'  placeholder='Out of stock ($stock)'></textarea>";
		}
		
		echo "<br>";
		
		if ($status === "private")
		{
			echo "<textarea rows='1' name='poststatus' class='poststatus private' id='poststatus'  placeholder='Sold'></textarea>";
		}
		else if ($status === "publish")
		{
			echo "<textarea rows='1' name='poststatus' class='poststatus publish' id='poststatus'  placeholder='Published'></textarea>";
		}
		else if ($status === "pending")
		{
			echo "<textarea rows='1' name='poststatus' class='poststatus pending' id='poststatus'  placeholder='Pending'></textarea>";
		}
		else if ($status === "draft")
		{	
			echo "<textarea rows='1' name='poststatus' class='poststatus draft' id='poststatus'  placeholder='Draft'></textarea>";
		}
		echo "<div><button class='btn copySKU' type='button' data-clipboard-target='#admin_link_skulink$postid'> Copy SKU </button></div>";
		//echo "<br><br><button class='btn product_isolate_link' onclick=\"window.open('https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_cat&product_type&stock_status&paged=1&postidfirst=143578&action2=-1','_blank');\" type='button' alt='Isolate Product'> Isolate </button>";
		echo "<div><a class='admin_link_isolink' id='admin_link_isolink$postid' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_cat&product_type&stock_status&paged=1&postidfirst=143578&action2=-1' rel='noopener noreferrer' target='_blank' title='Isolate'>
				<div class='admin_link_iso'>
					Isolate
			  	</div>
			  </a></div>";
		// get product name and test for inclusing of CCR number
		$name = $product->get_name();
		if ( ! strpos($name, "CCR") && ! strpos($name, "MS") ) { //echo "<br>Test";
			$name = $name . " CCR$sku";
			echo "<div><button class='btn copyHNSKU' type='button' data-clipboard-target='#hiddenNameSKU$postid'> Copy Name </button></div>";
			echo "<div class='hiddenNameSKU' id='hiddenNameSKU$postid'>$name</div>";
		}
		else { /*echo "<br>CCR";*/ 
			echo "<div><button class='btn copyHNSKU' type='button' data-clipboard-target='#hiddenNameSKU$postid'> Copy Name </button></div>";
			echo "<div class='hiddenNameSKU' id='hiddenNameSKU$postid'>$name</div>";
		}
    }
	
	// combine categories with date modified and modifier
	if ( $column == 'cat_date_modifier' ) 
    {
		// loop through all categories and display links
		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		$total = count($terms);
		$i = 0;
		foreach ($terms as $term) 
		{
			$i++;
			echo '<a href="' .  esc_url( get_term_link( $term->term_id ) ) . '">';
			echo $term->name;
			echo '</a>';
			if ($i != $total) echo ', ';
		}
		
		echo '<br><span class="date_modified">' . $product->get_date_modified()->date('m/d/Y - g:i a') . '</span>';
		echo "<br>";
		
		$lastuser  = get_post_meta( $postid, '_last_user', TRUE );
		$updated = get_post_meta( $postid, '_last_changed_field', TRUE );
		$updatedd = get_post_meta( $postid, '_last_change_desc', TRUE );
		echo "<br>";
		echo "<div style='font-size:11px'><textarea id='changedesc' class='changedesc' name='changedesc' rows='12' style='font-size:11px; text-align:center;'>";
		if ($lastuser != ""){ echo "$lastuser
"; }
		if ($updated != ""){ echo "$updated
"; }
		if ($updatedd != ""){ echo "$updatedd
"; }
		echo "</textarea></div>";
	}
	// warehouse location change button location update
    if ( $column == '_warehouse_loc' ) 
    {
		$status = $product->get_status();
			
		$loc = get_post_meta( $postid, '_warehouse_loc', true );
		
		echo "	<textarea name='postlocupdate' class='postlocupdate' id='postlocupdate' placeholder='$loc'></textarea>";
		
		echo "<div style='margin-top: 10px;' class='listerdiv'>Lister:<br></div>";
		echo "<div style='font-size:16px; font-weight:bold; color:#8d8d8d;'>" . get_post_meta( $postid, '_preparers_initials', true ) . "</div>";
		//get sku length
		$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
		echo "<br><a class='loglinknew' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='https://ccrind.com/log/LV/library/product-change-logs/$sku_2/$sku_3/$sku.txt' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2021/10/log1.png\" width=\"35\" height=\"35\" title='LOG' alt=\"loglinkfolder\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2021/10/log2.png\" width=\"35\" height=\"35\" title='LOG' alt=\"loglinkfolderhover\"></span>
					</a>";
		echo "<div style='line-height: 1.2; color: #ffffff; text-align: center;'>";
		echo "<button class='btn pc_log_link' onclick=\"window.open('https://ccrind.com/log/LV/library/product-change-logs/$sku_2/$sku_3/$sku.html','_blank');\" type='button' alt='Open Product Change Log'></button>";
		echo "<p style='margin-left: 5px; margin-top:-17px;'>Log<p></div>";
    }
	if ( $column == '_ccrind_brand' ) 
    {	
		$brand = get_post_meta( $postid, '_ccrind_brand', true );
		$mpn = get_post_meta( $postid, '_ccrind_mpn', true );
		$gsf = get_post_meta( $postid, '_gsf_value', true );
		if ($brand == "" ) { echo "<div class='brandmpn'><input type='text' class='brandinput' name='brandinput'  placeholder='Brand' style='opacity:0.3;'></div>"; }
		else { echo "<div class='brandmpn'><textarea id='brandinput' class='brandinput' name='brandinput'  placeholder='$brand' style='color:#89898a;'></textarea></div>"; }
		if ($mpn == "" ) {  echo "<div class='brandmpn'><input type='text' class='mpninput' name='mpninput'  placeholder='Model/MPN' style='opacity:0.3;'></div>"; }
		else { echo "<div class='brandmpn'><textarea id='mpninput' class='mpninput' name='mpninput' rows='3' placeholder='$mpn' style='color:#89898a;'></textarea></div>"; }
		if ($gsf != ""){ echo "GSF H / M:<div class='aucinputdiv'><input type='text' class='gsfinput' name='gsfinput' title='Google Shopping Feed Value, H/h for Half and M/m for Max.' placeholder='$gsf'></div>"; }
		else { echo "<div class='aucinputediv'><input type='text' class='gsfinpute' name='gsfinpute'  title='Google Shopping Feed Value, H/h for Half and M/m for Max.' placeholder='(GSF, h or m)'></div>"; }
		
		$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
		// ship quote log button
		if ( file_exists("../library/product-quote-logs/$sku_2/$sku_3/ShipQ$sku.html") ) {
			echo "<br><br><button class='btn ship_quote_log_link' onclick=\"window.open('https://ccrind.com/log/LV/library/product-quote-logs/$sku_2/$sku_3/ShipQ$sku.html','_blank');\" type='button' alt='Open Ship Quote Log'></button>"; 
			echo "<p style='margin-left: 5px; margin-top:-17px;'>Ship Quote Log<p></div>";
		}
    }
	
	if ( $column == 'item_stats' ) 
    {
		//echo "<div class='dimensions'>";
        $length = $product->get_length();
        $width = $product->get_width();
        $height = $product->get_height();
		echo "<div id='item_statscopy$postid'>";
		if ($length != "") { 
			$length = $length . "\" L";
			echo "<div><input type='text'  class='deminputl' name='deminputl' placeholder='$length'></div>";
		} else { 
			$length = "(L)"; 
			echo "<div><input type='text'  class='deminputlempty' name='deminputlempty' placeholder='$length'></div>";
		}
		if ($width != "") { 
			$width = $width . "\" W";
			echo "<div><input type='text'  class='deminputw' name='deminputw' placeholder='$width'></div>";
		} else { 
			$width = "(W)"; 
			echo "<div><input type='text'  class='deminputwempty' name='deminputwempty' placeholder='$width'></div>";
		}
		if ($height != "") { 
			$height = $height . "\" H";
			echo "<div><input type='text'  class='deminputh' name='deminputh' placeholder='$height'></div>";
		} else { 
			$height = "(H)"; 
			echo "<div><input type='text'  class='deminputhempty' name='deminputhempty' placeholder='$height'></div>";
		}
		//echo "</div>";
		
		echo "<div>";
		$weight = $product->get_weight();
		if ($weight != "") { 
			$weight = $weight . " lbs";
			echo "<input type='text'  class='wgtinput' name='wgtinput'  placeholder='$weight'>";
		} else { 
			$weight = "Weight"; 
			echo "<input type='text'  class='deminputwgtempty' name='deminputwgtempty'  placeholder='$weight'>";
		}
		echo "</div></div>";
		
		// pallet fee
		echo "<div>";
		$cfee = get_post_meta($postid, '_cratefee', true);
		if ($cfee != "") { 
			$cfee = "$$cfee";
			echo "<input type='text'  class='cfeeinput' name='cfeeinput'  placeholder='$cfee'>";
		} else { 
			$cfee = "(Pallet Fee)"; 
			//echo "<input type='text area' class='deminputcfeeempty' name='deminputcfeeempty'  placeholder='$cfee'>";
			echo "<div class='deminputcfeeempty'><textarea id='deminputcfeeempty' class='deminputcfeeempty' name='deminputcfeeempty' rows='2' placeholder='$cfee' style='color:#3b5897; font-weight:bold; font-size:12px; width:55px; resize:none;'></textarea></div>";
		}
		echo "</div>";
		echo "<button class='btn' type='button' data-clipboard-target='#item_statscopy$postid'> Copy </button>";
		
		$ship = get_post_meta( $postid, '_customship', true );
		if ($ship == 2) { echo "<p style='color: #c40403; background-color: #ffffff; border-radius: 5px; font-weight: bold;'>Local Pickup Only</p>"; }
		
		/*echo "<div style='text-align:center;'><button type='submit' name='stats_update' class='stats_update' title='Will update with values input in the fields above. Use \"clear\" or 0 to empty the field.'>Change</button>					</div>
			</form>";*/
    }
    if ( $column == 'Dimensions' ) 
    {
        $length = $product->get_length();
        $width = $product->get_width();
        $height = $product->get_height();
		
		if ($length != "")
		{
        	echo $length;
        	echo " x ";
        	echo $width;
        	echo " x ";
        	echo $height;
		}
    }
    if ( $column == 'Weight' ) 
    {
        $weight = $product->get_weight();
        echo $weight;
    }
	// combine shipping class custom ship and freight class columns
	if ( $column == 'product_shipping_class' ) 
    {
        $shipclass = $product->get_shipping_class();
		$ship = get_post_meta( $postid, '_customship', true );
		$fc = get_post_meta( $postid, '_ltl_freight', true );
		// translate $shipID to work with javascript function later
		$shipclasstrans = "";
		if ($shipclass == "") { $shipclasstrans = "None (UPS)"; } if ($shipclass == "ltl_freight") { $shipclasstrans = "LTL Freight"; } if ($shipclass == "flat_bed") { $shipclasstrans = "Flat Bed"; } if ($shipclass == "flat_usps2") { $shipclasstrans = "USPS 15.99"; } if ($shipclass == "flat_usps3") { $shipclasstrans = "USPS 19.99"; } if ($shipclass == "flat_usps") { $shipclasstrans = "USPS 9.99"; } if ($shipclass == "free_shipping") { $shipclasstrans = "Free Shipping"; }
		// translate $ship to words for easy reading understanding
		$shiptrans = "";
		if ($ship == 0) { $shiptrans = "0: No"; } if ($ship == 1) { $shiptrans = "1: Yes"; } if ($ship == 2) { $shiptrans = "2: Local Pickup Only"; } 
		if ($ship == 4) { $shiptrans = "4: Unavailable"; } if ($ship == 3) { $shiptrans = "3: Wire / Cash Only"; } if ($ship == 5) { $shiptrans = "5: Unpurchasable on WS"; } if ($ship == 6) { $shiptrans = "6: GovDeals"; }
		if ($fc == "") { $fc = "Enter FC #"; }
		
		// display labels and input boxes
		echo "	<div class='customshipinputdiv' style='text-align: center;'><span style='font-size:13px;'><label for='customship'>Custom Ship Code:</label></span>
				</div>
				<div>
					<textarea id='customshipinput$postid' class='customshipinput' name='customshipinput' rows='2'  placeholder='$shiptrans' title='Enter 0 for No, 1 for Yes, 2 for Local Pickup Only, 3 for Wire / Cash Only, 4 for Unavailable, 5 for Unpurchasable, 6 for GovDeals' style='font-size:14px; user-select: all;'></textarea>
				</div>
				<select id='cship_select' name='cship_select' class='cship_select'>
					<option value=''>Change to...</option>
					<option value='0'>0: No</option>
        			<option value='1'>1: Yes</option>
        			<option value='2'>2: Local Pickup Only</option>
        			<option value='3'>3: Wire / Cash Only</option>
					<option value='4'>4: Unavailable</option>
					<option value='5'>5: Unpurchasable on WS</option>
					<option value='6'>6: GovDeals</option>
					<option value='7'>7: clear</option>
				</select>
				<div>___________________</div>
				<div class='shipclassinputdiv' style='text-align: center;'><span style='font-size:14px;'><label for='shipclass'>Ship Class:</label></span>
				</div>
				<div>
					<input type='text' class='shipclassinput' name='shipclassinput'  title='Enter 0 for None (UPS), 1 for LTL Freight, Enter 2 for Flat Bed, 3 for Free Shipping, 4 for USPS 9.99, Enter 5 for USPS 15.99, 6 for USPS 19.99' placeholder='$shipclasstrans'>
				</div>
				<select id='shipc_select' name='shipc_select' class='shipc_select'>
					<option value=''>Change to...</option>
					<option value='0'>None (UPS)</option>
        			<option value='1'>LTL Freight</option>
        			<option value='2'>Flat Bed</option>
        			<option value='3'>Free Shipping</option>
					<option value='4'>USPS 9.99</option>
					<option value='5'>USPS 15.99</option>
        			<option value='6'>USPS 19.99</option>
				</select>
				<div>___________________</div>
				<div class='freightclassinputdiv' style='text-align: center;'><span style='font-size:14px;'><label for='freightclass'>Freight Class:</label></span>
				</div>
				<div>
					<input type='text' class='freightclassinput' name='freightclassinput'  placeholder='$fc'>
				</div>";
	}
	
	
	// auction and auction date combined
	if ( $column == '_auction' ) 
    {
		$auc = get_post_meta( $postid, '_auction', true );
		$aucdate = get_post_meta( $postid, '_auction_date', true );
		$GDLot = get_post_meta( $postid, '_govdeals', true );

			if ($auc != ""){ echo "<div class='aucinputdivNE'><textarea id='aucinput' class='aucinput' name='aucinput' title='Name of the Auction company, use clear to empty the value.' placeholder='$auc'></textarea></div>"; }
			else { echo "<div class='aucinputediv'><input type='text' class='aucinpute' name='aucinpute'  title='Name of the Auction company, use clear to empty the value.' placeholder='(Auc Name)'></div>"; }
			if ($aucdate != "" ){ $aucdate = date('m/d/y', strtotime($aucdate)); echo "<div class='aucdddiv'>
				<input type='text' class='aucdinput' name='aucdinput'  title='Date of Auction' placeholder='$aucdate'></div>"; }
			else { $aucdate = "(Auc Date)"; echo "<div class='aucdediv'><input type='text' class='aucdinpute' name='aucdinpute'  title='Date of Auction, use clear to empty the value.' placeholder='$aucdate'></div>"; }
		echo	"<div class='aucdinputdiv'><input type='date' class='newaucdinput' name='newaucdinput'  title='Enter new Auction Date information.' placeholder='mm/dd/yyyy'></div>";
		echo "<br>";
		if ($GDLot != "" ){ echo "<input type='text' class='gdlotinput' name='gdlotinput'  title='GovDeals Lot #' placeholder='$GDLot'>"; }
		else { echo "<input type='text' class='gdlotinpute' name='gdlotinpute'  title='GovDeals Lot #' placeholder='Lot #'>"; }
	}
	
	if ( $column == 'listed_on_ebay' )
	{
		echo "<br><br>";
		$dnl = get_post_meta( $postid, '_dnl_eBay', true );
        if ( $dnl ) { echo "<input type='checkbox' title='Do Not List to eBay (checked is yes do not)' id='dnlebay' name='dnlebay' class='dnlbox' value='dnl' checked>
  			  	  <label for='dnlebay' class='dnlebayl'> DNL</label><br>"; }
		else { echo "<input type='checkbox' title='Do Not List to eBay (checked is yes do not)' id='dnlebay' name='dnlebay' class='dnlbox' value='dnl'>
  			 	  <label for='dnlebay' class='dnlebayl'> DNL</label><br>"; echo "<i class='fa-brands fa-ebay fa-2xl'>"; }
		/*echo "<br>";
		$newfb = get_post_meta( $postid, '_newFB', true );
		if ( $newfb ) { echo "<input type='checkbox' title='Listed to new FB account (checked = yes)' id='newFB' name='newFB' class='newFBbox' value='newFB' checked>
  			  	  <label for='newFB' class='newFBl'> FB</label><br>"; }
		else { echo "<input type='checkbox' title='Listed to new FB account (checked = yes)' id='newFB' name='newFB' class='newFBbox' value='newFB'>
  			 	  <label for='newFB' class='newFBl'> FB</label><br>"; }*/
	}
	
	if ( $column == '_fi' ) 
    {
		if ( has_post_thumbnail( $postid ) )
		{
			$image = wp_get_attachment_url( get_post_thumbnail_id( $postid ), 'single-post-thumbnail' );
			echo "<a class='admin_link'
						style='display: inline-block; 
						color:#ffffff; 
						background-color:#378bbc; 
						text-align:center; 
						padding: 8px; 
						-webkit-border-radius: 5px;
						border-radius: 5px;'
						href='$image' rel='noopener noreferrer' target='_blank'><strong>Image</strong></a>";
		}
	}
	
	if ( $column == '_video' ) 
    {
        $vlink = get_post_meta( $postid, '_video', true );
		
		if ( $vlink == "" )
		{
			return;
		}
		echo "<a class='admin_link_yt' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'
					href='$vlink' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/yt-logo-small.png\" title='$vlink' alt=\"YT\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/yt-logo-small-invert.png\"  title='$vlink' alt=\"YT\"></span>
					</a>";
	}
	if ( $column == '_sales_channel_links')
	{
		$vlink = get_post_meta( $postid, '_video', true );
		
		if ( substr( $vlink, 0, 1 ) != "h" ) { /* do nothing */ }
		else
		{
			echo "<a class='admin_link_yt' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					margin-bottom: 5px;'
					href='$vlink' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/yt-logo-small.png\" title='$vlink' alt=\"YT\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/yt-logo-small-invert.png\"  title='$vlink' alt=\"YT\"></span>
					</a>";
		}
		
		// lsn line div
		echo "<div style='
			overflow: hidden;
    		white-space: nowrap;
			margin-bottom: 10px;'>";
        $lsn = get_post_meta( $postid, '_lsn', true );
		$lsnlink = get_post_meta( $postid, '_lsnlink', true );
		
		if ($lsn == "")
		{
			echo "";
		}
		else if ( substr( $lsn, 0, 1 ) == "l" || substr( $lsn, 0, 1 ) == "c"  )
		{
			echo "<a class='admin_lsn_link' href='$lsnlink' rel='noopener noreferrer' target='_blank' title='$lsnlink'>
					<div class='admin_lsn_logo'>
						$lsn
				  	</div>
				  </a>";
		}
	
        $lsnc = get_post_meta( $postid, '_lsn_cost', true );
		
		if ($lsnc == "")
		{
			echo "";
		}
		else
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#e36917; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong>$lsnc</strong></p>";
		}
		// end lsn line div
		echo "</div>";
		
		// fb line div
		echo "<div style='
			overflow: hidden;
    		white-space: nowrap;
			margin-bottom: 10px;'>";
		
        $fblink = get_post_meta( $postid, '_fbmp', true );
		$fblink = strtolower( $fblink );
		$fbflag = 0;
		
		if ( $fblink == "" )
		{
			echo "";
		}
		else if ( $fblink == "exclude" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; X &nbsp; </strong></p>";
		}
		else if ( $fblink == "multi" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; M &nbsp; </strong></p>";
		}
		else if ( substr( $fblink, 0, 5 ) == "https" )
		{
			//echo "Link:<br>";
			$fbID = get_post_meta( $postid, '_fbID', true );
			if ($fbID != "") {
				echo "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;
					margin-bottom: 5px;'
					href='https://www.facebook.com/marketplace/edit?listing_id=$fbID' rel='noopener noreferrer' target='_blank'>FB Edit</a><br>";
			}
			else {
				echo "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;
					margin-bottom: 5px;'
					href='$fblink' rel='noopener noreferrer' target='_blank'>FB Link</a><br>";
			}
			//echo "Search:<br>";
			echo "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='https://www.facebook.com/marketplace/you/selling?title_search=$sku' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/new-facebook-logo-1.png\" width=\"30\" height=\"30\" title='$fblink' alt=\"FBMP\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/new-facebook-logo-nc.png\" width=\"30\" height=\"30\" title='$fblink' alt=\"FBMP\"></span>
					</a>";
		}
		
        $fbc = get_post_meta( $postid, '_fbmp_cost', true );
		
		if ( ! empty($fbc) )
		{
			echo "<p style='display: inline-block; 
					position: relative;
					top: -12px;
					padding: 6px; 
					color:#ffffff; 
					background-color:#1776f2; 
					text-align:center; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong>$fbc</strong></p>";
		}
		// end fb line div
		echo "</div>";
		
		// cl line div
		echo "<div style='
			overflow: hidden;
    		white-space: nowrap;'>";
        $cllink = get_post_meta( $postid, '_cl', true );
		
		if ( $cllink == "" )
		{
			echo "";
		}
		else if ( $cllink == "x" || $cllink == "X" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#521d83; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; X &nbsp; </strong></p>";
		}
		else if ( $cllink == "m" || $cllink == "M" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#521d83; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; M &nbsp; </strong></p>";
		}
		else if ( substr( $cllink, 0, 1 ) == "h" )
		{
			echo "<a class='admin_link_cl' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'
					href='$cllink' rel='noopener noreferrer' target='_blank'>
					<img src=\"https://ccrind.com/wp-content/uploads/2020/09/cllogo-white.png\" width=\"30\" height=\"30\" title=\"CL Link\" alt=\"CL\">
					</a>";
		}

        $clc = get_post_meta( $postid, '_cl_cost', true );
		
		if ( ! empty($clc) )
		{
			echo "<p style='display: inline-block; 
					position: relative;
					top: -12px;
					padding: 6px; 
					color:#ffffff; 
					background-color:#521d83; 
					text-align:center; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong>$clc</strong></p>";
		}
		// end cl line div
		echo "</div>";
		
		// ebay classified line div
		echo "<div style='
			overflow: hidden;
    		white-space: nowrap;
			margin-bottom: 5px;'>";
		
        $ebclink = get_post_meta( $postid, '_ebayclass', true );
		$ebclink = strtolower( $ebclink );
		
		if ( $ebclink == "" )
		{
			echo "";
		}
		else if ( $ebclink == "exclude" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; X &nbsp; </strong></p>";
		}
		else if ( $ebclink == "multi" )
		{
			echo "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; M &nbsp; </strong></p>";
		}
		else if ( substr( $ebclink, 0, 1 ) == "h" )
		{
			echo "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='$ebclink' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2020/10/ebaylogo-resize2round.png\" width=\"30\" height=\"30\" title='$ebclink' alt=\"ebayclass\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2020/10/ebaylogo-resize2round.png\" width=\"30\" height=\"30\" title='$ebclink' alt=\"ebayclass\"></span>
					</a>";
		}
		
		$ebcc = get_post_meta( $postid, '_ebayclass_cost', true );
		
		if ( ! empty($ebcc) )
		{
			echo "<p style='display: inline-block; 
					position: relative;
					top: -12px;
					padding: 6px; 
					color:#ffffff; 
					background-color:#1776f2; 
					text-align:center; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong>$ebcc</strong></p>";
		}
		// end ebay classified line div
		echo "</div>";
		
		$tslink = get_post_meta( $postid, '_threesixty', true );
		
		if ( $tslink == "" )
		{
			echo"";
		}
		else
		{
			echo "<a class='admin_link_360' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'
					href='$tslink' rel='noopener noreferrer' target='_blank'>
					<span id='initial'><img src=\"https://ccrind.com/wp-content/uploads/2020/07/sr-attachment-icon-360_onebw.png\" height=\"36px\" title='$tslink' alt=\"360\"></span>
					<span id='onhover'><img src=\"https://ccrind.com/wp-content/uploads/2020/08/sr-attachment-icon-360_onebw-invert.png\"  height=\"36px\" title='$tslink' alt=\"360\"></span>
					</a><br>";
		}
	}
	
	
	// Link input column
	if ( $column == 'links_input' ) 
    {
		$vlink = get_post_meta( $postid, '_video', true );
		$vlink = strtolower( $vlink );
		$lsn = get_post_meta( $postid, '_lsn', true );
		if ($lsn != "") { $lsn = strtolower( $lsn ); }
		$lsnlink = get_post_meta( $postid, '_lsnlink', true );
		if ($lsnlink != "") { $lsnlink = strtolower( $lsnlink ); }
		$lsnc = get_post_meta( $postid, '_lsn_cost', true );
		$fblink = get_post_meta( $postid, '_fbmp', true );
		if ($fblink != "") { $fblink = strtolower( $fblink ); }
		$fbc = get_post_meta( $postid, '_fbmp_cost', true );
		$cllink = get_post_meta( $postid, '_cl', true );
		if ($cllink != "") { $cllink = strtolower( $cllink ); }
		$clc = get_post_meta( $postid, '_cl_cost', true );
		$ebclink = get_post_meta( $postid, '_ebayclass', true );
		if ($ebclink != "") { $ebclink = strtolower( $ebclink ); }
		$ebcc = get_post_meta( $postid, '_ebayclass_cost', true );
		$tslink = get_post_meta( $postid, '_threesixty', true );
		
		/*echo "<form method='post' action=''>
			  	<input type='hidden' name='linkinputid' value='$postid'>";*/
				if ( $vlink == "" ) { echo "<div class='linkinputdiv'><label>YT:</label><input type='text' class='vlinkinput' name='vlinkinput'  placeholder='YT' style='opacity:0.3;'></div>"; }
				else { echo "<div class='linkinputdiv'><label>YT:</label><input type='text' class='vlinkinput' name='vlinkinput'  placeholder='$vlink'></div>"; }
		
				if ( $lsn == "" ) { echo "<div class='linkinputdiv'><label>LSN Account:</label><input type='text' class='lsninput' name='lsninput'  placeholder='LSN' style='opacity:0.3;'></div>"; }
				else { echo "<div class='linkinputdiv'><label>LSN Account:</label><input type='text' class='lsninput' name='lsninput'  value='$lsn'></div>"; }
		
				if ( $lsnlink == "" ) { echo "<div class='linkinputdiv'><label>LSN:</label><input type='text' class='lsnlinput' name='lsnlinput'  placeholder='Link' style='opacity:0.3;'>"; }
				else { echo "<div class='linkinputdiv'><label>LSN:</label><input type='text' class='lsnlinput' name='lsnlinput'  value='$lsnlink'>"; }
				if ( $lsnc == "" ) { echo "<input type='text' class='lsncinput' name='lsncinput'  placeholder='Cost' style='opacity:0.3;'></div>"; }
				else { echo "<input type='text' class='lsncinput' name='lsncinput'  placeholder='$lsnc'></div>"; }
		
				if ( $fblink == "" ) { echo "<div class='linkinputdiv'><label>FB:</label><input type='text' class='fblinput' name='fblinput'  placeholder='Link' style='opacity:0.3;'>"; }
				else { echo "<div class='linkinputdiv'><label>FB:</label><input type='text' class='fblinput' name='fblinput'  value='$fblink'>"; }
				if ( $fbc == "" ) { echo "<input type='text' class='fbcinput' name='fbcinput'  placeholder='Cost' style='opacity:0.3;'></div>"; }
				else { echo "<input type='text' class='fbcinput' name='fbcinput'  placeholder='$fbc'></div>"; }
		
				if ( $cllink == "" ) { echo "<div class='linkinputdiv'><label>CL:</label><input type='text' class='cllinput' name='cllinput'  placeholder='Link' style='opacity:0.3;'>"; }
				else { echo "<div class='linkinputdiv'><label>CL:</label><input type='text' class='cllinput' name='cllinput'  value='$cllink'>"; }
				if ( $clc == "" ) { echo "<input type='text' class='clcinput' name='clcinput'  placeholder='Cost' style='opacity:0.3;'></div>"; }
				else { echo "<input type='text' class='clcinput' name='clcinput'  placeholder='$clc'></div>"; }
		
				/*if ( $ebclink == "" ) { echo "<div class='linkinputdiv'><label>eBayC:</label><input type='text' class='ebclinput' name='ebclinput'  placeholder='Link' style='opacity:0.3;'>"; }
				else { echo "<div class='linkinputdiv'><label>eBayC:</label><input type='text' class='ebclinput' name='ebclinput'  value='$ebclink'>"; }
				if ( $ebcc == "" ) { echo "<input type='text' class='ebccinput' name='ebccinput'  placeholder='Cost' style='opacity:0.3;'></div>"; }
				else { echo "<input type='text' class='ebccinput' name='ebccinput'  placeholder='$ebcc'></div>"; }*/
		
				if ( $tslink == "" ) { echo "<div class='linkinputdiv'><label>360:</label><input type='text' class='threesixtylink' name='threesixtylink'  placeholder='360' style='opacity:0.3;'></div>"; }
				else { echo "<div class='linkinputdiv'><label>360:</label><input type='text' class='threesixtylink' name='threesixtylink'  value='$tslink'></div>"; }
		/*echo "	<div style='text-align:center;'><button type='submit' name='linksinput' class='linksinput' title='Update Links and Associated Costs'>Change</button></div>
			  </form>";*/
				echo "<a href='https://ccrind.com/log/LV/library/LSN/LSN.html' rel='noopener noreferrer' target='_blank'><label>LSN Renew Date:</label></a><div class='linkinputdiv'><input type='text' class='lsnaccdate' name='lsnaccdate'  placeholder='Name' title='Enter Account name in the format of lsn** or lsn*, * being the account number'>";
				echo "<input type='text' class='lsndaterenew' name='lsndaterenew'  placeholder='Date' title='Enter Date in the format of **/**/** or **/**, single numbers do not require leading zeros'></div>";
	}	
	
	if ( $column == '_excerpt' ) 
    {
		$ex = get_post_meta($postid,'_sdcp',true);
		$keyterms = get_post_meta($postid,'_key_terms',true);
		if ($ex != "") {
			echo "	<div class='excerptdisplay' style='user-select: all;'><textarea id='excerptdisplay$postid' class='excerptdisplay' name='excerptdisplay' rows='12' style='font-size:10px; user-select: all;'>$ex</textarea></div>"; 
			echo "<button class='btn excerptdisplaycopy' type='button' data-clipboard-target='#excerptdisplay$postid' style='margin-left: 40px;'> Copy </button>";
		}
		echo "	<div class='keytermsdisplay' style='user-select: all;'><textarea id='keytermsdisplay$postid' class='keytermsdisplay' name='keytermsdisplay' rows='3' style='font-size:10px; user-select: all;'>$keyterms</textarea></div>"; 
	}
	
	if ( $column == '_fix_info' ) 
    {
		$fixinfo = get_post_meta($postid,'_fix_info',true);
		if ($fixinfo != ""){
			echo "	<div class='fixinfodisplaydiv'><textarea id='fixinfodisplay' class='fixinfodisplay' name='fixinfodisplay' rows='15' title='Enter fixing note information here.  Enter the word \"clear\" to empty.'>$fixinfo</textarea></div>";  
		}
		else {
			echo "	<div class='fixinfodisplaydiv'><textarea id='fixinfodisplay' class='fixinfodisplay' name='fixinfodisplay' rows='15' placeholder='Fixing Info' title='Enter fixing note information here.'></textarea></div>";
		}
	}
	
	if ($email == "dan@ccrind.com")
	{
	if ( $column == '_note_dan' ) 
    {
		$note = get_post_meta( $postid, '_note_dan', true );
		if ($note != ""){
			echo "	<div class='notedandisplaydiv'><textarea id='notedandisplay' class='notedandisplay' name='notedandisplay' rows='11' title='Enter note information here.  Enter the word \"clear\" to empty.'>" . get_post_meta( $postid, '_note_dan', true ) . "</textarea></div>"; 
		}
		else {
			echo "	<div class='notedandisplaydiv'><textarea id='notedandisplay' class='notedandisplay' name='notedandisplay' rows='11' placeholder='Dans Notes' title='Enter note information here.'></textarea></div>";
		}
	}
	}
	
	
	
	if ( $column == '_soldby' ) 
    {
        $sold = get_post_meta( $postid, '_soldby', true );
		
		if ( $sold != "" )
		{
			if ($sold == "ebay") 
			{
				echo "<p class='admin_ebay_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/ebaylogo-e1573053326628.png\" title=\"ebay Sold\" alt=\"ebay\">
					</p>";
			}
			if ($sold == "ebayo") 
			{
				echo "<p class='admin_ebay_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/ebaylogo-e1573053326628.png\" title=\"ebay Sold\" alt=\"ebay\">
					</p>";
				echo "<div class='ebayo'>
						Order
					  </div>";
				global $current_user; $email = $current_user->user_email; if ($email == "jedidiah@ccrind.com" || $email == "adam@ccrind.com" ){
					echo "<div style='line-height: 1.2; color: #ffffff; text-align: center;'>KEEP fb/lsn</div>"; }
			}
			if ($sold == "ws") 
			{
				echo "<p class='admin_ws_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/3dlogotrans-e1573052696567.png\" title=\"WS Sold\" alt=\"Web Store\">
					</p>";
			}
			if ($sold == "wso") 
			{
				echo "<p class='admin_ws_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/3dlogotrans-e1573052696567.png\" title=\"WS Sold\" alt=\"Web Store\">
					</p>";
				echo "<div class='wso'>
						Order
					  </div>";
				global $current_user; $email = $current_user->user_email; if ($email == "jedidiah@ccrind.com" || $email == "adam@ccrind.com" ){
					echo "<div style='line-height: 1.2; color: #ffffff; text-align: center;'>KEEP fb/lsn</div>"; }
			}
			if ($sold == "fb") 
			{
				echo "<p class='admin_link_fb' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2020/08/new-facebook-logo-scaled-1.png\" title=\"FBMP Link\" alt=\"FBMP\">
					</p>";
			}
			if ($sold == "lsn") 
			{
				echo "<p class='admin_lsn_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/lsnlogo-1-e1573052305325.png\" title=\"LSN Sold\" alt=\"LSN\">
					</p>";
			}
			if ($sold == "qbo") 
			{
				echo "<p class='admin_qbo_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/qbologo-e1573053709978.png\" title=\"QBO Sold\" alt=\"QB\">
					</p>";
			}
			if ($sold == "qboo") 
			{
				echo "<p class='admin_qbo_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/qbologo-e1573053709978.png\" title=\"QBO Sold\" alt=\"QB\">
					</p>";
				echo "<div class='qboo'>
						Order
					  </div>";
				global $current_user; $email = $current_user->user_email; if ($email == "jedidiah@ccrind.com" || $email == "adam@ccrind.com" ){
					echo "<div style='line-height: 1.2; color: #ffffff; text-align: center;'>KEEP fb/lsn</div>"; }
			}
			if ($sold == "auc") 
			{
				echo "<p class='admin_auc_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/auction-2-e1573056132566.png\" title=\"Auction Sold\" alt=\"Auc\">
					</p>";
			}
			if ($sold == "auco") 
			{
				echo "<div class='auco'>
						Sent to
					  </div>";
				echo "<p class='admin_auc_sold' 
					style='display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;'>
					<img src=\"https://ccrind.com/wp-content/uploads/2019/11/auction-2-e1573056132566.png\" title=\"Auction Sold\" alt=\"Auc\">
					</p>";
			}
			if ($sold == "keep") 
			{
				echo "<div class='keep'>
						Keep
					  </div>";
			}
			if ($sold == "fix") 
			{
				echo "<div class='fix'>
						Fixing
					  </div>";
			}
			if ($sold == "scrap") 
			{
				echo "<div class='scrap'>
						Scrapped
					  </div>";
			}
		}
		
		if ( $sold != "" ) { echo "<br><br>"; }
		echo "<select id='soldbyform3' name='soldbyform3' class='soldbyform3'>
					<option value=''></option>
        			<option value='ws'>Webstore</option>
        			<option value='wso'>Webstore Order</option>
        			<option value='ebay'>eBay</option>
					<option value='ebayo'>eBay Order</option>
					<option value='qbo'>QB</option>
        			<option value='qboo'>QB Order</option>
        			<option value='fb'>FB</option>
					<option value='lsn'>LSN</option>
					<option value='auc'>Auction</option>
					<option value='auco'>Sent to Auction</option>
					<option value='keep'>Keep</option>
					<option value='fix'>Fix</option>
					<option value='scrap'>Scrapped</option>
					<option value='clear'>Clear</option>
   				</select>";
	}
	
	if ( $column == '_linkboxes' ) 
    {
		echo "<br>";
		echo "<input type='checkbox' id='clearlinks' name='clearlinks' class='clearlinksbox' value='1'>
  			  <label for='clearlinks' class='clearlinksl'> Clear Links</label><br>";
		echo "<br>";
		echo "<input type='checkbox' id='restorelinks' name='restorelinks' class='restorelinksbox' value='1'>
  			  <label for='restorelinks' class='restorelinksl'> Restore Links</label><br>";
		if ( current_user_can('administrator') ) {
			echo "<br>";
			echo "<input type='checkbox' id='lsnsetrenew' name='lsnsetrenew' class='lsnsetrenewbox' value='1'>
  			  <label for='lsnsetrenew' class='lsnsetrenewl'> Set LSN Date</label><br>";
		}
			 
		// end massive form
		echo "</form>";
	}
	if ( 'generate_quote' === $column )  
	{
		$ship = get_post_meta( $postid, '_customship', true );
		// translate $shipID to work with javascript function later
		$shiptrans = "";
		if ($ship == 2) { $shiptrans = "Local Pickup Only"; 
		echo "<div style='text-align: center; color: #c40403; background-color: #ffffff; border-radius: 5px; font-weight: bold;'>Local Pickup Only</div>"; }
		else {
		echo "<div class=order_notes_area' style='line-height: 1.2; height: 250px; width: 160px; overflow: auto;'>
		<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fshipquote-admin-menu-ccr.php' method='post' target='_blank'>
		<input type='hidden' name='productidallq' value='$postid'>
		<input type='text' class='shipCostInput' name='zip'' placeholder='Ship Zip'>
		<input type='text' class='genQnameInput' name='nameID' placeholder='Name / ID / Phone#'>
		<div><label for='lift' class='liftboxl'>Liftgate?</label>
		<input type='checkbox' id='lift' name='lift' class='liftbox' value='1'></div>
		<div><label for='addtype' class='addtypeboxl'>Resid Adr?</label>
		<input type='checkbox' id='addtype' name='addtype' class='addtypebox' value='1'></div>
		<div><label for='access' class='accessboxl'>Limited Ac?</label>
		<input type='checkbox' id='access' name='access' class='accessbox' value='1'></div>
		<div><label for='insidedelivery' class='insidedeliveryboxl'>Inside Delivery?</label>
		<input type='checkbox' id='insidedelivery' name='insidedelivery' class='insidedeliverybox' value='1'></div>
		<div><label for='terminal' class='terminalboxl'>Terminal?</label>
		<input type='checkbox' id='terminal' name='terminal' class='terminalbox' value='1'></div>
		<div><label for='flip' class='flipboxl'>OK reorient?</label>
		<input type='checkbox' id='flip' name='flip' class='flipbox' value='1'></div>
		<div style='margin: 10px;'><input type='submit'></div>
		<p>Optional Fields:</p>
		<div><label for='pallet40' class='pallet40boxl'>48x40</label>
		<input type='checkbox' id='pallet40' name='pallet40' class='pallet40box' value='1'></div>
		<div><label for='pallet48' class='pallet48boxl'>48x48</label>
		<input type='checkbox' id='pallet48' name='pallet48' class='pallet48box' value='1'></div>
		<div class='height_inputBEdiv'>
		<input type='text' class='shipCostInput' name='length' placeholder='L'></div>
		<div class='width_inputBEdiv'>
 		<input type='text' class='shipCostInput' name='width' placeholder='W'></div>
		<div class='height_inputBEdiv'>
 		<input type='text' class='shipCostInput' name='height' placeholder='H'></div>
		<input type='text' class='shipCostInput' name='weight' placeholder='Weight'>
		<div class='pallet_feeBEdiv'><p style='color: #ffffff; font-size: 10px;'>Pallet Fee</p>
		<input type='text' class='_pallet_feeBE' name='pfee' placeholder='Pallet Fee'></div>
		<div class='pallet_feeBEdiv'><p style='color: #ffffff; font-size: 10px;'>Item Price</p>
		<input type='text' class='shipCostInput' name='value' placeholder='Price'></div>
		<div class='length_inputBEdiv2'><input type='text' class='shipCostInput' name='sku' placeholder='SKU'></div>
		<div class='length_inputBEdiv2'><input type='text' class='shipCostInput' name='name' placeholder='Product Name' title='Product Name'></div>
		</form>
		</div>";
		}
	}
}
/**********************************************************************************************/


// sortable columns designated product columns sort
add_action( 'manage_edit-product_sortable_columns', 'sortable_product_column' );
function sortable_product_column( $columns ) 
{
	$columns['_stock_status_combine'] = 'SKU / Stock / Status';
	$columns['cond_test'] = __( 'Condition / Tested?');
	$columns['_price_cost'] = 'Price / Cost';
	$columns['cat_date_modifier'] = 'Categories / Date Modified';
    $columns['_warehouse_loc'] = 'WH Loc / Lister';
	$columns['_ccrind_brand'] = __( 'Brand' );
	$columns['_video'] = __( 'Video');
	$columns['_auction'] = __( 'Auction');
	$columns['_fix_info'] = __( 'Fixing Notes');
	$columns['_note_dan'] = __( 'Dan\'s Notes');
	$columns['_soldby'] = __( 'Sold by:');
    return $columns;
}
// sorting code
add_action( 'pre_get_posts', 'woo_meta_orderby' );
function woo_meta_orderby( $query ) 
{
    $orderby = $query->get('orderby');

	if( 'SKU / Stock / Status' == $orderby ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set( 'meta_key', '_sku' );
		$query->set( 'meta_type', 'numeric' );
    }
	if( 'Condition / Tested?' == $orderby ) {
        $query->set('meta_key','_ebay_condition_id');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set('orderby','meta_value');
	}
	if( 'Price / Cost' == $orderby ) {
		$query->set( 'orderby', 'meta_value_num' );
		$order = "";
		if ( isset($_GET['order']) ){ $order = $_GET['order'];}
		if ($order == "desc") { $order = "asc"; }
		else if ($order == "asc") { $order = "desc"; }
		else { $order = "desc"; }
		$query->set( 'order', $order );
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set( 'meta_key', '_regular_price' );
    }
	if( 'Categories / Date Modified' == $orderby ) {
		$query->set( 'orderby', 'modified' );
    }
    if( 'WH Loc / Lister' == $orderby ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set( 'meta_key', '_warehouse_loc' );
    }
	if( 'Brand' == $orderby ) {
		$query->set( 'orderby', 'meta_value' );
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set( 'meta_key', '_ccrind_brand' );
    }
	if( 'Video' == $orderby ) {
        $query->set('meta_key','_video');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set('orderby','meta_value');
	}
	if( 'Auction' == $orderby ) {
        $query->set('meta_key','_auction');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set('orderby','meta_value');
    }
	if( 'Sold by:' == $orderby ) {
        $query->set('meta_key','_soldby');
        $query->set('orderby','meta_value');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
		$query->set('order', $_GET['order'] );
    }
	if( 'Fixing Notes' == $orderby ) {
        $query->set('meta_key','_fix_info');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set('orderby','meta_value');
	}
	if( 'Dan\'s Notes' == $orderby ) {
        $query->set('meta_key','_note_dan');
		$query->set('meta_value',' ');
		$query->set('meta_compare','!=');
        $query->set('orderby','meta_value');
	}
	
	return $query;
}

// reorder columns column order
// add new sku column
add_filter( 'manage_edit-product_columns', 'custom_product_column',11);
function custom_product_column($columns)
{
    $new_columns = array();
    foreach( $columns as $key => $column ){
        $new_columns[$key] =  $columns[$key];
		if( $key === 'cb' ){
			$new_columns['custom_image'] = __( '<span class="wc-image tips">Image</span>' );
		}
        if( $key === 'name' ){
			$new_columns['updateall'] = __( 'Update ALL' );
			$new_columns['_stock_status_combine'] = __( 'SKU / Stock / Status');
			$new_columns['cond_test'] = __( 'Condtion / Tested?');
		}
		if( $key === 'price' ){
			$new_columns['_price_cost'] = __( 'Price / Cost' );
			//$new_columns['_adminbutton4']  = __('Price Change');
		}
		// move wp-lister (ebay) column to after the cl link
		if( $key === '_auction' ){
			$new_columns['listed_on_ebay'] = __( 'eBay' );
			$new_columns[$key] = $column;
		}
    }
    return $new_columns;
}
// remove old sku column remove column
add_filter( 'manage_edit-product_columns', 'remove_column' );
function remove_column( $cols ) {
	unset( $cols['sku'] );
	unset( $cols['thumb'] );
	unset( $cols['is_in_stock'] );
	unset( $cols['product_cat'] );
	unset( $cols['date'] );
	unset( $cols['post_type'] );
	unset( $cols['wpseo-score'] );
	unset( $cols['wpseo-score-readability'] );
	unset( $cols['wpseo-title'] );
	unset( $cols['wpseo-metadesc'] );
	unset( $cols['wpseo-focuskw'] );
	
	return $cols;
}
add_filter( 'manage_edit-shop_order_columns', 'remove_ordercolumn' );
function remove_ordercolumn( $cols ) {
	unset( $cols['order_total'] );
	
	return $cols;
}
/* end code to change admin columns */

// Make custom column sortable
add_filter( "manage_edit-shop_order_sortable_columns", 'shop_order_column_meta_field_sortable' );
function shop_order_column_meta_field_sortable( $columns )
{
    $meta_key = '_status_sort';
    return wp_parse_args( array('order_status' => $meta_key), $columns );
}

// Make sorting work properly (by numerical values)
add_action('pre_get_posts', 'shop_order_column_meta_field_sortable_orderby' );
function shop_order_column_meta_field_sortable_orderby( $query ) {
    global $pagenow;

    if ( 'edit.php' === $pagenow && isset($_GET['post_type']) && 'shop_order' === $_GET['post_type'] ){

        $orderby  = $query->get( 'orderby');
        $meta_key = '_status_sort';

        if ('_status_sort' === $orderby){
			$query->set('meta_key', $meta_key);
			$query->set('orderby', 'meta_value');
			$query->set('meta_value',' ');
			$query->set('meta_compare','!=');
        }
    }
}
/*************************************************************************************************************************/

// remove yoast seo admin search filters
add_action( 'admin_init', 'remove_yoast_seo_admin_filters', 20 );
function remove_yoast_seo_admin_filters() {
    global $wpseo_meta_columns ;
    if ( $wpseo_meta_columns  ) {
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown' ) );
        remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'posts_filter_dropdown_readability' ) );
		remove_action( 'restrict_manage_posts', array( $wpseo_meta_columns , 'yoast_orphaned' ) );
    }
}
// end remove yoast filters
/*************************************************************************************************************************/

/* filter by featured filter or not in product search */
add_action('restrict_manage_posts', 'featured_products_sorting');
function featured_products_sorting() {
    global $typenow;
    $post_type = 'product'; // change to your post type
    $taxonomy  = 'product_visibility'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Filter by Featured / Visibility"),
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));
    };
}
add_filter('parse_query', 'featured_products_sorting_query');
function featured_products_sorting_query($query) {
    global $pagenow;
    $post_type = 'product'; // change to your post type
    $taxonomy  = 'product_visibility'; // change to your taxonomy
    $q_vars    = &$query->query_vars;
    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}
/* end sort by featured code */

/*************************************************************************************************************************/

/* code to stop the automatic empty of trash for woocommerce / wp */
// added 7-17-18 by Jedidiah Fowler
function wpb_remove_schedule_delete() {
    remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}
add_action( 'init', 'wpb_remove_schedule_delete' );
/* end automatic trash empty code */
/*************************************************************************************************************************/

/*code to show sku in cart and at checkout pages */
add_filter( 'woocommerce_cart_item_name', 'showing_sku_in_cart_items', 99, 3 );
function showing_sku_in_cart_items( $item_name, $cart_item, $cart_item_key  ) {
    // The WC_Product object
    $product = $cart_item['data'];
    // Get the  SKU
    $sku = $product->get_sku();

    // When sku doesn't exist
    if(empty($sku)) return $item_name;

    // Add the sku
    $item_name .= '<br><small class="product-sku-cart">' . __( "SKU: ", "woocommerce") . $sku . '</small>';

    return $item_name;
}
/*************************************************************************************************************************/

/* code to enable fuzzy logic matching in search - Jedidiah Fowler - 1-17-19 */
add_filter( 'relevanssi_fuzzy_query', 'rlv_partial_inside_words' );
function rlv_partial_inside_words( $query ) {
    return "(term LIKE '%#term#%')"; 
}
/*************************************************************************************************************************/

/* add search bar to all woocommerce pages 
Jedidiah Fowler
1-17-19*/
add_action( 'woocommerce_before_main_content', 'insert_search', 15 );
function insert_search() 
{
	echo do_shortcode( '[aws_search_form]' );
}
/*************************************************************************************************************************/

/* add Category header link 
add_action( 'woocommerce_after_add_to_cart_button', 'insert_cat', 5 );
function insert_cat()
{
	$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

    if ( $product_cats && ! is_wp_error ( $product_cats ) )
	{
        $single_cat = array_shift( $product_cats );
		$single_cat_slug = $single_cat->slug;
		$href = "https://ccrind.com/product-category/";
		$newhref = $href . $single_cat_slug . "/";
		$line = "See all our $single_cat->name";
		
		echo "<br><br><br>
			<a class='category-button'
			href='$newhref' rel='noopener noreferrer' target='_blank'>$line</a>";
	}
}
/*************************************************************************************************************************/

/* code to alter google shopping feed data
Jedidiah Fowler
1-21-19 */
// ensure dimensions do not exceed google limit, add dimensions if missing, 400 cm is roughly 150 in
function google_dimensions( $elements, $product_id, $variation_id = null ) 
{
	if ( ! is_null( $variation_id ) ) {
        $id = $variation_id;
    } else {
        $id = $product_id;
    }
	
    $product = wc_get_product( $id );
	$length = '';
	$width = '';
	$height = '';
	$weight = '';
	$length = $product->get_length();
	$width = $product->get_width();
	$height = $product->get_height();
	$weight = $product->get_weight();

    if ( empty($length) || $length == 0 || $length == '' || is_null($length) || $length > 150 )
	{
		$length = "150 in";
		$elements['shipping_length'] = array( $length );
    }
	if ($elements['shipping_length'] == '' ) { $length = $product->get_width() . " in"; $elements['shipping_length'] = array( $length ); }
	if ( empty($width) || $width == 0 || $width == '' || is_null($width) || $width > 150 )
	{
		$width = "150 in";
		$elements['shipping_width'] = array( $width );
    }
	if ($elements['shipping_width'] == '' ) { $width = $product->get_width() . " in"; $elements['shipping_width'] = array( $width ); }
	if ( empty($height) || $height == 0 || $height == '' || is_null($height) || $height > 150 )
	{
		$height = "150 in";
		$elements['shipping_height'] = array( $height );
    }
	if ($elements['shipping_height'] == '' ) { $height = $product->get_width() . " in"; $elements['shipping_height'] = array( $height ); }
	if ( $weight == 0 || $weight == '' || is_null($weight) || $weight > 2000 )
	{
		$weight = 1999;
		$elements['shipping_weight'] = array ( $weight );
	}
	
	//$date = date('Y-m-d', strtotime('+1 years'));
	//$elements['priceValidUntil'] = array ( $date );
	
    return $elements;
}
add_filter( 'woocommerce_gpf_elements', 'google_dimensions', 11, 3 );
// end alter of product feed code
/*************************************************************************************************************************/


/* kill WooComerce status reports, added by Jedidiah Fowler 2-1-19 
function themeslug_deactivate_stock_reports($from) 
{
	global $wpdb;
	return "FROM {$wpdb-&amp;amp;amp;gt;posts} as posts WHERE 1=0";
}
add_filter( 'woocommerce_report_low_in_stock_query_from', 'themeslug_deactivate_stock_reports' );
add_filter( 'woocommerce_report_out_of_stock_query_from', 'themeslug_deactivate_stock_reports' ); */
// end kill status
// commented out for now - JNF
/*************************************************************************************************************************/

// Adjust the OAuth version used for Intuit Payments.
function sv_wc_intuit_payments_set_oauth_version( $version ) {
    return '2.0';
}
add_filter( 'wc_intuit_payments_oauth_version', 'sv_wc_intuit_payments_set_oauth_version' );
/*************************************************************************************************************************/

/* change order status bubble color of Payment pending and Completed */
add_action('admin_head', 'styling_admin_order_list' );
function styling_admin_order_list() {
    global $pagenow, $post;

    if( $pagenow != 'edit.php') return; 
	if ( $post == "" ) return;
    if( get_post_type($post->ID) != 'shop_order' ) return;

    if ($order_status = 'Pending') 
		{
    	?>
    	<style>
        	.order-status.status-<?php echo sanitize_title( $order_status ); ?> {
            	background: #378bbc;
				color: #ffffff;
				display: inline-block;
				flex-wrap: wrap;
				padding-right: 5px;
        	}
    	</style>
		<?php
	}
	if ($order_status = 'Completed') 
		{
    	?>
    	<style>
        	.order-status.status-<?php echo sanitize_title( $order_status ); ?> {
            	background: #c41a02;
				color: #ffffff;
        	}
    	</style>
		<?php
	}
	if ($order_status = 'Refunded') 
		{
    	?>
    	<style>
        	.order-status.status-<?php echo sanitize_title( $order_status ); ?> {
            	background: #01F7FF;
				color: #626262;
        	}
    	</style>
		<?php
	}
	
		?>
    	<style>
        	span.woocommerce-Price-amount.amount{
            	display: inline-block;
				color:#ffffff; 
				background-color:#83d363; 
				text-align:center; 
				padding: 8px; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
        	}
    	</style>
		<?php
}
/*************************************************************************************************************************/

add_filter( 'post_class', function( $classes ) {
	if ( is_admin() ) {
		$current_screen = get_current_screen();
		if ( $current_screen->base == 'edit' && $current_screen->post_type == 'shop_order' ) $classes[] = 'no-link';
	}
	return $classes;
} );
/*************************************************************************************************************************/ 

/* register custom fields for prepopulation in the google product feed */
function lw_woocommerce_gpf_custom_field_list( $list ) {
    // Register the _my_custom_field meta field as a pre-population option.
    $list['_regular_price'] = 'CCRIND price';
    $list['meta:_ccrind_price'] = 'google ads price';
	$list['meta:_ccrind_brand'] = 'CCRIND brand';
	$list['meta:_ccrind_mpn'] = 'CCRIND mpn';
	$list['meta:_gsf_value'] = 'GSF Value';
	$list['meta:_product_tier'] = 'CCRIND product tier';
	$list['product_visiblity'] = 'Visibility';
	$list['meta:_priceValidUntil'] = 'priceValidUntil';
	
    return $list;
}
add_filter( 'woocommerce_gpf_custom_field_list', 'lw_woocommerce_gpf_custom_field_list' );
/*************************************************************************************************************************/
/**
 * Adds product SKUs and warehouse Locations above the "Add to Cart" buttons on shop pages (lots of items listed)
 * Jedidiah Fowler 9-5-19
**/
function shop_display_skus() {
	global $product;
	$id = $product->get_id();
	$loc = get_post_meta( $id, '_warehouse_loc', true );
	$qty = $product->get_stock_quantity();
	if ( $product->get_sku() ) {
		echo '<div class="product-sku">SKU: <span style="user-select: all; -webkit-user-select: text;">' . $product->get_sku() . ' </span></div>';
		
	}
	if ( $loc != "" ) {
		echo '<div class="product-loc">LOC: ' . $loc . '</div>';
	}
	if ( $qty > 1 ) {
		echo '<br>';
		echo '<div class="product-qty">Quantity: ' . $qty . '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'shop_display_skus', 9 );
/*************************************************************************************************************************/
// admin add columns to orders
function add_order_item_column_header( $columns ) {
    $new_columns = array();
    foreach ( $columns as $column_name => $column_info ) {
        $new_columns[ $column_name ] = $column_info;
		if ( 'order_date' === $column_name ) {
            $new_columns['order_email'] = __( 'Email', 'ccrind' );
        }
        if ( 'order_status' === $column_name ) {
            $new_columns['order_item'] = __( 'Item', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_billship'] = __( 'Bill / Ship Address', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_inputship'] = __( 'Input Address', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_inputtrack'] = __( 'Input Tracking Info', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_itemstats'] = __( 'Size / Weight', 'ccrind' );
        }
		/*if ( 'shipping_address' === $column_name ) {
			$new_columns['order_test'] = __( 'Test', 'ccrind' );
        }*/
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_subtotal'] = __( 'Subtotal', 'ccrind' );
        }
		/*if ( 'shipping_address' === $column_name ) {
			$new_columns['order_shipping'] = __( 'Shipping Charge', 'ccrind' );
        }*/
		/*if ( 'shipping_address' === $column_name ) {
			$new_columns['order_tax'] = __( 'Tax', 'ccrind' );
        }*/
		/*if ( 'shipping_address' === $column_name ) {
			$new_columns['order_ccfee'] = __( 'CC Fee (Remove for PP)', 'ccrind' );
        }*/
		/*if ( 'shipping_address' === $column_name ) {
			$new_columns['payment_method'] = __( 'Payment Method', 'ccrind' );
        }*/
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_totalccr'] = __( 'Total', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['order_notes'] = __( 'Order Notes', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['update_order'] = __( 'Update Order', 'ccrind' );
        }
		if ( 'shipping_address' === $column_name ) {
			$new_columns['generate_quote'] = __( 'Generate Quote', 'ccrind' );
        }
		if ( 'wc_actions' === $column_name ) {
			$new_columns['instructions'] = __( 'Instructions', 'ccrind' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'add_order_item_column_header', 20 );

add_filter( 'manage_shop_order_posts_columns', 'set_shop_order_posts_columns', 99 );
  function set_shop_order_posts_columns( $columns ) {
    $columns['order_notes'] = 'Order Notes';
    return $columns;
}
/***************************************************************************************/
// change background of entire order row based on status order background color product background color
add_action('admin_head','change_order_processing_row_color');
function change_order_processing_row_color()
{
?>
<style type="text/css">
	.status-wc-completed { background: #410800 !important; outline: thin solid black; }
	.status-wc-pending { background: #133041 !important; outline: thin solid black;  }
	.status-wc-on-hold { background: #615742 !important; outline: thin solid black; }
	.status-wc-processing { background: #434d43 !important; outline: thin solid black; }
	.status-wc-cancelled { background: #5e5e5e !important; outline: thin solid black; }
	.status-wc-refunded { background: #004c4e !important; outline: thin solid black; }
	.type-product.status-publish { background: #1d3016 !important; outline: thin solid black; }
	.type-product.status-pending { background: #382900 !important; outline: thin solid black; }
	.type-product.status-draft { background: #0c272c !important; outline: thin solid black; }
	.type-product.status-private { background: #251114 !important; outline: thin solid black; }
</style>
<?php 
}
/***************************************************************************************
 * Adds Item column and SKU under the item name column
 */
function add_order_item_column_content( $column ) {
    global $post;
	
	$order    = wc_get_order( $post->ID );
	$orderid  = $order->get_id();
	$status   = $order->get_status();
	$method   = $order->get_payment_method();
	$keeponhold = get_post_meta($orderid, '_saved_status', true);
	$email	  = $order->get_billing_email();
	$add_emails = get_post_meta( $orderid, '_add_emails', true );
	$subj	  = $order->get_order_number();
	$phone    = $order->get_billing_phone();
	if ($phone == "") { $phone = get_post_meta( $orderid, '_saved_phone', true ); }
	$state    = $order->get_shipping_state();
	$paylink  = $order->get_checkout_payment_url();
	$saCB     = get_post_meta( $orderid, 'sa_checkbox', true );
	$sasCB    = get_post_meta( $orderid, 'sa_signed_checkbox', true );
	$ebayuser = "";
	$salesrecord = "";
	$imageflag = 0;
	$ordersearchlink = "https://ccrind.com/wp-admin/edit.php?s=$orderid&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1";
	$orderHasWireOnly = 0; // set to false
	// order month page variables
	$date = $order->get_date_created(); $date_converted = $date->format('m-d-y'); $month = date("m",strtotime($date)); $year = date("Y",strtotime($date));
	$paydate_o = $order->get_date_paid(); 
	if ($paydate_o != "") { $paydate = $paydate_o->format('m-d-y'); $month = date("m",strtotime($paydate_o)); $year = date("Y",strtotime($paydate_o)); } else { $paydate = " "; }
	switch ($month) {
    	case "01": $month_trans = "01-January"; break;
   		case "02": $month_trans = "02-February"; break;
		case "03": $month_trans = "03-March"; break;
		case "04": $month_trans = "04-April"; break;
		case "05": $month_trans = "05-May"; break;
		case "06": $month_trans = "06-June"; break;
		case "07": $month_trans = "07-July"; break;
		case "08": $month_trans = "08-August"; break;
		case "09": $month_trans = "09-September"; break;
		case "10": $month_trans = "10-October"; break;
		case "11": $month_trans = "11-November"; break;
		case "12": $month_trans = "12-December"; break;
	}
	
	$items_first = $order->get_items();
	$list = "";
	foreach( $items_first as $item )
	{
			$product = wc_get_product($item->get_product_id());
			$id = $item->get_product_id(); 
			$name = $item->get_name();
			$namelink = "https://ccrind.com/wp-admin/post.php?post=$id&action=edit";
			$link = get_permalink($id);
			$qty = $item->get_quantity();
			if ( $product != "" ) { $sku = $product->get_sku(); }
			$break = "<br>";
			
			$itemname = $name . "   \n";
			$qtylist = "(Quantity: $qty)    \n";
			$skulist = "SKU: $sku     \n";
			
			$list = $list . $itemname . $qtylist . $skulist;

		// test to see if order has a customship code of 3 *wire only*
		if ( (get_post_meta( $item->get_product_id(), '_customship', true ) == 3) || ( (get_post_meta( $item->get_product_id(), '_customship', true ) =="3" ) ) )
		{ $orderHasWireOnly = 1; } // set to true
	}
	
	$order_notes = get_private_order_notes( $orderid );
	foreach($order_notes as $note)
	{
    	$note_content = $note['note_content'];
		if(strpos( $note_content, "eBay User ID:") !== false) { $imageflag = 1; }
	}
	
	if ( 'order_number' === $column ) 
	{
		$order_notes = get_private_order_notes( $orderid );
		foreach($order_notes as $note)
		{
    		$note_content = $note['note_content'];
			if(strpos( $note_content, "eBay User ID:") !== false)
			{
				$imageflag = 1;
				$ebayuser = substr ( $note_content, strpos( $note_content, "eBay User ID:"), strpos( $note_content, "eBay Sales Record ID:") );
				$ebayusername = substr ( $note_content, strpos( $note_content, "eBay User ID:") + 14 , strpos( $note_content, "eBay Sales Record ID:") - 14 );
				$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
				$salesrecord = "E" . $srnum;
				// form link for user page
				$ebayuserlink = "<a href=\"https://www.ebay.com/usr/$ebayusername\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#f4ae02 !important\">$ebayuser</a>";
				// form link for sales record
				$ebaylink = "<a href=\"https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber&search=salesrecordnumber%3A$srnum\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#85b716 !important\">$salesrecord</a>";
			}
		}
		
		// if an ebay id was found, show as ebay
		if( $imageflag )
		{	
			$ccfee = 0;
			// Iterating through order fee items ONLY to find CC Fee
			foreach( $order->get_items('fee') as $item_id => $item_fee ) {
				$fee_name = $item_fee->get_name();
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "usage fee") ) { $ccfee = $ccfee + $item_fee->get_total(); } }
			if ($ccfee == 0 && $method == "None") {
				if ($status == "pending"){ echo "<div class='updateme'>UPDATE ORDER TO PREP</div><br><br>"; }
			}
			echo '<div style="display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					background-color: #ffffff;
					padding-top: 10px;
					padding-bottom: 10px;
					overflow-wrap: break-word !important; 
					word-break: break-all !important;"';
			echo '<p class="admin_ebay_sold" style="display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;">
					<img src="https://ccrind.com/wp-content/uploads/2019/11/ebaylogo-e1573053326628.png" title="ebay Sold" alt="ebay">
					</p>';
			echo '<p>'.$ebayuserlink.'</p><br>';
			echo "<p id='EBoNum$orderid'>".$ebaylink."</p></div>";
		}
		else //its a ccrind.com order
		{
			// if an order that needs Prep
			if ($method == "cod"){
				if ($status == "processing"){ echo "<div class='updateme'>UPDATE ORDER TO PREP</div><br><br>"; }
			}
			echo '<p class="admin_ws_order" style="display: inline-block; 
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					background-color: #b51800;">
					<img src="https://ccrind.com/wp-content/uploads/2021/01/3dlogoinvert.png" title="Logo" alt="Web Store width="53" height="34">
					</p><br>';
		}

		echo "<a href=\"https://ccrind.com/wp-admin/post.php?post=$orderid&action=edit\" rel=\"noopener noreferrer\" target=\"_blank\" class=\"ccr_order_num\" style=\"display: inline-block; font-size: 13px;\"><strong>
		<text id='oNum$orderid'>C$orderid</text>
		</strong></a>";
		echo "<br>";
		echo "<br>";
		//echo "<a style='color: #9c7349 !important;' class='order_search_link' href='$ordersearchlink' rel='noopener noreferrer' target='_blank'></a>";
		echo "<button class='btn order_search_link' onclick=\"window.open('$ordersearchlink','_blank');\" type='button' alt='Open Order Alone Isolate'></button>";
		$prefix = substr($orderid, 0, 4);
		//echo "&nbsp;&nbsp;<a href=\"https://ccrind.com/log/LV/library/order-logs/$prefix/$orderid.txt\" rel=\"noopener noreferrer\" target=\"_blank\">LOG</a>";
		echo "&nbsp;&nbsp;<button class='btn order_log_link' onclick=\"window.open('https://ccrind.com/log/LV/library/order-logs/$prefix/$orderid.html','_blank');\" type='button' alt='Open Order Log'></button>";
		
		//echo "&nbsp;&nbsp;<button class='btn generateSA' onclick=\"window.open('https://ccrind.com/wp-admin/post.php?post=$orderid&action=edit&bewpi_action=view_packing_slip&nonce=$nonce','_blank');\" type='button' alt='Generate Sales Agreement'></button>";
		echo "<br>";
		// copy order number button
		echo "<button class='btn oNumbutton' type='button' alt='Copy Order Number' data-clipboard-target='#oNum$orderid'></button>";
		// if it has an ebay order number, show an order copy button
		if( $imageflag )
		{ echo "&nbsp;&nbsp;<button class='btn EBoNumbutton' type='button' alt='Copy eBay Order Number' data-clipboard-target='#EBoNum$orderid'></button>"; }
		echo "<br>";
		// ship quote log button
		if ( file_exists("../library/order-logs/$prefix/ShipQ$orderid.html") ) {
			echo "<button class='btn ship_quote_log_link' onclick=\"window.open('https://ccrind.com/log/LV/library/order-logs/$prefix/ShipQ$orderid.html','_blank');\" type='button' alt='Open Ship Quote Log'></button>"; 
		}
		// admin only fields 
		if( current_user_can('administrator') && $status == "on-hold" )
		{
			$test2 = $order->get_billing_address_1();
			$phone = $order->get_billing_phone();
			if ($test2) {
			if ( $phone != "") {
				echo "<br>";
				if( $imageflag ) { $num = $salesrecord; } 
				else { $num = "C$orderid"; }
				$msg = "New order $num ready for ship charge";
				echo "<div class='ship_ready_text' id='shipready$orderid' style='height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all; opacity: 0;'>$msg</div>";
				echo "<button class='btn shipreadybutton' type='button' alt='Copy Shipping Name' data-clipboard-target='#shipready$orderid'></button>";
				echo "<p style='margin-left: 5px; margin-top:-17px;'>Ship Ready<p>";
			} }
		}
		if( current_user_can('administrator') && ($status == "on-hold" || $status == "pending" ) ) {
			/* = get_post_meta( $orderid, '_sent_followup', true ); $sentfollowupdateTrim = date_format(date_create_from_format('y-m-d', $sentfollowupdate), 'm-d-y');
			if ($sentfollowupdate != "") {
				if ( strtotime($sentfollowupdate) < strtotime('-2 days') ) { 
					if( $imageflag ) { $num = $salesrecord; } 
					else { $num = "C$orderid"; }
					$msg2 = "$num is due for cancellation, unless you have reason not to do so";
					echo "<div class='ship_ready_text' id='cancelready$orderid' style='height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all; opacity: 0;'>$msg2</div>";
					echo "<button class='btn cancelreadybutton' type='button' alt='Copy Auto-Generated shipready Text' data-clipboard-target='#cancelready$orderid'><text style='color: #c40403 !important;'>Cancel Due</text></button>";
				}
			}*/
		}
	}
	if ( 'order_date' === $column )	
	{
		$allsku = "";
		foreach( $items_first as $item ) {
			$product = "";
			$product = wc_get_product($item->get_product_id());
			$id = $item->get_product_id();
			if ($product) { $sku = $product->get_sku(); }
			if ( has_post_thumbnail( $id ) ) {
				$allsku = $allsku . $sku . "<br>";
			}
		}
		echo "<div class='order_allsku' id='order_allsku$orderid' style='opacity: 0; height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all;'>$allsku</div>";
		echo "<div class='order_pics' style='height: 320px; overflow: auto;'>";
		foreach( $items_first as $item ) {
			$product = wc_get_product($item->get_product_id());
			$id = $item->get_product_id();
			$sku = $product->get_sku();
			if ( has_post_thumbnail( $id ) ) {
				echo "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a><br>";
				$image = wp_get_attachment_url( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
				echo "<a href=\"$image\"  rel=\"noopener noreferrer\" target=\"_blank\">
				<img width=\"180\" src=\"$image\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" loading=\"lazy\"></a>";
			}
		}
		echo "</div>";
		if ($paydate_o != "") {
			echo "<div>Paid: $paydate</div>"; }
			//$paidM = substr($paydate, 0, 2); echo "<div>PaidM: $paidM</div>"; 
			//$date = $order->get_date_created(); $date_converted = $date->format('m-d-y'); $month = $orderM = date("m",strtotime($date)); $year = date("Y",strtotime($date));
			//echo "<div>OrderM: $orderM</div>";
	}
	if ( 'order_email' === $column ) 
	{
		// start the form for input submission
		// hidden button to allow to work on first order in list
		echo "<form method='post' action=''>
			  	<input type='hidden' name='orderidfirst' value='$orderid'>
			  	<button type='submit' name='orderbuttonhidden' style='display:none;'></button>
			  </form>";
		// get order id for the form
		echo "<form method='post' action=''>
			  	<input type='hidden' name='orderidall' value='$orderid'>";
				
		$order_notes = get_private_order_notes( $orderid );
		foreach($order_notes as $note)
		{
    		$note_content = $note['note_content'];

			if(strpos( $note_content, "eBay User ID:") !== false)
			{
				$imageflag = 1;
				$ebayuser = substr ( $note_content, strpos( $note_content, "eBay User ID:"), strpos( $note_content, "eBay Sales Record ID:") );
				$ebayusername = substr ( $note_content, strpos( $note_content, "eBay User ID:") + 14 , strpos( $note_content, "eBay Sales Record ID:") - 14 );
				$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
				$salesrecord = "E" . $srnum;
				// form link for user page
				$ebayuserlink = "<a href=\"https://www.ebay.com/usr/$ebayusername\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#f4ae02 !important\">$ebayuser</a>";
				// form link for sales record
				$ebaylink = "<a href=\"https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber&search=salesrecordnumber%3A$srnum\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#85b716 !important\">$salesrecord</a>";
			}
		}
		
		// customize email subject line based on order origin
		echo "<div style='line-height: 1.2;'>";
		if ($email == "") { 
			echo "<p><input type='text' class='setEmailInput' name='setEmailInput' rows='1' placeholder='(email)' title='Enter email'></p>";
		}
		if( $imageflag ) { echo "<a href=\"mailto:$email?subject=ebay Order #$salesrecord&body=Order Items: $list\" rel=\"noopener noreferrer\" target=\"_blank\">$email</a>"; }
        else { echo "<a href=\"mailto:$email?subject=ccrind.com Order #$subj&body=Order Items: $list\" rel=\"noopener noreferrer\" target=\"_blank\">$email</a>"; }
		// phone number
		$didphone = 1;
		if (strlen($phone) == 10)
		{
			echo "<div class='orderPhone'>";
			echo substr($phone, 0, 3) . "-" . substr($phone, 3, 3) . "-" . substr($phone, 6, 4);
			echo "</div>";
		}
		else if ($phone == "" ) { 
			echo "<input type='text' class='setPhoneInput' name='setPhoneInput' rows='1' placeholder='(phone #)' title='Enter phone number with no dashes or other formatting'>"; $didphone = 0;
		}
		else { echo "<div class='orderPhone'>$phone</div>"; }
		// check for valid phone number lengths
		if (strlen($phone) == 10 || strlen($phone) == 12) { /* do nothing */ }
		else { 
			if ( $didphone ) {
				echo "<input type='text' class='setPhoneInput' name='setPhoneInput' rows='1' placeholder='(phone #)' title='Enter phone number with no dashes or other formatting'>"; } }
		// additional emails
		if ($add_emails != "")
		{
			echo "<br><text style='color: #ffffff;'><br>Additional Emails: </text><br>";
			if( $imageflag )
			{ echo "<a href=\"mailto:$add_emails?subject=ebay Order #$salesrecord&body=Order Items: $list\" rel=\"noopener noreferrer\" target=\"_blank\">$add_emails</a>"; }
        	else 
			{ echo "<a href=\"mailto:$add_emails?subject=ccrind.com Order #$subj&body=Order Items: $list\" rel=\"noopener noreferrer\" target=\"_blank\">$add_emails</a>"; }
		}
		echo "<p style='color: #ffffff;'><br>More Emails &nbsp; <i class='fa-solid fa-square-envelope fa-2xl'></i></p>";
		echo "<input type='text' class='addEmailInput' name='addEmailInput' rows='1' placeholder='(email, email, etc)' title='Enter additional emails in the format of the placeholder text, enter \"clear\" to clear all additional emails'>";
		// payment link
		if ($paylink != "") { echo "<br><a href=\"$paylink\" rel=\"noopener noreferrer\" target=\"_blank\">Customer payment page &#8594;</a>"; }
		$dne = get_post_meta( $orderid, '_dnemail', true );
		if ($dne) {
			echo "<br><div class='dnemail_checkdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 0.8; font-size: 12px;'><input type='checkbox' id='dnemailcheck$orderid' name='dnemailcheck' class='dnemailcheck' value='1' checked><label for='dnemailcheck$orderid' class='dnemailcheckl' checked> Do NOT Email</label></div>";
		}
		else { 
			echo "<br><div class='dnemail_checkdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 0.8; font-size: 12px;'><input type='checkbox' id='dnemailcheck$orderid' name='dnemailcheck' class='dnemailcheck' value='1'><label for='dnemailcheck$orderid' class='dnemailcheckl'> Do NOT Email</label></div>"; }
		// admin only fields 
		if ( current_user_can('administrator') ) {
			// get date of order creation but change to date paid if possible
			$date = $order->get_date_created(); $date_converted = $date->format('m-d-y'); $month = date("m",strtotime($date)); $year = date("Y",strtotime($date));
			$status   = $order->get_status();
			$paymethod = $order->get_payment_method();
			if ($paymethod == "Other") { $tid = $order->get_transaction_id(); $paymethod = $tid; }
			else if ($paymethod == "quickbookspay") { $paymethod = "Credit Card"; }
			else if ($paymethod == "paypal" || $paymethod === 'angelleye_ppcp' || $paymethod == "ppcp-gateway" || $paymethod == "ppcp") { $paymethod = "PayPal"; }
			else if ($paymethod == "stripe") { $paymethod = "Credit Card"; }
			else if ($paymethod == "cod") { $paymethod = ""; }
			if ($paymethod != ""  ) {
				$paydate_o = $order->get_date_paid(); 
				if ($paydate_o != "") { 
					$paydate = $paydate_o->format('m-d-Y'); 
					$month = date("m",strtotime($paydate_o)); $year = date("Y",strtotime($paydate_o)); } }
			echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>___________</div>";
			echo "<div class='gologYear_checkdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 0.8; font-size: 9px;'><input type='checkbox' id='gologYearcheck$orderid' name='gologYearcheck' class='gologYearcheck' value='1'><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$year.html' rel=\"noopener noreferrer\" target=\"_blank\"><label for='gologYearcheck' class='gologYearcheckl'> Gen. Order Log Year</label></a></div>";
			echo "<div class='golog_checkdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 0.8; font-size: 9px;'><input type='checkbox' id='gologcheck$orderid' name='gologcheck' class='gologcheck' value='1'><label for='gologcheck$orderid' class='gologcheckl'> Gen. Order Log</label></div>";
			$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
			$qbo_total = get_user_meta( $userID, "qbo_total$month", true );
			$qbo_count = get_user_meta( $userID, "qbo_countc$month", true );
			$qbo_shipprofit = get_user_meta( $userID, "qbo_shipprofit$month", true );
			// translate the month number to month name for paid
			switch ($month) {
    			case "01": $month_trans = "01-January"; break;
   				case "02": $month_trans = "02-February"; break;
				case "03": $month_trans = "03-March"; break;
				case "04": $month_trans = "04-April"; break;
				case "05": $month_trans = "05-May"; break;
				case "06": $month_trans = "06-June"; break;
				case "07": $month_trans = "07-July"; break;
				case "08": $month_trans = "08-August"; break;
				case "09": $month_trans = "09-September"; break;
				case "10": $month_trans = "10-October"; break;
				case "11": $month_trans = "11-November"; break;
				case "12": $month_trans = "12-December"; break;
			}
			echo "<a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$month_trans.html' rel=\"noopener noreferrer\" target=\"_blank\"><p>QBO Total/# $month:</p></a>";
			if ($qbo_total != "") { echo "<input type='text' class='inputQBOtotal' name='inputQBOtotal' rows='1' placeholder='$qbo_total' title='Enter the total for the QBO sales here.'>"; }
			else { echo "<input type='text' class='inputQBOtotal' name='inputQBOtotal' rows='1' placeholder='(QBO TOTAL)' title='Enter the total for the QBO sales here.'>"; }
			if ($qbo_count != "") { echo "<input type='text' class='inputQBOcount' name='inputQBOcount' rows='1' placeholder='$qbo_count' title='Enter the total completed sales for the QBO here.'>"; }
			else { echo "<input type='text' class='inputQBOcount' name='inputQBOcount' rows='1' placeholder='(QBO Count)' title='Enter the total completed sales for the QBO here.'>";}
			if ($qbo_shipprofit != "") { echo "<input type='text' class='inputQBOsp' name='inputQBOsp' rows='1' placeholder='$qbo_shipprofit' title='Enter the total ship profit for the QBO here.'>"; }
			else { echo "<input type='text' class='inputQBOsp' name='inputQBOsp' rows='1' placeholder='(QBO Ship Profit)' title='Enter the total ship profit for the QBO here.'>";}
			//echo "<button class='btn order_log_link' onclick=\"window.open('https://ccrind.com/log/?dir=library%2Forder-logs%2FY2022','_blank');\" type='button' alt='Open Order Year Log Dir'></button>";
		}
    }

	if ( 'order_status' === $column ) 
	{
		if ($status == "processing" && !$saCB && !$sasCB)
		{
			if ( $method == "cod" || $method== "" ) { /* do nothing */ }
			else {
				echo "<div class='order-processing-textMADE'>Needs SA Made</div>";
				echo "<p class='order-processing-invoice' style='text-align: center;'><i class='fa-solid fa-file-invoice fa-2xl'></i></p></div>"; 
			}
		}
		else if ( $status == "processing" && $saCB && !$sasCB)
		{
			echo "<div class='order-processing-textSIGN'>Needs SA Signed</div>";
			echo "<p class='order-processing-sign' style='text-align: center;'><i class='fa-solid fa-file-signature fa-2xl'></i></p>";
		}
		else if ( $status == "processing" && $saCB && $sasCB )
		{
			$items = (array) $order->get_items('shipping');
			$firstitem = true;
			$track = "Needs Tracking Info";
			foreach ( $items as $item ) {
				if ($firstitem) {
    				$ship_title = $item->get_method_title();
					if (strpos($ship_title, 'Local Pickup') !== false) { $track = "Local Pickup"; }
					$firstitem = false; 
				}
			}
			echo "<div class='order-processing-textTRACK'>$track</div>";
			echo "<p class='order-processing' style='text-align: center;'><i class='fa-solid fa-cart-flatbed fa-2xl'></i></p>";
		}
		
		if ($status == "on-hold") { echo "<div class='order-onhold' style='text-align: center; font-size: 24px;'><i class='fa-solid fa-circle-pause fa-2xl'></i></div>"; }
		if ($status == "completed") { echo "<div class='order-completed' style='text-align: center; font-size: 24px;'><i class='fa-solid fa-circle-check fa-2xl'></i></div>"; }
		if ($status == "pending") { echo "<div class='order-pending' style='text-align: center; font-size: 24px;'><i class='fa-solid fa-file-invoice-dollar fa-2xl'></i></div>"; }
		if ($status == "refunded") { echo "<div class='order-refunded' style='text-align: center; font-size: 24px;'><i class='fa-solid fa-hand-holding-dollar fa-2xl'></i></div>"; }
		if ($status == "cancelled") { echo "<div class='order-cancelled' style='text-align: center; font-size: 24px;'><i class='fa-solid fa-circle-xmark fa-2xl'></i></div>"; }
		echo "<br><select id='formorderstatuschange' name='formorderstatuschange' class='formorderstatuschange'>
					<option value=''></option>
        			<option value='pending'>Pending payment</option>
        			<option value='processing'>Processing</option>
        			<option value='on-hold'>On hold</option>
					<option value='completed'>Completed</option>
        			<option value='cancelled'>Cancelled</option>
        			<option value='refunded'>Refunded</option>
   				</select><br><br>";
		
		// if ebay order
		$ebayID = get_post_meta( $orderid, '_ebayID', true );
		if( $ebayID != "" )
		{
			// admin fields only
			if( current_user_can('administrator') )
			{
				// show saved status
				$saved = get_post_meta( $orderid, '_saved_status', true );
				echo "<div style='color:#ffffff; line-height: 1.2; text-align: center;'>Saved Status:<br><text style='color: ";
				if ($saved == "pending") { echo "#368bbc;'>$saved</div></div><br>"; }
				else if ($saved == "processing") { echo "#c6e1c6;'>$saved</text></div><br>"; }
				else if ($saved == "on-hold") { echo "#f7dca5;'>$saved</text></div><br>"; }
				else if ($saved == "completed") { echo "#c41a02;'>$saved</text></div><br>"; }
				else { echo "#fffff;>'$saved</text></div><br>"; }
			}
		}
	}

    if ( 'order_item' === $column ) 
	{
        $items = $order->get_items();
		$cost = $cost1 = $clcost = $fbcost = $lsncost = 0;
		$count = 0;
		$allsku = "";
		echo "<div class='item_list' style='height: 300px; overflow: auto;'>";
		foreach( $items as $item )
		{
			$product = wc_get_product($item->get_product_id());
			$data = $item->get_data();
			$id = $item->get_product_id();
			$product_id = $data['product_id'];
			$name = $item->get_name();
			$namelink = "https://ccrind.com/wp-admin/post.php?post=$id&action=edit";
			$link = get_permalink($id);
			$qty = $item->get_quantity();
			if ($product != "") { $sku = $product->get_sku(); $allsku = $allsku . $sku . "+" ; $count = $count + 1; }
			$loc = get_post_meta( $id, '_warehouse_loc', true );
			if ( get_post_meta( $id, '_cost', true ) != "" ) {
				$cost1 = (int) get_post_meta( $id, '_cost', true ); } 
			$cost = $cost + ($cost1 * $qty);
			if ( get_post_meta( $id, '_cl_cost', true ) != "" ) {
				$clcost = (int) get_post_meta( $id, '_cl_cost', true ); }
			if ( get_post_meta( $id, '_fbmp_cost', true ) != "" ) {
				$fbcost = (int) get_post_meta( $id, '_fbmp_cost', true ); }
			if ( get_post_meta( $id, '_lsn_cost', true ) != "" ) {
				$lsncost = $lsnc = (int) get_post_meta( $id, '_lsn_cost', true ); }
			$cost = $cost + $clcost + $fbcost + $lsncost;
			echo "<div style='line-height: 1.2;'>";
			echo "<a class='order_item_link' href='$namelink' rel='noopener noreferrer' target='_blank'><strong>$name</strong></a>";
			echo "<br>";
			echo "<span class='orderqty'>&nbsp;$qty&nbsp;</span><br>";
			echo "<text style='color: #ffffff;'>SKU: </text><a class='order_item_link' href='$link' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a><br>";
			echo "<text style='color: #ffffff;'>Location: </text><a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$loc</strong></a><br>";
			echo "<text style='color: #ffffff;'>Item Backend Link: </text><a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a><br>";
			// loop through all categories and display links, edited out to display ONLY the primary category
			/*$terms = get_the_terms( $id, 'product_cat' );
			$total = count($terms);
			$i = 0;
			foreach ($terms as $term) 
			{
				$i++;
				echo '<a href="' .  esc_url( get_term_link( $term->term_id ) ) . '">';
				echo $term->name;
				echo '</a>';
				if ($i != $total) echo ', ';
			}
			echo "<br>";*/
			$primary_cat_id = get_post_meta($id,'_yoast_wpseo_primary_product_cat',true);
			$category_link = $prodcatname = "";
			if($primary_cat_id)
			{
				$product_cat = get_term($primary_cat_id, 'product_cat');
				if(isset($product_cat->name))
				$category_link = get_category_link($primary_cat_id);
				$prodcatname = $product_cat->name;
			}
			else
			{
				// loop through all categories and display links
				$terms = get_the_terms( $id, 'product_cat' );
				$total = count($terms);
				$i = 0;
				foreach ($terms as $term) 
				{
					$i++;
					echo "<a id='catName$orderid' href='esc_url( get_term_link( $term->term_id ) )'>$term->name</a>";
					if ($i != $total) echo ', ';
				}
			}
			if ($category_link != "" && $prodcatname != ""){
				echo "<a href = \"$category_link\" id=\"catName$orderid\" class=\"catName\">$prodcatname</a>"; }
			echo "<br>";
			echo "</div>";
			echo "<br>";
		}
		echo "</div>";
		echo "<br>";
		if ($cost != 0) { echo "<text class='costorder' name='costorder'>Cost: $" . number_format($cost, 2, '.', ',') . "</text>"; echo "<br>"; }
		if ($count > 1) { echo "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=$allsku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_cat&product_type&stock_status&paged=1&postidfirst=131825&action2=-1' rel='noopener noreferrer' target='_blank'><strong>ALL ITEMS ($count)</strong></a><br>"; }
		// copy category button
		echo "<button class='btn catbutton' type='button' alt='Copy Category' data-clipboard-target='#catName$orderid'></button>";
		// copy bill name button
		echo "&nbsp;&nbsp;&nbsp;<button class='btn billnamebutton' type='button' alt='Copy Billing Name' data-clipboard-target='#billname$orderid'></button>";
		// copy all skus of the order button
		echo "&nbsp;&nbsp;&nbsp;<button class='btn copyallskubutton' type='button' alt='Copy All SKUs of Order' data-clipboard-target='#order_allsku$orderid'></button>";
		// copy ship name button
		echo "<br><button class='btn shipnamebutton' type='button' alt='Copy Shipping Name' data-clipboard-target='#shipname$orderid'></button>";
		// copy ship address 1 button
		echo "&nbsp;&nbsp;&nbsp;<button class='btn shipaddonebutton' type='button' alt='Copy Shipping Add.St.' data-clipboard-target='#shipaddone$orderid'></button>";
		// copy ship zip code button
		echo "&nbsp;&nbsp;&nbsp;<button class='btn shipzipbutton' type='button' alt='Copy Shipping Zip' data-clipboard-target='#shipzip$orderid'></button>";
    }
	
	if ( 'shipping_address' === $column ) 
	{
		/*$order_notes = get_private_order_notes( $orderid );
		foreach($order_notes as $note)
		{
    		$note_content = $note['note_content'];

			if(strpos( $note_content, "eBay User ID:") !== false)
			{
				$imageflag = 1;
				$ebayuser = substr ( $note_content, strpos( $note_content, "eBay User ID:"), strpos( $note_content, "eBay Sales Record ID:") );
				$ebayusername = substr ( $note_content, strpos( $note_content, "eBay User ID:") + 14 , strpos( $note_content, "eBay Sales Record ID:") - 14 );
				$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
				$salesrecord = "E" . $srnum;
				// form link for user page
				$ebayuserlink = "<a href=\"https://www.ebay.com/usr/$ebayusername\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#f4ae02 !important\">$ebayuser</a>";
				// form link for sales record
				$ebaylink = "<a href=\"https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber&search=salesrecordnumber%3A$srnum\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#85b716 !important\">$salesrecord</a>";
			}
		}
		if ($imageflag) // ebay order
		{
			$ccfee = 0;
			// Iterating through order fee items ONLY to find CC Fee
			foreach( $order->get_items('fee') as $item_id => $item_fee ) {
				$fee_name = $item_fee->get_name();
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "usage fee") ) { $ccfee = $ccfee + $item_fee->get_total(); } /* close foreach( $order->get_items('fee') */ /*}
			if ($keeponhold == "" && $ccfee == 0 && $method != "") {
				if ($status == "on-hold"){ echo "<div class='updateme'>SEND EBAY INVOICE TO IMPORT SHIPPING ADDRESS</div><br><br>"; }
			}
		}*/
		
		// display Address info if it is a ws order
		$addtype = get_post_meta( $orderid, 'address_type', true );
		$unloadtype = get_post_meta( $orderid, 'unload_type', true );
		//$delivery = get_post_meta( $orderid, 'd_appointment', true );
		$shiptype = get_post_meta( $orderid, 'ship_type', true );
		if ($addtype != "" && $shiptype != "Local Pickup") {
			echo "<text style='color: #ffffff;'>Add. Type: $addtype</text><br>";
		}
		if ($unloadtype != "" && $shiptype != "Local Pickup") {
			echo "<text style='color: #ffffff;'>Fork / Dock?: $unloadtype</text><br>";
		}
		/*if ($delivery != "" && $shiptype != "Local Pickup") {
			echo "<text style='color: #ffffff;'>Delivery Appt.?: $delivery</text><br>";
		}*/
		if ($shiptype != "") {
			echo "<text style='color: #ffffff;'>Ship Type: $shiptype</text><br>";
		}
		echo "<br>";
		
		// if there is no shipping address to display, show the saved shipping address instead
		$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
		$ship_add = $order->get_shipping_address_1();
		if (!empty($saved_ship) && empty($ship_add)) 
		{
			$starr = explode(" ", $saved_ship["address_1"]);
			$add = "";
			if ($starr != "")
			{
				foreach ($starr as $part)
				{
					$add = $add . $part . "+";
				}
				$add = $add . $saved_ship["city"] . "+" . $saved_ship["state"] . "+" . $saved_ship["postcode"] . "+" . "US&z=16";
			}
			echo "<div class='_saved_shipping'>";
			echo "<p style='color: #ffffff;'>Saved Shipping:</p>";
			echo "<a target='_blank' href='https://maps.google.com/maps?&q=$add'";
			echo "<p>" . $saved_ship["first_name"] . " " . $saved_ship["last_name"] . "<br>";
			echo $saved_ship["address_1"] . "<br>";
			echo $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"] . "</p>";
			echo "</a>";
			echo "</div>";
				
			$shiptype = $order->get_shipping_method();
			echo "<div><text style='color: #999999; font-size: 12px;'>via $shiptype</text></div><br>";
		}
	}
	
	if ( 'order_billship' === $column ) 
	{
		// display billing address
		$saved_bill = get_post_meta( $orderid, '_saved_billing', true );
		$billadd1 = $order->get_billing_address_1();
		if (!empty($saved_bill) && empty($billadd1)) {
			$starr = explode(" ", $saved_bill["address_1"]);
			$add = "";
			if ($starr != "") {
				foreach ($starr as $part) {
					$add = $add . $part . "+"; }
				$add = $add . $saved_bill["city"] . "+" . $saved_bill["state"] . "+" . $saved_bill["postcode"] . "+" . "US&z=16"; 
			}
			echo "<div class='_saved_billing' style='line-height: 1.2;'>";
			echo "<p style='color: #ffffff;'>Saved Billing</p>";
			if ($saved_bill["first_name"]) { echo "<span class='billname' id='billname$orderid'>" . $saved_bill["first_name"] . " " . $saved_bill["last_name"] . "</span>"; }
			if ( ($saved_bill["first_name"] && $saved_bill["company"]) || ($saved_bill["first_name"] && $saved_bill["address_1"]) ) { echo ", "; }
			if ($saved_bill["company"]) { echo $saved_bill["company"]; }
			if ($saved_bill["company"] && $saved_bill["address_1"]) { echo ", "; }
			if ($saved_bill["address_2"]) { echo $saved_bill["address_1"] . ", " . $saved_bill["address_2"] . ", " . $saved_bill["city"] . ", " . $saved_bill["state"] . " " . $saved_bill["postcode"] . " " . $saved_bill["country"]; }
			else if ($saved_bill["address_1"]) { echo $saved_bill["address_1"] . ", " . $saved_bill["city"] . ", " . $saved_bill["state"] . " " . $saved_bill["postcode"] . " " . $saved_bill["country"]; }
			echo "</div>"; print_billvia( $order );
		}
		else {
			$billcity = $order->get_billing_city(); $billstate = $order->get_billing_state(); $billz = $order->get_billing_postcode(); $billcountry = $order->get_billing_country();
			$add = $billadd1 . $billcity . $billstate . $billz . "+US&z=16";
			echo "<div class='_saved_billing' style='line-height: 1.2;'>";
			echo "<p style='color: #ffffff;'>Billing</p>";
			echo "<div style='color: #bbc8d4;'>";
			$billfn = $order->get_billing_first_name(); $billln = $order->get_billing_last_name(); $billcom = $order->get_billing_company(); $billadd2 = $order->get_billing_address_2();
			if ($billfn) { echo "<span class='billname' id='billname$orderid'>" . $billfn . " " . $billln . "</span>"; }
			if ( ($billfn && $billcom) || ($billfn && $billadd1) ) { echo ", "; }
			if ($billcom) { echo $billcom; }
			if ($billcom && $billadd1) { echo ", "; }
			if ($billadd2) { echo $billadd1 . ", " . $billadd2 . ", " . $billcity . ", " . $billstate . " " . $billz . " " . $billcountry; }
			else if ($billadd1) { echo $billadd1. ", " . $billcity . ", " . $billstate . " " . $billz . " " . $billcountry; }
			echo "</div></div>"; print_billvia( $order );
		}
		/*******************************************************************/
		// display Address info if it is a ws order
		$addtype = get_post_meta( $orderid, 'address_type', true );
		$unloadtype = get_post_meta( $orderid, 'unload_type', true );
		//$delivery = get_post_meta( $orderid, 'd_appointment', true );
		$shiptype = get_post_meta( $orderid, 'ship_type', true );
		$foundBy = get_post_meta( $orderid, '_found_by', true );
		if ($addtype != "" && $shiptype != "Local Pickup") {
			if ($addtype == 'R') { $addtype = "Residential"; }
			else if ($addtype == 'C') { $addtype = "Commercial"; }
			echo "<div style='line-height: 1.2; color: #ffffff;'>Addr. Type: $addtype</div>"; }
		if ($unloadtype != "" && $shiptype != "Local Pickup") {
			if ($unloadtype == 'Y') { $unloadtype = "Yes"; }
			else if ($unloadtype == 'N') { $unloadtype = "No"; }
			echo "<div style='line-height: 1.2; color: #ffffff;'>Fork / Dock?: $unloadtype</div>"; }
		/*if ($delivery != "" && $shiptype != "Local Pickup") {
			echo "<div style='line-height: 1.2; color: #ffffff;'>Delivery Appt?: $delivery</div>";
		}*/
		if ($shiptype != "") {
			$shipSelected = $order->get_shipping_method();
			if ($shiptype == "CCR Ship" && $shipSelected == "Local Pickup") {
				echo "<div style='line-height: 1.2; color: #ffffff;'>Ship Type: <text class='shipConflict'>$shiptype</text></div>"; }
			else { echo "<div style='line-height: 1.2; color: #ffffff;'>Ship Type: $shiptype</div>"; }	
		}
		if ($foundBy != "") {
			echo "<div style='line-height: 1.2; color: #ffffff;'>F: $foundBy</div>"; }
		$quoteprice = get_post_meta( $orderid, 'shipq_price', true );
		if ($quoteprice != "") {
			echo "<div style='line-height: 1.2; color: #ffffff;'>Ship Quote: $$quoteprice</div>"; }
		if ($addtype || $unloadtype || $shiptype || $foundBy || $quoteprice ) { echo "<br>"; }
		/*******************************************************************/
		// if there is no shipping address to display, show the saved shipping address instead
		$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
		$ship_add = $order->get_shipping_address_1();
		if (!empty($saved_ship) && empty($ship_add)) {
			$starr = explode(" ", $saved_ship["address_1"]);
			$add = "";
			if ($starr != "") {
				foreach ($starr as $part) {
					$add = $add . $part . "+"; }
				$add = $add . $saved_ship["city"] . "+" . $saved_ship["state"] . "+" . $saved_ship["postcode"] . "+" . "US&z=16";
			}
			echo "<div class='_saved_shipping' style='line-height: 1.2;'>";
			echo "<p style='color: #ffffff;'>Saved Shipping</p>
				<a target='_blank' href='https://maps.google.com/maps?&q=$add'<div>";
			if ($saved_ship["first_name"]) { echo "<span class='shipname' id='shipname$orderid'>" . $saved_ship["first_name"] . " " . $saved_ship["last_name"] . "</span>"; }
			if ( ($saved_ship["first_name"] && $saved_ship["company"]) || ($saved_ship["first_name"] && $saved_ship["address_1"]) ) { echo ", "; }
			if ($saved_ship["company"]) { echo $saved_ship["company"]; }
			if ($saved_ship["company"] && $saved_ship["address_1"]) { echo ", "; }
			if ($saved_ship["address_2"]) { echo "<span class='shipaddone' id='shipaddone$orderid'>" . $saved_ship["address_1"] . "</span>, " . $saved_ship["address_2"] . ", " . $saved_ship["city"] . ", " . $saved_ship["state"] . " <span class='shipzip' id='shipzip$orderid'>" . $saved_ship["postcode"] . "</span> " . $saved_ship["country"]; }
			else if ($saved_ship["address_1"]) { echo "<span class='shipaddone' id='shipaddone$orderid'>" . $saved_ship["address_1"] . "</span>, " . $saved_ship["city"] . ", " . $saved_ship["state"] . " <span class='shipzip' id='shipzip$orderid'>" . $saved_ship["postcode"] . "</span> " . $saved_ship["country"]; }
			echo "</a></div>"; print_shipvia( $order );
		}
		else {
			$shipcity = $order->get_shipping_city(); $shipstate = $order->get_shipping_state(); $shipz = $order->get_shipping_postcode(); $shipcountry = $order->get_shipping_country();
			$add = $ship_add . $shipcity . $shipstate . $shipz . "+US&z=16";
			echo "<div class='_saved_shipping' style='line-height: 1.2;'>";
			echo "<p style='color: #ffffff;'>Shipping</p>
				<a target='_blank' href='https://maps.google.com/maps?&q=$add'<div>";
			$shipfn = $order->get_shipping_first_name(); $shipln = $order->get_shipping_last_name(); $shipcom = $order->get_shipping_company(); $shipadd2 = $order->get_shipping_address_2();
			if ($shipfn) { echo "<span class='billname' id='shipname$orderid'>" . $shipfn . " " . $shipln . "</span>"; }
			if ( ($shipfn && $shipcom) || ($shipfn && $ship_add) ) { echo ", "; }
			if ($shipcom) { echo $shipcom; }
			if ($shipcom && $ship_add) { echo ", "; }
			if ($shipadd2) { echo "<span class='shipaddone' id='shipaddone$orderid'>" . $ship_add . "</span>, " . $shipadd2 . ", " . $shipcity . ", " . $shipstate . " <span class='shipzip' id='shipzip$orderid'>" . $shipz . "</span> " . $shipcountry; }
			else if ($ship_add) { echo "<span class='shipaddone' id='shipaddone$orderid'>" . $ship_add . "</span>, " . $shipcity . ", " . $shipstate . " <span class='shipzip' id='shipzip$orderid'>" . $shipz . "</span> " . $shipcountry; }
			echo "</a></div>"; print_shipvia( $order );
		}
	}
	
	if ( 'order_inputship' === $column ) 
	{
		echo "<div class='_inputship' style='line-height: 1.2;'>";
		echo "<p style='color: #ffffff;'>Input Address &nbsp; <i class='fa-solid fa-address-card fa-xl'></i></p>";
		if ( $order->get_billing_phone() == "") { echo "<p><input type='text' class='setPhoneInput2' name='setPhoneInput2' rows='1' placeholder='(phone #)' title='Enter phone number with no dashes or other formatting'></p>"; }
		echo "<div class='nameinputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' class='nameinput' name='nameinput' rows='1' placeholder='(first) (last)' title='Enter buyer name info in the format of the placeholder text'></p></div>";
		echo "<div class='businputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' class='businput' name='businput' rows='1' placeholder='(company)' title='Enter company name info in the format of the placeholder text'></p></div>";
		echo "<div class='addressinputst2BEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' class='addressinputst2' name='addressinputst2' rows='1' placeholder='(street)' title='Enter street address info in the format of the placeholder text'></p></div>";
		echo "<div class='addressinput2adddiv' line-height: 1.2;'>";
		echo "<p><input type='text' class='addressinput2add' name='addressinput2add' rows='1' placeholder='(more st)' title='Enter more street address info in the format of the placeholder text'></p></div>";
		echo "<div class='addressinput2BEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' class='addressinput2' name='addressinput2' rows='1' placeholder='(city), (state) (zip)' title='Enter city state address info in the format of the placeholder text'></p></div>";
		// check boxes for shipping only
		echo "<div class='billonlycheckdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'><input type='checkbox' id='billaddonly$orderid' name='billaddonly' class='billaddonly' value='1'>
  			  	<label for='billaddonly$orderid' class='billaddonlyl'> Bill</label></div>";
		echo "<div class='shiponlycheckdiv' style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'><input type='checkbox' id='shipaddonly$orderid' name='shipaddonly' class='shipaddonly' value='1'>
  			  	<label for='shipaddonly$orderid' class='shipaddonlyl'> Ship</label></div>";
		echo "</div>"; // closing the first div of this block
		echo "<div class='add_ship_info' line-height: 1;'>";
		echo "<p style='color: #ffffff; font-size:11px;'>Add. Ship Info Inputs &nbsp; <i class='fa-solid fa-dolly fa-xl'></i></p>";
		echo "</div>";
		// additional ship info inputs, address infomation input select boxes
		echo "<div class='addTypeInputBEdiv' line-height: 1.2;'>";
		echo "<select id='addTypeInputBE' name='addTypeInputBE' class='addTypeInputBE'>
					<option value='' disabled selected>Add. Type</option>
        			<option value='Commercial'>Commericial</option>
					<option value='Residential'>Residential</option>
   			  </select>";
		echo "</div>";
		echo "<div class='forkDockInputBEdiv' line-height: 1.2;'>";
		echo "<select id='forkDockInputBE' name='forkDockInputBE' class='forkDockInputBE'>
					<option disabled selected value=''>Fork/Dock?</option>
        			<option value='Yes'>Yes</option>
					<option value='No'>No</option>
   			  </select>";
		echo "</div>";
		//echo "<div class='dApptInputBEdiv' line-height: 1.2;'>";
		/*echo "<select id='dApptInputBE' name='dApptInputBE' class='dApptInputBE'>
					<option disabled selected value=''>Del. Appt.?</option>
        			<option value='Yes'>Yes</option>
					<option value='No'>No</option>
   			  </select>";
		echo "</div>";*/
		echo "<div class='shipTypeInputBEdiv' line-height: 1.2;'>";
		echo "<select id='shipTypeInputBE' name='shipTypeInputBE' class='shipTypeInputBE'>
					<option disabled selected value=''>Ship Type</option>
        			<option value='CCR Ship'>CCR Ship</option>
					<option value='3rd Party Ship'>3rd Party Ship</option>
					<option value='Local Pickup'>Local Pickup</option>
   			  </select>";
		echo "</div>";
		echo "<div class='found_byBEdiv' line-height: 1.2;'>";
		echo "<select id='_found_byBE' name='_found_byBE' class='_found_byBE'>
					<option disabled selected value=''>Found By</option>
        			<option value='ws'>ccr (google)</option>
					<option value='fb'>facebook</option>
					<option value='ebay'>eBay</option>
					<option value='lsn'>lsn</option>
					<option value='referral'>referral</option>
   			  </select>";
		echo "</div>";
		// ship quote inputs
		$term = get_post_meta( $orderid, 'terminal_delivery', true );
		$tz = get_post_meta( $orderid, 'terminal_zip', true ); if ($tz == "") { $tz = "(Term zip)"; }
		$l = get_post_meta( $orderid, 'shipq_length', true ); if ($l == "") { $l = "(L)"; }
		$w = get_post_meta( $orderid, 'shipq_width', true ); if ($w == "") { $w = "(W)"; }
		$h = get_post_meta( $orderid, 'shipq_height', true ); if ($h == "") { $h = "(H)"; }
		$lbs = get_post_meta( $orderid, 'shipq_weight', true ); if ($lbs == "") { $lbs = "(lbs)"; }
		$pf = get_post_meta( $orderid, 'shipq_pallet_fee', true ); if ($pf == "") { $pf = "(Pallet)"; }
		$CCRprice = get_post_meta( $orderid, 'shipq_CCRcost', true ); if ($CCRprice == "") { $CCRprice = "(Quote)"; }
		echo "<p style='color: #ffffff; font-size:11px;'>Ship Quote Inputs &nbsp; <i class='fa-solid fa-dollar-sign fa-xl'></i><i class='fa-solid fa-truck-fast'></i></p>";
		if ($term == "") {
		echo "<div class='terminalBEdiv' line-height: 1.2;'>";
		echo "<select id='terminalBE' name='terminalBE' class='terminalBE'>
					<optgroup>
					<option disable selected value=''>Terminal Delivery?</option>
        			<option value='Yes'>Yes</option>
					<option value='No'>No</option>
					<option value='Offered'>Offered</option>
					<option value='clear'>Clear</option>
					</optgroup>
   			  </select></div>"; }
		else if ($term == "Yes") {
		echo "<div class='terminalBEdiv' line-height: 1.2;'>";
		echo "<select id='terminalBE' name='terminalBE' class='terminalBE'>
					<optgroup>
					<option disable value=''>Terminal Delivery?</option>
        			<option selected value='Yes'>Yes</option>
					<option value='No'>No</option>
					<option value='Offered'>Offered</option>
					<option value='clear'>Clear</option>
					<optgroup>
   			  </select></div>"; }
		else if ($term == "No") {
		echo "<div class='terminalBEdiv' line-height: 1.2;'>";
		echo "<select id='terminalBE' name='terminalBE' class='terminalBE'>
					<optgroup>
					<option disable value=''>Terminal Delivery?</option>
        			<option value='Yes'>Yes</option>
					<option selected value='No'>No</option>
					<option value='Offered'>Offered</option>
					<option value='clear'>Clear</option>
					<optgroup>
   			  </select></div>"; }
		else if ($term == "Offered") {
		echo "<div class='terminalBEdiv' line-height: 1.2;'>";
		echo "<select id='terminalBE' name='terminalBE' class='terminalBE'>
					<optgroup>
					<option disable value=''>Terminal Delivery?</option>
        			<option value='Yes'>Yes</option>
					<option value='No'>No</option>
					<option selected value='Offered'>Offered</option>
					<option value='clear'>Clear</option>
					<optgroup>
   			  </select></div>"; }
		echo "<div class='terminal_zipBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='terminal_zipBE' class='terminal_zipBE' name='terminal_zipBE' rows='1' placeholder='$tz' title='Enter the zip code of the terminal address delivery.'></p></div>";
		echo "<div class='length_inputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_length_inputBE' class='_length_inputBE' name='_length_inputBE' rows='1' placeholder='$l' title='Enter the length of pallet here.'></p></div>";
		echo "<div class='width_inputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_width_inputBE' class='_width_inputBE' name='_width_inputBE' rows='1' placeholder='$w' title='Enter the width of pallet here.'></p>";
		echo "</div>";
		echo "<div class='height_inputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_height_inputBE' class='_height_inputBE' name='_height_inputBE' rows='1' placeholder='$h' title='Enter the height of pallet here.'></p>";
		echo "</div>";
		echo "<div class='weight_inputBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_weight_inputBE' class='_weight_inputBE' name='_weight_inputBE' rows='1' placeholder='$lbs lbs' title='Enter the weight of pallet here.'></p>";
		echo "</div>";
		echo "<div class='pallet_feeBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_pallet_feeBE' class='_pallet_feeBE' name='_pallet_feeBE' rows='1' placeholder='$$pf' title='Enter the cost of pallet fee here.'></p>";
		echo "</div>";
		echo "<div class='CCR_ship_costBEdiv' line-height: 1.2;'>";
		echo "<p><input type='text' id='_CCR_ship_costBE' class='_CCR_ship_costBE' name='_CCR_ship_costBE' rows='1' placeholder='$$CCRprice' title='Enter the cost of shipping quote to CCR here.'></p>";
		echo "</div>";
		echo "<div class='pallet_feeBEdiv' line-height: 1.2;'>";
		echo "<p style='color: #ffffff; font-size: 10px;'>Pallet Fee</p>";
		echo "</div>";
		echo "<div class='CCR_ship_costBEdiv' line-height: 1.2;'>";
		echo "<p style='color: #ffffff; font-size: 10px;'>CCR Quoted $</p>";
		echo "</div>";
		
	}
	if ( 'order_inputtrack' === $column ) 
	{
		echo "<p style='line-height: 1.2; color: #ffffff;'>Tracking Info &nbsp; <i class='fa-solid fa-map-location-dot fa-xl'></i></p>";
		// if order has ccr ship cost display it
		$ourshipcost = get_post_meta($orderid, '_ccr_ship_cost', true);
		if ($ourshipcost != "") { echo "<div class='ship_cost_input' style='line-height: 1.2; color: #f7dca5'>Ship Cost: $$ourshipcost</div>"; }
		// if order has tracking number display it
		$trackNum = get_post_meta($orderid, '_bst_tracking_number', true);
		$fqOrderN = get_post_meta($orderid, 'shiporder_ID', true);
		$fqShipTrackN = get_post_meta($orderid, 'shipordertrack_ID', true);
		
		if ($trackNum != "")
		{
			$trackCarrier = get_post_meta($orderid, '_bst_tracking_provider', true);
			// convert tracking number into clickable link if possible
			if ( $trackCarrier == "Freightquote.com" ) { $trackNum = "<a target='_blank' href='https://online.chrobinson.com/tracking/#/?trackingNumber=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "ABF Freight" ) { $trackNum = "<a target='_blank' href='https://www.aftership.com/track/abf/$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Averitt" ) { $trackNum = "<a target='_blank' href='https://www.averittexpress.com/trackLTLById.avrt?serviceType=LTL&resultsPageTitle=LTL+Tracking+by+PRO+and+BOL&searchType=LTL&trackPro=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Central Transport" || $trackCarrier == "centraltransport" ) { $trackNum = "<a target='_blank' href='https://www.centraltransport.com/tools/track-shipment'>$trackNum</a>"; }
			else if ( $trackCarrier == "FedEx Freight" ) { $trackNum = "<a target='_blank' href='https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Holland" ) { $trackNum = "<a target='_blank' href='https://my.hollandregional.com/tools/track/shipments?referenceNumber=$trackNum&referenceNumberType=PRO'>$trackNum</a>"; }
			else if ( $trackCarrier == "Old Dominion Freight" || $trackCarrier == "olddominionfreight" ) { $trackNum = "<a target='_blank' href='https://www.odfl.com/us/en/tools/trace-track-ltl-freight/trace.html?proNumbers=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Roadrunner" ) { $trackNum = "<a target='_blank' href='http://tools.rrts.com/LTLTrack/?searchValues=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Saia" ) { $trackNum = "<a target='_blank' href='https://www.saia.com/track/details;pro=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "Southeastern Freight Lines" ) { $trackNum = "<a target='_blank' href='https://www.sefl.com/webconnect/tracing?Type=PN&RefNum1=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "XPO Logistics" ) { $trackNum = "<a target='_blank' href='https://www.xpo.com/track/ltl-shipment/$trackNum/'>$trackNum</a>"; }
			else if ( $trackCarrier == "YRC Freight" || $trackCarrier == "yrc" ) { $trackNum = "<a target='_blank' href='https://my.yrc.com/tools/track/shipments?referenceNumber=$trackNum&referenceNumberType=PRO'>$trackNum</a>"; }
			else if ( $trackCarrier == "FedEx" ) { $trackNum = "<a target='_blank' href='https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "UPS Ground" ) { $trackNum = "<a target='_blank' href='https://www.aftership.com/track/ups/$trackNum'>$trackNum</a>"; }
			else if ( $trackCarrier == "USPS Flat Rate" ) { $trackNum = "<a target='_blank' href='https://tools.usps.com/go/TrackConfirmAction?tRef=fullpage&tLc=2&text28777=&tLabels=$trackNum%2C&tABt=false'>$trackNum</a>"; }
			
			// display tracking info ahead of input fields
			echo "<div class='track_info_input_filled' style='line-height: 1.2; font-size: 11px;'>Carrier: $trackCarrier ";
			echo "#  $trackNum</div>";
			//echo "<br>";
		}
		
		// tracking info input fields
		echo "<div class='track_info_input' style='line-height: 1.2;'>";
		//echo "<p style='color: #ffffff;'>Tracking Info <i class='fa-solid fa-map-location-dot fa-xl'></i></p>";
		//echo "<p style='color: #ffffff;'><i class='fa-solid fa-truck-moving fa-xl'></i></p>";
		echo "<p><input type='text' class='shipCostInput' name='shipCostInput' rows='1' placeholder='(Our Ship Cost)' title='Enter the cost of shipping to CCR here.'></p>";
		echo "<select id='carrierInput' name='carrierInput' class='carrierInput'>
					<option disabled selected value=''>Select Carrier</option>
					<option value='Freightquote.com'>Freightquote.com</option>
        			<option value='ABF Freight'>ABF Freight</option>
					<option value='Averitt'>Averitt</option>
					<option value='Central Transport'>Central Transport</option>
					<option value='FedEx'>FedEx Freight</option> 
					<option value='Holland'>Holland</option>
					<option value='Old Dominion Freight'>Old Dominion Freight</option>
					<option value='Roadrunner'>Roadrunner</option>
					<option value='Saia'>Saia</option>
					<option value='Southeastern Freight Lines'>Southeastern Freight Lines</option>
					<option value='XPO Logistics'>XPO Logistics</option>
					<option value='YRC Freight'>YRC Freight</option>
					<option value='FedEx'>FedEx</option>
        			<option value='UPS Ground'>UPS Ground</option>
					<option value='USPS Flat Rate'>USPS Flat Rate</option>
					<option value='Local Pickup'>Local Pickup / 3rd Party</option>
   			  </select>";
		echo "<p><input type='text' class='trackNumInput' name='trackNumInput' rows='1' placeholder='(Tracking#)' title='Enter tracking number here'></p>";
		//echo "<textarea id='carrierInput' class='carrierInput' name='carrierInput' rows='2' placeholder='(Carrier: YRC, UPS, USPS, LocalPickup)'></textarea>";
		echo "<p><input type='text' class='carrierInput2' name='carrierInput2' rows='1' placeholder='(Enter Carrier Manually)' title='Enter the carrier manually if it is not listed as a choice above.'></p>";
		echo "<p style='color: #ffffff;'><i class='fa-brands fa-ebay fa-2xl'></i> ONLY</p>";
		echo "<text style='color: #ffffff; font-size: 11px;'>Optional (Date, Message):</text><br>";
		echo "<p><input type='text' class='shipDateInput' name='shipDateInput' rows='1' placeholder='(****-**-** Y-m-d)' title='Enter ship date here: year, month, day (Optional)'></p>";
		echo "<p><input type='text' class='feedbackInput' name='feedbackInput' rows='1' placeholder='(eBay Feedback Msg)' title='Enter feedback message you wish to give customer here (Optional)'></p>";
		echo "</div>";

		echo "<div class='track_info_input' style='line-height: 1.2;'>";
		if ($fqOrderN || $fqShipTrackN) { echo "<br><text style='color: #ffffff; font-size: 12px;'>freightquote.com Info:</text><br>"; }
		if ($fqOrderN != "") { 
			echo "<a href='https://www.freightquote.com/book/#/orders/$fqOrderN' target='_blank'>FQ Order Link</a><br>";
			echo "Order Number: <a href='" . admin_url("admin.php?page=ccr-admin-menu%2Ffreightorder-admin-menu-ccr&orderid=$orderid&orderNumber=$fqOrderN") . "' target='_blank'>$fqOrderN</a><br>"; }
		if ($fqShipTrackN != "") { echo "<span style='font-size: 11px;'>Tracking Number: $fqShipTrackN</span><br>"; }
		echo "</div>";
		
		/*
		 https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Ffreightorder-admin-menu-ccr&orderid=$orderid&orderNumber=$num
			$parse = "https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fordernotes-admin-menu-ccr&orderid=$orderid";
			echo "<br><button class='btn order_search_link' onclick=\"window.open('$parse','_blank');\" type='button' alt='Open Notes Page'></button>";
			echo "<br><a href='" . admin_url("admin.php?page=ccr-admin-menu/ordernotes-admin-menu-ccr&orderid=$orderid") . "' target='_blank'>Open Notes Page</a>";
			*/
		
	}
	if ( 'order_itemstats' === $column ) 
	{
        $items = $order->get_items();
		echo "<div style='height: 320px; overflow: auto;'>";
		foreach( $items as $item )
		{
			$product = wc_get_product($item->get_product_id());
			if ($product != ""){
				
				$length = $product->get_length();
        		$width = $product->get_width();
        		$height = $product->get_height();
				$weight = $product->get_weight();
				$sku = $product->get_sku();
				// l, w, h, weight
				echo "<div style='line-height: 1.2; color: #ffffff; text-align: center;'>";
				if ($sku != "") { echo "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a><br>"; } else { echo "(SKU)"; }
				if ($length != "") { echo "$length\" L<br>"; } else { echo "(L)<br>"; }
				if ($width != "") { echo "$width\" W<br>"; } else { echo "(W)<br>"; }
				if ($height != "") { echo "$height\" H<br>"; } else { echo "(H)<br>"; }
				//echo "$length\" L<br> $width\" W<br> $height\" H";
				if ( $weight != "" ) { echo "$weight lbs<br>"; } else { echo "(lbs)<br>"; }
				// pallet fee
				$cratefee = get_post_meta($item->get_product_id(), '_cratefee', true);
				if ($cratefee > 0) { echo "<text class='cratefee' id='cratefee'>Pallet Fee:<br>$$cratefee<br></text>"; }
				
				$ship = get_post_meta( $item->get_product_id(), '_customship', true );
				if ($ship == 2) { 
				echo "<p style='color: #c40403; background-color: #ffffff; border-radius: 5px; font-weight: bold;'>Local Pickup Only</p>"; }
				echo "</div>";
			}
			echo "<br>";
		}
		echo "</div>";
    }
	
	if ( 'order_test' === $column ) {  }
	
	if ( 'order_subtotal' === $column ) 
	{
		echo "<div style='line-height: 1.2;'><br></div>";
		$sub = $order->get_subtotal(); $dis = $order->get_total_discount(); $sub = $sub - $dis; $label = " Items"; $fee = $sub; fee_trans( $status, $fee, $label );
		$tax = $order->get_total_tax(); $label = " Tax"; $fee = $tax; fee_trans( $status, $fee, $label);
		$shipping = $order->get_total_shipping(); $label = " Shipping"; $fee = $shipping; fee_trans( $status, $fee, $label );
		
		$method = $order->get_payment_method();
		if ($method === 'intuit_payments_credit_card' || $method === '' || $method === 'None' || $method === 'CashOnPickup' || $method === 'CCAccepted' || $method === 'Other' || $method === 'other' || $method === 'quickbookspay' || $method === 'stripe' || $method === 'CreditCard (PayPal)')
		{
			$fee_total = 0;
			$ccfee = 0;
			$ebaytax = 0;
			$palletfee = 0;
			// Iterating through order fee items ONLY to find CC Fee
			foreach( $order->get_items('fee') as $item_id => $item_fee )
			{
				$fee_name = $item_fee->get_name();
				if (strpos( $fee_name, "(eBay") ) { $ebaytax = $ebaytax + $item_fee->get_total(); } 
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "usage fee") ) { $ccfee = $ccfee + $item_fee->get_total(); } 
				if (strpos( $fee_name, "allet fee") ) { $palletfee = $palletfee + $item_fee->get_total(); } 
				if (strpos( $fee_name, "rating") || strpos( $fee_name, "rate") ) { $palletfee = $palletfee + $item_fee->get_total(); } 
			}
			// itereate again to get total fees with CC
			foreach( $order->get_items('fee') as $item_id => $item_fee )
			{
				$fee_total = $fee_total + $item_fee->get_total();
			}
			// get total other fees by subtracting the credit card fee and ebay tax
			$fee_total = $fee_total - $ccfee - $ebaytax - $palletfee;
			
			if ( $ccfee > 0 ){ $label = " CC Fees"; $fee = $ccfee; fee_trans( $status, $fee, $label ); }
			if ( $ebaytax > 0 ){ $label = " eBay Collected Tax"; $fee = $ebaytax; fee_trans( $status, $fee, $label ); }
			if ( $palletfee > 0 ){ $label = " Pallet Fees"; $fee = $palletfee; fee_trans( $status, $fee, $label ); }
			// display other fees if not total of 0
			if ( $fee_total != 0 ) { $label = " Other Fees"; $fee = $fee_total; fee_trans( $status, $fee, $label ); } 
		}
		
		//update_post_meta( $orderidall, 'shipq_price', sanitize_text_field( $quoted_cost ) ); 
		$quoteprice = get_post_meta( $orderid, 'shipq_price', true );
		if ($status == "on-hold") {
			if ($method == '') {
				if ($quoteprice != "") {
			echo "<div style='margin-top: 3px; margin-bottom: 3px; color: #ffffff; line-height: 1.2; font-size: 11px;'>Generated Quote Price:</div>";
			echo "<div style='margin-top: 3px; margin-bottom: 3px; color: #ffffff; line-height: 1.2; font-size: 13px;'>$$quoteprice</div>";
		}
				echo "<div style='margin-top: 3px; margin-bottom: 3px; color: #ffffff; line-height: 1.2; font-size: 11px;'>Shipping / Pallet Fee:</div>";
				echo "<p><input type='text' class='shipcostinput' name='shipcostinput' title='Default input is Freight, check UPS, 3rd Party Freight, or Local Pickup to specify shipping method.' placeholder='" . $shipping . "'></p>";
				echo "<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='upsradio$orderid'><input type='radio' id='upsradio$orderid' name='shipradio' class='upsradio' value='1'>
                        <span style='color: #ffbe03; !important'>UPS</span></label></div>
                  <div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='tpfradio$orderid'><input type='radio' id='tpfradio$orderid' name='shipradio' class='tpfradio' value='2'>
                        <span style='font-size: 12px; color: #92b5d1; !important'>3rd Party Freight (Pallet Fee)</span></label></div>
						
				  <div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='termdradio$orderid'><input type='radio' id='termdradio$orderid' name='shipradio' class='termdradio' value='5'>
                        <span style='font-size: 12px; color: #9fc0c0; !important'>Terminal Delivery</span></label></div>
						
                  <div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='lpradio$orderid'><input type='radio' id='lpradio$orderid' name='shipradio' class='lpradio' value='3'>
                        <span style='color: #d19c9c; !important'>Local Pickup</span></label></div>
                  <div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='clearallradio$orderid'><input type='radio' id='clearallradio$orderid' name='shipradio' class='clearallradio' value='4'>
                        <span style='color: #ffffff; !important'>Clear All</span></label></div>
                  <div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
                  <label for='noneradio$orderid'><input type='radio' id='noneradio$orderid' name='shipradio' class='noneradio' value=''>
                        <span style='color: #303030; !important'>None</span></label></div>";
			}
			else {
			echo "<div style='color:#ffffff; font-size:12px; line-height: 1.2;'>Payment method must be empty in order to change shipping charges here.</div>";
			echo "<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'><input type='checkbox' id='clearpaycheck$orderid' name='clearpaycheck' class='clearpaycheckbox' value='1'>
  			  	<label for='clearpaycheck$orderid' class='clearpaycheckl'> Clear Payment Method</label></div>";
			} 
		} 
    	
		
		
		if ($method === 'CreditCard')
		{
			$ebay_tax = 0;
			// Iterating through order fee items ONLY to find ebay tax
			foreach( $order->get_items('fee') as $item_id => $item_fee )
			{
				$fee_name = $item_fee->get_name();
				$fee_name = strtolower($fee_name);
				if ( strpos( $fee_name, "ebay") || strpos( $fee_name, "collected") ) { $ebay_tax = $ebay_tax + $item_fee->get_total(); }
			}
			// display ebay collected sales tax
			if ($ebay_tax != 0) { $label = " eBay Collected Tax"; $fee = $ebay_tax; fee_trans( $status, $fee, $label ); }
		}
		
		if ($method === 'paypal' || $paymethod == "ppcp")
		{
			$fee_total = 0;
			$ccfee = 0;
			// Iterating through order fee items ONLY to find CC Fee
			foreach( $order->get_items('fee') as $item_id => $item_fee )
			{
				$fee_name = $item_fee->get_name();
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "usage fee") ) { $ccfee = $ccfee + $item_fee->get_total(); }
			}
			// itereate again to get total fees with CC
			foreach( $order->get_items('fee') as $item_id => $item_fee )
			{
				$fee_total = $fee_total + $item_fee->get_total();
			}
			// get total other fees by subtracting the credit card fee
			$fee_total = $fee_total - $ccfee;
			if ( $ccfee > 0 ) { $label = " CC Fee"; $fee = $ccfee; fee_trans( $status, $fee, $label ); }
			// display other fees if not total of 0
			if ($fee_total != 0) { $label = " Other Fees"; $fee = $fee_total; fee_trans( $status, $fee, $label ); } 
		}
		
		$refund = $order->get_total_refunded();
		if ($refund != 0) { 
			$order_notes = get_private_order_notes( $orderid );
			foreach( $order_notes as $note) {
				$note_content = $note['note_content']; if ( strpos($note_content, 'Refunded') !== false ) { $date = $note['note_date']; $datearr = explode(' ', $date); $date = $datearr[0]; break; } }
			$label = " Partial Refund on $date"; $fee = $refund; fee_trans( $status, $fee, $label ); }
	}
	
	// add payment method to order total column
	if ( 'order_total' === $column )
	{
		$method = $order->get_payment_method();
		$status = $order->get_status();
		$tid = $order->get_transaction_id();
		$savedpay = get_post_meta($orderid, '_saved_pay_input', true); 
		
		// check for email
		$oEmail = $order->get_billing_email();
		if ($status == "on-hold" || $status == "pending")
		{
			if ($order->get_billing_email() != "") {
				// if order contains *wire only* remove the send invoice checkbox option
				if ( $orderHasWireOnly ) { 
					// WIRE or CASH only invoice email code
					$fnameBill = $order->get_billing_first_name();
					$lnameBill = $order->get_billing_last_name();
					if ($fnameBill == "") {
						$saved_bill = get_post_meta( $orderid, '_saved_billing', true );
						$billname = "Valued Customer";
					}
					else { $billname = $fnameBill . " " . $lnameBill; }
					$wireCashEmail = "$billname,<br>
<br>
Your order, ($orderid), contains an item that requires a CASH or WIRE TRANSFER payment ONLY.  Please see the attached invoice details for further information regarding the item(s).<br>  
<br>
You will receive a separate email with details regarding WIRE TRANSFER payment should you decide to pay by wire, or you can call us at:<br>
(931) 563-4704<br>
or email us at:<br>
sales@ccrind.com<br>
to discuss scheduling a CASH payment.<br>
<br>
Thank you for your business.<br>
<br>
CCR IND LLC";
					echo "<div style='line-height: 1.2; color: #ffffff;'>Wire Only:</div>"; 
					echo "<div class='order_notes_area' id='oldspecialinvoice$orderid' style='opacity: 0; height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all;'>$wireCashEmail</div>";
					echo "<div style='color: #ffffff; line-height: 1.2;'>Special Invoice:</div>";
					echo "<button class='btn specialinvoicebtn' type='button' alt='Copy Special Invoice Email Auto-Generated Text' data-clipboard-target='#oldspecialinvoice$orderid'></button><br>";
				}
				else { echo "<div style='line-height: 1.2;'><input type='checkbox' id='oldsendinvcheck$orderid' name='oldsendinvcheck' class='oldsendinvcheck' value='1'>
							<label for='oldsendinvcheck$orderid' class='oldsendinvcheckl'>Send Invoice</label></div>"; }
				echo "<div style='line-height: 1.2;'><input type='checkbox' id='oldsendwireinfo$orderid' name='oldsendwireinfo' class='oldsendwireinfo' value='1'>
  			  			<label for='oldsendwireinfo$orderid' class='oldsendwireinfol'>Send Wire Info</label></div>"; 
			}
			else { echo "<div style='line-height: 1.2; color: #ffffff;'>NO EMAIL</div>"; }
		}
		if ($status == "pending") {
			if ($order->get_billing_email() != "") {
			echo "<div style='line-height: 1.2;'><input type='checkbox' id='oldsendfollowup$orderid' name='oldsendfollowup' class='oldsendfollowup' value='1'>
  			  			<label for='oldsendfollowup$orderid' class='oldsendfollowupl'>Follow Up Email</label></div>"; }
		}
		echo "<div style='line-height: 1.2; color:#ffffff;'>Total:</div>"; 
	}
	
	if ( 'order_totalccr' === $column ) 
	{
		$status = $order->get_status();
		$t = $order->get_total();
		if ($status == "completed") { $color = "ffffff"; $color2 = "ffffff"; $bgc = "c41a02"; }
		else if ( $status == "pending" ) { $color = "ffffff"; $color2 = "ffffff"; $bgc = "368bbc"; }
		else if ( $status == "processing" ) { $color = "ffffff"; $color2 = "70995d"; $bgc = "c6e1c6"; }
		else if ( $status == "on-hold" ) { $color = "ffffff"; $color2 = "a1794d"; $bgc = "f7dca5"; }
		else if ( $status == "failed" ) { $color = "ffffff"; $color2 = "7d3a45"; $bgc = "eba3a3"; }
		else { $color = "ffffff"; $color2 = "ffffff"; $bgc = "3a3a3a"; }
		$t = "$" . number_format((float) $t, 2, '.', '' ); 
		echo "<div class='order_totalccr' style='margin-top: 5px; margin-bottom: 5px; line-height: 1.2; color: #$color;'>Total<br><span style='display: inline-block; color: #$color2; background-color: #$bgc; padding: 6px; -webkit-border-radius: 5px; border-radius: 5px;'>$t</span></div><br>"; 
		
		if ($status == "on-hold" || $status == "pending")
		{
			if ($order->get_billing_email() != "") {
				// if order contains *wire only* remove the send invoice checkbox option
				if ( $orderHasWireOnly ) { 
					// WIRE or CASH only invoice email code
					$fnameBill = $order->get_billing_first_name();
					$lnameBill = $order->get_billing_last_name();
					if ($fnameBill == "") {
						$saved_bill = get_post_meta( $orderid, '_saved_billing', true );
						$billname = "Valued Customer"; }
					else { $billname = $fnameBill . " " . $lnameBill; }
					echo "<div style='line-height: 1.2; margin-bottom: 14px;'><span style='color: #696254; background-color: #ffffff; -webkit-border-radius: 5px; border-radius: 5px; border-style: solid; border-width: 3px; border-color: #696254; padding: 5px;'>Wire Only:</span></div>"; 
					echo "<div style='line-height: 1.2; margin-top: 5px;'><label for='sendinvwire$orderid' class='sendinvwirel'>Send Wire Invoice</label>
						<input type='checkbox' id='sendinvwire$orderid' name='sendinvwire' class='sendinvwire' value='1'></div>";
				}
				else { echo "<div style='line-height: 1.2;'><label for='sendinvcheck$orderid' class='sendinvcheckl'>Send<br>Invoice</label>
					<input type='checkbox' id='sendinvcheck$orderid' name='sendinvcheck' class='sendinvcheck' value='1'></div>"; }
				echo "<div style='line-height: 1.2;'><label for='sendwireinfo$orderid' class='sendwireinfol'>Send Wire Info</label>
					<input type='checkbox' id='sendwireinfo$orderid' name='sendwireinfo' class='sendwireinfo' value='1'></div>"; 
			}
			else { echo "<div style='line-height: 1.2; color: #ffffff;'>NO EMAIL</div>"; }
		}
		if ($status == "pending")
		{
			if ($order->get_billing_email() != "") {
				echo "<div style='line-height: 1.2;'><label for='sendfollowup$orderid' class='sendfollowupl'>Follow Up Email</label>
					<input type='checkbox' id='sendfollowup$orderid' name='sendfollowup' class='sendfollowup' value='1'></div>"; }
		}
	}
	if ( 'order_notes' === $column ) 
	{
		echo "<span><input type='text' id='noteinput' class='noteinput' name='noteinput' rows='1' placeholder='Add note to order...'>
			<label for='customer_note_check$orderid' class='customer_note_checkl'>CN</label>
			<input type='checkbox' id='customer_note_check$orderid' name='customer_note_check' class='customer_note_check' title='Make Note Customer Note' value='1' onClick='ckChange(this)'></span>";
		$ccrnote = get_post_meta( $orderid, '_ccr_customer_note', true );
        //$cusnote = $order->get_customer_note();
		
		if ($ccrnote != "") { 
			order_notes_filterC( $ccrnote, 1 );
			//echo "<div class='customer_order_notes_area' style='line-height: 1.2; color: #ffffff; background-color: #5c5c5c; border-radius: 5px; font-size: 14px;'>$ccrnote<br><br></div>"; 
			}
		$cusnote = $order->get_customer_note();
		if ($cusnote != "") { 
			$cusnote = "CUSTOMER NOTE: " . $cusnote;
			order_notes_filterC( $cusnote, 2 );
			//echo "<div class='customer_order_notes_area' style='line-height: 1.2; color: #ff9f9e; background-color: #5c5c5c; border-radius: 5px; font-size: 14px;'>$cusnote<br><br></div>"; 
			}
		
		// insert first and second order private note
		$note_content = "";
		$date = "";
		$user = "";
		$order_notes = get_private_order_notes( $orderid );
		$count = count($order_notes);
		$i = 0;

		echo "<div class='order_notes_area' style='line-height: 1.2; height: 300px; overflow: auto; margin-top: 10px;'>";
		$stockup = $stockdown = 1;
		foreach( array_reverse($order_notes) as $note)
		{
			$note_content = $note['note_content'];
			$date = $note['note_date'];
    		$user = $note['note_author'];
			$color = "";
			// check if odd or even
			$remainder = $count %2;
			if ($remainder == 0) { /* $count is even */ $color = "#cacaca"; }
			else { /* $count is odd */ $color = "#a2a2a2"; }
			order_notes_filter( $note_content, $date, $user, $color, $stockup, $stockdown, 3 );
			$count = $count - 1;
		}
		echo "</div>";
		// bookmark parse
		/*if ( current_user_can('administrator') ) {
			session_start();
			$_SESSION['orderid'] = $orderid;
			echo "Order ID: $orderid";
			https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Ffreightorder-admin-menu-ccr&orderid=$orderid&orderNumber=$num
			$parse = "https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fordernotes-admin-menu-ccr&orderid=$orderid";
			echo "<br><button class='btn order_search_link' onclick=\"window.open('$parse','_blank');\" type='button' alt='Open Notes Page'></button>";
			echo "<br><a href='" . admin_url("admin.php?page=ccr-admin-menu/ordernotes-admin-menu-ccr&orderid=$orderid") . "' target='_blank'>Open Notes Page</a>";
		}*/
	}
	if ( 'wc_actions' === $column ) 
	{
		if ($status == "pending" || $status == "on-hold" ) {
			echo "<div class='order_dates_info' style='line-height: 1.2; overflow: auto; margin-bottom: 50px; text-align: center;'>";
			$sentinvdate = get_post_meta( $orderid, '_sent_invoice', true ); 
			if ($sentinvdate != "") { $tempdate = date_create_from_format('y-m-d', $sentinvdate); $sentinvdateTrim = date_format($tempdate, 'm-d-y'); }
			$sentfollowupdate = get_post_meta( $orderid, '_sent_followup', true ); 
			if ($sentfollowupdate != "") { $tempdate = date_create_from_format('y-m-d', $sentfollowupdate); $sentfollowupdateTrim = date_format($tempdate, 'm-d-y'); }
			$sentwireinvdate= get_post_meta( $orderid, '_sent_wireinv', true ); 
			if ($sentwireinvdate != "") { $tempdate = date_create_from_format('y-m-d', $sentwireinvdate); $sentwireinvdateTrim = date_format($tempdate, 'm-d-y'); }
			$sentwireinfodate = get_post_meta( $orderid, '_sent_wireinfo', true );
			if ($sentwireinfodate != "") { $tempdate = date_create_from_format('y-m-d', $sentwireinfodate); $sentwireinfodateTrim = date_format($tempdate, 'm-d-y'); }
			$sentebaymsgdate = get_post_meta( $orderid, '_sent_ebaymsg', true ); 
			if ($sentebaymsgdate != "") { $tempdate = date_create_from_format('y-m-d', $sentebaymsgdate); $sentebaymsgdateTrim = date_format($tempdate, 'm-d-y'); }
			$datenow = date("y-m-d");
			/*if (strtotime($testdate) < strtotime('-2 days')) {
				echo "<div class='date_alert'>Testing Invoice sent: $testdate<br>Follow Up Due</div>"; 
			}
			else { echo "<div>Testing Invoice sent: $testdate</div>"; }*/
			if ($sentinvdate != "" && $sentfollowupdate == "") {
				if ( strtotime($sentinvdate) < strtotime('-2 days') ) { echo "<div class='date_alert'>Invoice Sent: $sentinvdateTrim<br>FOLLOWUP DUE</div>"; }
				else { echo "<div class='date_normal'>Invoice Sent: $sentinvdateTrim</div>"; }
			}
			if ($sentwireinvdate != "" && $sentfollowupdate == "") {
				if ( strtotime($sentwireinvdate) < strtotime('-2 days') ) { echo "<div class='date_alert'>Wire Invoice Sent: $sentwireinvdateTrim<br>FOLLOWUP DUE</div>"; }
				else { echo "<div class='date_normal'>Wire Invoice Sent: $sentwireinvdateTrim</div>"; }
			}
			if ($sentwireinfodate != "" && $sentfollowupdate == "") { echo "<div class='date_normal'>Wire Info Sent: $sentwireinfodateTrim</div>"; }
			if ($sentfollowupdate != "") {
				if ( strtotime($sentfollowupdate) < strtotime('-2 days') ) { echo "<div class='date_alert'>Followup Sent: $sentfollowupdateTrim<br>CANCEL DUE</div>"; }
				else { echo "<div class='date_normal'>Followup Sent: $sentfollowupdateTrim</div>"; }
			}
			if ($sentebaymsgdate != "") { echo "<div class='date_normal'>eBay Msg Sent: $sentebaymsgdateTrim</div>"; }
			echo "</div>";
		}
		// if an ebay id was found, show ebay helper buttons
		if( $imageflag )
		{	
		// ebay message code
		$fname = $order->get_shipping_first_name();
		$lname = $order->get_shipping_last_name();
		$bname = $order->get_shipping_company();
		$add = $order->get_shipping_address_1();
		$add2 = $order->get_shipping_address_2();
		$city = $order->get_shipping_city();
		$state = $order->get_shipping_state();
		$postcode = $order->get_shipping_postcode();
		$shipAdd = "";
		if ($fname == "")
		{
			$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
			if ($saved_ship != "") {
				$fname = $saved_ship["first_name"]; $lname = $saved_ship["last_name"]; $bname = $saved_ship["company"]; $add = $saved_ship["address_1"]; $add2 = $saved_ship["address_2"]; 
				$city = $saved_ship["city"]; $state = $saved_ship["state"]; $postcode = $saved_ship["postcode"];
				if ($bname != "") { $shipAddpart1 = $fname . " " . $lname . "<br>" . $bname . "<br>"; }
				else { $shipAddpart1 = $fname . " " . $lname . "<br>"; }
				if ($add2 != "") { $shipAddpart2 = $add . "<br>" . $add2 . "<br>" . $city . ", " . $state . " " . $postcode; }
				else { $shipAddpart2 = $add . "<br>" . $city . ", " . $state . " " . $postcode; }
				$shipAdd = $shipAddpart1 . $shipAddpart2; $name = $fname . " " . $lname; }
		}
		else 
		{
			if ($bname != "") { $shipAddpart1 = $fname . " " . $lname . "<br>" . $bname . "<br>"; }
			else { $shipAddpart1 = $fname . " " . $lname . "<br>"; }
			if ($add2 != "") { $shipAddpart2 = $add . "<br>" . $add2 . "<br>" . $city . ", " . $state . " " . $postcode; }
			else { $shipAddpart2 = $add . "<br>" . $city . ", " . $state . " " . $postcode; }
			$shipAdd = $shipAddpart1 . $shipAddpart2; $name = $fname . " " . $lname;
		}
		$shiptype = $order->get_shipping_method();
		$addtype = get_post_meta( $orderid, 'address_type', true );
		$unloadtype = get_post_meta( $orderid, 'unload_type', true );
		$msgstart = "An invoice has been sent to your ebay email from sales@ccrind.com, please check your inbox and spam folder for the email.<br><br>
The invoice will detail the costs of the order as well as provide a link for payment.<br><br>
If you require a different shipping option or local pickup, we can adjust the invoice and resend.<br><br>
Current Option, via $shiptype for: <br>
$shipAdd<br><br>";
		if ($addtype != "") { $msgaddt = "Address Type: $addtype <br>"; } else { $msgaddt = " "; }
		if ($unloadtype != "") { $msgunloadt = "Forklift / Freight Dock: $unloadtype <br><br>"; } else { $msgunloadt = " "; }
		$msgend = "If any of this information is incorrect or needs to be updated, please let us know. <br>
If you are unable to find the email, you can also use the following link to view and pay for the order, click or copy and paste into your browser:<br><br>
$paylink";
		$msg = $msgstart . $msgaddt . $msgunloadt . $msgend;
		$followup = "$name,<br>
&nbsp;&nbsp;&nbsp;&nbsp;We wanted to follow up with you on your potential purchase.  You should have received an email with a link to allow you to pay for your order.  If you are having problems or never received the email, please let us know how we can help.  If you have decided to cancel the order, please let us know.  If you have already spoken with one of our agents, please disregard this message. Thank you and have a great day.<br><br>
If you are unable to find the email, you can also use the following link to view and pay for the order, click or copy and paste into your browser:<br><br>
$paylink";
		}
		if( $imageflag ){ // text area divs, if an ebay id was found, make ebay message divs show ebay helper buttons
			echo "<div class='order_notes_area' id='ebaymsg$orderid' style='opacity: 0; height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all;'>$msg</div>";
			echo "<div class='order_notes_area' id='followup$orderid' style='opacity: 0; height: 1px; line-height: 1px; font-size: 1px; overflow: auto; user-select: all;'>$followup</div>";
			echo "<button class='btn ebaymsgbutton' type='button' alt='Copy eBay Message Auto-Generated Text' data-clipboard-target='#ebaymsg$orderid'></button>";
			echo "<button class='btn followupbutton' type='button' alt='Copy Follow Up Message Auto-Generated Text' data-clipboard-target='#followup$orderid'></button>"; }
	}
	if ( 'update_order' === $column )  
	{
		$method = $order->get_payment_method();
		$status = $order->get_status();
		$tid = $order->get_transaction_id();
		//$feeitems = (array) $order->get_items('fee');
		// get email of authorized user
		global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email;
		
		if ($method == "cod")
		{
			if ($status == "processing")
			{
				echo "<div class='updateme'>UPDATE ORDER TO PREP</div><br><br>";
				echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will mark order as \"On hold\".' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
				/*echo "<br>";
				echo "<div style='text-align:center;'><input type='checkbox' id='cancelorder' name='cancelorder' class='cancelorderbox' value='1'><br>
					<label for='cancelorder' class='cancelorderl'>Cancel</label></div>";*/
			}
		}
		
		$order_notes = get_private_order_notes( $orderid );
		foreach($order_notes as $note)
		{
    		$note_content = $note['note_content'];

			if(strpos( $note_content, "eBay User ID:") !== false)
			{
				$imageflag = 1;
				$ebayuser = substr ( $note_content, strpos( $note_content, "eBay User ID:"), strpos( $note_content, "eBay Sales Record ID:") );
				$ebayusername = substr ( $note_content, strpos( $note_content, "eBay User ID:") + 14 , strpos( $note_content, "eBay Sales Record ID:") - 14 );
				$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
				$salesrecord = "E" . $srnum;
				// form link for user page
				$ebayuserlink = "<a href=\"https://www.ebay.com/usr/$ebayusername\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#f4ae02 !important\">$ebayuser</a>";
				// form link for sales record
				$ebaylink = "<a href=\"https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber&search=salesrecordnumber%3A$srnum\" rel=\"noopener noreferrer\" target=\"_blank\" style=\"color:#85b716 !important\">$salesrecord</a>";
			}
		}
		
		// if an ebay id was found, show as ebay
		if( $imageflag )
		{	
			$ccfee = 0;
			// Iterating through order fee items ONLY to find CC Fee
			foreach( $order->get_items('fee') as $item_id => $item_fee ) {
				$fee_name = $item_fee->get_name();
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "usage fee") ) { $ccfee = $ccfee + $item_fee->get_total(); } }
			if ($ccfee == 0 && $method == "None") {
				if ($status == "pending"){ echo "<div class='updateme'>UPDATE ORDER TO PREP</div><br><br>"; }
			}
		}
		if ($method != "") {
			if ($status == "on-hold") {
				echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will Update based on Inputs' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
			}
		}
		if ($method == "None" || $method == "CashOnPickup" || $method == "" ) {
			if ($status == "on-hold") { update_checks($orderid); }
		}
		// add shipping input box for ebay orders
		if ($method == "" || $method == "None" || $method == "CashOnPickup" || $method == "CCAccepted") {
			if ($status == "pending") /* status is pending payment */ {
				// check boxes for Cash or Check or Wire
				update_checks($orderid);
				if ($email == "jedidiah@ccrind.com" || $email == "sharon@ccrind.com" || $email == "sales@ccrind.com") {
					echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>________</div>";
					echo "<input type='checkbox' id='addebaymsg$orderid' name='addebaymsg' class='addebaymsg' value='1'>
  			  			<label for='addebaymsg$orderid' class='addebaymsgl'>MsgSent</label><br>"; }
			} 
			else if ($status == "on-hold") /* status is pending payment */ {
				// check boxes for Cash or Check or Wire
				if ($email == "jedidiah@ccrind.com" || $email == "sharon@ccrind.com" || $email == "sales@ccrind.com") {
					echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>________</div>";
					echo "<input type='checkbox' id='addebaymsg$orderid' name='addebaymsg' class='addebaymsg' value='1'>
  			  			<label for='addebaymsg$orderid' class='addebaymsgl'>MsgSent</label><br>"; }
			} 
		}
		
		// add payment checkboxes for orders that have selected pay method but have not completed pay method
		if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "paypal"|| $method == "ppcp-gateway" || $method == "ppcp" || $method === 'angelleye_ppcp' || $method == "stripe" || $method == "CreditCard" || $method == "CreditCard (PayPal)") && $tid == "" ) {
			if ($tid == "") {
				if ($status == "pending") /* status is pending payment */ {
				update_checks($orderid);
					if ($email == "jedidiah@ccrind.com" || $email == "sharon@ccrind.com" || $email == "sales@ccrind.com") {
						echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>________</div>";
						echo "<input type='checkbox' id='addebaymsg' name='addebaymsg' class='addebaymsg' value='1'>
  			  				<label for='addebaymsg' class='addebaymsgl'>MsgSent</label><br>"; } 
				}
			}
			else {
				update_checks($orderid);
				if ($email == "jedidiah@ccrind.com" || $email == "sharon@ccrind.com" || $email == "sales@ccrind.com") {
					echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>________</div>";
					echo "<input type='checkbox' id='addebaymsg' name='addebaymsg' class='addebaymsg' value='1'>
  			  			<label for='addebaymsg' class='addebaymsgl'>MsgSent</label><br>"; }
			}
		}
		
		// if the payment has been submitted by the customer 
		if ($status == "on-hold" || $status == "pending")
		{
			// and payment method is credit card
			if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "stripe") && $tid !== "" )
			{
				echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will leave the CC Fee, capture charge and mark order as \"Processing\".' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
				/*echo "<br>";
				echo "<div style='text-align:center;'><input type='checkbox' id='cancelorder' name='cancelorder' class='cancelorderbox' value='1'><br>
					<label for='cancelorder' class='cancelorderl'>Cancel</label></div>";*/
			}
			// and payment method is paypal
			if ( ($method == "paypal" || $method === 'angelleye_ppcp' || $method == "ppcp-gateway" || $method == "ppcp") && $tid !== "")
			{
				echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will remove the CC Fee and leave as \"On hold\", Click the Processing button (...) to the right capture charge and mark order as \"Processing\".' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
				/*echo "<br>";
				echo "<div style='text-align:center;'><input type='checkbox' id='cancelorder' name='cancelorder' class='cancelorderbox' value='1'><br>
					<label for='cancelorder' class='cancelorderl'>Cancel</label></div>";*/
			}
		}
		
		// if the order has finished processing and is paid for
		if ($status == "processing")
		{
			// and payment method is credit card or paypal
			if ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "paypal" || $method == "ppcp-gateway" || $method == "ppcp" || $method === 'angelleye_ppcp' || $method == "CreditCard" || $method == "CreditCard (PayPal)" || $method == "stripe")
			{
				echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will mark the order as \"Completed\".' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
				/*echo "<br>";
				echo "<div style='text-align:center;'><input type='checkbox' id='cancelorder' name='cancelorder' class='cancelorderbox' value='1'><br>
					<label for='cancelorder' class='cancelorderl'>Cancel</label></div>";*/
			}
			if ( $method == "Other" || $method == "other" )
			{
				$tid = get_post_meta($orderid, '_transaction_id', true);
				$tid = strtolower($tid);
				if ( $tid == "cash" || $tid == "check" || $tid == "wire" || $tid == "sis" || $tid == "ebay" ) 
				{
					echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will mark the order as \"Completed\".' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
				}
			}
		}
		// status change update order button
		if ($status == "completed" || $status == "cancelled")
		{
			echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will change order status based on Status Selection.' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
		}
		// add tax exempt check box for marking tax status
		if ($status == "on-hold" || $status == "pending") {
			echo "<div style='margin-top: -3px; margin-bottom: 13px; line-height: 1.2; color: #000000;'>________</div>
				<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
				<label for='taxexempt$orderid'><input type='radio' id='taxexempt$orderid' name='taxradio' class='texemptradio' value='1'>
        		<span style='color: #cccccc !important;font-weight: bold;font-size: 12px;text-shadow: -1px 1px 0 #c40403,1px 1px 0 #c40403,1px -1px 0 #c40403,-1px -1px 0 #c40403 !important;'>Exempt</span></label></div>
				<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
				<label for='taxexemptx$orderid'><input type='radio' id='taxexemptx$orderid' name='taxradio' class='texemptxradio' value='2'>
        		<span style='color: #a2b899; !important'>Tax</span></label></div>";
		}
		if ($status == "completed" || $status == "cancelled" || $status == "processing")
		{
			$saCB = get_post_meta( $orderid, 'sa_checkbox', true );
			$sasCB = get_post_meta( $orderid, 'sa_signed_checkbox', true );
			if ( $saCB ) { echo "<input type='checkbox' title='Sales Agreement made and submitted to buyer.' id='sa_checkbox$orderid' name='sa_checkboxinput' class='sa_checkboxinput' value='1' checked> <label for='sa_checkboxinput' class='sa_checkboxl'> SA Made / Submitted</label><br>"; }
			else { echo "<input type='checkbox' title='Sales Agreement made and submitted to buyer.' id='sa_checkbox$orderid' name='sa_checkboxinput' class='sa_checkboxinput' value='1'><label for='sa_checkboxinput' class='sa_checkboxl'> SA Made / Submitted</label><br>"; }
			echo "</div>";
			if ( $sasCB ) { echo "<input type='checkbox' title='Sales Agreement Signed by buyer.' id='sa_signed_checkbox$orderid' name='sa_signed_checkboxinput' class='sa_signed_checkboxinput' value='1' checked><label for='sa_signed_checkboxinput' class='sa_signed_checkboxl'> SA Signed</label>"; }
			else { echo "<input type='checkbox' title='Sales Agreement Signed by buyer.' id='sa_signed_checkbox$orderid' name='sa_signed_checkboxinput' class='sa_signed_checkboxinput' value='1'><label for='sa_signed_checkboxinput' class='sa_signed_checkboxl'> SA Signed</label>"; }
			echo "</div>";
		}
		if ($status == "refunded") {
			echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='Will process based on inputs.' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>";
		}
		
		// end of form submission
		echo "</form>";
		
		if ($status != "cancelled" && $status != "completed" ) {
			// get order id for the form
			echo "<form method='post' action=''>
			  	<input type='hidden' name='cancelid' value='$orderid'>";
			// cancel button
			echo "<div style='margin-top: 13px; text-align:center;'><button type='submit' name='cancelorderb' class='cancelorderb' id=\"cancelorderb\" onclick=\"document.getElementById('cancelorderb').disabled = true; document.getElementById('cancelorderb').style.opacity='0.5'; this.form.submit();\"></button></div>";
			echo "</form>";
		}
		$prefix = substr($orderid, 0, 4);
		if ( file_exists("../library/order-logs/$prefix/ShipQ$orderid.html") && current_user_can('administrator') ) {
				// get order id for the form
				echo "<form method='post' action=''>
			  		<input type='hidden' name='deleteshipqlid' value='$orderid'>";
				// delete ship quote log button
				echo "<div style='margin-top: 13px; text-align:center;'><button type='submit' name='deleteshipqlb' class='deleteshipqlb'></button></div>";
				echo "</form>";
		}
	}
	if ( 'generate_quote' === $column )  // generate quote
	{
		// bookmark now
		$items = $order->get_items();
		foreach( $items as $item )
		{
		$product = wc_get_product($item->get_product_id());
			if ($product != ""){
				$ship = get_post_meta( $item->get_product_id(), '_customship', true );
			}
		}
		if ($ship == 2) { 
		echo "<p style='text-align: center; color: #c40403; background-color: #ffffff; border-radius: 5px; font-weight: bold;'>Local Pickup Only</p>"; }
		else {
		echo "<div style='line-height: 1.2; min-height: 350px; overflow: auto;'>
		<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fshipquote-admin-menu-ccr.php' method='post' target='_blank'>
		<input type='hidden' name='orderidallq' value='$orderid'>
		<div><label for='lift$orderid' class='liftboxl'>Liftgate?</label>
		<input type='checkbox' id='lift$orderid' name='lift' class='liftbox' value='1'></div>
		<div><label for='addtype$orderid' class='addtypeboxl'>Resid Adr?</label>
		<input type='checkbox' id='addtype$orderid' name='addtype' class='addtypebox' value='1'></div>
		<div><label for='access$orderid' class='accessboxl'>Limited Ac?</label>
		<input type='checkbox' id='access$orderid' name='access' class='accessbox' value='1'></div>
		<div><label for='insidedelivery$orderid' class='insidedeliveryboxl'>Inside Delivery?</label>
		<input type='checkbox' id='insidedelivery$orderid' name='insidedelivery' class='insidedeliverybox' value='1'></div>
		<div><label for='terminal$orderid' class='terminalboxl'>Terminal?</label>
		<input type='checkbox' id='terminal$orderid' name='terminal' class='terminalbox' value='1'></div>
		<div><label for='flip$orderid' class='flipboxl'>OK reorient?</label>
		<input type='checkbox' id='flip$orderid' name='flip' class='flipbox' value='1'></div>
		<div style='margin: 10px;'><input type='submit'></div>
		<div>Optional Fields:</div>
		<div><label for='pallet40$orderid' class='pallet40boxl'>48x40</label>
		<input type='checkbox' id='pallet40$orderid' name='pallet40' class='pallet40box' value='1'></div>
		<div><label for='pallet48$orderid' class='pallet48boxl'>48x48</label>
		<input type='checkbox' id='pallet48$orderid' name='pallet48' class='pallet48box' value='1'></div>
		<div class='height_inputBEdiv'>
 		<input type='text' class='shipCostInput' name='length' placeholder='L'></div>
		<div class='width_inputBEdiv'>
 		<input type='text' class='shipCostInput' name='width' placeholder='W'></div>
		<div class='height_inputBEdiv'>
        <input type='text' class='shipCostInput' name='height' placeholder='H'></div>
		<div><input type='text' class='shipCostInput' name='weight' placeholder='Weight'></div>
		<div class='pallet_feeBEdiv'><span style='color: #ffffff; font-size: 10px;'>Pallet Fee</span>
        <input type='text' class='_pallet_feeBE' name='pfee' placeholder='Pallet Fee'></div>
		<div class='pallet_feeBEdiv'><span style='color: #ffffff; font-size: 10px;'>Item Price</span>
        <input type='text' class='shipCostInput' name='value' placeholder='Price'></div>
		<div><input type='text' class='shipCostInput' name='sku' placeholder='SKU'></div>
		<div><input type='text' class='shipCostInput' name='zip' placeholder='Ship Zip'></div>
		<div><input type='text' class='shipCostInput' name='name' placeholder='Product Name'></div>
		</form>
		</div>";
		}
	}
	if ( 'instructions' === $column )  // generate quote
	{
		$salesrecord = "";
		$salesrecord = establish_if_ebay($orderid);
		// start div formatting
		echo "<div style='margin-top: 3px; margin-bottom: 3px; height: 400px; overflow: auto; line-height: 1.2;'>";
		// if it is an ebay order
		if ($salesrecord != "") 
		{
			// debug
			echo "eBay<br>";
			if ($status == "on-hold") 
			{
				// debug
				echo "on hold<br>";
				// check billing address for info
				$saved_bill = get_post_meta( $orderid, '_saved_billing', true );
				$billadd1 = $order->get_billing_address_1();
				if (empty($saved_bill) && empty($billadd1)) {
					echo "Input order Info:<br><br>Go to <a href='https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber' rel=\"noopener noreferrer\" target=\"_blank\">eBay</a>.<br><br>Find the matching order number.<br><br>Open the \"Send invoice\" link in a new tab to find address info.<br><br>Open the \"View order details\" link in a new tab by selecting the down arrow under \"Awaiting payment\".<br><br>Select \"Show contact info\" to find Phone Number.<br><br>\"Buyer\" will display customer name.<br><br>Copy and paste all the relevant data in the fields under the \"Input Address\" column. (Phone, Name, Company, Street, More St, City, State Zip)";
				}
				else {
					$shiptype = $order->get_shipping_method();
					if ($shiptype != "") {
						// check to see if invoice was sent
						$sentwireinvdate = get_post_meta( $orderid, '_sent_wireinv', true );
						if ($sentwireinvdate != "") {
							echo "Wire Invoice Sent:<br><br>Order will stay in \"On Hold\" status, to prevent payment page from becoming active. Wait for payment to be completed.<br><br>If wire payment is verified, select \"Wire\" from options in \"Update Order\" column and Update.";
						}
						else {
							
						$shipping = $order->get_total_shipping();
						//if ( strpos($shiptype, "reight Shipping (Terminal)") ) { echo "<div style='font-size: 12px; color: #999999; line-height: 1;'>via $shiptype</div>"; }
						//else { echo "<div style='font-size: 16px; color: #999999; line-height: 1;'>via $shiptype</div>";  }
						if ($shiptype == "Local Pickup") { 
							//echo "<img src=\"https://ccrind.com/wp-content/uploads/2022/11/localpickupccr.png\" title='Local Pickup' alt=\"local pickup image\">"; 
							if ($shipping != 0) {
								echo "Local Pickup selected.<br><br>There should be no shipping charge.<br><br>To reset the ship carge to 0, enter a 0 into the Shipping / Pallet Fee: input field above the bullet choices in the \"Subtotal\" column, select the LOCAL PICKUP bullet choice below the input field, and update the order. ";
							}
							else {
								echo "Local Pickup selected.<br><br>Check all the order details (Shipping Method, email, phone number, billing and shipping address, taxes, etc), especially TAXES. Taxes should be added to the order unless the customer has an exemption.<br><br>Taxes can be added (TAX) and removed (EXEMPT) using the bullet choices under the \"Update Order\" column. Select appropriately and update the order.<br><br>If everything appears correct, check the \"Send Invoice\" box in the \"Total\" column and update the order."; 
							}
						}
						else if ( strpos($shiptype, "Party") ) { 
							//echo "<p class='thirdicon' style='color: #92b5d1; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-truck-ramp-box fa-2xl'></i></p>"; 
							echo "3rd Party Freight Selected. Add any necessary pallet fees to the order, select the 3RD PARTY FREIGHT (PALLET FEE) choice under the \"Subtotal\" column and enter the appropriate fee, if any, into the Shipping / Pallet Fee: input field above the bullet choices and update the order.<br><br>Check all the order details. (Shipping Method, email, phone number, billing and shipping address, taxes, etc)<br><br>If everything appears correct, check the \"Send Invoice\" box in the \"Total\" column and update the order.";
						}
						else if ( strpos($shiptype, "reight Shipping (Terminal)") ) { 
							echo "<p class='freighticonterm' style='color: #9fc0c0; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-truck-moving fa-2xl'></i><i class='fa-solid fa-industry fa-2xl'></i></p>"; }
						else if ( strpos($shiptype, "reight") ) { 
							if ($shipping == 0) {
								//echo "<img src=\"https://ccrind.com/wp-content/uploads/2022/11/freighticon.png\" title='Freight' alt=\"freight ship image\"><br>"; 
								echo "Determine shipping cost.<br><br>Click the \"Shipping\" Address link to determine shipping conditions. (Commercial or Residential? Liftgate needed? Limited Access? Etc)<br><br>Or contact the customer to obtain this info. (Call or Message in eBay)<br><br>Once determined use the \"Generate Quote\" column to determine the shipping cost.<br><br>If another method besides freight is needed, example: LOCAL PICKUP or 3RD PARTY FREIGHT, select the appropriate bullet choice under the \"Subtotal\" column and enter the appropriate fee, if any, into the Shipping / Pallet Fee: input field above the bullet choices."; 
							}
							else {
								echo "Shipping cost has been entered for the order.<br><br>Check all the order details. (Shipping Method, email, phone number, billing and shipping address, taxes, etc)<br><br>If everything appears correct, check the \"Send Invoice\" box in the \"Total\" column and update the order.";
							}
						}
						else if ( strpos($shiptype, "SPS") ) { 
							echo "<p class='uspsicon' style='color: #333366; padding-top: 7px; font-size: 20px;'><i class='fa-brands fa-usps fa-2xl'></i></p>"; }
						else if ( strpos($shiptype, "PS") ) { 
							echo "<p class='upsicon' style='color: #ffbe03; padding-top: 7px; font-size: 20px;'><i class='fa-brands fa-ups fa-2xl'></i></p>"; } 
							
						}
					} 
					else {
						echo "Determine shipping cost.<br><br>Click the \"Shipping\" Address link to determine shipping conditions. (Commercial or Residential? Liftgate needed? Limited Access? Etc)<br><br>Or contact the customer to obtain this info. (Call or Message in eBay)<br><br>Once determined use the \"Generate Quote\" column to determine the shipping cost.";
					}
				}
			}
			if ($status == "pending") 
			{
				// debug
				echo "pending<br>";
				if ($method == "None") {
					echo "Update order to prep for further action.<br><br>Hit the <button type='submit' name='postallorder' class='postallorder' id=\"postallorder\"></button> button in the \"Update Order\" column.";
				}
				else {
					echo "Wait for Payment.<br><br>If you just sent the invoice, be sure to send a direct eBay message as well. Instructions found <a href='https://ccrind.com/send-ebay-message/'>here</a>.<br><br>CREDIT CARD and PAYPAL will occur automatically or can be input using the<br><a href=\"$paylink\" rel=\"noopener noreferrer\" target=\"_blank\">Customer<br>payment page &#8594;</a><br>link in the \"Email\" column.<br><br>CASH, CHECK, WIRE options can be selected in the \"Update Order\" column."; }
			}
			// EBAY PROCESSING INSTRUCTIONS
			if ($status == "processing") 
			{
				// debug
				echo "processing<br>";
				if ($saCB) {
					if ($sasCB) {
						echo "SA Made... SA Signed<br><br>If the item requires Freight or 3rd Party Freight Shipping, inform the appropriate person that the item needs to be prepped / palletized.<br><br>If CCR is Freight Shipping the order, once you receive the final weight / dimensions, use the \"Generate Quote\" column to BOOK the Freight Shipping.<br>Enter the L, W, H, Weight and anything else appropriate into the input fields and click \"Submit\".<br><br>If you have BOOKED the shipping, select the carrier using the select box in the \"Input Tracking Info\" column, then input the Tracking # below the select carrier box, and update the order.";
					}
					else {
						echo "Waiting for SA signing.<br><br>If you need instructions on uploading the SA to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.<br><br>If you received an email saying the SA has been signed, check the box \"SA Signed\" in the \"Update Order\" column and update the order.<br><br>Download the signed copy of the SA from <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a> to the CCR server. If you need instructions on the download process, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.";
					}
				}
				else {
					echo "Need to generate the SA and upload to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>.<br><br>Before you start or after you finish the process, click the \"SA Made / Submitted\" checkbox in the \"Update Order\" column and update the order.<br><br>Click this button, found in the \"Actions\" column: <a href='' class='btn generateSA' alt='Generate SA PDF'></a> to generate the Sales Agreement using the order data.<br><br>Click the download button in the upper right hand corner of the SA tab that was opened and save the pdf to the CCR server.<br><br>If you need instructions on uploading the SA to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.";
				}
			}
			// EBAY COMPLETED INSTRUCTIONS
			if ($status == "completed") 
			{
				// debug
				echo "completed<br>";
				echo "Order is complete.<br><br>Changes can still be made by going directly into the order link in the \"Order\" column.<br><br>Many changes require the order to be put into \"On Hold\" status.";
			}
			// EBAY CANCELLED INSTRUCTIONS
			if ($status == "cancelled") 
			{
				// debug
				echo "cancelled<br>";
				echo "Please be sure the order is cancelled inside the <a href='https://www.ebay.com/sh/ord/?filter=status%3AALL_ORDERS&sort=-recordnumber'>eBay</a> order interface as well.<br><br>When the order is cancelled select the appropriate reason why (Buyer has not paid, Buyer asked to cancel, etc).<br><br>NEVER choose to relist the item. Relist the item using the ccrind.com backend interface.";
			}
		}
		// if it is a ws order
		else 
		{
			// debug
			echo "Webstore<br>";
			// WEBSTORE ON HOLD INSTRUCTIONS
			if ($status == "on-hold") 
			{
				// debug
				echo "on hold<br>";
				// check to see if invoice was sent
						$sentwireinvdate = get_post_meta( $orderid, '_sent_wireinv', true );
						if ($sentwireinvdate != "") {
							echo "Wire Invoice Sent:<br><br>Order will stay in \"On Hold\" status, to prevent payment page from becoming active. Wait for payment to be completed.<br><br>If wire payment is verified, select \"Wire\" from options in \"Update Order\" column and Update.";
						}
			}
			// WEBSTORE PENDING INSTRUCTIONS
			if ($status == "pending") 
			{
				// debug
				echo "pending<br>";
				if ($method == "cod") {
					echo "Update order to prep for further action.<br><br>Hit the <br><button type='submit' name='postallorder' class='postallorder' id=\"postallorder\"></button><br> button in the \"Update Order\" column.";
				}
				else {
				echo "Wait for Payment.<br><br>CREDIT CARD and PAYPAL will occur automatically or can be input using the<br><a href=\"$paylink\" rel=\"noopener noreferrer\" target=\"_blank\">Customer<br>payment page &#8594;</a><br>link in the \"Email\" column.<br><br>CASH, CHECK, WIRE options can be selected in the \"Update Order\" column."; }
			}
			// WEBSTORE PROCESSING
			if ($status == "processing") 
			{
				// debug
				echo "processing<br>";
				if ($saCB) {
					if ($sasCB) {
						echo "SA Made... SA Signed<br><br>If the item requires Freight or 3rd Party Freight Shipping, inform the appropriate person that the item needs to be prepped / palletized.<br><br>If CCR is Freight Shipping the order, once you receive the final weight / dimensions, use the \"Generate Quote\" column to BOOK the Freight Shipping.<br>Enter the L, W, H, Weight and anything else appropriate into the input fields and click \"Submit\".<br><br>If you have BOOKED the shipping, select the carrier using the select box in the \"Input Tracking Info\" column, then input the Tracking # below the select carrier box, and update the order.";
					}
					else {
						echo "Waiting for SA signing.<br><br>If you need instructions on uploading the SA to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.<br><br>If you received an email saying the SA has been signed, check the box \"SA Signed\" in the \"Update Order\" column and update the order.<br><br>Download the signed copy of the SA from <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a> to the CCR server. If you need instructions on the download process, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.";
					}
				}
				else {
					echo "Need to generate the SA and upload to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>.<br><br>Before you start or after you finish the process, click the \"SA Made / Submitted\" checkbox in the \"Update Order\" column and update the order.<br><br>Click this button, found in the \"Actions\" column: <img src='https://ccrind.com/wp-content/uploads/2023/05/Screenshot-2023-05-19-at-8.04.14-AM.png' alt='generate SA image'> to generate the Sales Agreement using the order data.<br><br>Click the download button in the upper right hand corner of the SA tab that was opened and save the pdf to the CCR server.<br><br>If you need instructions on uploading the SA to <a href='https://cloud.gonitro.com/documents/my-documents' rel=\"noopener noreferrer\" target=\"_blank\">Nitrocloud</a>, please <a href='https://ccrind.com/sales-agreement-instructions/' rel='noopener noreferrer' target='_blank'>click here</a>.";
				}
			}
			// WEBSTORE COMPLETED INSTRUCTIONS
			if ($status == "completed") 
			{
				// debug
				echo "completed<br>";
				echo "Order is complete.<br><br>Changes can still be made by going directly into the order link in the \"Order\" column.<br><br>Many changes require the order to be put into \"On Hold\" status.";
			}
			// WEBSTORE CANCELLED INSTRUCTIONS
			if ($status == "cancelled") 
			{
				// debug
				echo "cancelled<br>";
			}
		}
		echo "</div>"; // end div formatting
	}
}
add_action( 'manage_shop_order_posts_custom_column', 'add_order_item_column_content' );
/*****************************************************************************************************************************/


// adjust width of CC Fee column width and all other column width column size column css style admin column
add_action( 'admin_head', 'cc_fee_column' );
function cc_fee_column() {
    global $pagenow;
    if ( $pagenow == 'edit.php' ) {
        ?>
        <style type="text/css">
			.column-order_number { width:80px !important; overflow:hidden; }
			.column-order_email { width:120px !important; overflow:auto; }
			.column-order_status { width:80px !important; overflow:auto; }
			.column-order_inputship { width:136px !important; overflow:hidden; }
			.column-order_inputtrack { width:128px !important; overflow:hidden; }
			.column-order_date { width:190px !important; overflow:hidden; }
            .column-order_ccfee { width:80px !important; overflow:hidden; }
			.column-wc_actions { width:80px !important; overflow:hidden; }
			.column-update_order { width:75px !important; overflow:hidden; }
			.column-order_billship { width:150px !important; overflow:hidden; }
			.column-order_itemstats { width:60px !important; overflow:hidden; }
			.column-order_tax { width:50px !important; overflow:hidden; }
			.column-generate_quote { width:140px !important; overflow:hidden; }
			.column-instructions { width:200px !important; }
			/*.column-billing_address {
				width:100px !important; overflow:hidden;
			}*/
			.column-order_subtotal {
               width:110px !important; overflow:hidden; z-index: 99999; 
           }
			.column-order_totalccr {
               width:80px !important; overflow:hidden; z-index: 99999; 
           }
			.column-order_notes {
               width:230px !important; overflow:hidden;
           }
		  .column-order_item {
               width:180px !important; overflow:hidden
           }
			.column-_stock_status_combine{
				max-width: 140px !important;
				min-width: 100px !important;
				text-align: center;
			}
		  .column-_sku {
			  width:90px !important; overflow:hidden;
           }
			.column-product_visibility {
			  width:70px !important; overflow:hidden;
           }
			.column-new_is_in_stock {
			  width:110px !important; overflow:hidden;
           }
			.column-_cost {
			  width:90px !important; overflow:hidden;
           }
			.column-_price_cost {
			  min-width:80px !important;
			  max-width:120px !important;
			  text-align: center;
           }
			.column-_fix_info, .column-_note_dan { max-width: 100px !important; overflow:auto;}
			.column-cat_date_modifier{
			  min-width: 150px !important;
			  max-width: 150px !important;
		   }
			.column-thumb {
			  min-width:154px !important;
           }
			.column-price {
			  width:100px !important; overflow:hidden;
           }
			.column-_fi {
			  width:50px !important; overflow:hidden;
           }/*
			.column-_video {
			  width:70px !important; overflow:hidden
           }*/
			.column-_soldby {
			  width:70px !important; overflow:hidden;
           }
		  /* hide the short description column from everyone */
		  .column-_shortdesc {
			  display: none;
           }
			/* fix some narrow columns on the admin product list page */
			.edit-php.post-type-product table {
  				table-layout:auto;
			}
			.column-name {
			  min-width: 120px !important;
			  overflow-wrap: break-word !important;
			  word-break: break-all !important;
           }
			.column-product_cat {
			  width:150px !important;
           }
			.column-item_stats {
				max-width: 65px !important;
				text-align: center;
			}
			.column-_auction {
				max-width: 100px !important;
			}
			.column-product_shipping_class {
				min-width : 134px !important;
			}
			.column-cond_test{
				min-width: 110px !important;
				max-width: 110px !important;
			}
			.column-_testbutton2 {
				min-width: 80px !important;
				max-width: 110px !important;
			}
			.column-_ccrind_brand {
				min-width: 100px !important;
				max-width: 150px !important;	
			}
			.column-links_input {
				min-width: 100px !important;
				max-width: 150px !important;
			}
			#name, #_price_cost, #_stock_status_combine, #cond_test, #cat_date_modifier, #_warehouse_loc, #_ccrind_brand, #item_stats, #product_shipping_class, #_auction, 
			#_sales_channel_links, #_soldby, #_testbutton, #_testbutton2, #_ccrind_brand, #links_input, #updateall {
				text-align: center !important;
			}
			.column-_price_cost, .column-cond_test, .column- , .column-cat_date_modifier , .column-_warehouse_loc , .column-item_stats, .column-product_shipping_class,  
			.column-_auction, .column-_sales_channel_links, .column-_ccrind_brand, .column-links_input, .column-updateall {
				text-align: center;
			}
         </style>
        <?php
    }
}


/* enable php in widget */
//enable php in text widget
add_filter('widget_text','execute_php',100);
function execute_php($html){
 if(strpos($html,"<"."?php")!==false){
 ob_start();
 eval("?".">".$html);
 $html=ob_get_contents();
 ob_end_clean();
 }
 return $html;
 }
/*************************************************************************************************************************/
add_filter( 'relevanssi_modify_wp_query', 'rlv_meta_fix', 99 );
function rlv_meta_fix( $q ) {
	$q->set( 'meta_query', array() );
	return $q;
}
/*************************************************************************************************************************/
// curbside notice for all of clothing category
add_action('woocommerce_before_add_to_cart_form', 'tax_notice');
function tax_notice( )
{
	global $product;
	$id = $product->get_id();
	$customship = 0;
	$customship = $customship + get_post_meta( $id, '_customship', true );
	
	echo "<br><div class='box-animation';>";
	if( has_term( 'clothing', 'product_cat', $post_id ))
	{
		echo "* Curbside pickup available *<br>";
	}
	if ($customship == 2) {
		echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">LOCAL PICKUP ONLY</h4>";
		if ( $id == 146062 ) {
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">However, you can setup your own shipping through UPS, FedEx, USPS, etc.</h4>";
		}
		else {
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">NO SHIPPING FOR THIS ITEM</h4>"; }
		if( has_term( 'furniture', 'product_cat', $post_id ))
		{ 
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">CASH PAYMENT ONLY FOR THIS ITEM</h4>";
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">CONTACT US DIRECTLY TO ARRANGE ORDER</h4>";
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">CALL (931) 563-4704</h4>";
			echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">EMAIL sales@ccrind.com</h4>";
		}
	}
	if( has_term( 'forklifts', 'product_cat', $post_id ))
	{ 
		echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">IF LP FUELED, TANK NOT INCLUDED</h4>";
	}
	if ($customship == 3) 
	{
		echo "<h4 style=\"font-weight: bold; padding: 6px; color: #a08100;\">WIRE / CASH PAYMENT ONLY</h4>";
	}
	echo "<span style=\"padding: 6px; text-align: center;\">price does not include any applicable taxes</span><br>";
	echo "<span style=\"padding: 6px; text-align: center;\">items located in <a href='https://www.google.com/maps/dir//411+E+Carroll+St,+Tullahoma,+TN/@35.3607327,-86.2342698,13z/data=!4m8!4m7!1m0!1m5!1m1!1s0x88616313cbb37c8b:0xc64fb2939eb952f!2m2!1d-86.1992504!2d35.3606678' target='_blank'> Tullahoma, TN</a></span><br>" ;
	echo "<span style=\"padding: 6px; text-align: center;\">unless otherwise stated</span>";
	echo "</div>";
}

/*************************************************************************************************************************/
// new helper function to find ebay user id and ebay record number
// fucntion also extracts order private note details
function get_private_order_notes( $orderid ){
    global $wpdb;

    $table_perfixed = $wpdb->prefix . 'comments';
    $results = $wpdb->get_results("
        SELECT *
        FROM $table_perfixed
        WHERE  `comment_post_ID` = $orderid
        AND  `comment_type` LIKE  'order_note'
    ");

    foreach($results as $note){
        $order_note[]  = array(
            'note_content' => $note->comment_content,
			'note_date'    => $note->comment_date,
            'note_author'  => $note->comment_author,
        );
    }
    return $order_note;
}

/*************************************************************************************************************************/
// alter shipping info for wplister ebay items 
add_filter( "wplister_available_shipping_providers", "my_custom_ebay_shipping_providers", 10, 1 );
function my_custom_ebay_shipping_providers( $shipping_providers ) {
    // define custom selection of shipping providers
    $shipping_providers = array(
		'Freightquote.com' => 'Freightquote.com',
		'ABF Freight' => 'ABF Freight',
		'Averitt' => 'Averitt',
		'Central Transport' => 'Central Transport',
		'FedEx Freight' => 'FedEx Freight',
		'Holland' => 'Holland',
		'Old Dominion Freight' => 'Old Dominion Freight',
		'Roadrunner' => 'Roadrunner',
		'Saia' => 'Saia',
		'Southeastern Freight Lines' => 'Southeastern Freight Lines',
		'XPO Logistics' => 'XPO Logistics',
		'YRC Freight' => 'YRC Freight',
		'FedEx' => 'FedEx',
		'UPS Ground' => 'UPS Ground',
		'USPS Flat Rate' => 'USPS Flat Rate',
        'Local Pickup'   => 'Local Pickup'
    );
    return $shipping_providers;
}
/*************************************************************************************************************************/
// PHP: Remove "(optional)" from our non required fields
add_filter( 'woocommerce_form_field' , 'remove_checkout_optional_fields_label', 10, 4 );
function remove_checkout_optional_fields_label( $field, $key, $args, $value ) {
    // Only on checkout page
    if( is_checkout() && ! is_wc_endpoint_url() ) {
        $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
        $field = str_replace( $optional, '', $field );
    }
    return $field;
}

// JQuery: Needed for checkout fields to Remove "(optional)" from our non required fields
add_filter( 'wp_footer' , 'remove_checkout_optional_fields_label_script' );
function remove_checkout_optional_fields_label_script() {
    // Only on checkout page
    if( ! ( is_checkout() && ! is_wc_endpoint_url() ) ) return;

    $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
    ?>
    <script>
    jQuery(function($){
        // On "update" checkout form event
        $(document.body).on('update_checkout', function(){
            $('#billing_country_field label > .optional').remove();
            $('#billing_address_1_field label > .optional').remove();
            $('#billing_postcode_field label > .optional').remove();
            $('#billing_state_field label > .optional').remove();
            $('#shipping_country_field label > .optional').remove();
            $('#shipping_address_1_field label > .optional').remove();
            $('#shipping_postcode_field label > .optional').remove();
            $('#shipping_state_field label > .optional').remove();
        });
    });
    </script>
    <?php
}
/*************************************************************************************************************************/
// CUSTOM FUNCTIONS
// create note in sold oos log
function sold_oos_log( $email, $product ) 
{
	$year = date("Y"); $mon = date("m"); $day = date("d");
	if ( !file_exists("../library/sold-oos-log/$year/$mon/$day/" ) ) { 
		mkdir("../library/sold-oos-log/$year/$mon/$day", 0744, true); }
	
	$sku = $product->get_sku();
	$postid = $product->get_id();
	$lsnlink = get_post_meta( $postid, '_lsnlink', true ); if ($lsnlink != "") { $lsnlink = strtolower( $lsnlink ); }
	$fblink = get_post_meta( $postid, '_fbmp', true ); if ($fblink != "") { $fblink = strtolower( $fblink ); }
	
	$file = fopen("../library/sold-oos-log/$year/$mon/$day/sold-oos.html","a");
	// build line
	$line = "<br>" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $email . " --- <a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a>";
	if ( $fblink != "" && substr($fblink, 0, 1) == "h" ) {
		$line = $line . " --- <a class='fb_item_link' href='https://www.facebook.com/marketplace/you/selling?title_search=$sku' rel='noopener noreferrer' target='_blank'><strong>FB</strong></a>"; }
	if ($lsnlink != "") {
		$line = $line . " --- <a class='lsn_item_link' href='$lsnlink' rel='noopener noreferrer' target='_blank'><strong>LSN</strong></a>"; }
	// write the line to the file
	echo fwrite($file, $line);
	fclose($file);
}
/*************************************************************************************************************/
// create note in price change log
function old_price_change_log( $email, $product, $oregprice, $regprice ) 
{
	$postid = $product->get_id();
	$lsn = get_post_meta( $postid, '_lsn', true );
	$lsnlink = get_post_meta( $postid, '_lsnlink', true );
		if ($lsn == "") { $lsnL = ""; }
		else if ( substr( $lsn, 0, 1 ) == "l" || substr( $lsn, 0, 1 ) == "c"  ) {
			$lsnL = "<a class='admin_lsn_link' href='$lsnlink' rel='noopener noreferrer' target='_blank' title='$lsnlink'>$lsn</a>"; }
	$fblink = get_post_meta( $postid, '_fbmp', true );
	$fblink = strtolower( $fblink );
	$pos = strpos($fblink, "item/") + 5; // find where item/ is and account for its length of 5
	$fbID = substr($fblink, $pos);
	$len = strlen($fbID) - 1;
	$fbID = substr($fbID, 0, $len);
	$fbPriceChangeLink = "https://www.facebook.com/marketplace/edit/?listing_id=$fbID";
		if ( $fblink == "" ) { $fbL = ""; }
		else if ( $fblink == "exclude" ) {
			 $fbL = "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; X &nbsp; </strong></p>"; }
		else if ( $fblink == "multi" ) {
			$fbL = "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; M &nbsp; </strong></p>"; }
		else if ( substr( $fblink, 0, 1 ) == "h" ) {
			$fbL = "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='$fbPriceChangeLink' rel='noopener noreferrer' target='_blank'>
					facebook</a>"; }
	
	if ( !file_exists("../library/price-change-log/".date("Y-m-d")) ) { 
		mkdir("../library/price-change-log/".date("Y-m-d"), 0744, true); }
	$file = fopen("../library/price-change-log/".date("Y-m-d")."/price-change.html","a");
	echo fwrite($file, "<br>" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $email . " --- " . $lsnL . " - " . $fbL . " ---       " . $product->get_sku() . " --- $" . $oregprice . " -> $" . $regprice );
}
// new price change log
function price_change_log( $email, $product, $oregprice, $regprice )  
{
	$postid = $product->get_id();
	$lsn = get_post_meta( $postid, '_lsn', true );
	$lsnlink = get_post_meta( $postid, '_lsnlink', true );
	if ( $lsnlink != "" ) {
		$pos = strpos($lsnlink, '/', strpos($lsnlink, '/', strpos($lsnlink, '/', strpos($lsnlink, '/', strpos($lsnlink, '/') + 1) + 1) + 1 ) + 1) + 1;
		$pos2 = strpos($lsnlink, '.', strpos($lsnlink, '.', strpos($lsnlink, '.') + 1) + 1);
		$lsnID = substr($lsnlink, $pos, $pos2 - $pos); 
	}
	// create new lsn link 
	$newlsnlink = "https://www.lsn.com/mylsn/manage/$lsnID";
		if ($lsn == "") { $lsnL = ""; }
		else if ( substr( $lsn, 0, 1 ) == "l" || substr( $lsn, 0, 1 ) == "c"  ) {
			$lsnL = "<a class='admin_lsn_link' href='$newlsnlink' rel='noopener noreferrer' target='_blank' title='$newlsnlink'>$lsn</a>"; }
	$fblink = get_post_meta( $postid, '_fbmp', true );
	$fblink = strtolower( $fblink );
	$pos = strpos($fblink, "item/") + 5; // find where item/ is and account for its length of 5
	$fbID = substr($fblink, $pos);
	$len = strlen($fbID) - 1;
	$fbID = substr($fbID, 0, $len);
	$sku = "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='https://ccrind.com/wp-admin/edit.php?s=%3D".$product->get_sku()."&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_cat&product_type&stock_status&paged=1&postidfirst=142130&action2=-1' rel='noopener noreferrer' target='_blank'>".$product->get_sku()."</a>"; 
	$fbPriceChangeLink = "https://www.facebook.com/marketplace/edit/?listing_id=$fbID";
		if ( $fblink == "" ) { $fbL = ""; }
		else if ( $fblink == "exclude" ) {
			 $fbL = "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; X &nbsp; </strong></p>"; }
		else if ( $fblink == "multi" ) {
			$fbL = "<p style='display: inline-block; 
					color:#ffffff; 
					background-color:#48649f; 
					text-align:center; 
					padding: 8px; 
					-webkit-border-radius: 20px;
					border-radius: 20px;'><strong> &nbsp; M &nbsp; </strong></p>"; }
		else if ( substr( $fblink, 0, 1 ) == "h" ) {
			$fbL = "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='$fbPriceChangeLink' rel='noopener noreferrer' target='_blank'>
					facebook</a>"; 
			$fbLS = "<a class='admin_link_fb2' 
					style='display: inline-block;
					text-align:center; 
					-webkit-border-radius: 5px;
					border-radius: 5px;
					transition-duration: 0.3s;'
					href='https://www.facebook.com/marketplace/you/selling?title_search=".$product->get_sku()."' rel='noopener noreferrer' target='_blank'>
					fb search</a>"; 
		}
	
	$year = date("Y"); $md = date("m-d");
	if ( !file_exists("../library/price-change-log/$year/$md/" ) ) { 
		mkdir("../library/price-change-log/$year/$md/", 0744, true); }
	
		// create the html product change log
		// create update log table from existing array
		$tabledatarows = "";
		$tabledatarows = $tabledatarows ."
		<tr>
			<td>" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . "</td>
			<td>$email</td>
			<td>$lsnL</td>
			<td>$fbL</td>
			<td>$fbLS</td>
			<td>$sku</td>
			<td>$oregprice</td>
			<td>$regprice</td>
		</tr>
";
		
	$filestart = "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
.pl_table_title { font-size: 20px; font-weight: heavy; }
tr:nth-child(even) { background-color: #f2f2f2 }
</style>
</head>
<body>

<p>Click the buttons to sort the table.  Buttons denoted by headers with *</p>

<h2>PRICE CHANGE LOG: " . date('Y-m-d', current_time( 'timestamp', 0 ) ) . "</h2>
<table id='priceTable'>
	<tr>
		<th><button onclick='sortTableDATE()'><b>* Date / Time *</b></button></th>
		<th>User</th>
		<th><button onclick='sortTableLSN()'><b>* LSN *</b></button></th>
		<th>FB Link</th>
		<th>FB Search SKU Link</th>
		<th><button onclick='sortTableSKU()'><b>* SKU *</b></button></th>
		<th>Old Price</th>
		<th><button onclick='sortTablePRICE()'><b>* NEW PRICE *</b></button></th>
	</tr>
	$tabledatarows
";
	

	$fileend = "</table>
<script>
function sortTableLSN() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('priceTable');
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName('TD')[2];
      y = rows[i + 1].getElementsByTagName('TD')[2];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function sortTableDATE() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('priceTable');
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName('TD')[0];
      y = rows[i + 1].getElementsByTagName('TD')[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function sortTableSKU() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('priceTable');
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName('TD')[5];
      y = rows[i + 1].getElementsByTagName('TD')[5];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function sortTablePRICE() {
  var table, rows, switching, i, x, y, shouldSwitch, a, b;
  table = document.getElementById('priceTable');
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName('TD')[7]; 
	  a = Number(x.innerHTML.toLowerCase());
      y = rows[i + 1].getElementsByTagName('TD')[7]; 
	  b = Number(y.innerHTML.toLowerCase());
      //check if the two rows should switch place:
      if (a > b) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

</body>
</html>
";
		// html product change log
		// if the file doesnt exist, format html with page title and table header cells
		if ( !file_exists("../library/price-change-log/$year/$md/price-change.html") ) {
			$file = fopen("../library/price-change-log/$year/$md/price-change.html","a");
			$data = $filestart . $fileend;
			echo fwrite($file, $data);
			fclose($file);
		}
		// if the file exists, add the latest change log to the top after the style and h1 title
		else {
			// open the file
			$file = fopen("../library/price-change-log/$year/$md/price-change.html","c+");
			$found = true; // flag to verify if string is found
			$find = "</table>";  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// once $find is found, stop reading
				if ( strpos( $line, $find) !== false ) { $found = false; }
				if ($found) { $filecontents = $filecontents . $line; continue; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/price-change-log/$year/$md/price-change.html","w");
			echo fwrite($file, "$filecontents
$tabledatarows " . "$fileend
");
			fclose($file); 
		}
}

/*************************************************************************************************************/
// translate lister emails
function translate_email( $email ) 
{
	if ($email == "adam@ccrind.com"){ $email = "Adam"; }
	else if ($email == "jedidiah@ccrind.com"){ $email = "Jed"; }
	else if ($email == "dan@ccrind.com"){ $email = "Dan"; }
	else if ($email == "sharon@ccrind.com"){ $email = "Sharon"; }
	else if ($email == "ccrind02@gmail.com"){ $email = "Ryan"; }
	else if ($email == "ccrind05@gmail.com"){ $email = "Kelsey"; }
	return $email;
}
/*************************************************************************************************************/
// email appropriate user regarding status updates to orders
function email_order_update()
{
	global $current_user;
    wp_get_current_user();
	$email = $current_user->user_email; 
	//if ( $email == "jedidiah@ccrind.com" ) { $email = "adam@ccrind.com"; }
	if ( $email == "sharon@ccrind.com" ) { $email = "jedidiah@ccrind.com"; }
	return $email;
}
/*************************************************************************************************************/
// display Paid eBay icon with transaction id
function paid_ebay( $tid )
{
	//echo "<span style='display: inline-block; color:#ffffff; background-color:#c41a02; text-align:center; padding: 8px; -webkit-border-radius: 5px; border-radius: 5px;'>eBay</span>";
	echo '<p class="admin_ebay_sold" style="display: inline-block; text-align:center; -webkit-border-radius: 5px; border-radius: 5px; padding-top: 2px;"><img src="https://ccrind.com/wp-content/uploads/2019/11/ebaylogo-e1573053326628.png" title="ebay Sold" alt="ebay"> </p>';
	if ($tid != "") { $stid = substr($tid, 0, 7); echo "<br><text style='color:#ffffff; font-size: 9px;'>$tid</text>"; }
}
/*************************************************************************************************************/
// print all the via payment method, tid, and icons associated
function print_billvia( $order )
{
	$shiptype = $order->get_payment_method();
	$tid = $order->get_transaction_id();
	if ($shiptype != "" && $tid != "") {
	list($shiptype, $tid) = translate_pay( $shiptype, $tid );
	if ($tid != "") { echo "<div style='font-size: 16px; color: #999999; line-height: 1;'>via $shiptype <text style='font-size: 12px;'>($tid)</text></div>"; }
	else { echo "<div style='font-size: 16px; color: #999999; line-height: 1;'>via $shiptype</div>"; } 
	if ( strpos($shiptype, "redit") ) { echo "<p class='ccicon' style='color: #2ca01c; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-credit-card fa-2xl'></i></p>"; }
	else if ( strpos($shiptype, "ayPal") ) { echo "<p class='ppicon' style='color: #213170; padding-top: 7px; font-size: 20px;'><i class='fa-brands fa-cc-paypal fa-2xl'></i></p>"; }
	else if ( $shiptype == "Other" || $shiptype == "other" ) {
		if ( $tid == "Cash") { echo "<p class='cashicon' style='color: #89b383; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-money-bill-1-wave fa-2xl'></i></p>"; }
		else if ( $tid == "Check") { echo "<p class='checkicon' style='color: #a0895c; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-money-check fa-2xl'></i></p>"; }
		else if ( $tid == "Wire") { echo "<p class='wireicon' style='color: #696254; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-building-columns fa-2xl'></i></p>"; }
	}
	else if ( strpos($shiptype, "Bay") ) { echo '<p class="admin_ebay_sold" style="display: inline-block; text-align:center; -webkit-border-radius: 5px; border-radius: 5px; padding-top: 2px;"><img src="https://ccrind.com/wp-content/uploads/2019/11/ebaylogo-e1573053326628.png" title="ebay Sold" alt="ebay"> </p><br>'; } } echo "<br><br>";
}
/*************************************************************************************************************/
// print all the via shipping method and icons associated
function print_shipvia( $order )
{
	$shiptype = $order->get_shipping_method();
	if ($shiptype != "") {
		if ( strpos($shiptype, "reight Shipping (Terminal)") ) { echo "<div style='font-size: 12px; color: #999999; line-height: 1;'>via $shiptype</div>"; }
		else { echo "<div style='font-size: 16px; color: #999999; line-height: 1;'>via $shiptype</div>";  }
		if ($shiptype == "Local Pickup") { 
			echo "<div style='margin-top: 7px;'><img src=\"https://ccrind.com/wp-content/uploads/2022/11/localpickupccr.png\" title='Local Pickup' alt=\"local pickup image\" width='69' height='43'></div>"; }
			//echo "<p class='lpicon' style='color: #c40403; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-warehouse fa-2xl'></i></p>"; } 
		else if ( strpos($shiptype, "Party") ) { echo "<p class='thirdicon' style='color: #92b5d1; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-truck-ramp-box fa-2xl'></i></p>"; }
		else if ( strpos($shiptype, "reight Shipping (Terminal)") ) { echo "<p class='freighticonterm' style='color: #9fc0c0; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-truck-moving fa-2xl'></i><i class='fa-solid fa-industry fa-2xl'></i></p>"; }
		else if ( strpos($shiptype, "reight") ) { 
			//echo "<p class='freighticon' style='color: #9fc0c0; padding-top: 7px; font-size: 20px;'><i class='fa-solid fa-truck-moving fa-2xl'></i></p>"; 
			echo "<div style='margin-top: 7px;'><img src=\"https://ccrind.com/wp-content/uploads/2022/11/freighticon.png\" title='Freight' alt=\"freight ship image\" width='90' height='43'></div>";
		}
		//else if ( strpos($shiptype, "reight") ) { echo "<p class='freighticon' style='color: #f8dda7; padding-top: 7px; font-size: 3px;'>
		//<img style=\"width:120px;\" src=\"https://ccrind.com/wp-content/uploads/2022/08/noun-truck-199691.svg\" alt=\"Freight Icon\"/></p>"; }
		else if ( strpos($shiptype, "SPS") ) { echo "<p class='uspsicon' style='color: #333366; padding-top: 7px; font-size: 20px;'><i class='fa-brands fa-usps fa-2xl'></i></p>"; }
		else if ( strpos($shiptype, "PS") ) { echo "<p class='upsicon' style='color: #ffbe03; padding-top: 7px; font-size: 20px;'><i class='fa-brands fa-ups fa-2xl'></i></p>"; } } echo "<br>";
}
/*************************************************************************************************************/
// translate the payment method into a more user friendly readable phrase
function translate_pay( $shiptype, $tid ) {
	if ($shiptype == "paypal" || $shiptype == 'angelleye_ppcp' || $shiptype == 'ppcp-gateway' || $shiptype == "ppcp" ) { 
		$shiptype = "PayPal"; 
		if ($tid != "") { $tid = "<a href=\"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=$tid\"  rel=\"noopener noreferrer\" target=\"_blank\">$tid</a>"; } }
	else if ($shiptype == "quickbookspay") { 
		$shiptype = "Credit Card"; 
		if ($tid != "") { $tid = "<a href=\"https://merchantcenter.intuit.com/msc/portal/reporting#transaction/$tid\"  rel=\"noopener noreferrer\" target=\"_blank\">$tid</a>"; } }
	else if ($shiptype == "stripe") { 
		$shiptype = "Credit Card"; 
		if ($tid != "") { $tid = "<a href=\"https://dashboard.stripe.com/payments/$tid\"  rel=\"noopener noreferrer\" target=\"_blank\">$tid</a>"; } }
	else if ($shiptype == "CreditCard") { $shiptype = "eBay CC"; }
	else if ($shiptype == "CreditCard (PayPal)") { $shiptype = "eBay PP"; }
	return array($shiptype, $tid); }
/*************************************************************************************************************/
// get stock qty of variations of a variable product
function get_selected_variation_stock() {
    if ( $product->is_type( 'variable' ) ) {
        $available_variations = $product->get_available_variations();
        foreach ($available_variations as $key => $value) {
            $variation_id = $value['variation_id'];
            $variation_obj = new WC_Product_variation($variation_id);
            $stock = $variation_obj->get_stock_quantity();
            echo $attribute_pa_colour . ": " . $stock . " "; } } }
/*************************************************************************************************************/
// filter order notes on order page for readability note color
function order_notes_filter ( $note_content, $date, $user, $color, &$stockup, &$stockdown ) {
	// translate user name color
	if ( strpos($note_content, 'Jedidiah') !== false ) { 
		$user = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Sharon') !== false) { 
		$user = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Lamar') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Brian') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
	if ( strpos($user, 'Jedidiah') !== false ) { 
		$user = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Sharon') !== false) { 
		$user = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Lamar') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Brian') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
	// color notes based on their meaning
	$note_lower = strtolower($note_content);
	if ( strpos($note_lower, 'invoice sent,') !== false || strpos($note_lower, 'tracking info entered') !== false || strpos($note_lower, 'email') !== false ) { $color = "#ff9797"; }
	if ( strpos($note_lower, 'ebay') !== false ) { $color = "#f4ae02"; }
	if ( strpos($note_lower, 'info / ship') !== false || strpos($note_lower, 'ancelled') !== false ) { $color = "#ffffff"; }
	if ( strpos($note_lower, 'tock levels reduced') !== false ) { $color = "#c97a7a"; }
	if ( strpos($note_lower, 'tock levels increased') !== false ) { $color = "#7ec97a"; }
	if ( strpos($note_lower, 'arked exempt') !== false ) { $color = "#c39595"; }
	if ( strpos($note_lower, 'arked taxable') !== false ) { $color = "#a8c09f"; }
	if ( strpos($note_lower, 'ales agreement signed') !== false ) { $color = "#f8dda7"; }
	if ( strpos($note_lower, 'ales agreement made') !== false ) { $color = "#6fa0bd"; }
	if ( strpos($note_lower, 'quickbooks payments') !== false || strpos($note_lower, 'ipn payment completed') !== false || strpos($note_lower, 'paypal transaction id:') !== false || strpos($note_lower, 'payment via paypal') !== false ) { $color = "#c6e1c6"; }
	// filter out unwanted messages notes
	if ( ( strpos ($note_content, 'No active eBay listings found in this order.') !== false ) 
		|| ( strpos ($note_content, 'Order status changed from') !== false ) 
		|| ( strpos ($note_content, 'Order has been exported to Shipstation') !== false ) 
		|| ( strpos ($note_content, 'eBay inventory was updated successfully') !== false ) 
		|| ( strpos ($note_content, 'Scheduled to update inventory in the background') !== false ) 
		|| ( strpos ($note_content, 'There was a problem revising the inventory') !== false ) 
	   ) { /* do nothing */ }
	else if ( strpos ($note_content, 'Stock levels reduced:') !== false ) {
		if ($stockdown) { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } $stockdown = 0; }
	else if ( strpos ($note_content, 'Stock levels increased:') !== false ) {
		if ($stockup) { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } $stockup = 0; }
	else { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } 
}
/*************************************************************************************************************/
function order_notes_filterC ($note, $ntype) {
	
	if ($ntype == 1) {
		echo "<div class='customer_order_notes_area' style='max-height: 100px; overflow:auto; line-height: 1.2; color: #ffffff; background-color: #5c5c5c; border-radius: 5px; font-size: 14px;'>$note<br><br></div>"; 
	}
	if ($ntype == 2) {
		echo "<div class='customer_order_notes_area' style='line-height: 1.2; color: #ff9f9e; background-color: #5c5c5c; border-radius: 5px; font-size: 14px; margin-top: 3px;'>$note<br><br></div>"; 
	}
}
/*************************************************************************************************************/
function order_notes_filterPage ( $note_content, $date, $user, $color, &$stockup, &$stockdown ) {
	// translate user name color
	if ( strpos($note_content, 'Jedidiah') !== false ) { 
		$user = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Sharon') !== false) { 
		$user = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Lamar') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
	else if ( strpos($note_content, 'Brian') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
	if ( strpos($user, 'Jedidiah') !== false ) { 
		$user = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Sharon') !== false) { 
		$user = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Lamar') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
	else if ( strpos($user, 'Brian') !== false) { 
		$user = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
	// color notes based on their meaning
	$note_lower = strtolower($note_content);
	if ( strpos($note_lower, 'invoice sent,') !== false || strpos($note_lower, 'tracking info entered') !== false || strpos($note_lower, 'email') !== false ) { $color = "#ff9797"; }
	if ( strpos($note_lower, 'ebay') !== false ) { $color = "#f4ae02"; }
	if ( strpos($note_lower, 'info / ship') !== false || strpos($note_lower, 'ancelled') !== false ) { $color = "#ffffff"; }
	if ( strpos($note_lower, 'tock levels reduced') !== false ) { $color = "#c97a7a"; }
	if ( strpos($note_lower, 'tock levels increased') !== false ) { $color = "#7ec97a"; }
	if ( strpos($note_lower, 'arked exempt') !== false ) { $color = "#c39595"; }
	if ( strpos($note_lower, 'arked taxable') !== false ) { $color = "#a8c09f"; }
	if ( strpos($note_lower, 'ales agreement signed') !== false ) { $color = "#f8dda7"; }
	if ( strpos($note_lower, 'ales agreement made') !== false ) { $color = "#6fa0bd"; }
	if ( strpos($note_lower, 'quickbooks payments') !== false || strpos($note_lower, 'ipn payment completed') !== false || strpos($note_lower, 'paypal transaction id:') !== false || strpos($note_lower, 'payment via paypal') !== false ) { $color = "#c6e1c6"; }
	// filter out unwanted messages notes
	if ( ( strpos ($note_content, 'No active eBay listings found in this order.') !== false ) 
		|| ( strpos ($note_content, 'Order status changed from') !== false ) 
		|| ( strpos ($note_content, 'Order has been exported to Shipstation') !== false ) 
		|| ( strpos ($note_content, 'eBay inventory was updated successfully') !== false ) 
		|| ( strpos ($note_content, 'Scheduled to update inventory in the background') !== false ) 
		|| ( strpos ($note_content, 'There was a problem revising the inventory') !== false ) 
	   ) { /* do nothing */ echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; }
	if ( strpos ($note_content, 'Stock levels reduced:') !== false ) {
		if ($stockdown) { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } $stockdown = 0; }
	else if ( strpos ($note_content, 'Stock levels increased:') !== false ) {
		if ($stockup) { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } $stockup = 0; }
	else { echo "<div class='ordernote' style='color: $color; flex: 1;'>$note_content<br>$date  $user</div><br>"; } }
/*************************************************************************************************************/
// establish if order is ebay
function establish_if_ebay($orderidall) {
	$order_notes = get_private_order_notes( $orderidall );
	foreach($order_notes as $notes) {
    	$note_content = $notes['note_content'];
		if(strpos( $note_content, "eBay User ID:") !== false) {
			$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
			$salesrecord = "E" . $srnum; } }
	return $salesrecord; }
/*************************************************************************************************************/
// mark the correct _soldby and add to the product log
function mark_soldby_make_log($product, $salesrecord) {
	$id = $product->get_id();
	$tableupdate = array();
	$osb = get_post_meta( $id, '_soldby', true );
	if ($salesrecord == "") /*ws order*/
	{ update_post_meta( $id, '_soldby', wc_clean( "ws" ) ); $tag = "ws";}
	else /*ebay order*/
	{ update_post_meta( $id, '_soldby', wc_clean( "ebay" ) ); $tag = "ebay";}
	$updatedesc = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: $osb => $tag"; 
	array_push( $tableupdate, array("MARKED PENDING", "(OLD STATUS)", "PRIVATE (SOLD)") ); 
	array_push( $tableupdate, array("SOLD BY", $osb, $tag) );
	// change product status
	$product->set_status('private'); 
	$product->save(); 
	$changeloc = "Order Change Edit (Auto)";
	make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
}
/*************************************************************************************************************/
// make product change logs
function make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc) {
	// create text log of change
		$sku = $product->get_sku();
		$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
		// make directory for the file if it does not exist
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
			mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true); }
		if ($changeloc == "Product Page Edit"){ $changeloctrans = "PPE"; }
		else if ($changeloc == "Inline Edit"){ $changeloctrans = "INL"; }
		else if ($changeloc == "Product Page Edit (Description)"){ $changeloctrans = "PPED"; }
		else if ($changeloc == "Product Page Edit (Title)"){ $changeloctrans = "PPET"; }
		else if ($changeloc == "Product Page Edit (Pictures)"){ $changeloctrans = "PPEP"; }
		// create the txt product change log
		$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
		echo fwrite($file, "\n" . date('Y-m-d    h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $lastuser . "
- $changeloc - 
" . $updatedesc . "
		
");
		fclose($file);
		// create the html product change log
		// create update log table from existing array
		if ( !empty($tableupdate)) {
		$tabledatarows = "";
		for ( $i=0; $i < count($tableupdate); $i++ ) {
			$tabledatarows = $tabledatarows ."
	<tr>
		";
			for ( $j=0; $j < 3; $j++ ) {
				$tabledatarows = $tabledatarows ."
		<td>". $tableupdate[$i][$j] ."</td>
		";
			}
	$tabledatarows = $tabledatarows ."
	</tr>
";
		}
	$filestart = "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
.pl_table_title { font-size: 20px; font-weight: heavy; }
.pl_userJedidiah { color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px; }
.pl_userSharon { color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px; }
.pl_userDan { color: #ffffff; background-color: #000000; border-radius: 10px; padding: 2px; }
.pl_userKelsey { color: #ffffff; background-color: #4ea33c; border-radius: 10px; padding: 2px; }
.pl_userRyan { color: #ffffff; background-color: #33718f; border-radius: 10px; padding: 2px; }
.pl_userAdam{ color: #ffffff; background-color: #3ca39f; border-radius: 10px; padding: 2px; }
.cl_PPE { color: #ffffff; background-color: #000000; border-radius: 10px; padding: 2px; }
.cl_INL { color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px; }
.cl_PPED { color: #ffffff; background-color: #4ea33c; border-radius: 10px; padding: 2px; }
.cl_PPET { color: #ffffff; background-color: #33718f; border-radius: 10px; padding: 2px; }
.cl_PPEP { color: #ffffff; background-color: #3ca39f; border-radius: 10px; padding: 2px; }
</style>
<body>
<h2>SKU: $sku UPDATE LOG </h2>
<div class='pl_table_title'>". date('Y-m-d    h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / <text class='pl_user$lastuser'>&nbsp;". $lastuser ."&nbsp;</text> --- <text class='cl_$changeloctrans'>&nbsp;$changeloc&nbsp;</text></div>
<table>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>
";
		// html product change log
		// if the file doesnt exist, format html with page title and table header cells
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/$sku.html") ) {
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","a");
			echo fwrite($file, $filestart);
			fclose($file);
		}
		// if the file exists, add the latest change log to the top after the style and h1 title
		else {
			// open the file
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","c+");
			$found = false; // flag to verify if string is found
			$find = "</h2>";  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// once $find is found, read all the lines into the $filecontents variable
				if ($found) { $filecontents = $filecontents . $line; continue; }
				if ( strpos( $line, $find) !== false ) { $found = true; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, "$filestart
<br>
$filecontents
");
			fclose($file); 
		}
		}
}

/*************************************************************************************************************/
function fee_trans( $status, $fee, $label ) {
	// coloring
	if ($status == "completed") { $color = "ffffff"; $color2 = "ffffff"; $bgc = "c41a02"; }
	else if ( $status == "pending" ) { $color = "ffffff"; $color2 = "ffffff"; $bgc = "368bbc"; }
	else if ( $status == "processing" ) { $color = "ffffff"; $color2 = "70995d"; $bgc = "c6e1c6"; }
	else if ( $status == "on-hold" ) { $color = "ffffff"; $color2 = "a1794d"; $bgc = "f7dca5"; }
	else if ( $status == "failed" ) { $color = "ffffff"; $color2 = "7d3a45"; $bgc = "eba3a3"; }
	else { $color = "ffffff"; $color2 = "ffffff"; $bgc = "3a3a3a"; }
	// output
	$fee = "$" . number_format((float) $fee, 2, '.', '' ); echo "<div class='total_labels' style='margin-top: 5px; margin-bottom: 5px; line-height: 1.2; color: #$color;'><span style='display: inline-block; color: #$color2; background-color: #$bgc; padding: 6px; -webkit-border-radius: 5px; border-radius: 5px;'>$fee</span>$label "; echo "</div>"; }
/*************************************************************************************************************/
function update_checks($orderid) {
	echo "<div style='text-align:center;'><button type='submit' name='postallorder' class='postallorder' title='' id=\"postallorder\" onclick=\"document.getElementById('postallorder').disabled = true; document.getElementById('postallorder').style.opacity='0.5'; this.form.submit();\"></button></div>
		<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
		<label for='cashcheck$orderid'><input type='radio' id='cashcheck$orderid' name='payradio' class='cashradio' value='1'>
      	<span style='color: #b2fc95 !important;'>Cash</span></label></div>
		<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
		<label for='checkcheck$orderid'><input type='radio' id='checkcheck$orderid' name='payradio' class='checkradio' value='2'>
        <span style='color: #f8dda7; !important'>Check</span></label></div>
		<div style='margin-top: 3px; margin-bottom: 3px; line-height: 1.2;'>
		<label for='wirecheck$orderid'><input type='radio' id='wirecheck$orderid' name='payradio' class='wireradio' value='3'>
        <span style='color: #c8c8c8; !important'>Wire</span></label></div>"; }
/*************************************************************************************************************/
// wp_mail email alert for items marked sold (not in use)
function email_alert($email) {
	//$to = array("jedidiah@ccrind.com", "adam@ccrind.com");
	$to = "jedidiah@ccrind.com";
	$subject = "SOLD CCR Item Forced to SOLD: OUT OF STOCK, SKU:" . $product->get_sku();
	$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Line Edit Stock Change Column SOLD\n
If item is Out of Stock and Marked Sold, please remove links for FB and LSN.
Product ID: $postidall 
Product name: $title
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1";
	wp_mail( $to, $subject, $message ); /* email alert */ }
/*************************************************************************************************************/
// change allowed users to access the creation of sales agreements generateSA
function bewpi_allowed_roles_to_download_invoice($allowed_roles) {
    // available roles: shop_manager, customer, contributor, author, editor, administrator, sub_editor
    $allowed_roles[] = "administrator, editor, subeditor";
    // end so on..
    return $allowed_roles; }
add_filter( 'bewpi_allowed_roles_to_download_invoice', 'bewpi_allowed_roles_to_download_invoice', 10, 2 );
/*************************************************************************************************************/
function lsn_scheduled_event() {
    // fetch today's date and store in LSN log
    $date = date('m/d/y');
	// place the date inside the log
	$find = "class='today'>"; // div class of today
	$findrenew = "class='renewDateS";
	$reading = fopen("../library/LSN/LSN.html", "r"); // read file
	$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
	$replaced = false; // flagl
	$renewc = 0;
	$debug = "";
	// read through the entire file
	while ( !feof($reading)) {
		$line = fgets($reading); // line by line
		// once $find is found, overwrite the data already in the table
		if ( strpos($line, $find) && (!$replaced) ) { $newline = "<div class='today'>$date</div>"; $line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } /* replace line with data in $newline */ 
		// if a renew date is the same day as today
		else if ( strpos($line, $findrenew) ) { // if the line contains a possible renew date
			if ( strpos($line, "-") || strpos($line, "/") ) { // if the renewDate line contains formatting specifying a date
				// extrapolate the date from $line
				// <th class='renewDate LSN'>10-6-22</th>
				$pos = strpos($line, ">") + 1;
				$end = strpos($line, "</th>");
				$end = $end - $pos; 
				$rdate = substr($line, $pos, $end); 
				$rdatealt = strtotime($rdate); 
				$datealt = strtotime("$date + 3 days"); 
				if ($rdatealt < $datealt) {
					// break the line in 2 pieces
					$newline = "	<th class='renewDateR" . substr($line, strpos($line, $findrenew)+17 ); // new beginning changes class
					//$newline2 =  // just append the old ending to the new beginning
					//$newline = $newline . $newline2;
					$line = $newline; fwrite($writing, $line);
				}
				else { fwrite($writing, $line); }
			}
		}
		else { fwrite($writing, $line); } // write each line from read file to write file 
	}
	fclose($reading); fclose($writing); // close both working files
	// if a line was replaced during the above loop, overwrite the read file with the written file
	if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
	// if a line was NOT replaced, delete the unrequired write temporary file
	else { unlink("../library/LSN/LSN.tmp.html"); }
	
	// get accounts with renewals due
	$reading = fopen("../library/LSN/LSN.html", "r"); // read file
	$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
	// read through the entire file
	while ( !feof($reading)) {
		$line = fgets($reading); // line by line
		if ( strpos($line, "class='renewDateR ") ) { $renewc = $renewc + 1; fwrite($writing, $line); }
		else if ( strpos($line, "color_key renewDueCount") ) {
			$newline = "	<td class='color_key renewDueCount'>$renewc</td>";
			$line = $newline . PHP_EOL; fwrite($writing, $line); 
		}
		else { fwrite($writing, $line); } // write each line from read file to write file 
	}
	fclose($reading); fclose($writing); // close both working files
	rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); 
	
	lsn_counts_and_dates();
	
	/*$to = "jedidiah@ccrind.com";
	$subject = "LSN Cron event";
	$message = "$debug";
	wp_mail( $to, $subject, $message );*/
}
function get_query_IDs() {


        global $wp_query;

        $buffer_query = $wp_query->query;
    
        $args = array(
            'nopaging' => true,
            'fields' => 'ids',
        );
    
        $custom_query = new WP_Query( array_merge( $buffer_query, $args ) );
    
        wp_reset_postdata();
    
        return $custom_query->posts;

}
add_filter( 'woocommerce_products_admin_list_table_filters', 'remove_products_admin_list_table_filters', 10, 1 );
function remove_products_admin_list_table_filters( $filters ){
    // Remove "Product type" dropdown filter
        unset($filters['fb_sync_enabled']);

    return $filters;
}
/*************************************************************************************************************/

add_action('save_post_product', 'send_fbmp_email', 9999, 3);
function send_fbmp_email( $post_id, $post, $update )   {
	$product = wc_get_product( $post_id );
	$status = $product->get_status();
	$type = get_post_type( $post );
	$sku = $product->get_sku();
	
	if( 'product' === $type && $status == "publish" ) 
	{	
		remove_action('save_post_product', 'send_fbmp_email', 9999, 3 );
		$product->save();
		//add_action('save_post_product', 'send_fbmp_email', 9999, 3);
		$fblink = get_post_meta( $post_id, '_fbmp', true );
		$solby = get_post_meta( $post_id, '_soldby', true );
		$customs = get_post_meta( $post_id, '_customship', true );
		
		if ( substr($fblink, 0, 4) != "http" && $soldby != "auco" && $customs != 4 && $customs != 6) 
		{
			$sku = $product->get_sku();
			$subject  = "PRODUCT NEEDS FBMP: $sku";
			$message  = "Post: $post_id, SKU: $sku may need to be posted to Facebook Marketplace.";
			wp_mail("jedidiah@ccrind.com", $subject, $message ); 
		}
	} 
}
/*************************************************************************************************************/
add_action( 'woocommerce_product_published', 'send_fbmp_email_new', 10, 1 );
function send_fbmp_email_new( $product_id ) {
	$product = wc_get_product( $product_id );
	$sku = $product->get_sku();
	
	$fblink = get_post_meta( $post_id, '_fbmp', true );
	$solby = get_post_meta( $post_id, '_soldby', true );
	$customs = get_post_meta( $post_id, '_customship', true );
	
	if ( substr($fblink, 0, 4) != "http" && $soldby != "auco" && $customs != 4 && $customs != 6) 
	{
		$sku = $product->get_sku();
		$subject  = "PRODUCT NEEDS FBMP: $sku NEW PUBLISH";
		$message  = "Post: $post_id, SKU: $sku may need to be posted to Facebook Marketplace.";
		wp_mail("jedidiah@ccrind.com", $subject, $message ); 
	}
}
/*************************************************************************************************************/
function get_product_by_sku( $sku ) {

    global $wpdb;

    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

    if ( $product_id ) return new WC_Product( $product_id );

    return null;
}
/*************************************************************************************************************/
