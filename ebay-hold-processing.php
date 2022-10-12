<?php

add_action('woocommerce_order_status_changed','woo_order_status_change_custom');
function woo_order_status_change_custom($orderid) {
	
	$order = wc_get_order($orderid);
	$status   = $order->get_status();
	$method   = $order->get_payment_method();
	$state    = $order->get_shipping_state();
	$state2   = $order->get_billing_state();
	$shiptype = $order->get_shipping_method();
	$saved_status = get_post_meta( $orderid, '_saved_status', true );
	$phone    = $order->get_billing_phone();
	$tid = $order->get_transaction_id();
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
			update_post_meta( $orderid, '_ebayID', wc_clean( $salesrecord ) );
		}
	}// end establishment
	
	if ( $salesrecord != "" ) // if ebay order
	{ 
		if ($status == "pending" || $status == "processing" )
		{
			if ($saved_status == "processing" || $saved_status == "on-hold") 
			{ 	
				if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "paypal" || $method == "angelleye_ppcp" || $method == "Other") && $tid !="")
				{
					/* debug
					$to = "jedidiah@ccrind.com";
					$subject = "Order C$orderid order STATUS change tripped";
					$message = "Order:  C" . $orderid . " order STATUS change tripped: $salesrecord,\n
					status: $status, saved status: $saved_status";
					wp_mail( $to, $subject, $message );*/
				
					add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );
					
					update_post_meta( $orderid, '_saved_status', wc_clean( 'processing' ) );
					//$note = "completed status control save";
					//$order->update_status('completed', $note, 1);
					$order->set_status('processing'); update_post_meta( $orderid, '_status_sort', wc_clean( 2 ) );
					remove_action('woocommerce_order_status_changed', 'woo_order_status_change_custom' );
					$order->save();
					generate_order_log($order, $orderid);
				}
			}
		}
	}
	if ( $salesrecord != "" ) // if ebay order
	{ 
		if ($status == "pending" || $status == "on-hold" )
		{
			if ( $saved_status == "on-hold") { 
				
				/* debug
				$to = "jedidiah@ccrind.com";
				$subject = "Order C$orderid order STATUS change tripped";
				$message = "Order:  C" . $orderid . " order STATUS change tripped: $salesrecord,\n
				status: $status, saved status: $saved_status";
				wp_mail( $to, $subject, $message );*/
				
				// protect _saved_shipping and _saved_billing
			$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
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
			$saved_bill = get_post_meta( $orderid, '_saved_billing', true );
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
				
				add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );
				
				update_post_meta( $orderid, '_saved_status', wc_clean( 'on-hold' ) );
				//$note = "completed status control save";
				//$order->update_status('completed', $note, 1);
				$order->set_status('on-hold'); update_post_meta( $orderid, '_status_sort', wc_clean( 1 ) );
				remove_action('woocommerce_order_status_changed', 'woo_order_status_change_custom' );
				$order->save();
				generate_order_log($order, $orderid);
			}
			if ( $saved_status == "pending") { 
				
				/* debug
				$to = "jedidiah@ccrind.com";
				$subject = "Order C$orderid order STATUS change tripped";
				$message = "Order:  C" . $orderid . " order STATUS change tripped: $salesrecord,\n
				status: $status, saved status: $saved_status";
				wp_mail( $to, $subject, $message );*/
				
				// protect _saved_shipping and _saved_billing
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
				
				add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );
				
				update_post_meta( $orderid, '_saved_status', wc_clean( 'pending' ) );
				//$note = "completed status control save";
				//$order->update_status('completed', $note, 1);
				$order->set_status('pending'); update_post_meta( $orderid, '_status_sort', wc_clean( 3 ) );
				remove_action('woocommerce_order_status_changed', 'woo_order_status_change_custom' );
				$order->save();
				generate_order_log($order, $orderid);
			}
		}
	}
	
	// if paid by Credit Card or PayPal, email notification
	if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "paypal" || $method == "angelleye_ppcp" || $method == "stripe" || $method == "CreditCard" || $method == "CreditCard (PayPal)") && $tid !=="")
	{
		if ( $status == "processing" || $status == "on-hold" ) // if marked processing
		{
			if ( $salesrecord != "" ) // if ebay order
			{
				if ($saved_status == "pending")
				{ 
					if ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "stripe") { $pay = "Credit Card"; }
					else if ($method == "CreditCard" || $method == "CreditCard (PayPal)") { $pay = "eBay"; }
					else { $pay = "PayPal"; }
					$to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com";
					$subject = "Order C$orderid Marked Paid by $pay";
					$message = "Order: $orderid
Paid by $pay
Transaction ID: $tid


Debugging Info:
Status: $status, Saved_status: $saved_status";
					wp_mail( $to, $subject, $message );
				
					update_post_meta( $orderid, '_saved_status', wc_clean( 'processing' ) );
					//$note = "completed status control save";
					//$order->update_status('completed', $note, 1);
					$order->set_status('processing'); update_post_meta( $orderid, '_status_sort', wc_clean( 2 ) ); $order->save(); generate_order_log($order, $orderid);
					
					$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				//if( $product != "")
				//{
					$qty = $product->get_stock_quantity();
					if ($qty == 0 || $qty == 1)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						$tableupdate = array();
						$osb = get_post_meta( $id, '_soldby', true );
						if ($salesrecord == "") /*ws order*/
						{ update_post_meta( $id, '_soldby', wc_clean( "ws" ) ); $tag = "ws";}
						else /*ebay order*/
						{ update_post_meta( $id, '_soldby', wc_clean( "ebay" ) ); $tag = "ebay";}
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: $osb => $tag";
						$updatedesc = $msg."
						
";
						array_push( $tableupdate, array("MARKED PENDING", "(OLD STATUS)", "PRIVATE (SOLD)") ); 
						array_push( $tableupdate, array("SOLD BY", $osb, $tag) );
						$product->set_status('private');
						$product->save(); 
						$changeloc = "Order Change Edit (Auto)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
						
						/* create text log of change
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
			fclose($file);*/
					}
					else { $product->set_status('published'); $product->save(); }
				//}
			}
					
				}
			}
			else 
			{
				
				if ($method == "intuit_payments_credit_card" || $method == "quickbookspay" || $method == "stripe") { $pay = "Credit Card"; }
				else { $pay = "PayPal"; }
				$to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com";
				$subject = "Order C$orderid Marked Paid by $pay";
				$message = "Order: $orderid
Paid by $pay
Transaction ID: $tid


Debugging Info:
Status: $status, Saved_status: $saved_status";
				wp_mail( $to, $subject, $message );
				
				update_post_meta( $orderid, '_saved_status', wc_clean( 'processing' ) );
				//$note = "completed status control save";
				//$order->update_status('completed', $note, 1);
				$order->set_status('processing'); update_post_meta( $orderid, '_status_sort', wc_clean( 2 ) ); $order->save(); generate_order_log($order, $orderid);
				 
				$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				//if( $product != "")
				//{
					$qty = $product->get_stock_quantity();
					if ($qty == 0 || $qty == 1)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						$tableupdate = array();
						$osb = get_post_meta( $id, '_soldby', true );
						if ($salesrecord == "") /*ws order*/
						{ update_post_meta( $id, '_soldby', wc_clean( "ws" ) ); $tag = "ws";}
						else /*ebay order*/
						{ update_post_meta( $id, '_soldby', wc_clean( "ebay" ) ); $tag = "ebay";}
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: $osb => $tag";
						$updatedesc = $msg."
						
";
						array_push( $tableupdate, array("MARKED PENDING", "(OLD STATUS)", "PRIVATE (SOLD)") ); 
						array_push( $tableupdate, array("SOLD BY", $osb, $tag) );
						$product->set_status('private'); 
						$product->save(); 
						$changeloc = "Order Change Edit (Auto)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
						
						/* create text log of change
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
			fclose($file);*/
					}
					else { $product->set_status('published'); $product->save(); }
				//}
			}
			}
		}
	}
}
function unhook_those_pesky_emails( $email_class ) {
	remove_action( 'woocommerce_low_stock_notification', array( $email_class, 'low_stock' ) );
	remove_action( 'woocommerce_no_stock_notification', array( $email_class, 'no_stock' ) );
}
?>