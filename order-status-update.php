<?php
add_action( 'woocommerce_after_order_object_save', 'woocommerce_process_shop_order' );
function woocommerce_process_shop_order ( $order ) 
{
	$status   = $order->get_status();
	$orderid  = $order->get_id();
	$method   = $order->get_payment_method();
	$state    = $order->get_shipping_state();
	$salesrecord = "";
	
	// establish if order is ebay
	$order_notes = get_private_order_notes( $orderid );
	foreach($order_notes as $note)
	{
    	$note_content = $note['note_content'];
		if(strpos( $note_content, "eBay User ID:") !== false)
		{
			$srnum = substr ( $note_content, strpos( $note_content, "eBay Sales Record ID:") + 22, 10 );
			$salesrecord = "E" . $srnum;
		}
	}// end establishment
	
	if ($status == "pending")
	{
		// if ccrind order
		if ($salesrecord == "") 
		{ 
			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				if( $product != "")
				{
					$qty = $product->get_stock_quantity();
					if ($qty == 0)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						update_post_meta( $id, '_soldby', wc_clean( "wso" ) ); 
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => wso PENDING";
						$product->set_status('private'); 
						$product->save(); 
						
						// create text log of change
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- 
" . $msg. "
		
");
			fclose($file);
					}
				}
			}
		}
		else // if ebay order
		{ 
			// check for state of _saved_status, if it is not pending then redirect to other status save
			$saved_status = get_post_meta( $orderid, '_saved_status', true );
			if ($saved_status == "on-hold") { 
				// check ebay order keep on hold status
				$keeponhold = get_post_meta($orderid, '_EBkeeponhold', true);
				if ($keeponhold == "hold" ){ 
					$order->set_status('on-hold');  
					$order->save(); }
				if ($method == "intuit_payments_credit_card"){
					$order->set_status('on-hold');  
					$order->save(); }
				if ($method == "paypal"){
					$order->set_status('on-hold');  
					$order->save(); }
			}
			if ($saved_status == "processing") { $order->set_status('processing');  $order->save(); }
			if ($saved_status == "completed") { $order->set_status('completed');  $order->save(); }
			if ($saved_status == "cancelled") { $order->set_status('cancelled');  $order->save(); }
			
			if ( ($method != "intuit_payments_credit_card") && ($method != "paypal") ) 
				{
					update_post_meta( $orderid, '_saved_status', wc_clean( "pending" ) ); 
					$items_first = $order->get_items();
					foreach( $items_first as $item )
					{
						$product = wc_get_product($item->get_product_id());
						
						if( $product instanceof WC_Product )
						{

						$sku = $product->get_sku();
						$id = $item->get_product_id();
						$qty = $product->get_stock_quantity();
			
						if ($qty == 0)
						{ 
							update_post_meta( $id, '_soldby', wc_clean( "ebayo" ) ); 
							$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ebayo"; 
							$product->set_status('private'); 
							$product->save(); 
						}
				
					// bookmark pending
					$transaction_id = get_post_meta($orderid, '_transaction_id', true);
					if ($transaction_id == "SIS" ) { $saved_id = get_post_meta( $orderid, '_saved_ebay_transaction_id', true ); update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) ); }
					else if ( $transaction_id == "" ) { /* do nothing */ }
					else { update_post_meta( $orderid, '_saved_ebay_transaction_id', wc_clean( $transaction_id ) ); update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) ); }
		
					// create text log of change
					$skul = strlen($sku);
					if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
					else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
					else { $sku_2 = $sku; $sku_3 = $sku; }
		
					if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true); }
					$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
					echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- 
" . $msg. "
		
");
					fclose($file);
						}
					}
				}
			
		
			$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			if ( ($state == "") || ($saved_ship) ) 
			{
				$country = $saved_ship["country"];
					$shipst = $saved_ship["address_1"];
					$city = $saved_ship["city"];
					$state = $saved_ship["state"];
					$postcode = $saved_ship["postcode"];
						
					$address = array(
						'country' => $country,
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city,
            			'state'      => $state,
            			'postcode'   => $postcode
        			);
				$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
			}
		}
	}
	if ($status == "on-hold")
	{
		// checked saved status for redirection
		$saved_status = get_post_meta( $orderid, '_saved_status', true );
		if ($saved_status != "on-hold") 
		{	
			update_post_meta( $orderid, '_saved_status', wc_clean( "on-hold" ) ); 
			// if order is new, prep the shipping method and add note
			$keeponhold = get_post_meta($orderid, '_EBkeeponhold', true);
			if ($keeponhold == "")
			{ 
				update_post_meta( $orderid, '_EBkeeponhold', wc_clean( "hold" ) );
				// if a ws order, change the shipping method title, remove all other shipping method titles
				if ($salesrecord == "") // if ws order
				{ 
					$items    = (array) $order->get_items('shipping');
					$order->set_payment_method('');
					$firstitem = true;
					foreach ( $items as $item ) {
						if ($firstitem) {
    						$item->set_method_title( __("This item requires a Custom Shipping Quote.") );
							$item->save();
							$firstitem = false;
						}
					}
					$firstitem = true;
					foreach ( $items as $item_id => $item ) {
						if ($firstitem){ $firstitem = false; }
						else { $order->remove_item( $item_id ); }
    				}
				}
			} // new order prep finished for ebay and ws

			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				$sku = $product->get_sku();
				$id = $product->get_id(); 
				$qty = $product->get_stock_quantity();
				// if paid for
				if ( $method == "intuit_payments_credit_card" || $method == "paypal" ) 
				{
					if ($salesrecord == "") // if ws order
					{ 	
						if ($qty == 0){
							update_post_meta( $id, '_soldby', wc_clean( "wso" ) ); 
							$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => wso ON HOLD";
							// set items to private
							$product->set_status('private');
							$product->save();
						}
						if ($method == "paypal") {
							
							$paid = get_post_meta( $orderid, '_ebay_paid', true );
							if ($paid != "paid") {
								update_post_meta( $orderid, '_ebay_paid', esc_attr( "paid" ) );
								$msg2 = "WebStore Order Updated: " . $orderid . " ON-HOLD";
								$to = "jedidiah@ccrind.com, sara@ccrind.com";
								$subject = "ONHOLD WebStore Order Marked Paid: " . $orderid . " through PayPal";
							}
							// remove CC fee
							$feeitems = (array) $order->get_items('fee');
							foreach ( $feeitems as $item_id => $feeitem ) {
								$fee_name = $feeitem->get_name();
								$fee_name = strtolower($fee_name);
								if (strpos( $fee_name, "usage fee") ) { $order->remove_item( $item_id ); }
							}
							$items    = (array) $order->get_items('shipping');
							$firstitem = true;
							foreach ( $items as $item ) {
								if ($firstitem) {
    								$title = $item->get_method_title();
									if ($title == "Pickup Order at our Warehouse located in Tullahoma, TN (NO SHIPPING / PERSONALLY PICKUP), no Crating / Pallet fees with this option.")
									{
										
									}
									$firstitem = false;
								}
							}
							$firstitem = true;
							$order->calculate_totals();
							$order->set_status('on-hold');
							$order->save();
						}
						// if paid by CC
						else {
							//email
							update_post_meta( $orderid, '_ebay_paid', esc_attr( "paid" ) );
							$transaction_id = get_post_meta($orderid, '_transaction_id', true);
							if ($transaction_id == "") { $note = __("Order Status: Not captured, No transaction ID for transaction."); }
							else { $note = __("Order Status: Not captured, hit Order Update button to capture. Transaction ID: $transaction_id"); }
							
							$msg2 = "WebStore Order Updated: " . $orderid . " ON-HOLD, SKU: ". $sku;
							$to = "jedidiah@ccrind.com, sara@ccrind.com";
							$subject = "ONHOLD WebStore Order Marked Paid: " . $orderid . " through Credit Card";
							wp_mail( $to, $subject, $msg2);
							$order->add_order_note( $note );
							$order->save();
						}
					}
					else // if ebay order
					{
						if ($qty == 0){ 
							update_post_meta( $id, '_soldby', wc_clean( "ebay" ) ); 
							$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ebay";
							// set items to private
							$product->set_status('private'); 
							$product->save();
						}
						if ($method == "intuit_payments_credit_card") {
							$paid = get_post_meta( $orderid, '_ebay_paid', true );
							if ($paid != "paid") {
								update_post_meta( $orderid, '_ebay_paid', esc_attr( "paid" ) );
								$transaction_id = get_post_meta($orderid, '_transaction_id', true);
								if ($transaction_id == "") { $note = __("Order Status: Not captured, No transaction ID for transaction."); }
								else { $note = __("Order Status: Not captured, hit hit Update Order button to capture. Transaction ID: $transaction_id"); update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) ); }
								
								$msg2 = "eBay Order Updated: " . $salesrecord . " ON-HOLD, Order: ". $orderid;
								$to = "jedidiah@ccrind.com, sara@ccrind.com";
								$subject = "ONHOLD eBay Order Marked Paid: " . $salesrecord . " Order C" . $orderid . " through Credit Card";
								wp_mail( $to, $subject, $msg2);
								$order->add_order_note( $note );
								$order->save();
							}
						}
						if ($method == "paypal") {
							$paid = get_post_meta( $orderid, '_ebay_paid', true );
							if ($paid != "paid") {
								update_post_meta( $orderid, '_ebay_paid', esc_attr( "paid" ) );
								$msg2 = "eBay Order Updated: " . $salesrecord . " ON-HOLD, Order: ". $orderid;
								$to = "jedidiah@ccrind.com, sara@ccrind.com";
								$subject = "ONHOLD eBay Order Marked Paid: " . $salesrecord . " Order C" . $orderid . " through PayPal";
								wp_mail( $to, $subject, $msg2);
							}
							// remove CC fee
							$feeitems = (array) $order->get_items('fee');
							foreach ( $feeitems as $item_id => $feeitem ) {
								$fee_name = $feeitem->get_name();
								$fee_name = strtolower($fee_name);
								if (strpos( $fee_name, "usage fee") ) { $order->remove_item( $item_id ); }
							}
							$order->calculate_totals();
							$order->set_status('on-hold');
							$order->save();
						}
						
						$transaction_id = get_post_meta($orderid, '_transaction_id', true);
						if ($transaction_id == "SIS" ) { $saved_id = get_post_meta( $orderid, '_saved_ebay_transaction_id', true ); update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) ); }
						else if ( $transaction_id == "" ) { /* do nothing */ }
						else { update_post_meta( $orderid, '_saved_ebay_transaction_id', wc_clean( $transaction_id ) ); update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) ); }
						
						$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			if ( ($state == "") || ($saved_ship) ) 
			{
				$country = $saved_ship["country"];
					$shipst = $saved_ship["address_1"];
					$city = $saved_ship["city"];
					$state = $saved_ship["state"];
					$postcode = $saved_ship["postcode"];
						
					$address = array(
						'country' => $country,
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city,
            			'state'      => $state,
            			'postcode'   => $postcode
        			);
					$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
			}
					}
				}
				else // not paid for yet
				{
					if ($qty == 0){
						if ($salesrecord == "") { // ws order
							update_post_meta( $id, '_soldby', wc_clean( "wso" ) ); 
							$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => wso";
							// set items to private
						}
						else { // ebay order
							update_post_meta( $id, '_soldby', wc_clean( "ebayo" ) ); 
							$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ebayo";
						}
							$product->set_status('private');
							$product->save();
						
					}
				}
			}
		}
	}
	
	if ($status == "processing")
	{
		// guard saved transaction ID
		$transaction_id = get_post_meta($orderid, '_transaction_id', true);
		if ($transaction_id == "SIS" ) {
			$saved_id = get_post_meta( $orderid, '_saved_ebay_transaction_id', true );
			update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) );
		}
		else if ( $transaction_id == "" ) { /* do nothing */ }
		else {
			update_post_meta( $orderid, '_saved_ebay_transaction_id', wc_clean( $transaction_id ) );
			update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) );
		}
		
		$saved_status = get_post_meta( $orderid, '_saved_status', true );
		if ($saved_status != "processing") 
		{
			update_post_meta( $orderid, '_saved_status', wc_clean( "processing" ) );
			// email
			$msg2 = "Order updated to PROCESSING Status, Order: " . $orderid;
			$to = "jedidiah@ccrind.com, sara@ccrind.com";
			if ($salesrecord != "") { $subject = "PROCESSING eBay order updated: " . $salesrecord; }
			else { $subject = "PROCESSING ws order updated: " . $orderid; }
			wp_mail( $to, $subject, $msg2);
			
			if ($salesrecord == "") { 
			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				if( $product != "")
				{
					$qty = $product->get_stock_quantity();
					if ($qty < 2)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						update_post_meta( $id, '_soldby', wc_clean( "ws" ) ); 
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ws PROCESSING";
						$product->set_status('private'); 
						$product->save(); 
						
						// email
			$msg = "NEW ORDER on product: " . $sku;
			$to = "jedidiah@ccrind.com, sara@ccrind.com";
			$subject = "NEW ORDER #" . $orderid . ", on product: " . $sku; 
			wp_mail( $to, $subject, $msg);
						
						// create text log of change
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- 
" . $msg. "
		
");
			fclose($file);
					}
				}
			}
			} // end of ccrind order
			else {
			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				if( $product != "")
				{
					$qty = $product->get_stock_quantity();
					if ($qty == 0)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						update_post_meta( $id, '_soldby', wc_clean( "ebay" ) ); 
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ebay";
						$product->set_status('private'); 
						$product->save(); 
						
						// create text log of change
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- 
" . $msg. "
		
");
			fclose($file);
					}
				}
			}
			}
			
			$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			if ( ($state == "") || ($saved_ship) ) 
			{
				$country = $saved_ship["country"];
					$shipst = $saved_ship["address_1"];
					$city = $saved_ship["city"];
					$state = $saved_ship["state"];
					$postcode = $saved_ship["postcode"];
						
					$address = array(
						'country' => $country,
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city,
            			'state'      => $state,
            			'postcode'   => $postcode
        			);
					$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
			}
		}
	}
	
	if ($status == "completed")
	{
		// guard saved transaction ID
		$transaction_id = get_post_meta($orderid, '_transaction_id', true);
		if ($transaction_id == "SIS" ) {
			$saved_id = get_post_meta( $orderid, '_saved_ebay_transaction_id', true );
			update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) );
		}
		else if ( $transaction_id == "" ) { /* do nothing */ }
		else {
			update_post_meta( $orderid, '_saved_ebay_transaction_id', wc_clean( $transaction_id ) );
			update_post_meta( $orderid, '_transaction_id', wc_clean( $transaction_id ) );
		}
		
		$saved_status = get_post_meta( $orderid, '_saved_status', true );
		if ($saved_status != "completed") {
		
		$items_first = $order->get_items();
		foreach( $items_first as $item )
		{
			$product = wc_get_product($item->get_product_id());
			if (isset($product)) {
				$qty = $product->get_stock_quantity();
				$sku = $product->get_sku();
				$id = $item->get_product_id();
				if ($qty == 0) {
					$product->set_status('private');
					$product->save(); 
				}
			}
		}
			
		update_post_meta( $orderid, '_saved_status', wc_clean( "completed" ) );
		// email 
		$msg2 = "Order updated to COMPLETED Status, Order: " . $orderid;
		$to = "jedidiah@ccrind.com, sara@ccrind.com";
		if ($salesrecord != "") { $subject = "COMPLETED eBay order updated: " . $salesrecord . " Order: " . $orderid; }
		else { $subject = "COMPLETED ws order updated: " . $orderid; }
		wp_mail( $to, $subject, $msg2);
			
		$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			if ( ($state == "") || ($saved_ship) ) 
			{
				$country = $saved_ship["country"];
					$shipst = $saved_ship["address_1"];
					$city = $saved_ship["city"];
					$state = $saved_ship["state"];
					$postcode = $saved_ship["postcode"];
						
					$address = array(
						'country' => $country,
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city,
            			'state'      => $state,
            			'postcode'   => $postcode
        			);
					$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
			}
		}
	}
	
	if ($status == "cancelled")
	{
		$saved_status = get_post_meta( $orderid, '_saved_status', true );
		if ($saved_status != "cancelled") {
			
		update_post_meta( $orderid, '_saved_status', wc_clean( "cancelled" ) );
		// email
		$msg2 = "Order updated to CANCELLED Status, Order: " . $orderid;
		$to = "jedidiah@ccrind.com, sara@ccrind.com";
		if ($salesrecord != "") { $subject = "CANCELLED eBay order updated: " . $salesrecord . " Order: " . $orderid; }
		else { $subject = "CANCELLED ws order updated: " . $orderid; }
		wp_mail( $to, $subject, $msg2);
		//update item status
		$items_first = $order->get_items();
		foreach( $items_first as $item )
		{
			$product = wc_get_product($item->get_product_id());
			$id = $item->get_product_id();
			$sku = $product->get_sku();
			
			update_post_meta( $id, '_soldby', wc_clean( "" ) );
			$product->set_status('publish');
			$product->save();

			$msg = "Order Change Triggered Product Status Change:
MARKED CANCELLED:	 CHANGED: Old Status => Published
SOLD BY:			 CHANGED: old soldby => ";
		
			// create text log of change
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- 
" . $msg. "
		
");
			fclose($file);
		}
			
			$saved_ship = get_post_meta( $order->id, '_saved_shipping', true );
			if ( ($state == "") || ($saved_ship) ) 
			{
				$country = $saved_ship["country"];
					$shipst = $saved_ship["address_1"];
					$city = $saved_ship["city"];
					$state = $saved_ship["state"];
					$postcode = $saved_ship["postcode"];
						
					$address = array(
						'country' => $country,
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city,
            			'state'      => $state,
            			'postcode'   => $postcode
        			);
					$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
				$order->calculate_totals(); 
			}               
		}
	}
}
/*****************************************************************************************************************************/
?>