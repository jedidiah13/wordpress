<?php
add_action( 'woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
function woocommerce_process_shop_order ( $order ) 
{
	remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
	$status   = $order->get_status();
	$orderid  = $order->get_id();
	$method   = $order->get_payment_method();
	$state    = $order->get_shipping_state();
	$state2   = $order->get_billing_state();
	$shiptype = $order->get_shipping_method();
	$saved_status = get_post_meta( $orderid, '_saved_status', true );
	$phone    = $order->get_billing_phone();
	$salesrecord = "";
	$ccrordernum = "C" . $orderid;
	update_post_meta( $orderid, '_ccrID', wc_clean( $ccrordernum ) );
	
	// establish if order is ebay
	$order_notes = get_private_order_notes( $orderid );
	foreach($order_notes as $note)
	{
    	$note_content = $note['note_content'];
		if(strpos( $note_content, "eBay User ID:") !== false)
		{
			$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
			$salesrecord = "E" . $srnum;
			update_post_meta( $orderid, '_ebayID', wc_clean( $salesrecord ) );
		}
	}// end establishment
	
	if ( $salesrecord != "" ) // if ebay order
	{ 
		if ($status == "pending")
		{
			// protect _saved_shipping and _saved_billing and _saved_phone
			$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			$statesaved = $saved_ship["state"];
			if ($state != $statesaved ) 
			{
				$fname = $saved_ship["first_name"];
				$lname = $saved_ship["last_name"];
				$bname = $saved_ship["company"];
				$country = $saved_ship["country"];
				$shipst = $saved_ship["address_1"];
				$moreaddress = $saved_ship["address_2"];
				$city = $saved_ship["city"];
				$postcode = $saved_ship["postcode"];
						
				$address = array(
					'first_name' => $fname,
					'last_name'  => $lname,
					'company'    => $bname,
					'country'    => $country,
					'address_1'  => $shipst,
            		'address_2'  => $moreaddress, 
            		'city'       => $city,
            		'state'      => $statesaved,
            		'postcode'   => $postcode
        		);
				$order->set_address( $address, 'shipping' );
				$order->calculate_totals(); 
				//$order->save();
			}
			$saved_bill = get_post_meta( $order->id, '_saved_billing', true );
			$statesaved = $saved_bill["state"];
			if ($state2 != $statesaved ) 
			{
				$fname = $saved_bill["first_name"];
				$lname = $saved_bill["last_name"];
				$bname = $saved_bill["company"];
				$country = $saved_bill["country"];
				$shipst = $saved_bill["address_1"];
				$moreaddress = $saved_bill["address_2"];
				$city = $saved_bill["city"];
				$postcode = $saved_bill["postcode"];
						
				$address = array(
					'first_name' => $fname,
					'last_name'  => $lname,
					'company'    => $bname,
					'country'    => $country,
					'address_1'  => $shipst,
            		'address_2'  => $moreaddress, 
            		'city'       => $city,
            		'state'      => $statesaved,
            		'postcode'   => $postcode
        		);
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
				//$order->save();
			}
			$saved_phone = get_post_meta( $order->id, '_saved_phone', true );
			if ($phone != $saved_phone ) { $order->set_billing_phone($saved_phone); }
			
			// guard saved transaction ID
			$transaction_id = get_post_meta($orderid, '_transaction_id', true);
			if ($transaction_id == "SIS" ) {
				$saved_id = get_post_meta( $orderid, '_saved_ebay_transaction_id', true );
				update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) );
			}
			else if ( $transaction_id == "" ) {  }
			else {
				update_post_meta( $orderid, '_saved_ebay_transaction_id', wc_clean( $transaction_id ) );
				update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) );
				// if not marked as processing, then mark as on-hold for users to permanently mark as processing
				$saved_status = get_post_meta( $orderid, '_saved_status', true );
				if ($saved_status === "pending" ) {
					//remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order', 10, 3 );
					update_post_meta( $orderid, '_saved_status', wc_clean( 'on-hold' ) );
					$order->set_status('on-hold'); update_post_meta( $orderid, '_status_sort', wc_clean( 1 ) ); 
					//remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order', 10, 3 );
				}
			}
			
			if ($saved_status == "processing") { 
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
				update_post_meta( $orderid, '_saved_status', wc_clean( 'processing' ) );
				//$note = "completed status control save";
				//$order->update_status('completed', $note, 1);
				$order->set_status('processing'); update_post_meta( $orderid, '_status_sort', wc_clean( 2 ) );
				//$order->save();
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
			}
			else if ($saved_status == "completed") {  
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
				update_post_meta( $orderid, '_saved_status', wc_clean( 'completed' ) );
				//$note = "completed status control save";
				//$order->update_status('completed', $note, 1);
				$order->set_status('completed'); update_post_meta( $orderid, '_status_sort', wc_clean( '' ) ); 
				//$order->save();
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
			}
			else if ($saved_status == "cancelled") { 
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
				update_post_meta( $orderid, '_saved_status', wc_clean( 'cancelled' ) );
				//$note = "cancelled status control save";
				//$order->update_status('cancelled', $note, 1);
				$order->set_status('cancelled'); update_post_meta( $orderid, '_status_sort', wc_clean( '' ) ); 

				//$order->save();
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
												   }
			else if ($saved_status == "on-hold") { 
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
				update_post_meta( $orderid, '_saved_status', wc_clean( 'on-hold' ) );
				//$note = "on-hold status control save";
				//$order->update_status('on-hold', $note, 1);
				$order->set_status('on-hold'); update_post_meta( $orderid, '_status_sort', wc_clean( 1 ) ); 
				//$order->save();
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
												 }
			else 
			{
				remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order', 10, 3 );
				/*$notify = get_post_meta($orderid, '_new_notify', true);
				if ($notify != 1)
				{
					update_post_meta( $orderid, '_new_notify', 1 );
					$to = "jedidiah@ccrind.com, sharon@ccrind.com";
					$subject = "NEW ORDER, # C$orderid, eBay order # $salesrecord";
					$message = "NEW ORDER, # C$orderid, eBay order # $salesrecord";
					wp_mail( $to, $subject, $message ); // email alert
				}*/
			}
			//generate_order_log($order, $orderid);
		}
	}

	
	// change order shipping address based on shipping method selection
	if (strpos($shiptype, 'Pickup') == true)
	{
		//remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order', 10, 3 );
		$items    = (array) $order->get_items('shipping');
		$firstitem = true;
		$local = false;
		foreach ( $items as $item ) {
			if ($firstitem) {
    			$ship_title = $item->get_method_title();
				if (strpos($ship_title, 'Pickup') !== false)
				{
					$item->set_method_title( __("Local Pickup") ); $local = true;
				}
				$firstitem = false; 
				$item->save();
			}
		}
		$firstitem = true;
		foreach ( $items as $item_id => $item ) {
			if ($firstitem){ $firstitem = false; }
			else { $order->remove_item( $item_id ); }
    	}
		
		$fname = $order->get_shipping_first_name();
		$lname = $order->get_shipping_last_name();
		$address = array(
				'first_name' => $fname,
				'last_name' => $lname,
				'country' => 'US',
            	'address_1'  => '411 E Carroll St',
            	'address_2'  => '', 
            	'city'       => 'Tullahoma',
            	'state'      => 'TN',
            	'postcode'   => '37388',
        );
        $order->set_address( $address, 'shipping' );
		update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
		$order->calculate_totals(); 
		//remove_action('woocommerce_after_order_object_save', 'woocommerce_process_shop_order', 10, 3 );
	}
	
	$items_first = $order->get_items();
	foreach( $items_first as $item )
	{
		$product = wc_get_product($item->get_product_id());
		$qty = $product->get_stock_quantity();
		if ($qty < 1 ) {
    		$product->set_status( isset($args['status']) ? $args['status'] : 'private' );
			$product->save(); 
		}
		else {
			if ($qty == 1 ) {
			if ($status == "pending") {
				$product->set_status( isset($args['status']) ? $args['status'] : 'private' );
				$product->save(); } }
			else {
    		$product->set_status( isset($args['status']) ? $args['status'] : 'publish' );
			$product->save(); }
		}
		if ($status == "cancelled") {
			$product->set_status( isset($args['status']) ? $args['status'] : 'publish' );
			$product->save(); 
		}
	}
	
	/*$tid = $order->get_transaction_id();
	if ( $status == "processing" ) // if marked processing
	{
		// if paid by Credit Card
		if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay") && $tid !="")
		{
			$to = "jedidiah@ccrind.com";
			$subject = "Order C$orderid Marked Paid by CC automatically";
			$message = "Order:  " . $orderid . " was marked paid by Credit Card automatically with quickbookspay method.";
			wp_mail( $to, $subject, $message );
		}
	}*/
}
?>