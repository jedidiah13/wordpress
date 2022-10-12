<?php
add_action( 'woocommerce_admin_order_data_after_order_details', 'order_custom_meta_general' );
function order_custom_meta_general ( $order ) 
{
	$saCB = get_post_meta( $order->id, 'sa_checkbox', true );
	$sasCB = get_post_meta( $order->id, 'sa_signed_checkbox', true );
	$saDate = get_post_meta( $order->id, 'sa_made_date', true );
	$sasDate = get_post_meta( $order->id, 'sa_signed_date', true ); 
	$term = get_post_meta( $order->id, 'terminal_delivery', true );
	$tzs = get_post_meta( $order->id, 'terminal_zip', true ); if ($tzs == "") { $tz = "(Terminal zip)"; }
	$ls = get_post_meta( $order->id, 'shipq_length', true ); if ($ls == "") { $l = "(L)"; }
	$ws = get_post_meta( $order->id, 'shipq_width', true ); if ($ws == "") { $w = "(W)"; }
	$hs = get_post_meta( $order->id, 'shipq_height', true ); if ($hs == "") { $h = "(H)"; } 
	$lbss = get_post_meta( $order->id, 'shipq_weight', true ); if ($lbss == "") { $lbs = "(lbs)"; } 
	$pfs = get_post_meta( $order->id, 'shipq_pallet_fee', true ); if ($pfs == "") { $pf = "(Pallet $)"; } 
	$CCRprices = get_post_meta( $order->id, 'shipq_CCRcost', true ); if ($CCRprices == "") { $CCRprice = "(Quote $)"; }
	$quoteprice = get_post_meta( $order->id, 'shipq_price', true );
		
	?> <div class="_clear_line">                                                                       </div> <?php
	echo "<h3 style='color: #ffffff;'>Sales Agreement Info:</h3><br>";
	echo "<div class='samade'>";
	if ( $saCB ) { echo "<input type='checkbox' title='Sales Agreement made and submitted to buyer.' id='sa_checkbox' name='sa_checkbox' class='sa_checkbox' value='sa_checkbox' checked> <label for='sa_checkbox' class='sa_checkboxl'> SA Made / Submitted</label>"; }
	else { echo "<input type='checkbox' title='Sales Agreement made and submitted to buyer.' id='sa_checkbox' name='sa_checkbox' class='sa_checkbox' value='sa_checkbox'><label for='sa_checkbox' class='sa_checkboxl'> SA Made / Submitted</label>"; }
	echo "</div>";
	echo "<div class='sasigned'>";
	if ( $sasCB ) { echo "<input type='checkbox' title='Sales Agreement Signed by buyer.' id='sa_signed_checkbox' name='sa_signed_checkbox' class='sa_signed_checkbox' value='sa_signed_checkbox' checked><label for='sa_signed_checkbox' class='sa_signed_checkboxl'> SA Signed</label>"; }
	else { echo "<input type='checkbox' title='Sales Agreement Signed by buyer.' id='sa_signed_checkbox' name='sa_signed_checkbox' class='sa_signed_checkbox' value='sa_signed_checkbox'><label for='sa_signed_checkbox' class='sa_signed_checkboxl'> SA Signed</label>"; }
	echo "</div>";
	echo "<div class='saDatediv' style='line-height: 1.2;'>";
	echo "<input type='text' id='saDate' class='saDate' name='saDate' rows='1' placeholder='' value='$saDate' title='Enter the date the SA was made here.'></div>";
	echo "<div class='sasDatediv' style='line-height: 1.2;'>";
	echo "<input type='text' id='sasDate' class='sasDate' name='sasDate' rows='1' placeholder='' value='$sasDate' title='Enter the date the SA was signed here.'></div>";
	?> <div class="_clear_line">                                                                       </div> <?php
	echo "<h3 style='color: #ffffff;'>Ship Quote Inputs &nbsp; <i class='fa-solid fa-dollar-sign fa-xl'></i><i class='fa-solid fa-truck-fast'></i></h3>";
	?> <div class="OterminalBEdiv" style="line-height: 1.2;"> <?php
			woocommerce_wp_select( 
				array( 
					'class' => 'OterminalBE',
					'id' => 'terminal_delivery',
					'label' => "Terminal Delivery: ",
					'options' => array(
						''   => __( 'Change to...', 'woocommerce' ),
						'Yes'   => __( 'Yes', 'woocommerce' ),
						'No'   => __( 'No', 'woocommerce' ),
						'Offered'   => __( 'Offered', 'woocommerce' ),
						'clear'   => __( 'Clear', 'woocommerce' ),
					) 
				) 
			); 
		?></div> <?php
	echo "<div class='Oterminal_zipBEdiv' style='line-height: 1.2;'>";
	echo "<label for='Oterminal_zipBE' class='Oterminal_zipBEl'>Terminal Zip:</label><input type='text' id='Oterminal_zipBE' class='Oterminal_zipBE' name='Oterminal_zipBE' rows='1' placeholder='$tz' value='$tzs' title='Enter the zip code of the terminal address delivery.'></div>";
	?> <div class="_clear_line">                                                                       </div> <?php
	echo "<div class='length_inputBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_length_inputBE' class='O_length_inputBEl'>Length:</label><input type='text' id='O_length_inputBE' class='O_length_inputBE' name='O_length_inputBE' rows='1' placeholder='$l' value='$ls' title='Enter the length of pallet here.'></div>";
	echo "<div class='width_inputBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_width_inputBE' class='O_width_inputBEl'>Width:</label><input type='text' id='O_width_inputBE' class='O_width_inputBE' name='O_width_inputBE' rows='1' placeholder='$w' value='$ws' title='Enter the width of pallet here.'></div>";
	echo "<div class='height_inputBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_height_inputBE' class='O_height_inputBEl'>Height:</label><input type='text' id='O_height_inputBE' class='O_height_inputBE' name='O_height_inputBE' rows='1' placeholder='$h' value='$hs' title='Enter the height of pallet here.'></div>";
	echo "<div class='Oweight_inputBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_weight_inputBE' class='O_weight_inputBEl'>Weight:</label><input type='text' id='O_weight_inputBE' class='O_weight_inputBE' name='O_weight_inputBE' rows='1' placeholder='$lbs' value='$lbss' title='Enter the weight of pallet here.'></div>";
	echo "<div class='Opallet_feeBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_pallet_feeBE' class='O_pallet_feeBEl'>Pallet Fee:</label><input type='text' id='O_pallet_feeBE' class='O_pallet_feeBE' name='O_pallet_feeBE' rows='1' placeholder='$pf' value='$pfs' title='Enter the cost of pallet fee here.'></div>";
	echo "<div class='OCCR_ship_costBEdiv' style='line-height: 1.2;'>";
	echo "<label for='O_CCR_ship_costBE' class='O_CCR_ship_costBEl'>CCR Ship Cost Quote:</label><input type='text' id='O_CCR_ship_costBE' class='O_CCR_ship_costBE' name='O_CCR_ship_costBE' rows='1' placeholder='$CCRprice' value='$CCRprices' title='Enter the cost of shipping quote to CCR here.'></div>";
	if ($quoteprice != "") {
		?> <div class="_clear_line">                                                                       </div> <?php
		echo "<div class='shipquotediv' style='line-height: 1.2; color: #ffffff; margin-top: 1ch;'>Ship Quote: $$quoteprice</div>"; }
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'order_custom_meta_bill' );
function order_custom_meta_bill ( $order ) 
{
	$ebayID = get_post_meta( $order->id, '_ebayID', true );
	//$manual = get_post_meta( $order->id, '_manual_control', true );
	$saved = get_post_meta( $order->id, '_saved_status', true );
	$method = $order->get_payment_method();
	$keep = get_post_meta( $order->id, '_EBkeeponhold', true );
	$saved_id = get_post_meta( $order->id, '_saved_ebay_transaction_id', true );
	$addtype = get_post_meta( $order->id, 'address_type', true );
	$unloadtype = get_post_meta( $order->id, 'unload_type', true );
	$shiptype = get_post_meta( $order->id, 'ship_type', true );
	$foundBy = get_post_meta( $order->id, '_found_by', true );
	$sort = get_post_meta( $order->id, '_status_sort', true );
	$sentinvdate = get_post_meta( $order->id, '_sent_invoice', true ); 
	//if ($sentinvdate != "") {$sentinvdate->format('m-d-y'); }
	$sentfollowupdate = get_post_meta( $order->id, '_sent_followup', true ); 
	//if ($sentfollowupdate != "") {$sentfollowupdate->format('m-d-y');}
	$sentwireinvdate= get_post_meta( $order->id, '_sent_wireinv', true ); 
	//if ($sentwireinvdate != "") {$sentwireinvdate->format('m-d-y');}
	$sentwireinfodate = get_post_meta( $order->id, '_sent_wireinfo', true ); 
	//if ($sentwireinfodate != "") {$sentwireinfodate->format('m-d-y');}
	$sentebaymsgdate = get_post_meta( $order->id, '_sent_ebaymsg', true ); 
	//if ($sentebaymsgdate != "") {$sentebaymsgdate->format('m-d-y');}
	$ourshipcost = get_post_meta($order->id, '_ccr_ship_cost', true);
	$paydate = $order->get_date_paid(); 
	if ($paydate != "") {$paydate = $paydate->format('m-d-y');}
	$shipdate = get_post_meta( $order->id, '_ccr_ship_date', true );
	
	// only do header if one value is set
	if ( $saved || $keep || $saved_id || $addtype || $unloadtype || $shiptype || $foundBy || $paydate ) 
	{
		echo "<h3>Additional Info:</h3>";
	}
	
	// start div to control layout
	?> <div class="order_add_info"> <?php
	if ( $saved ) {
		?> <div class="_saved_status"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_saved_status',
				'label' => 'O Saved Status:',
				'value' => $saved,
				'class' => '_saved_status'
			) );
		?> </div> <?php
	}
	if ( $method ) {
		?> <div class="_saved_pay"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_saved_pay',
				'label' => 'Pay Method:',
				'value' => $method,
				'class' => '_saved_pay'
			) );
		?> </div> <?php
		$tid = $order->get_transaction_id();
		if ($tid != "") {
			?> <div class="_saved_pay_tid"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_saved_pay_tid',
				'label' => 'Transaction ID:',
				'value' => $tid,
				'class' => '_saved_pay_tid'
			) );
		?> </div> <?php
		}
	}
	if ( $ebayID ) {
		?> <div class="_ebayID"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_ebayID',
				'label' => 'eBay Order #:',
				'value' => $ebayID,
				'class' => '_ebayID'
			) );
		?> </div> <?php
	}
	if ( $saved_id ) {
		?> <div class="_saved_ebay_transaction_id"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_saved_ebay_transaction_id_input',
				'label' => 'Saved Transaction ID:',
				'value' => $saved_id,
				'class' => '_saved_ebay_transaction_id_input'
			) );
		?> </div> <?php
	}
	?> <div class="_clear_line">                                                                       </div> <?php
	?> <div class="_found_by"> <?php
			woocommerce_wp_select( 
				array( 
					'id' => '_found_by',
					'label' => "Found By:",
					'options' => array(
						''     => __( 'Select one', 'woocommerce' ),
						'ws'   => __( 'google', 'woocommerce' ),
						'ws' => __( 'google shopping ad', 'woocommerce' ),
						'ws' => __( 'ccr (google)', 'woocommerce' ),
						'fb'   => __( 'facebook', 'woocommerce' ),
						'ebay' => __( 'eBay', 'woocommerce' ),
						'lsn'   => __( 'lsn', 'woocommerce' ),
						'referral'   => __( 'referral', 'woocommerce' )
					) 
				) 
			); 
		?></div> <?php
		?> <div class="address_type"> <?php
			woocommerce_wp_select( 
				array( 
					'id' => 'address_type',
					'label' => "Address Type: ",
					'options' => array(
						''   => __( 'Change to...', 'woocommerce' ),
						'Commercial'   => __( 'Commercial', 'woocommerce' ),
						'Residential'   => __( 'Residential', 'woocommerce' )
					) 
				) 
			); 
		?></div> <?php
		?> <div class="unload_type"> <?php
			woocommerce_wp_select( 
				array( 
					'id' => 'unload_type',
					'label' => "Forklift / Dock? ",
					'options' => array(
						''   => __( 'Change to...', 'woocommerce' ),
						'Yes'   => __( 'Yes', 'woocommerce' ),
						'No'   => __( 'No', 'woocommerce' )
					) 
				) 
			); 
		?></div> <?php
		?> <div class="ship_type"> <?php
			woocommerce_wp_select( 
				array( 
					'id' => 'ship_type',
					'label' => "Shipping Type: ",
					'options' => array(
						''   => __( 'Change to...', 'woocommerce' ),
						'CCR Ship'   => __( 'CCR Ship', 'woocommerce' ),
						'3rd Party Ship'   => __( '3rd Party Ship', 'woocommerce' ),
						'Local Pickup'   => __( 'Local Pickup', 'woocommerce' )
					) 
				) 
			);
		?></div> <?php
		
	?> <div class="_clear_line">                                                                       </div> <?php
	?> <div class="_sent_invoice"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_sent_invoice',
				'label' => 'Invoice Sent:',
				'value' => $sentinvdate,
				'class' => '_sent_invoice'
			) );
		?> </div> <?php
	?> <div class="_sent_followup"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_sent_followup',
				'label' => 'Followup Sent:',
				'value' => $sentfollowupdate,
				'class' => '_sent_followup'
			) );
		?> </div> <?php
	?> <div class="_sent_wireinv"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_sent_wireinv',
				'label' => 'Wire Invoice Sent:',
				'value' => $sentwireinvdate,
				'class' => '_sent_wireinv'
			) );
		?> </div> <?php
	?> <div class="_sent_wireinfo"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_sent_wireinfo',
				'label' => 'Wire Info sent:',
				'value' => $sentwireinfodate,
				'class' => '_sent_wireinfo'
			) );
		?> </div> <?php
	?> <div class="_sent_ebaymsg"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_sent_ebaymsg',
				'label' => 'eBay Msg Sent:',
				'value' => $sentebaymsgdate,
				'class' => '_sent_ebaymsg'
			) );
		?> </div> <?php
	?> <div class="_ccr_ship_cost"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_ccr_ship_cost',
				'label' => 'CCR Ship Cost:',
				'value' => $ourshipcost,
				'class' => '_ccr_ship_cost'
			) );
		?> </div> <?php
	?> <div class="_pay_date"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_pay_date',
				'label' => 'Date Paid:',
				'value' => $paydate,
				'class' => '_pay_date'
			) );
		?> </div> <?php
	?> <div class="_ccr_ship_date"> <?php
			woocommerce_wp_text_input( array(
				'id' => '_ccr_ship_date',
				'label' => 'Date Shipped:',
				'value' => $shipdate,
				'class' => '_ccr_ship_date'
			) );
		?> </div> <?php
	
	// end div to control layout
	?> </div> <?php
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'order_custom_meta_ship' );
function order_custom_meta_ship ( $order ) 
{
	$add_emails = get_post_meta( $order->id, '_add_emails', true );
	$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
	$saved_bill = get_post_meta( $order->id, '_saved_billing', true );
	$saved_phone = get_post_meta( $order->id, '_saved_phone', true );
	
	echo "<h3>Additional Emails:</h3>";
	?> <span class="_add_emails"><?php
			woocommerce_wp_text_input( array(
				'id' => '_add_emails_input',
				'class' => '_add_emails_input',
				'type' => 'text',
				'label' => __( 'Enter "clear" to empty the field.', 'woocommerce' ),
				'value' => $add_emails
			) );
	?> </span> <?php
	?> <div class="_clear_line">                                                                       </div> <?php
	if ( $saved_phone ) 
	{
		echo "<h3>Saved Phone:</h3>";
		echo "<div class='_saved_phone'>";
		echo "<p>$saved_phone</p>";
		echo "</div>"; 
	}
	?> <div class="_clear_line">                                                                       </div> <?php
	if ( $saved_ship || $saved_bill ) { echo "<h3>Saved Addresses</h3>"; }
	if ( $saved_ship ) {
		echo "<div class='_saved_shippingO'>";
		echo "<p>Saved Shipping:<br>";
		echo $saved_ship["first_name"] . " " . $saved_ship["last_name"] . "<br>";
		if ($saved_ship["company"] != "") { echo $saved_ship["company"] . "<br>"; }
		if ($saved_ship["address_1"] != "") { echo $saved_ship["address_1"] . "<br>"; }
		if ($saved_ship["address_2"] != "") { echo $saved_ship["address_2"] . "<br>"; }
		echo $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"] . "</p>";
		echo "</div>"; 
	}
	if ( $saved_bill ) {
		echo "<div class='_saved_billingO'>";
		echo "<p>Saved Billing:<br>";
		echo $saved_bill["first_name"] . " " . $saved_bill["last_name"] . "<br>";
		if ($saved_bill["company"] != "") { echo $saved_bill["company"] . "<br>"; }
		if ($saved_bill["address_1"] != "") { echo $saved_bill["address_1"] . "<br>"; }
		if ($saved_bill["address_2"] != "") { echo $saved_bill["address_2"] . "<br>"; }
		echo $saved_bill["city"] . ", " . $saved_bill["state"] . " " . $saved_bill["postcode"] . " " . $saved_bill["country"] . "</p>";
		echo "</div>"; 
	}
}

add_action( 'woocommerce_process_shop_order_meta', 'order_save_general_details' );
function order_save_general_details( $order_id )
{
	if ( ! empty( $_POST['_EBkeeponhold'] ) ) 
	{ update_post_meta( $order_id, '_EBkeeponhold', wc_clean( $_POST[ '_EBkeeponhold' ] ) ); }
	if ( ! empty( $_POST['_saved_pay'] ) ) 
	{ update_post_meta( $order_id, '_saved_pay', sanitize_text_field( $_POST['_saved_pay'] ) ); }
	if ( ! empty( $_POST['_saved_ebay_transaction_id'] ) ) 
	{ update_post_meta( $order_id, '_saved_ebay_transaction_id', wc_clean( $_POST[ '_saved_ebay_transaction_id' ] ) ); }
	if ( ! empty( $_POST['address_type'] ) ) 
	{ update_post_meta( $order_id, 'address_type', sanitize_text_field( $_POST['address_type'] ) ); }
	if ( ! empty( $_POST['unload_type'] ) ) 
	{ update_post_meta( $order_id, 'unload_type', sanitize_text_field( $_POST['unload_type'] ) ); }
	if ( ! empty( $_POST['d_appointment'] ) ) 
	{ update_post_meta( $order_id, 'd_appointment', sanitize_text_field( $_POST['d_appointment'] ) ); }
	if ( ! empty( $_POST['_found_by'] ) ) 
	{ update_post_meta( $order_id, '_found_by', sanitize_text_field( $_POST['_found_by'] ) ); }
	if ( ! empty( $_POST['_add_emails_input'] ) ) 
	{ 
		if ( $_POST['_add_emails_input'] == "clear" ) { update_post_meta( $order_id, '_add_emails', "" ); }
		else { update_post_meta( $order_id, '_add_emails',  wc_clean( $_POST[ '_add_emails_input' ] ) );  }
	}
	if (! empty( $_POST['ship_type'] ) ) 
	{ update_post_meta( $order_id, 'ship_type', sanitize_text_field( $_POST['ship_type'] ) ); } 
	
	update_post_meta( $order_id, 'sa_made_date', wc_clean( $_POST['saDate'] ) ); 
	update_post_meta( $order_id, 'sa_signed_date', wc_clean( $_POST['sasDate'] ) ); 
	update_post_meta( $order_id, '_ccr_ship_date', wc_clean( $_POST['_ccr_ship_date'] ) );
	
	update_post_meta( $order_id, '_sent_invoice', sanitize_text_field( $_POST['_sent_invoice'] ) );
	update_post_meta( $order_id, '_sent_followup', sanitize_text_field( $_POST['_sent_followup'] ) );
	update_post_meta( $order_id, '_sent_wireinv', sanitize_text_field( $_POST['_sent_wireinv'] ) );
	update_post_meta( $order_id, '_sent_wireinfo', sanitize_text_field( $_POST['_sent_wireinfo'] ) );
	update_post_meta( $order_id, '_sent_ebaymsg', sanitize_text_field( $_POST['_sent_ebaymsg'] ) );
	update_post_meta( $order_id, '_ccr_ship_cost', sanitize_text_field( $_POST['_ccr_ship_cost'] ) );
	
	update_post_meta( $order_id, 'sa_checkbox', wc_clean( $_POST['sa_checkbox'] ) );
	update_post_meta( $order_id, 'sa_signed_checkbox', wc_clean( $_POST['sa_signed_checkbox'] ) );
	
	$oterm = get_post_meta( $order_id, 'terminal_delivery', true );
	$otz = get_post_meta( $order_id, 'terminal_zip', true );
	$ols = get_post_meta( $order_id, 'shipq_length', true );
	$ows = get_post_meta( $order_id, 'shipq_width', true );
	$ohs = get_post_meta( $order_id, 'shipq_height', true );
	$olbss = get_post_meta( $order_id, 'shipq_weight', true );
	$opfs = get_post_meta( $order_id, 'shipq_pallet_fee', true ); 
	$oCCRprices = get_post_meta( $order_id, 'shipq_CCRcost', true );
	$change = 0;
	$list = "";
	$term = $_POST['terminal_delivery']; if ($oterm != $term) { update_post_meta( $order_id, 'terminal_delivery', sanitize_text_field( $term ) ); $change = 1; $list = $list . "Terminal Delivery: $term, ";}
	$tz = $_POST['Oterminal_zipBE']; if ($otz != $tz) { update_post_meta( $order_id, 'terminal_zip', sanitize_text_field( $tz ) ); $change = 1; $list = $list . "Terminal Zip: $tz, ";} 
	$l = $_POST['O_length_inputBE']; if ($ols != $l) { update_post_meta( $order_id, 'shipq_length', sanitize_text_field( $l ) ); $change = 1; $list = $list . "QL: $l, ";} 
	$w = $_POST['O_width_inputBE']; if ($ows != $w) { update_post_meta( $order_id, 'shipq_width', sanitize_text_field( $w ) ); $change = 1; $list = $list . "QW: $w, ";} 
	$h = $_POST['O_height_inputBE']; if ($ohs != $h) { update_post_meta( $order_id, 'shipq_height', sanitize_text_field( $h ) ); $change = 1; $list = $list . "QH: $h, ";} 
	$lbs = $_POST['O_weight_inputBE']; if ($olbss != $lbs) { update_post_meta( $order_id, 'shipq_weight', sanitize_text_field( $lbs ) ); $change = 1; $list = $list . "Qlbs: $lbs, ";} 
	$pf = $_POST['O_pallet_feeBE']; if ($opfs != $pf) { update_post_meta( $order_id, 'shipq_pallet_fee', sanitize_text_field( $pf ) ); $change = 1; $list = $list . "Pallet Fee: $pf, ";}  
	$shipquote = $_POST['O_CCR_ship_costBE']; if ($shipquote != $oCCRprices ) {
		update_post_meta( $order_id, 'shipq_CCRcost', sanitize_text_field( $shipquote )); $list = $list . "CCR Q Cost: $shipquote, ";
		$quoted_cost = ( $shipquote * 1.25 ) + $pf; $quoted_cost = number_format((float) $quoted_cost, 2, '.', '' ); 
		update_post_meta( $order_id, 'shipq_price', sanitize_text_field( $quoted_cost )); $list = $list . "Generated Quote: $quoted_cost, ";
		$change = 1; }
	$order = wc_get_order( $order_id ); 
	if ($change) { 
		global $current_user;
    	wp_get_current_user();
		$lastuser = $current_user->user_firstname;
		generate_ship_quote_log($order, $order_id); $list = substr($list, 0, -2);
		$note = __("Quote Info Changed in Order Main Page: $list, updated by $lastuser"); $order->add_order_note( $note ); }
}
?>