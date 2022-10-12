<?php
// code to document content changes to products (underlines additions, strikethrough removals)
add_action('pre_post_update', 'content_change_email', 10, 2);
function content_change_email($post_ID, $data) 
{
	remove_action('pre_post_update', 'content_change_email', 10, 2);
	
	function diff($old, $new)
	{
    	$matrix = array();
    	$maxlen = 0;
    	foreach($old as $oindex => $ovalue)
		{
        	$nkeys = array_keys($new, $ovalue);
       		foreach($nkeys as $nindex)
			{
            	$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
            	if($matrix[$oindex][$nindex] > $maxlen)
				{
                	$maxlen = $matrix[$oindex][$nindex];
                	$omax = $oindex + 1 - $maxlen;
                	$nmax = $nindex + 1 - $maxlen; 
				} /* close if($matrix */ 
			} /* close foreach($nkeys */ 
		} /* close foreach($old */
    	if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
    	return array_merge(
        	diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
        	array_slice($new, $nmax, $maxlen),
        	diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
	} /*close function diff */
	
	function htmlDiff($old, $new)
	{
    	$ret = '';
    	$diff = diff(preg_split("/[\s]+/", $old), preg_split("/[\s]+/", $new));
    	foreach($diff as $k)
		{
        	if(is_array($k))
            	$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
        	else $ret .= $k . ' '; 
		} /* close foreach($diff */
    	return $ret; 
	} /* close function htmlDiff */
	
	$type = get_post_type( $post_ID ); // get post type
	if ( $type == 'product' )
	{ // if post type is product
		$content = $_POST['content'];
		$title = $_POST['post_title'];
		$product = wc_get_product( $post_ID );
		$oldcontent = $product->post->post_content;
		$oldtitle = $product->get_title();
		$status = $product->get_status();
		
		if ( $status == "publish" || $status == "private") 
		{
			if ( $content != "" ) 
			{
				if ( $oldcontent != $content ) 
				{
					$msg = htmlDiff($oldcontent, $content);
					$memail = "
<pre><style type='text/css'>
ins { background-color:#ccffcc; }
del { background-color:#ffcccc; }
</style>
".$msg;
					//$file = file_put_contents("changes.html", $email); *** send email not write to file
					$headers = array('Content-Type: text/html; charset=UTF-8');
		
					global $current_user;
    				wp_get_current_user();
					$email = $current_user->user_email;
					$lastuser = $current_user->user_firstname;
		
					// translate lister emails
					if ($email == "adam@ccrind.com"){ $lastuser = "Adam Waller"; }
					else if ($email == "ccrind02@gmail.com"){ $lastuser = "Ryan Cleveland"; }
					else if ($email == "ccrind05@gmail.com"){ $lastuser = "Kelsey Kanehl"; }
					if ( $product->get_sku() != "" ) 
					{
						$memail = "<pre>USER: " . $lastuser . " made the following changes:
Additions will have underlining.
Subtractions will be strikethrough.
			
" . $memail . "</pre>";
						$subject = "CONTENT CHANGED - SKU: " . $product->get_sku();
						$to = "";
						if ( $email == "dan@ccrind.com" ) { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com"; }
						else if ( $email == "jedidiah@ccrind.com" ) { $to = "sharon@ccrind.com, adam@ccrind.com, dan@ccrind.com"; }
						else if ( $email == "adam@ccrind.com" ) { $to = "dan@ccrind.com, sharon@ccrind.com, jedidiah@ccrind.com"; }
						else if ( $email == "sharon@ccrind.com" ) { $to = "dan@ccrind.com, adam@ccrind.com, jedidiah@ccrind.com"; }
						else { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com, dan@ccrind.com"; }
						wp_mail( $to, $subject, $memail, $headers ); 
						$updatedesc = $subject . "
" . $memail . "

";
						$tableupdate = array();
						array_push( $tableupdate, array("PRODUCT DESCRIPTION CONTENT", $oldcontent, $memail) );
						$changeloc = "Product Page Edit (Description)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
						/* create text log of change
			$sku = $product->get_sku();
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
		
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $lastuser . "
- Inline edit - 
" . $subject . "
" . $msg . "
		
");
			fclose($file);*/
						
					} /* close if ( $product->get_sku() */
				} /* close if ( $oldcontent */
			} /* close if ( $content */
			// email for title changes on a product
			if ( $title != "" ) 
			{
				if ( $oldtitle != $title ) 
				{
					$msg = htmlDiff($oldtitle, $title);
					$memail = "
<pre><style type='text/css'>
ins { background-color:#ccffcc; }
del { background-color:#ffcccc; }
</style>
".$msg;
					//$file = file_put_contents("changes.html", $email); *** send email not write to file
					$headers = array('Content-Type: text/html; charset=UTF-8');
		
					global $current_user;
    				wp_get_current_user();
					$email = $current_user->user_email;
					$lastuser = $current_user->user_firstname;
		
					// translate lister emails
					if ($email == "adam@ccrind.com"){ $lastuser = "Adam Waller"; }
					else if ($email == "ccrind02@gmail.com"){ $lastuser = "Ryan Cleveland"; }
					else if ($email == "ccrind05@gmail.com"){ $lastuser = "Kelsey Kanehl"; }
					if ( $product->get_sku() != "" ) 
					{
						$memail = "<pre>USER: " . $lastuser . " made the following changes:
Additions will have underlining.
Subtractions will be strikethrough.
			
" . $memail . "</pre>";
						$subject = "TITLE / NAME CHANGED - SKU: " . $product->get_sku();
						$to = "";
						if ( $email == "dan@ccrind.com" ) { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com"; }
						else if ( $email == "jedidiah@ccrind.com" ) { $to = "dan@ccrind.com, sharon@ccrind.com, adam@ccrind.com, jedidiah@ccrind.com"; }
						else if ( $email == "adam@ccrind.com" ) { $to = "dan@ccrind.com, sharon@ccrind.com, jedidiah@ccrind.com"; }
						else if ( $email == "sharon@ccrind.com" ) { $to = "dan@ccrind.com, adam@ccrind.com, jedidiah@ccrind.com"; }
						else { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com, dan@ccrind.com"; }
						wp_mail( $to, $subject, $memail, $headers ); 
						$updatedesc = $subject . "
" . $memail . "

";
						$tableupdate = array();
						array_push( $tableupdate, array("TITLE / NAME CHANGED", $oldtitle, $title) );
						$changeloc = "Product Page Edit (Title)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
						/* create text log of change
			$sku = $product->get_sku();
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
		
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $lastuser . "
- Inline edit - 
" . $subject . "
" . $msg . "
		
");
			fclose($file);*/
						
					} /* close if ( $product->get_sku() */
				} /* close if ( $oldcontent */
			} /* close if ($title */
		} /* close if ( $status */
	} /* close if ( $type */
	
	remove_action('pre_post_update', 'content_change_email', 10, 2);
}

// send email when images change for a product
add_action( 'woocommerce_update_product', 'imagecheck_on_product_save', 10, 1 );
function imagecheck_on_product_save( $product_id ) {
	
	remove_action( 'woocommerce_update_product', 'imagecheck_on_product_save', 10, 1 );
	
	$product = wc_get_product( $product_id );
	$status = $product->get_status();
	if ( $status == "publish" ) 
	{
	
	// do something with this product
	$text_field2 = get_post_meta( $product_id, '_gallery_image_ids', true );
  	$text_field = $product->get_gallery_image_ids();
	
	$imageIDs2 = get_post_thumbnail_id( $product_id );
		
	$imageIDs2 = $imageIDs2 . ", ";
	foreach($text_field as $value) {
		$imageIDs2 = $imageIDs2 . $value . ", "; 
	}

  	if ( $text_field2 != $imageIDs2 )
	{
		update_post_meta( $product_id, '_gallery_image_ids', esc_attr( $imageIDs2 ) );
		
		global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email;
		$lastuser = $current_user->user_firstname;
		
		// translate lister emails
		if ($email == "adam@ccrind.com"){ $lastuser = "Adam Waller"; }
		else if ($email == "ccrind02@gmail.com"){ $lastuser = "Ryan Cleveland"; }
		else if ($email == "ccrind05@gmail.com"){ $lastuser = "Kelsey Kanehl"; }
		if ( $product->get_sku() != "" ) 
		{
			$memail = "<pre>USER: " . $lastuser . " made the following changes:</br>
Meta gallery images: " . $text_field2 . "</br>
</br>
Actual gallery images: " . $imageIDs2 . "
" . $memail . "</pre>";
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$subject = "PICTURES CHANGED - SKU: " . $product->get_sku();
			$to = "";
			if ( $email == "dan@ccrind.com" ) { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com"; }
			else if ( $email == "jedidiah@ccrind.com" ) { $to = "dan@ccrind.com, sharon@ccrind.com, adam@ccrind.com"; }
			else if ( $email == "adam@ccrind.com" ) { $to = "dan@ccrind.com, sharon@ccrind.com, jedidiah@ccrind.com"; }
			else if ( $email == "sharon@ccrind.com" ) { $to = "dan@ccrind.com, adam@ccrind.com, jedidiah@ccrind.com"; }
			else { $to = "jedidiah@ccrind.com, sharon@ccrind.com, adam@ccrind.com, dan@ccrind.com"; }
			if ( $text_field2 != "" ) {
				wp_mail( $to, $subject, $memail, $headers ); }
			$updatedesc = $subject . "
" . $memail . "

";
						$tableupdate = array();
						array_push( $tableupdate, array("PRODUCT PICTURES CHANGED", "Meta gallery images: " . $text_field2, "Actual gallery images: " . $imageIDs2) );
						$changeloc = "Product Page Edit (Pictures)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
			/* create text log of change
			$sku = $product->get_sku();
			$skul = strlen($sku);
			if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
			else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
			else { $sku_2 = $sku; $sku_3 = $sku; }
		
			if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
				mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
			}
		
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
			echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $lastuser . "
- Inline edit - 
" . $subject . "
" . $msg . "
		
");
			fclose($file);*/
		}
	}
	}
	remove_action( 'woocommerce_update_product', 'imagecheck_on_product_save', 10, 1 );
}
?>