<?php
// adding custom checkout fields
add_action( 'woocommerce_after_order_notes', 'add_custom_checkout_fields' );
function add_custom_checkout_fields( $checkout ) 
{
	echo "<br><br><br>";
	//echo '<h3>__________________________________</h3>';
	echo '<div class="address_misc_info" style="background-color: #ffffff;" id="address_misc_info"><h3>Address Info (REQUIRED)</h3>';
	echo '<p style="color:#c40403;">' . __('If you are doing Local Pickup (NO SHIPPING) or have made other arrangements, you must still select these items, but the values will not matter, except for "Shipping Type" for Local Pickup specifically.') . '</p>';
	
	woocommerce_form_field( 'ship_type', array(
		'type'          => 'select',
		'class'         => array( 'ship_type_field', 'form-row-wide' ),
		'required'		=> 'true',
		'label'         => __( 'Shipping Type: Require Shipping or Setup your own Shipping?' ),
		'options'       => array(
			''     => __( 'Select one', 'woocommerce' ),
			'CCR Ship'   => __( 'I require CCR Industrial to ship the item to me.', 'woocommerce' ),
			'3rd Party Ship' => __( 'I will setup my own shipping through a Freight Shipper.', 'woocommerce' ),
			'Local Pickup' => __( 'I will personally pickup my order (Local Pickup).', 'woocommerce' )
		), ), $checkout->get_value( 'ship_type' ) );
	
	woocommerce_form_field( 'address_type', array(
		'type'          => 'select',
		'class'         => array( 'address_type_field', 'form-row-wide' ),
		'required'		=> 'true',
		'label'         => __( 'Address Type: Address the item will be delivered to is:' ),
		'options'       => array(
			''     => __( 'Select one', 'woocommerce' ),
			'Commercial'   => __( 'Commercial', 'woocommerce' ),
			'Residential' => __( 'Residential', 'woocommerce' )
		), ), $checkout->get_value( 'address_type' ) );
	
	woocommerce_form_field( 'unload_type', array(
		'type'          => 'select',
		'class'         => array( 'unload_type_field', 'form-row-wide' ),
		'required'		=> 'true',
		'label'         => __( 'Address has use of a Forklift or Freight Dock access for unloading?' ),
		'options'       => array(
			''     => __( 'Select one', 'woocommerce' ),
			'Yes'   => __( 'Yes', 'woocommerce' ),
			'No' => __( 'No', 'woocommerce' )
		), ), $checkout->get_value( 'unload_type' ) );
	
	/*woocommerce_form_field( 'd_appointment', array(
		'type'          => 'select',
		'class'         => array( 'd_appointment_field', 'form-row-wide' ),
		'required'		=> 'true',
		'label'         => __( 'Do you require a Delivery Appointment?' ),
		'options'       => array(
			''     => __( 'Select one', 'woocommerce' ),
			'Y'   => __( 'Yes', 'woocommerce' ),
			'N' => __( 'No', 'woocommerce' )
		), ), $checkout->get_value( 'd_appointment' ) );*/
	
	//echo '<div><h3>' . __('__________________________________') . '</h3></div>';
	echo '<br><br></div>';
	echo '<div class="address_misc_info" style="background-color: #ffffff;" id="address_misc_info"><h3>How Did You Find Us?</h3>';
	echo '<p style="color:#c40403;">' . __('Examples: google search, google shopping ad, facebook, lsn, (other website), etc.?  Thank you for your input.') . '</p>';
	
	woocommerce_form_field( '_found_by_select', array(
		'type'          => 'select',
		'class'         => array( '_found_by_select', 'form-row-wide' ),
		'required'		=> false,
		'label'         => __( 'Select from the following or type a custom answer below:' ),
		'options'       => array(
			''     => __( 'Select one', 'woocommerce' ),
			'ws'   => __( 'google', 'woocommerce' ),
			'ws' => __( 'google shopping ad', 'woocommerce' ),
			'fb'   => __( 'facebook', 'woocommerce' ),
			'lsn'   => __( 'lsn', 'woocommerce' ),
			'referral'   => __( 'referral', 'woocommerce' )
		), ), $checkout->get_value( '_found_by_select' ) );
	woocommerce_form_field( '_found_by', array(
 		'type'        => 'text',
 		'required'    => false,
 		'label'       => 'Custom Answer:',
 		'description' => 'Please enter how you found our product (website name, etc)...',
 		), $checkout->get_value( '_found_by' ) );
	
	echo '<br><br></div>';
}

add_action('woocommerce_checkout_process', 'custom_checkout_field_process');
function custom_checkout_field_process() 
{
	if ( ($_POST['ship_type'] == '') || ($_POST['ship_type'] == "Select one") )
        wc_add_notice( __( 'Please select a <strong>Shipping Type</strong>, under Address Info.' ), 'error' );
    if ( ($_POST['address_type'] == '') || ($_POST['address_type'] == "Select one") )
        wc_add_notice( __( 'Please select an <strong>Address Type</strong>, under Address Info.' ), 'error' );
	if ( ($_POST['unload_type'] == '') || ($_POST['unload_type'] == "Select one") )
        wc_add_notice( __( 'Please select <strong>Unloading Capability</strong>, under Address Info.' ), 'error' );
	//if ( ($_POST['d_appointment'] == '') || ($_POST['d_appointment'] == "Select one") )
        //wc_add_notice( __( 'Please select <strong>Delivery Appointment</strong> option, under Address Info.' ), 'error' );
}

add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');
function custom_checkout_field_update_order_meta( $order_id ) 
{
	if ( ! empty( $_POST['ship_type'] ) ) 
	{ 
		if ($_POST['ship_type'] == "I require CCR Industrial to ship the item to me.") { $_POST['ship_type'] = "CCR Ship"; }
		else if ($_POST['ship_type'] == "I will setup my own shipping through a Freight Shipper.") { $_POST['ship_type'] = "3rd Party Ship"; }
		else if ($_POST['ship_type'] == "I will personally pickup my order (Local Pickup).") { $_POST['ship_type'] = "Local Pickup"; }
		update_post_meta( $order_id, 'ship_type', sanitize_text_field( $_POST['ship_type'] ) ); 
	}
	if ( ! empty( $_POST['address_type'] ) ) { update_post_meta( $order_id, 'address_type', sanitize_text_field( $_POST['address_type'] ) ); }
	if ( ! empty( $_POST['unload_type'] ) ) { update_post_meta( $order_id, 'unload_type', sanitize_text_field( $_POST['unload_type'] ) ); }
	//if ( ! empty( $_POST['d_appointment'] ) ){ update_post_meta( $order_id, 'd_appointment', sanitize_text_field( $_POST['d_appointment'] ) ); }
	if ( ! empty( $_POST['_found_by_select'] ) ){ update_post_meta( $order_id, '_found_by', sanitize_text_field( $_POST['_found_by_select'] ) ); }
	if ( ! empty( $_POST['_found_by'] ) ){ update_post_meta( $order_id, '_found_by', sanitize_text_field( $_POST['_found_by'] ) ); }
}
?>