<?php
/*
Plugin Name: CCR Admin Menu
Description: Adds a custom admin menu with sample styles and scripts.
Version: 1.0.0
Author: Jedidiah Fowler
Text Domain: ccr-admin-page
*/

add_action( 'admin_menu', 'ccr_admin_menu' );
function ccr_admin_menu() {
	add_menu_page(
		__( 'CCR IND', 'ccrind' ),
		__( 'CCR Admin', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/ccr-admin-menu.php',
		'ccr_admin_page_contents',
		'https://ccrind.com/wp-content/uploads/2022/09/ccrSiteIcon2small-e1662564215117.png',
		26
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'CCR Order Logs', 'ccrind' ),
		__( 'Order Logs / Directory', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/ccr-admin-menu-ccr.php',
		'ccr_admin_page_ccr_contents',
		28
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'LSN Post Log', 'ccrind' ),
		__( 'LSN', 'ccrind' ),
		'read_private_posts',
		'https://ccrind.com/log/LV/library/LSN/LSN.html',
		'',
		28
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'Parse Order Notes', 'ccrind' ),
		__( 'Parse Order Notes', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/ordernotes-admin-menu-ccr',
		'ordernotes_admin_page_ccr_contents',
		28
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'Generate Contact Log', 'ccrind' ),
		__( 'Generate Contact Log', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/contactlog-admin-menu-ccr.php',
		'contactlog_admin_page_ccr_contents',
		28
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'Ship Quote Generator', 'ccrind' ),
		__( 'Ship Quote Generator', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/shipquote-admin-menu-ccr.php',
		'shipquote_admin_page_ccr_contents',
		28
	);
	
	add_submenu_page(
		'ccr-admin-menu/ccr-admin-menu.php',
		__( 'Freightquote.com Order Lookup', 'ccrind' ),
		__( 'Freightquote.com Order Lookup', 'ccrind' ),
		'read_private_posts',
		'ccr-admin-menu/freightorder-admin-menu-ccr',
		'freightorder_admin_page_ccr_contents',
		28
	);
}

function ccr_admin_page_ccr_contents() {
	// variables
	$date = date('m-d-Y'); 
	$year = substr($date, 6, 4);
	$montharr = array("01-January", "02-February", "03-March", "04-April", "05-May", "06-June", "07-July", "08-August", "09-September", "10-October", "11-November", "12-December");
	
	echo "<h1>CCR Admin</h1>
		<div style='line-height: 1.2; color: #ffffff;'>
			<h2><a href='https://ccrind.com/log' rel='noopener noreferrer' target='_blank'>All Logs Directory</a></h2>
		</div>
		<br>
		<h2>$year Revenue Log Pages:</h2>
		<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$year.html' rel='noopener noreferrer' target='_blank'>$year Totals Log</a></p>";
	
	for ($m = 0; $m < 12; $m++) {
		$filename = $montharr[$m];
		if ( file_exists("../library/order-logs/Y$year/$filename.html") ) {
			echo "<div style='line-height: 1.2; color: #ffffff;'>
					<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$filename.html' rel='noopener noreferrer' target='_blank'>$filename, $year Log</a></p>
		</div>";
		}
	}
	echo "<br><h2>$year Email Log Pages:</h2>";
	for ($m = 0; $m < 12; $m++) {
		$filename = $montharr[$m];
		if ( file_exists("../library/order-logs/Y$year/$filename.html") ) {
			echo "<div style='line-height: 1.2; color: #ffffff;'>
					<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/emails/$filename-emails.html' rel='noopener noreferrer' target='_blank'>$filename, $year Log</a></p>
		</div>";
		}
	}
	
	if ($year > 2021) 
	{
		$year = $year - 1;
		
		echo "
<br><h2>$year Revenue Log Pages:</h2>
		<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$year.html' rel='noopener noreferrer' target='_blank'>$year Totals Log</a></p>";
		for ($m = 0; $m < 12; $m++) {
		$filename = $montharr[$m];
		if ( file_exists("../library/order-logs/Y$year/$filename.html") ) {
			echo "<div style='line-height: 1.2; color: #ffffff;'>
					<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/$filename.html' rel='noopener noreferrer' target='_blank'>$filename, $year Log</a></p>
		</div>";
		}
	}
	echo "<br><h2>$year Email Log Pages:</h2>";
	for ($m = 0; $m < 12; $m++) {
		$filename = $montharr[$m];
		if ( file_exists("../library/order-logs/Y$year/$filename.html") ) {
			echo "<div style='line-height: 1.2; color: #ffffff;'>
					<p><a href='https://ccrind.com/log/LV/library/order-logs/Y$year/emails/$filename-emails.html' rel='noopener noreferrer' target='_blank'>$filename, $year Log</a></p>
		</div>";
		}
	}
	}
}

function ccr_admin_page_lsn_contents() {

	
	echo "<h1>LSN Posts Log</h1>
		<div style='line-height: 1.2; color: #ffffff;'>
			<h2><a href='https://ccrind.com/log/LV/library/LSN/LSN.html' rel='noopener noreferrer' target='_blank'>LSN</a></h2>
		</div>";
		
	
}
// contact log page
function ordernotes_admin_page_ccr_contents() {
	echo "<h2>Order Notes Page</h2>";
	$orderid = $_GET['orderid'];
	echo "<p>ORDER ID: $orderid</p>";
	$order = wc_get_order( $orderid );
	$cusnote = $order->get_customer_note();
		if ($cusnote != "") { echo "<div class='customer_order_notes_area' style='line-height: 1.2; color: #e7dcaa; background-color: #5c5c5c; border-radius: 5px; font-size: 14px;'>$cusnote<br><br></div>"; }
		
		// insert first and second order private note
		$note_content = "";
		$date = "";
		$user = "";
		$order_notes = get_private_order_notes( $orderid );
		$count = count($order_notes);
		$i = 0;

		echo "<div class='order_notes_area' style='line-height: 1.2; height: 300px; overflow: auto;'>";
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
			echo "<p>Note: $note_content</p>";
			$count = $count - 1;
		}
		echo "</div>";
}
// contact log page
function contactlog_admin_page_ccr_contents() {
	
	$id = $_POST['productID'];
    $updaterowv = $_POST['updaterowvalue'];
    $updatespecial = $_POST['updatespecial'];
	$user = $_POST['user'];
	$inputfromlog = $_POST['dateremove']; // if a date is captured on form submission, it is an update row
	
	if ($id != "") { $product = wc_get_product($id); $sku = $product->get_sku(); }
	$skul = strlen($sku);
	if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
	else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
	else { $sku_2 = $sku; $sku_3 = $sku; }
	
	$error = $phoneError = $emailError = 0;

    // initial call from the log show input data and allow choice
	if( ($id != "") && !$updatespecial && !$updaterowv)
	{
		// get form submission variables
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		if ($phone != "") {
		$strip = array("(", ")", " ", "-");
		$phone = str_replace($strip, "", $phone);
		if ( strlen($phone) != 10 ) { $phoneError = 1; $error = 1; } // set error codes
		else { $phone = "(" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6, 4); } // format phone output
		}
		$email = $_POST['email'];
		if ($email != "") {
		if ( (strpos($email, "@")) && (strpos($email, ".")) ) { /* email is valid, do nothing */ }
		else { $emailError = 1; $error = 1; } // set error codes
		}
		$note = stripslashes($_POST['clnote']);
		$offer = $_POST['offer'];
        $snote = stripslashes($_POST['clnotespecialinput']);
		$append = $_POST['appendSI'];
		
		if ($inputfromlog != "") { // the data was input from the log, capture it
			$datetime = $inputfromlog;
			$name = $_POST['name2'];
			$phone = $_POST['phone2'];
			$strip = array("(", ")", " ", "-");
			$phone = str_replace($strip, "", $phone);
			if ($phone != "") {
			if ( strlen($phone) != 10 ) { $phoneError = 1; $error = 1; } // set error codes
			else { $phone = "(" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6, 4); } // format phone output
			}
			$email = $_POST['email2'];
			if ($email != "") {
			if ( (strpos($email, "@")) && (strpos($email, ".")) ) { /* email is valid, do nothing */ }
			else { $emailError = 1; $error = 1; } // set error codes
			}
			$note = stripslashes($_POST['clnote2']);
			$offer = $_POST['offer2'];
			$user = $_POST['user2'];
			$updaterow = 1;
			$removerow = $_POST['removerow'];
		}
			
		if ($datetime == "") { $datetime = date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ); }
		
		if ($snote != "") {
			if ($snote == "clear") { $snote = ""; $datetime = ""; $user = ""; }
            // read through file and replace the line:
            // <div class="clnotespecialdiv"><textarea id="clnotespecial" class="clnotespecial" name="clnotespecial" rows="6" title="Enter special info here." placeholder="Enter SPECIAL INFO Here"></textarea></div>
            $form = "<br><br><br><br>
<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fcontactlog-admin-menu-ccr.php' method='post'>
<input type='hidden' name='updatespecial' value='1'>
<input type='hidden' name='updatespecialdate' value='$datetime'>
<input type='hidden' name='updatespecialsnote' value='$snote'>
<input type='hidden' name='productID' value='$id'>
<input type='hidden' name='user' value='$user'>
<input type='hidden' name='appendSI' value='$append'>
<table id='contactTABLE' class='contactTABLE'>
	<tr>
		<th class='date'>DATE / TIME</th>
		<th class='note'>SPECIAL NOTE:</th>
		<th class='note'>USER:</th>
	</tr>
	<tr>
		<td class='date'>$datetime</th>
		<td class='note'>$snote</th>
		<td class='note'>$user</th>
	</tr>
	<div class='insert_here'></div>
</table>
	<p><input type='submit' value='SAVE: Update Log' /></p>
</form>
<br><br>
<form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html' method='post'>
<p><input type='submit' value='DO NOT SAVE: Return to Contact Log' /></p>
</form>";
            echo $form;
        }
		else if ( !$error ){ // build the common parts of the form for all submissions, if there is no error
            $formstart = "<br><br><br><br>
<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fcontactlog-admin-menu-ccr.php' method='post'>
	<input type='hidden' name='updaterowvalue' value='1'>
	<input type='hidden' name='updaterowdate' value='$datetime'>
	<input type='hidden' name='updaterowname' value='$name'>
	<input type='hidden' name='updaterowphone' value='$phone'>
	<input type='hidden' name='updaterowemail' value='$email'>
	<input type='hidden' name='updaterowoffer' value='$offer'>
	<input type='hidden' name='updaterownote' value='$note'>
	<input type='hidden' name='user' value='$user'>
	<input type='hidden' name='productID' value='$id'>
<table id='contactTABLE' class='contactTABLE'>
	<tr>
		<th class='date'>DATE / TIME</th>
		<th class='name'>NAME</th>
		<th class='phone'>PHONE</th>
		<th class='email'>EMAIL</th>
		<th class='offer'>OFFER</th>
		<th class='note'>NOTE:</th>
		<th class='note'>User:</th>
		<th class='user'>Remove Row?</th>
	</tr>
	<tr>
		<td class='date' >$datetime</td>
		<td class='name' ><input style='width: 100%; overflow: auto;' type='text' name='name' value='$name' /></td>
		<td class='phone' ><input style='width: 100%; overflow: auto;' type='text' name='phone' value='$phone' /></td>
		<td class='email' ><textarea id='email' style='width: 100%; height: 100%;' class='email' name='email' rows='3'>$email</textarea></td>
		<td class='offer' ><input style='width: 100%; overflow: auto;' type='text' name='offer' value='$offer' /></td>
		<td class='note' ><textarea id='clnote' style='width: 100%; height: 100%;' class='clnote' name='clnote' rows='3'>$note</textarea></td>
		<td class='user' >$user</td>";
			
			if (!$removerow && !$updaterow) {
				$formend = "
		<td class='remove'></td>
	</tr>
</table>
	<p><input type='submit' value='SAVE: Update Log' /></p>
</form>
<br><br>
<form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='DO NOT SAVE: Return to Contact Log' /></p>
</form>";
			}
			else if ($updaterow && !$removerow) {
				$formend = "
		<td class='remove'>UPDATE</td>
		
	</tr>
</table>
	<input type='hidden' name='updaterow' value='1'>
	<p><input type='submit' value='CONFIRM UPDATE: Update Log' /></p>
</form>
<br><br>
<form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='DO NOT UPDATE: Return to Contact Log' /></p>
</form>";
			}
			else if ($removerow) {
				$formend = "
		<td class='remove'>YES</td>
	</tr>
</table>
	<input type='hidden' name='removerow' value='1'>
	<p><input type='submit' value='CONFIRM REMOVAL: Update Log' /></p>
</form>
<br><br>
<form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='DO NOT REMOVE: Return to Contact Log' /></p>
</form>";
			}
			$form = $formstart . $formend;
			echo $form;
        }
		else { // error occured, process
			if ($phoneError) {
				$formstart = "<h2>Invalid Phone Number Entered</h2>
	<p>Please make sure to use 10 digits, no more, no less.</p>";
			}
			if ($emailError) {
				$formstart = $formstart . "<h2>Invalid Email Entered</h2>
	<p>Please make sure to include an @ and a . (dot)</p>";
			}
			$formend = "<br><br>
<form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='ERROR: Return to Contact Log' /></p>
</form>";
			$form = $formstart . $formend;
			echo $form;
		}
	} // end of if($id != "" && !$updatespecial && !$updaterow && !$removerow)
    // if choice was to SAVE
    if ($updatespecial) {
		$date = $_POST['updatespecialdate'];
		$snote = $_POST['updatespecialsnote'];
		$append = $_POST['appendSI'];
		if ($append) {
			$specialnotearea = '<div class="specialnote" style="font-size: 20px; font-weight: bold; margin-bottom: 5px;">'.$snote.' - '.$date.' - '.$user.'</div>' . PHP_EOL . '<div class="specialappend" ></div>'. PHP_EOL;
		
		// open the file
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","c+");
			$read = true; // flag to verify if string is found
			$find = '<div class="specialappend"';  // string to find
			$found = 0;
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// read all lines as is until the <div class="clnotesspecial"
				if ( strpos( $line, $find) !== false ) { 
					if ( !$found ) { $filecontents = $filecontents . $specialnotearea; $found = 1; }
					else { /* read nothing */ }
				}
				else { $filecontents = $filecontents . $line; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, $filecontents);
			fclose($file); 
		}
		else {
			if ($snote == "") { $specialnotearea = PHP_EOL . '<div class="specialnote" ></div>' . PHP_EOL; }
			else { $specialnotearea = '<div class="specialnote" style="font-size: 20px; font-weight: bold; margin-bottom: 5px;">'.$snote.' - '.$date.' - '.$user.'</div>' . PHP_EOL . '<div class="specialappend" ></div>'. PHP_EOL; }
		
		// open the file
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","c+");
			$read = true; // flag to verify if string is found
			$find = '<div class="specialnote"';  // string to find
			$found = 0;
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// read all lines as is until the <div class="clnotesspecial"
				if ( strpos( $line, $find) !== false ) { 
					if ( !$found ) { $filecontents = $filecontents . $specialnotearea; $found = 1; }
					else { /* read nothing */ }
				}
				else { $filecontents = $filecontents . $line; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, $filecontents);
			fclose($file); 
		}
		
		$form = "<br><br><br><br><form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='Return to Contact Log' /></p>
</form>";
		echo $form;
    }
	if ($updaterowv) {
		$date = $_POST['updaterowdate'];
		$name = $_POST['updaterowname'];
		$phone = $_POST['updaterowphone'];
		$email = $_POST['updaterowemail'];
		$offer = $_POST['updaterowoffer'];
		$note = $_POST['updaterownote'];
		$user = $_POST['user'];
		$update = $_POST['updaterow'];
		$remove = $_POST['removerow'];
		
		if ((!$remove) && (!$update)) {
			$insert = '<div class="insert_here" ></div>' . PHP_EOL;
        	$tablerow = "<tr> <form class='contactlog' action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fcontactlog-admin-menu-ccr.php' method='post'> <input type='hidden' name='productID' value='$id'> <input type='hidden' name='dateremove' value='$date'> <input type='hidden' name='user2' value='$user'> <td class='date'>$date</td> <td class='name'><input type='text' name='name2' value='$name' /></td> <td class='phone'><input type='text' name='phone2' value='$phone' /></td> <td class='email'><textarea id='email2' style='width: 100%; height: 100%;' class='email2' name='email2' rows='3'>$email</textarea></td> <td class='offer'><input type='text' name='offer2' value='$offer' /></td> <td class='note'><textarea id='clnote2' style='width: 100%; height: 100%;' class='clnote2' name='clnote2' rows='3'>$note</textarea></td> <td class='user2'>$user</td> <td class='removerow'> <input type='checkbox' id='removerow' name='removerow' class='removerowbox' value='1'></td> <td class='removerowbutton'> <input type='submit' value='Update Row'></td> </form> </tr>" . PHP_EOL;
			$insert = $insert . $tablerow;
		
			// open the file
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","c+");
			$read = true; // flag to verify if string is found
			$find = '<div class="insert_here"';  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// read all lines as is until the <div class="clnotesspecial"
				if ( strpos( $line, $find) !== false ) { $filecontents = $filecontents . $insert; }
				else { $filecontents = $filecontents . $line; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, $filecontents);
			fclose($file); 
    	} // end of if (!$remove) {
		else if ($update) {
        	$tablerow = "<tr> <form class='contactlog' action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fcontactlog-admin-menu-ccr.php' method='post'> <input type='hidden' name='productID' value='$id'> <input type='hidden' name='dateremove' value='$date'> <input type='hidden' name='user2' value='$user'> <td class='date'>$date</td> <td class='name'><input type='text' name='name2' value='$name' /></td> <td class='phone'><input type='text' name='phone2' value='$phone' /></td> <td class='email'><textarea id='email2' style='width: 100%; height: 100%;' class='email2' name='email2' rows='3'>$email</textarea></td> <td class='offer'><input type='text' name='offer2' value='$offer' /></td> <td class='note'><textarea id='clnote2' style='width: 100%; height: 100%;' class='clnote2' name='clnote2' rows='3'>$note</textarea></td> <td class='user2'>$user</td> <td class='removerow'> <input type='checkbox' id='removerow' name='removerow' class='removerowbox' value='1'></td> <td class='removerowbutton'> <input type='submit' value='Update Row'></td> </form> </tr>" . PHP_EOL;
			// open the file
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","c+");
			$read = true; // flag to verify if string is found
			$find = $date;  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// read all lines as is until the $date is found
				if ( strpos( $line, $find) !== false ) { $filecontents = $filecontents . $tablerow; }
				else { $filecontents = $filecontents . $line; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, $filecontents);
			fclose($file); 
		}
		else if ($remove) {
			// open the file
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","c+");
			$read = true; // flag to verify if string is found
			$find = $date;  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// read all lines as is until the $date is found
				if ( strpos( $line, $find) !== false ) { /* read nothing, removing the row with the date in question */ }
				else { $filecontents = $filecontents . $line; }
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, $filecontents);
			fclose($file); 
			
			}
		$form = "<br><br><br><br><form action='https://ccrind.com/log/LV/library/product-contact-logs/$sku_2/$sku_3/$sku.html'  method='post'>
<p><input type='submit' value='Return to Contact Log' /></p>
</form>";
		echo $form;
	} // end of if ($updaterow) {
}
// ship quote generator
function shipquote_admin_page_ccr_contents() {
	echo "<h2>Ship Quote Generator using <a href='https://www.freightquote.com/book/#/single-page-quote' rel='noopener noreferrer' target='_blank'>freightquote.com</a></h2>";
	// baseline variables
    $clientID = "0oaqytpn1zrGXMNyR357";
    $clientSecret = "xSllN5OleLXhGEp6fY4vPVUP3MlroLHV8V7Xfc9s";
	$clientIDsand = "0oaqgzu6m1Z2lbKXv357";
    $clientSecretsand = "6v0z8Ophav7ySIUDngbYx5sNBYyKbTLhYxP2AgEJ";
    $customerCode = "C8664585";
	// check token age
	date_default_timezone_set("America/Chicago");
	$check = date("Y-m-d h:i:sa");
	//echo "<p>DEBUG Now: $check</p>";
	$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
	$fqToken = get_user_meta($userID, 'fq_token', true);
	$date = get_user_meta($userID, 'fq_token_age', true);
	$fqTokensand = get_user_meta($userID, 'fq_token_sand', true);
	$datesand = get_user_meta($userID, 'fq_token_age_sand', true);
	$date24 = strtotime($date . ' + 1 days');
	$check2 = strtotime($check);
	//echo "<p>DEBUG Saved Date + 24 hours: $date24</p>";
	// if the token age is older than 24 hours (86400sec = 60sec * 60mins * 24hours) or date is empty or token is empty, fetch a new token
	if ($check2 > $date24 || $date == "" || $fqToken == "" ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.navisphere.com/v1/oauth/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    	'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"client_id\": \"$clientID\", \"client_secret\": \"$clientSecret\", \"audience\": \"https://inavisphere.chrobinson.com\", \"grant_type\": \"client_credentials\" }");

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		$data = json_decode($response);
		
		$fqToken = $data->access_token;
		$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
		$date = date("Y-m-d h:i:sa");
		update_user_meta( $userID, "fq_token_age", sanitize_text_field( $date ) );
		update_user_meta( $userID, "fq_token", sanitize_text_field( $fqToken ) );
	}
	if ($check2 > $date24 || $datesand == "" || $fqTokensand == "" ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://sandbox-api.navisphere.com/v1/oauth/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    	'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"client_id\": \"$clientIDsand\", \"client_secret\": \"$clientSecretsand\", \"audience\": \"https://inavisphere.chrobinson.com\", \"grant_type\": \"client_credentials\" }");

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		$data = json_decode($response);
		
		$fqTokensand = $data->access_token;
		$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
		$date = date("Y-m-d h:i:sa");
		update_user_meta( $userID, "fq_token_age_sand", sanitize_text_field( $date ) );
		update_user_meta( $userID, "fq_token_sand", sanitize_text_field( $fqTokensand ) );
	}
	//echo "<p>DEBUG Saved Date: $date</p>";
	
	// work with token
	//$subToken = substr($fqToken, 0, 120);
	//echo "<p style='word-wrap: break-word;'>DEBUG FQ Access Token: $subToken</p>";
	
	if ( $_POST['freightaction'] != "Book Quote" && $_POST['bookaction'] != "Submit") {
	// start html form
	$generateQform = "<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 33%;
  max-width: 500px;
  padding: 10px;
  border-right: 5px solid black;
}

/* Clear floats after the columns */
.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>
	<form action='' method='post'>
		<div class='row'>
		<div class='column'>	
		<h3>Submit will automatically use data from SKU if values are not input to the other fields.</h3>
		<p>Product SKU: <input type='text' name='sku' /></p>
		<p>Ship to Zip <input type='text' name='zip' /></p>
		<p>Liftgate Required? <input type='checkbox' id='lift' name='lift' class='liftbox' value='1'></p>
		<p>Residential Address? <input type='checkbox' id='addtype' name='addtype' class='addtypebox' value='1'></p>
		<p>Limited Access? <input type='checkbox' id='access' name='access' class='accessbox' value='1'></p>
		<p>Inside Delivery? <input type='checkbox' id='insidedelivery' name='insidedelivery' class='insidedeliverybox' value='1'></p>
		<p>Terminal Delivery? <input type='checkbox' id='terminal' name='terminal' class='terminalbox' value='1'></p>
		<p>If product limited by height, ok to lay on its side? <input type='checkbox' id='flip' name='flip' class='flipbox' value='1'></p>
 		<p><input type='submit' /></p>
		</div>
		<div class='column'>
		<h3>Optional Fields</h3>
		<p>Product Name: <input type='text' name='name' /></p>
 		<div style='display: inline-block;'>Length: <input style='width: 80px' type='text' name='length' />Width: <input style='width: 80px' type='text' name='width' />Height: <input style='width: 80px' type='text' name='height' /></div>
		<p>Weight: <input type='text' name='weight' /></p>
		<p>Pallet Fee: <input type='text' name='pfee' /></p>
		<p>Declared Value (Price): <input type='text' name='value' /></p>
		</div>
		</div>	
	</form>";
		//echo $generateQform;
	} // end of if ( $_POST['freightaction'] != "Book Quote")

		// get order number to get skus, etc
		$orderid = $productid = "";  // set both to baseline null value
		$orderid = $_POST['orderidallq'];
		$productid = $_POST['productidallq'];
		if ($orderid == "" && $productid == "") { echo $generateQform; }
		$sku = $zip = "";
		$arrSKU = array();
		// submitted from order
		if ($orderid != "") {
			
			$order = wc_get_order( $orderid ); // get order object
			$items = $order->get_items(); // loop through items to get skus
			foreach( $items as $item ) {
				$product = wc_get_product($item->get_product_id());
				if ($product != "") { $sku = $product->get_sku(); array_push($arrSKU, $sku); }
			}
			// get ship to zip
			$zip = $order->get_shipping_postcode();
			if ($zip == "") {
				$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
				$zip = $saved_ship["postcode"];
			}
			// truncate excess zip code data
			$zip = substr($zip, 0, 5);
		}
		// submitted from product
		if ($productid != "") {
			$product = wc_get_product($productid);
			$sku = $product->get_sku(); array_push($arrSKU, $sku);
			$nameID = $_POST['nameID'];
		}
		
		// override auto sku if a sku is entered in the input field
		$sku2 = $_POST['sku']; if ($sku2 != "") { 
			if ( strpos($sku2, ",") > 0 ) { $arrSKU = explode(",", $sku2); $id = wc_get_product_id_by_sku( $arrSKU[0] ); $productid = $id; }
			else { array_push($arrSKU, $sku2); $id = wc_get_product_id_by_sku( $sku2 ); $productid = $id; }
		}
		//$sku2 = $_POST['sku']; if ($sku2 != "") { array_push($arrSKU, $sku2); $productid = $id; }
		$zip2 = $_POST['zip']; if ($zip2 != "") { $zip = $zip2; }
		$lg = $_POST['lift'];
		$resid = $_POST['addtype'];
		$limited = $_POST['access'];
		if ($resid) { $limited = ""; } // disable limited access if residential (already included in quote price)
		if ($limited) { $resid = ""; }
		$indel = $_POST['insidedelivery'];
		$term = $_POST['terminal'];
		// check day of week of ship date
		$day = date('w', strtotime($check));
		//echo "DEBUG: Day: $day<br>";
		if ($day == 5) { $shipDate = date(DATE_ISO8601, strtotime($check. ' + 3 days')); $test = "Friday"; }
		else { $shipDate = date(DATE_ISO8601, strtotime($check. ' + 1 days')); $test = "Not Friday"; }
		$shipDate2 = date(DATE_ISO8601, strtotime($check. ' + 1 seconds'));
		//echo "DEBUG: Day: $shipDate, test: $test<br>";
		//echo "DEBUG: Day: $check<br>";
		// get the rest of the product data by its sku
		$countSKU = count($arrSKU);
		$i = 0;
		$itemsfull = $itemsfull2 = "";
		foreach ($arrSKU as $sku) {
		$products = new WP_Query(
			array(
				'post_type'  => array( 'product', 'product_variation' ),
				'meta_query' => array(
					array(
						'key'     => '_sku',
						'value'   => $sku,
					)
				),
			)
		); 
		while( $products->have_posts() ) : $products->the_post();
			$product = wc_get_product( $products->post->ID );
		endwhile;
		if ($product != "") { $id = $product->get_id(); }
		if ($id == "") { echo "<h2>Invalid SKU, NO product found.</h2><br><br>"; }
		else {
			echo "<h2>Valid SKU entered.</h2><br><br>"; 
			//echo "DEBUG: Product: $product, ID: $id<br><br>";
			$image = wp_get_attachment_url( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
			$image = "<a href=\"$image\"  rel=\"noopener noreferrer\" target=\"_blank\">
				<img width=\"180\" src=\"$image\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" loading=\"lazy\"></a>";
			$name = $product->get_name();
			$l = $product->get_length();
			$w = $product->get_width();
			$h = $product->get_height();
			$lbs = $product->get_weight();
			$value = $product->get_regular_price();
			$orlen = $orwid = $orhgt = $orwgt = 0;
			$pf = get_post_meta($id, '_cratefee', true);
			$pallet48x40 = $_POST['pallet40'];
			$pallet48x48 = $_POST['pallet48'];
			$name2 = $_POST['name']; if ($name2 != "") { $name = $name2; }
			$l2 = $_POST['length']; if ($l2 != "") { $l = $l2; $orlen = 1; }
			$w2 = $_POST['width']; if ($w2 != "") { $w = $w2; $orwid = 1; }
			$h2 = $_POST['height']; if ($h2 != "") { $h = $h2; $orhgt = 1; }
			$lbs2 = $_POST['weight']; if ($lbs2 != "") { $lbs = $lbs2; $orwgt = 1; }
			$value2 = $_POST['value']; if ($value2 != "") { $value = $value2; }
			$pf2 = $_POST['pfee']; if ($pf2 != "") { $pf = $pf2; }
			// lay the item on its side?
			$flip = $_POST['flip'];
			if ($flip) { 
				if ($l < $h) { $save = $h; $h = $l; $l = $save; }
				if ($w < $h) { $save = $w; $w = $h; $h = $save;  }
			}
			// is the length less than width, switch them if so
			if ($l < $w) { $save = $l; $l = $w; $w = $save; }
			// padd l w and h
			
			if ($pallet48x40) {
				$l2 = 48; $w2 = 40;
				if ($orhgt) { /* do nothing */ }
				else { $h2 = $h + 5; }
				// add weight for pallet size
				if ($orwgt) { $lbs3 = $lbs; }
				else {
				$footage = $l2 * $w2; $lbpad = (int)(($footage / 36)+1);
				$lbs3 = $lbs + $lbpad; }
			}
			else if ($pallet48x48) {
				$l2 = 48; $w2 = 48;
				if ($orhgt) { /* do nothing */ }
				else { $h2 = $h + 5; }
				// add weight for pallet size
				if ($orwgt) { $lbs3 = $lbs; }
				else {
				$footage = $l2 * $w2; $lbpad = (int)(($footage / 36)+1);
				$lbs3 = $lbs + $lbpad; }
			}
			else { 
				$l2 = $l + 2; $w2 = $w + 2; $h2 = $h + 5; 
				// add weight for pallet size
				$footage = $l2 * $w2; $lbpad = (int)(($footage / 36)+1);
				$lbs3 = $lbs + $lbpad;
			}
			if ( $orlen ) { $l2 = $l; } 
			if ( $orwid ) { $w2 = $w; } 
			if ( $orhgt ) { $h2 = $h; } 
			if ( $orwgt ) { $lbs3 = $lbs; } 
		} // end of if ($id == "") else
	
	$l2 = (float)$l2; $w2 = (float)$w2; $h2 = (float)$h2; $value = (float)$value; $pf = (float)$pf; $fc = 0; $lbs = (float)$lbs;
	if ($l == 0) { $l = ""; $fc = ""; $l2 = ""; } if ($w == 0) { $w = ""; $w2 = ""; } 
	if ($h == 0) { $h = ""; $h2 = ""; } if ($value == 0) { $value = ""; } $lbs = (int)$lbs;
	// calculate Freight Class
	$fcval = (float)(($l2 * $w2 * $h2) / 1728);
	$fcval = (float)($lbs3 / $fcval);
	if ($fcval >= 50) { $fc = 50; }
	else if ( 35 <= $fcval && $fcval < 50) { $fc = 55; }
	else if ( 30 <= $fcval && $fcval < 35) { $fc = 60; }
	else if ( 22.5 <= $fcval && $fcval < 30) { $fc = 65; }
	else if ( 15 <= $fcval && $fcval < 22.5) { $fc = 70; }
	else if ( 13.5 <= $fcval && $fcval < 15) { $fc = 77.5; }
	else if ( 12 <= $fcval && $fcval < 13.5) { $fc = 85; }
	else if ( 10.5 <= $fcval && $fcval < 12) { $fc = 92.5; }
	else if ( 9 <= $fcval && $fcval < 10.5) { $fc = 100; }
	else if ( 8 <= $fcval && $fcval < 9) { $fc = 110; }
	else if ( 7 <= $fcval && $fcval < 8) { $fc = 125; }
	else if ( 6 <= $fcval && $fcval < 7) { $fc = 150; }
	else if ( 5 <= $fcval && $fcval < 6) { $fc = 175; }
	else if ( 4 <= $fcval && $fcval < 5) { $fc = 200; }
	else if ( 3 <= $fcval && $fcval < 4) { $fc = 250; }
	else if ( 2 <= $fcval && $fcval < 3) { $fc = 300; }
	else if ( 1 <= $fcval && $fcval < 2) { $fc = 400; }
	else if ( 0 <= $fcval && $fcval < 1) { $fc = 500; }
	
	if ($orderid != "") {
	if ($resid) { $addType = "Residential"; update_post_meta( $orderid, 'address_type', sanitize_text_field( $addType ) ); }
	else { $addType = "Commercial"; update_post_meta( $orderid, 'address_type', sanitize_text_field( $addType ) ); }
	if ($lg) { $forkDock = "No"; update_post_meta( $orderid, 'unload_type', sanitize_text_field( $forkDock ) ); } 
	else { $forkDock = "Yes"; update_post_meta( $orderid, 'unload_type', sanitize_text_field( $forkDock ) ); } 
	if ($sku) { $shipType = "CCR Ship"; update_post_meta( $orderid, 'ship_type', sanitize_text_field( $shipType ) );  }
	if ($term) { $terminalD = "Yes"; update_post_meta( $orderid, 'terminal_delivery', sanitize_text_field( $terminalD ) );  }
	if ($zip) { update_post_meta( $orderid, 'terminal_zip', sanitize_text_field( $zip ) ); }
	if ($l2) { update_post_meta( $orderid, 'shipq_length', sanitize_text_field( $l2 ) ); }
	if ($w2) { update_post_meta( $orderid, 'shipq_width', sanitize_text_field( $w2 ) ); }
	if ($h2) { update_post_meta( $orderid, 'shipq_height', sanitize_text_field( $h2 ) ); }
	if ($lbs3) { update_post_meta( $orderid, 'shipq_weight', sanitize_text_field( $lbs3 ) ); }
	if ($pf != "") { update_post_meta( $orderid, 'shipq_pallet_fee', sanitize_text_field( $pf ) ); } 
	} // end of if ($orderid != "")
	if ($productid != "") {	
	if ($nameID != "") { update_post_meta( $productid, 'QnameID', sanitize_text_field( $nameID ) ); }
	if ($resid) { $addType = "Residential"; update_post_meta( $productid, 'address_type', sanitize_text_field( $addType ) ); }
	else { $addType = "Commercial"; update_post_meta( $productid, 'address_type', sanitize_text_field( $addType ) ); }
	if ($lg) { $forkDock = "No"; update_post_meta( $productid, 'unload_type', sanitize_text_field( $forkDock ) ); } 
	else { $forkDock = "Yes"; update_post_meta( $productid, 'unload_type', sanitize_text_field( $forkDock ) ); } 
	if ($sku) { $shipType = "CCR Ship"; update_post_meta( $productid, 'ship_type', sanitize_text_field( $shipType ) );  }
	if ($term) { $terminalD = "Yes"; update_post_meta( $productid, 'terminal_delivery', sanitize_text_field( $terminalD ) );  }
	if ($zip) { update_post_meta( $productid, 'terminal_zip', sanitize_text_field( $zip ) ); }
	if ($l2) { update_post_meta( $productid, 'shipq_length', sanitize_text_field( $l2 ) ); }
	if ($w2) { update_post_meta( $productid, 'shipq_width', sanitize_text_field( $w2 ) ); }
	if ($h2) { update_post_meta( $productid, 'shipq_height', sanitize_text_field( $h2 ) ); }
	if ($lbs3) { update_post_meta( $productid, 'shipq_weight', sanitize_text_field( $lbs3 ) ); }
	if ($pf != "") { update_post_meta( $productid, 'shipq_pallet_fee', sanitize_text_field( $pf ) ); }
	} // end of if ($productid != "")
	
	//if ($orderid != "") { generate_ship_quote_log($order, $orderid); }
	
	// generate table output based on form submission values, if sku data is submitted do the quote generator table
	
		$dataTable = "<table class='fqInputTable'>
	<tr>
		<th>Product Image</th>
    	<th>Product Name</th>
    	<th>SKU</th>
		<th>Length</th>
    	<th>Width</th>
		<th>Height</th>
		<th>Weight</th>
		<th>Freight Class</th>
    </tr>
	<tr>
		<td>$image</td>
    	<td>$name</td>
    	<td>$sku</td>
		<td>$l (item) <br>$l2 (padded)</td>
    	<td>$w (item) <br>$w2 (padded)</td>
		<td>$h (item) <br>$h2 (padded)</td>
		<td>$lbs (item weight) <br>$lbpad (pallet weight) <br>$lbs3 (total)</td>
		<td>$fc</td>
	</tr>
	<tr>
</table>
<table class='fqInputTable'>
	<tr>
		<th>Declared Value</th>
		<th>Ship to Zip</th>
		<th>Liftgate</th>
    	<th>Residential</th>
		<th>Limited Access</th>
		<th>Inside Delivery</th>
    	<th>Terminal Delivery</th>
		<th>Pallet Fee</th>
		<th>Ship Date</th>
	</tr>
	<tr>
		<td>$value</td>
		<td>$zip</td>
    	<td>$lg</td>
		<td>$resid</td>
    	<td>$limited</td>
		<td>$indel</td>
		<td>$term</td>
		<td>$pf</td>
    	<td>$shipDate</td>
	</tr>
</table>";
		echo "<h2>Verify the Information below (1 means yes in the values on the second white row).</h2>"; 
		echo $dataTable; 
	
	// translate 1 or 0 values to true and false strings
	if ($lg) { $lg2 = "\"liftGate\": \"true\","; } else { $lg2 = "\"liftGate\": \"false\","; }
	if ($resid) { $resid2 = "\"residentialNonCommercial\": \"true\","; } else { $resid2 = "\"residentialNonCommercial\": \"false\","; }
	if ($limited) { $limited2 = "\"limitedAccess\": \"true\","; } else { $limited2 = "\"limitedAccess\": \"false\","; }
	if ($indel) { $indel2 = "\"insideDelivery\": \"true\","; } else { $indel2 = "\"insideDelivery\": \"false\","; }
	if ($term) { 
		$term2 = "\"pickupAtCarrierTerminal\": \"true\""; 
		$lg2 = $resid2 = $limited2 = $indel2 = "";
	} else { $term2 = "\"pickupAtCarrierTerminal\": \"false\""; }
	$pcsku = "\"productCode\": \"$sku\",";
	$sku = "\"sku\": \"$sku\"";
	$zipItem = "\"postalCode\": \"$zip\",";
	$shipDateItem = "\"shipDate\": \"$shipDate\",";
	//$customerCode = "\"customerCode\": \"$customerCode\",";
	$description = "\"description\": \"$name\",";
	$weight = "\"actualWeight\": $lbs3,";
	$weight2 = "\"weight\": $lbs3,";
	$length = "\"length\": $l2,";
 	$width = "\"width\": $w2,";
 	$height = "\"height\": $h2,";
	$length2 = "\"equipmentLength\": $l2,";
 	$width2 = "\"equipmentWidth\": $w2,";
 	$height2 = "\"equipmentHeight\": $h2,";
	$dV = "\"declaredValue\": $value,";
	$pN = "\"productName\": \"$name\",";
	$FC = "\"freightClass\": $fc,";
	$FC2 = "\"freightClass\": \"$fc\",";
		
	$items = '{ 
 		'.$description.'
		'.$FC.'
 		'.$weight.'
 		"weightUnit": "Pounds",
 		'.$length.'
 		'.$width.'
		'.$height.'
 		"linearUnit": "Inches",
 		"pallets": 1,
 		"pieces": 1,
 		"packagingCode": "PLT",
 		"isStackable": "false",
 		'.$pcsku.'
 		'.$pN.'
 		'.$sku.'
 	}';
	$items2 = '{ 
		"packagingType": "PLT",
		"quantity": 1,
 		'.$description.'
		'.$pcsku.'
		'.$FC2.'
 		'.$weight2.'
 		"weightUnitOfMeasure": "Pounds",
 		'.$length2.'
 		'.$width2.'
		'.$height2.'
 		"equipmentUnitOfMeasure": "Inches",
		"insuranceValue": '.$value.',
 		"pallets": 1,
 		"isStackable": "false"
 	}';
	
	//echo "DEBUG i: $i, countSKU: $countSKU <br><br>";
	if ($i == 0) { $itemsfull = $items; $itemsfull2 = $items2; }
	else { $itemsfull = $itemsfull . "," . $items; $itemsfull2 = $itemsfull2 . "," . $items2; }
	$i = $i + 1;
	$pfall = $pfall + $pf;
			
	} // end of foreach ($arrSKU as $sku) 
		
	$quote = '{
 	"items": [
	'.$itemsfull.'
	],
 	"origin": { 
 		"locationName": "Origin Location",
 		"address1": "411 E Carroll St",
 		"city": "Tullahoma",
 		"stateProvinceCode": "TN",
 		"countryCode": "US",
 		"postalCode": "37388",
 		"specialRequirement": { 
 			"liftGate": "false",
 			"residentialNonCommercial": "false",
 			"limitedAccess": "false",
 			"dropOffAtCarrierTerminal": "false"
		}
 	},
 	"destination": {
 		"locationName": "Destination Location",
 		"countryCode": "US",
 		'.$zipItem.'
 		"specialRequirement": {
 			'.$lg2.'
			'.$indel2.'
 			'.$resid2.'
 			'.$limited2.'
 			'.$term2.'
 		}
 	},
 	'.$shipDateItem.'
 	"customerCode": "'.$customerCode.'",
 	"transportModes": [{ 
 		"mode": "LTL"
 	}],
	"optionalAccessorials": ["APT"] 
	}';
	
	//echo "DEBUG Itemsfull: $itemsfull<br><br>";
	$strip = array("\n", "\t", "\r");
	$quote = str_replace($strip, "", $quote); 
	$itemsfull2 = str_replace($strip, "", $itemsfull2); 
	if ( current_user_can('administrator') ) {
		//echo "DEBUG QUOTE: $quote<br><br>";
	}
	$jquote = json_encode( $quote );
	if ( current_user_can('administrator') ) {
		//echo "DEBUG JSON: $jquote<br><br>";
	}
    $auth = 'Authorization: Bearer '. $fqToken;
	
	//echo "<p>DEBUG: Before 2nd cURL</p>";
	$sel = $_POST['selectQuote'];
	//echo "<p>DEBUG: Sel is $sel</p>";
	if ($l != "" && $w != "" && $h != "" && $lbs != "") {
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_URL, 'https://api.navisphere.com/v1/quotes');
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    		$auth,
    		'Content-Type: application/json'
		]);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jquote);

		$response = curl_exec($ch2);
		curl_close($ch2);
		$data = json_decode($response);
		
		// display errors if able
		//if ($data[0]->message != "") { echo "Error Message: ".$data[0]->message."<br><br>"; }
		//if ($data[0]->statusCode == 401) { echo "Error: ".$data[0]->error."<br>Message: ".$data[0]->message."<br><br>"; }
		/*if ($data->statusCode == 403) { echo "Error: ".$data->error."<br>Message: ".$data->message."<br><br>"; }
		if ($data->statusCode == 404) { 
			echo "Error: ".$data->error."<br>Message: Probable problem - data submitted for item is wrong or too large."; 
		}*/
		
		$prices = array();
		$i = 0;
		$count = sizeof($data->quoteSummaries);
		echo "<p>Number of Quotes: $count</p><br>";
		if ( $count < 1 ) { echo "DEBUG: Data Dump:<br>" . $response . "<br><br>"; }
		if ( current_user_can('administrator') ) {
			//echo "DEBUG: Data Dump:<br>" . $response . "<br><br>";
		}
		
		while ($i <= $count) {
			if ($data->quoteSummaries[$i]->quoteId != "") {
				array_push($prices, $data->quoteSummaries[$i]->totalCharge);
			}
			$i = $i + 1;
		}
		sort($prices);
		/*foreach ($prices as $v) {
			echo "Quote: " . $v;
			echo "<br>";
		}*/
		$i = 0;
		$j = 0;
		//echo "<br><br>";
		//echo "<br><br>Quote IDs: <br>";
		$fqTableRows = "";
		while ($i < $count) {
			$v = $prices[$i];
			while ($j < $count) {
				if ($data->quoteSummaries[$j]->totalCharge == $v) {
					if ($resid || $lg || $limited) {
						//$v = ($v * 1.07); // add baseline of 7% for residential address, use of a liftgate, limited access
					}
					$v = number_format($v, 2, '.', ''); // format for 2 decimal
					$gencharge = ($v * 1.25) + $pfall; // add 27% surcharge (25 base, 2 for delivery appt) to cover any overages for ccrind, add pallet fee
					$gencharge = number_format($gencharge, 2, '.', ''); // format for 2 decimal
     				//echo "<pre>ID: " . $data->quoteSummaries[$j]->quoteId . "	Carrier: " . $data->quoteSummaries[$j]->carrier->carrierName . "	Quote: " . $data->quoteSummaries[$j]->totalCharge . "	Generated Charge: $gencharge<br></pre>";
					// adjust for freightquote.com surcharge
					//if ($lg && $resid) { $v = number_format($v * 1.13, 2, '.', ''); } 
					//else if ($resid) { $v = number_format($v * 1.1633, 2, '.', ''); } 
					//else { $v = number_format($v * 1.228, 2, '.', ''); }
					if ($data->quoteSummaries[$j]->carrier->carrierName != "Central Transport") 
					{
						//$days2 = $data->quoteSummaries[$j]->transit->minimumTransitDays + 1;
						$fqTableRows = $fqTableRows . "
	<tr>
		<td>" . $data->quoteSummaries[$j]->quoteId . "
		<input type='hidden' id='quoteID$j' name='quoteID$j' class='quoteID$j' value='" . $data->quoteSummaries[$j]->quoteId . "'></td>
    	<td>" . $data->quoteSummaries[$j]->carrier->carrierName . "<input type='hidden' id='carrier$j' name='carrier$j' class='carrier$j' value='" . $data->quoteSummaries[$j]->carrier->carrierName . "'></td>
		<td>Estimated transit is " . $data->quoteSummaries[$j]->transit->minimumTransitDays . "-" . ($data->quoteSummaries[$j]->transit->minimumTransitDays + 1) . " days after pickup<input type='hidden' id='transit$j' name='transit$j' class='transit$j' value='" . $data->quoteSummaries[$j]->transit->minimumTransitDays . "'></td>
    	<td>$v<input type='hidden' id='quote$j' name='quote$j' class='quote$j' value='" . $v . "'></td>
		<td>$gencharge<input type='hidden' id='charge$j' name='charge$j' class='charge$j' value='" . $gencharge . "'></td>
		<td><input type='checkbox' id='selectQuote' name='selectQuote' class='selectQuote' value='" . $j . "'></td>
		<input type='hidden' id='scac$j' name='scac$j' class='scac$j' value='" . $data->quoteSummaries[$j]->carrier->scac . "'>
		<input type='hidden' id='carrierCode$j' name='carrierCode$j' class='carrierCode$j' value='" . $data->quoteSummaries[$j]->carrier->carrierCode . "'>
	</tr>";	
					} 
				}
				$j = $j + 1;
			}
			$j = 0;
			$i = $i + 1;
		} // end of while ($i < $count) 
		// if submitted through order
		if ($orderid != "") {
		$fqTable = "<table class='fqInputTable'>
	<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fshipquote-admin-menu-ccr.php' method='post'>
	<input type='hidden' name='orderidallFQ' value='$orderid'>
	<input type='hidden' name='items' value='$itemsfull2'>
	<input type='hidden' name='lg' value='$lg2'>
	<input type='hidden' name='resid' value='$resid2'>
	<input type='hidden' name='limited' value='$limited2'>
	<input type='hidden' name='indel' value='$indel2'>
	<input type='hidden' name='term' value='$term2'>
	<tr>
		<th>Quote ID</th>
    	<th>Carrier</th>
		<th>Minimum Transit</th>
    	<th>Quote</th>
		<th>Generated Charge</th>
		<th>Select Checkbox</th>
	</tr>" . $fqTableRows . "
</table>
<br><br>
<div style='width: 25%; float: left;'><input type='submit' name='freightaction' value='Submit Quote Data'><br>Click here to obtain shipping charge using quote.</div><div style='width: 25%; float: left;'><input type='submit' name='freightaction' value='Book Quote'><br>Click here to book the quote for shipping.</div>
</form>";
		echo "<h2>Select the desired quote below by price, transit time, etc. Only 1 can be selected.</h2>";
		echo $fqTable;
		} // end of if ($orderid != "") 
		if ($productid != "") {
		$fqTable = "<table class='fqInputTable'>
	<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fshipquote-admin-menu-ccr.php' method='post'>
	<input type='hidden' name='productidallFQ' value='$productid'>
	<input type='hidden' name='items' value='$itemsfull2'>
	<input type='hidden' name='lg' value='$lg2'>
	<input type='hidden' name='resid' value='$resid2'>
	<input type='hidden' name='limited' value='$limited2'>
	<input type='hidden' name='indel' value='$indel2'>
	<input type='hidden' name='term' value='$term2'>
	<tr>
		<th>Quote ID</th>
    	<th>Carrier</th>
		<th>Minimum Transit</th>
    	<th>Quote</th>
		<th>Generated Charge</th>
		<th>Select Checkbox</th>
	</tr>" . $fqTableRows . "
</table>
<p>Click here to generate quote ship charge.<br><input type='submit' value='Submit Quote Data' /></p>
";
		echo "<h2>Select the desired quote below by price, transit time, etc. Only 1 can be selected.</h2>";
		echo $fqTable;
		} // end of if ($productid != "") 
	} //end of if ($l != "" && $w != "" && $h != "" && $lbs != "") 
	else if ($sel == "" && $_POST['bookaction'] != "Submit" ) { echo "<br>ERROR: Missing Length, Width, Height, or Weight, check inputs."; }
	
	// get data from second form submission
	//$sel = $_POST['selectQuote'];
    // display simple table with the selected quote if the quote is checked and submitted by user
    if ($sel != "") {
		$orderid = $productid = ""; // base null value
		$orderid = $_POST['orderidallFQ'];
		$productid = $_POST['productidallFQ'];
		if ($orderid != "") {
		$order = wc_get_order( $orderid ); }
		if ($productid != "") {
		$product = wc_get_product($productid); }
		//echo "Selected: $sel<br><br>";
		$qID = "quoteID$sel";
		$quoteID = $_POST[$qID];
		$car = "carrier$sel";
        $carrier = $_POST[$car];
		$scac = "scac$sel";
		$scac = $_POST[$scac];
		$carrierCode = "carrierCode$sel";
		$carrierCode = $_POST[$carrierCode];
		//echo "Carrier: $carrier<br><br>";
		$t = "transit$sel";
		$transit = $_POST[$t]; $transit2 = $transit + 1;
		$quote = $_POST["quote$sel"];
		$charge = $_POST["charge$sel"];
		// determine type of submit
		if ( $_POST['freightaction'] == "Submit Quote Data") {
        	$selectedQRow = $selectedQRow . "
	<tr>
		<td>$quoteID<input type='hidden' id='quoteID' name='quoteID' class='quoteID' value='" . $quoteID . "'></td>
    	<td>$carrier<input type='hidden' id='carrier' name='carrier' class='carrier' value='" . $carrier . "'></td>
		<input type='hidden' id='scac' name='scac' class='scac' value='" . $scac . "'>
		<input type='hidden' id='carrierCode' name='carrierCode' class='carrierCode' value='" . $carrierCode . "'>
		<td>Estimated transit is $transit-$transit2 days after pickup <input type='hidden' id='transit' name='transit' class='transit' value='" . $transit . "'></td>
    	<td>$quote<input type='hidden' id='quote' name='quote' class='quote' value='" . $quote . "'></td>
		<td>$charge<input type='hidden' id='charge' name='charge' class='charge' value='" . $charge . "'></td>
	</tr>";
		
        
		if ($orderid != "") {
        $selectedQTable = "<table class='fqInputTable'>
		<form action='https://ccrind.com/wp-admin/edit.php?s=$orderid&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' method='post'>
	<tr>
		<th>Quote ID</th>
    	<th>Carrier</th>
		<th>Minimum Transit</th>
    	<th>Quote</th>
		<th>Generated Charge</th>
	</tr>" . $selectedQRow . "
</table>
<p><input type='submit' value='Return to Order' /></p>
</form>";
			echo $selectedQTable;
			echo "<div style='display: none'>";
			update_post_meta( $orderid, 'shipq_ID', sanitize_text_field( $quoteID ) );
			update_post_meta( $orderid, 'shipq_CCRcost', sanitize_text_field( $quote ) ); 
			update_post_meta( $orderid, 'shipq_price', sanitize_text_field( $charge ) ); 
		 	generate_ship_quote_log($order, $orderid); 
			input_ship_charge( $orderid, $charge );
		} // end of if ($orderid != "") 
		} // end of if ( $_POST['freightaction'] == "Submit Quote Data")
		else if ( $_POST['freightaction'] == "Book Quote") {
			//echo "<p>DEBUG: Book Quote Selected, loading booking form</p>";
			// get embedded flag variables
			$itemsfull2 = $_POST['items'];
			$lg = $_POST['lg']; if ( strpos($lg, "true") > 0 ) { $lgv = 1; } else { $lgv = 0; }
			$resid = $_POST['resid']; if ( strpos($resid, "true") > 0 ) { $residv = 1; } else { $residv = 0; }
			$limited = $_POST['limited']; if ( strpos($limited, "true") > 0 ) { $limitedv = 1; } else { $limitedv = 0; }
			$indel = $_POST['indel']; if ( strpos($indel, "true") > 0 ) { $indelv = 1; } else { $indelv = 0; }
			$term = $_POST['term']; if ( strpos($term, "true") > 0 ) { $termv = 1; } else { $termv = 0; }
			// display all inputs for booking freight
			$today = date('Y-m-d'); // today's date
			$today = date('Y-m-d', strtotime($today . ' +1 day'));
			global $current_user; wp_get_current_user(); $fname = $current_user->first_name; $lname = $current_user->last_name; $useremail = $current_user->user_email; // user info for inputs
			// delivery location variables
			$del_email = $order->get_billing_email();
			$del_phone = $order->get_billing_phone();
			if ($del_phone == "") { $del_phone = get_post_meta( $orderid, '_saved_phone', true ); }
			$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
			$ship_add = $order->get_shipping_address_1();
			if (!empty($saved_ship) && empty($ship_add)) {
				$ship_add = $saved_ship["address_1"]; $shipcity = $saved_ship["city"]; $shipstate = $saved_ship["state"]; $shipz = $saved_ship["postcode"]; $shipcountry = "US"; $ship_add2 = $saved_ship["address_2"]; $shipcompany = $saved_ship["company"]; $del_fname = $saved_ship["first_name"]; $del_lname = $saved_ship["last_name"];
			}
			else {
				$shipcity = $order->get_shipping_city(); $shipstate = $order->get_shipping_state(); $shipz = $order->get_shipping_postcode(); $shipcountry = $order->get_shipping_country(); $ship_add2 = $order->get_shipping_address_2(); $shipcompany = $order->get_shipping_company(); $del_fname = $order->get_shipping_first_name(); $del_lname = $order->get_shipping_last_name();
			}
			if ($shipcompany != "") { $del_contact = $shipcompany . " (". $del_fname . " " . $del_lname . ")"; }
			else { $del_contact = $del_fname . " " . $del_lname; }
			
			$bookform = "<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 33%;
  max-width: 40%;
  padding: 10px;
  border-right: 5px solid black;
}

/* Clear floats after the columns */
.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>

	<form action='' method='post'>
		<h3>Booking Freight Data:</h3>
		<div class='row'>
		<div class='column'>	
		<h2>Pickup Address Details</h2>
		<p>Company: <input type='text' id='ship_company' name='ship_company' class='ship_company' value='CCR IND LLC'></p>
		<p>Address: <input type='text' id='ship_add1' name='ship_add1' class='ship_add1' value='411 E Carroll St'></p>
		<p>Address 2: <input type='text' id='ship_add2' name='ship_add2' class='ship_add2' value=''></p>
		<p>City: <input type='text' id='ship_city' name='ship_city' class='ship_city' value='Tullahoma'></p>
		<p>State (2 Letter Code): <input type='text' id='ship_state' name='ship_state' class='ship_state' value='TN'></p>
		<p>Zip Code: <input type='text' id='ship_zip' name='ship_zip' class='ship_zip' value='37388'></p>
		<h2>Carrier Pickup Info</h2>
		<p><label for='load_date'>Requested Load Date:</label><input type='date' id='load_date' name='load_date' class='load_date' value='$today'></p>
		<div><label for='load_window_start'>Requested Pickup Window:</label>
		<select id='load_window_start' name='load_window_start' class='load_window_start'>
			<option value='12:00'>12:00</option>
			<option value='12:30'>12:30</option>
			<option value='1:00'>1:00</option>
			<option value='1:30'>1:30</option>
			<option value='2:00'>2:00</option>
		</select>
		<label for='load_window_end'>to:</label>
		<select id='load_window_end' name='load_window_end' class='load_window_end'>
			<option value='1:30'>1:30</option>
			<option value='2:00'>2:00</option>
			<option value='2:30'>2:30</option>
			<option value='3:00' selected>3:00</option>
			<option value='3:30'>3:30</option>
		</select>
		</div>
		<p>Pickup Reference # (optional): <input type='text' id='ship_ref_num' name='ship_ref_num' class='ship_ref_num' value='C$orderid'></p>
		<p>Special Instructions (optional): <br><textarea id='ship_special' name='ship_special' class='ship_special' rows='3' style='width: 350px;'></textarea>
		<h2>Contact at Pickup Location</h2>
		<p>First Name: <input type='text' id='ship_first_name' name='ship_first_name' class='ship_first_name' value='$fname'></p>
		<p>Last Name: <input type='text' id='ship_last_name' name='ship_last_name' class='ship_last_name' value='$lname'></p>
		<p>Email: <input type='text' id='ship_email' name='ship_email' class='ship_email' style='width: 350px;' value='$useremail'></p>
		<p>Phone: <input type='text' id='ship_phone' name='ship_phone' class='ship_phone' value='9315634704'></p>
		</div>
		<div class='column'>
		<h2>Delivery Address Details</h2>
		<p>Company or Indvidual: <input type='text' id='del_company' name='del_company' class='del_company' value='$del_contact'></p>
        <p>Address: <input type='text' id='del_add1' name='del_add1' class='del_add1' value='$ship_add'></p>
        <p>Address 2: <input type='text' id='del_add2' name='del_add2' class='del_add2' value='$ship_add2'></p>
        <p>City: <input type='text' id='del_city' name='del_city' class='del_city' value='$shipcity'></p>
        <p>State (2 Letter Code): <input type='text' id='del_state' name='del_state' class='del_state' value='$shipstate'></p>
        <p>Zip Code: <input type='text' id='del_zip' name='del_zip' class='del_zip' value='$shipz'></p>
        <p>Delivery Reference # (optional): <input type='text' id='del_ref_num' name='del_ref_num' class='del_ref_num' value='C$orderid'></p>
        <p>Special Instructions (optional): <br><textarea id='del_special' name='del_special' class='del_special' rows='3' style='width: 350px;'></textarea>
        <h2>Contact at Delivery Location</h2>
        <p>First Name: <input type='text' id='del_first_name' name='del_first_name' class='del_first_name' value='$del_fname'></p>
        <p>Last Name: <input type='text' id='del_last_name' name='del_last_name' class='del_last_name' value='$del_lname'></p>
        <p>Email: <input type='text' id='del_email' name='del_email' class='del_email' style='width: 350px;' value='$del_email'></p>
        <p>Phone: <input type='text' id='del_phone' name='del_phone' class='del_phone' value='$del_phone'></p>
		</div>
		</div>";
			
		$selectedQRow = $selectedQRow . "
	<tr>
		<input type='hidden' name='orderidallbookQ' value='$orderid'>
		<td>$quoteID<input type='hidden' id='quoteID' name='quoteID' class='quoteID' value='" . $quoteID . "'></td>
    	<td>$carrier<input type='hidden' id='carrier' name='carrier' class='carrier' value='" . $carrier . "'></td>
		<input type='hidden' name='items' value='$itemsfull2'>
		<input type='hidden' name='lg' value='$lg'>
		<input type='hidden' name='resid' value='$resid'>
		<input type='hidden' name='limited' value='$limited'>
		<input type='hidden' name='indel' value='$indel'>
		<input type='hidden' name='term' value='$term'>
		<input type='hidden' id='scac' name='scac' class='scac' value='" . $scac . "'>
		<input type='hidden' id='carrierCode' name='carrierCode' class='carrierCode' value='" . $carrierCode . "'>
		<td>Estimated transit is $transit-$transit2 days after pickup <input type='hidden' id='transit' name='transit' class='transit' value='" . $transit . "'></td>
    	<td>$quote<input type='hidden' id='quote' name='quote' class='quote' value='" . $quote . "'></td>
	</tr>";
		
		if ($orderid != "") {
        $selectedQTable = "<table class='fqInputTable'>
	<tr>
		<th>Quote ID</th>
    	<th>Carrier</th>
		<th>Minimum Transit</th>
    	<th>Quote</th>
	</tr>" . $selectedQRow . "
	<tr>
		<th>Liftgate</th>
    	<th>Residential</th>
		<th>Limited Access</th>
		<th>Inside Delivery</th>
    	<th>Terminal Delivery</th>
	</tr>
	<tr>
		<td>$lgv</td>
    	<td>$residv</td>
		<td>$limitedv</td>
		<td>$indelv</td>
    	<td>$termv</td>
	</tr>
</table>";
		} // end of if ($orderid != "")
		// build entire form for display
		$endbookform = "
		<p><input type='submit' name='bookaction' value='Submit'></p>
	</form>";
		$bookform = $bookform . $selectedQTable . $endbookform;
			
			echo $bookform;
			update_post_meta( $orderid, 'shipq_ID', sanitize_text_field( $quoteID ) );
			update_post_meta( $orderid, 'shipq_Carrier', sanitize_text_field( $carrier ) );
			update_post_meta( $orderid, 'shipq_CCRcost', sanitize_text_field( $quote ) ); 
			update_post_meta( $orderid, 'shipq_price', sanitize_text_field( $charge ) ); 
			echo "<div style='display: none'>"; 
		} // end of else if ( $_POST['freightaction'] == "Book Quote")
		
		if ($productid != "") {
		$product = wc_get_product($productid); $sku = $product->get_sku();
		$selectedQRow = $selectedQRow . "
	<tr>
		<td>$quoteID<input type='hidden' id='quoteID' name='quoteID' class='quoteID' value='" . $quoteID . "'></td>
    	<td>$carrier<input type='hidden' id='carrier' name='carrier' class='carrier' value='" . $carrier . "'></td>
		<input type='hidden' id='scac' name='scac' class='scac' value='" . $scac . "'>
		<input type='hidden' id='carrierCode' name='carrierCode' class='carrierCode' value='" . $carrierCode . "'>
		<td>Estimated transit is $transit-$transit2 days after pickup <input type='hidden' id='transit' name='transit' class='transit' value='" . $transit . "'></td>
    	<td>$quote<input type='hidden' id='quote' name='quote' class='quote' value='" . $quote . "'></td>
		<td>$charge<input type='hidden' id='charge' name='charge' class='charge' value='" . $charge . "'></td>
	</tr>";
			
        $selectedQTable = "<table class='fqInputTable'>
	<form action='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_cat&product_type&stock_status&fb_sync_enabled&paged=1&postidfirst=144122&action2=-1' method='post'>
	<tr>
		<th>Quote ID</th>
    	<th>Carrier</th>
		<th>Minimum Transit</th>
    	<th>Quote</th>
		<th>Generated Charge</th>
	</tr>" . $selectedQRow . "
</table>
<p><input type='submit' value='Return to Product' /></p>
</form>";
		echo $selectedQTable;
		echo "<div style='display: none'>";
			update_post_meta( $productid, 'shipq_ID', sanitize_text_field( $quoteID ) );
			update_post_meta( $productid, 'shipq_Carrier', sanitize_text_field( $carrier ) );
			update_post_meta( $productid, 'shipq_CCRcost', sanitize_text_field( $quote ) ); 
			update_post_meta( $productid, 'shipq_price', sanitize_text_field( $charge ) ); 
			generate_ship_quote_log_Product($productid, $product); 
		} // end of if ($productid != "") 
	} // end of if ($sel != "") {
		
	// IF Booking Freight Data submitted to ccrind.com page
	if ( $_POST['bookaction'] == "Submit") {
		
		$itemsfull2 = $_POST['items'];
		$lg = $_POST['lg']; if ( strpos($lg, "true") > 0 ) { $lgv = 1; $lg = "\"liftGate\": true, "; } else { $lgv = 0; $lg = "\"liftGate\": false,"; }
		$resid = $_POST['resid']; if ( strpos($resid, "true") > 0 ) { $residv = 1; $resid = "\"residentialNonCommercial\": true,"; } else { $residv = 0; $resid = "\"residentialNonCommercial\": false,"; }
		$limited = $_POST['limited']; if ( strpos($limited, "true") > 0 ) { $limitedv = 1; $limited = "\"limitedAccess\": true,"; } else { $limitedv = 0; $limited = "\"limitedAccess\": false,"; }
		$indel = $_POST['indel']; if ( strpos($indel, "true") > 0 ) { $indelv = 1; $indel = "\"insideDelivery\": true,"; } else { $indelv = 0; $indel = "\"insideDelivery\": false,"; }
		$term = $_POST['term']; if ( strpos($term, "true") > 0 ) { $termv = 1; $term = "\"pickupAtCarrierTerminal\": true,"; } else { $termv = 0; $term = "\"pickupAtCarrierTerminal\": false,"; }
		// process load window variables
		$loaddate = $_POST['load_date'];
		$loadWS = $_POST['load_window_start']; $loadWS = $loaddate . " " . $loadWS . ":00 PM";
		$loadWE = $_POST['load_window_end']; $loadWE = $loaddate . " " . $loadWE . ":00 PM"; 
		$loadWS_ISO8601 = date(DATE_ISO8601, strtotime($loadWS));
		$loadWE_ISO8601 = date(DATE_ISO8601, strtotime($loadWE));
		
		$shipSpecial = $_POST['ship_special'];
		if ($shipSpecial != "") { $shipSpecial = '\"specialInstructions\": \"'.$shipSpecial.'\",'; }
		else { $shipSpecial = ""; }
		$shipRefNum = $_POST['ship_ref_num'];
		if ($shipRefNum != "") { $shipRefNum = ', "referenceNumbers": [ { "type": "PU", "value": "'.$shipRefNum.'" } ]'; }
		else { $shipRefNum = ""; }
		$delSpecial = $_POST['del_special'];
		if ($delSpecial != "") { $delSpecial = '\"specialInstructions\": \"'.$delSpecial.'\",'; }
		else { $delSpecial = ""; }
		$delRefNum = $_POST['del_ref_num'];
		if ($delRefNum != "") { $delRefNum = ', "referenceNumbers": [ { "type": "DEL", "value": "'.$delRefNum.'" } ]'; }
		else { $delRefNum = ""; }
		
		//echo "DEBUG itemsfull: $itemsfull2<br><br>";
		//echo "DEBUG loaddate: $loaddate<br><br>";
		//echo "DEBUG loadWS: $loadWS<br><br>";
		//echo "DEBUG loadWE: $loadWE<br><br>";
		//echo "DEBUG loadWS: $loadWS_ISO8601<br><br>";
		//echo "DEBUG loadWE: $loadWE_ISO8601<br><br>";
		
		$bookquote = '{
  "customers": [
    {
      "customerCode": "'.$customerCode.'",
      "contacts": [
        {
          "name": "'.$_POST['ship_first_name'].' '.$_POST['ship_last_name'].'",
          "type": "Contact",
          "companyName": "'.$_POST['ship_company'].'",
          "contactMethods": [
            {
              "method": "Phone",
              "value": "'.$_POST['ship_phone'].'"
            }
          ]
        }
      ],
      "referenceNumbers": [
        {
          "type": "CRID",
          "value": "C'.$_POST['orderidallbookQ'].'"
        }
      ]
    }
  ],
  "billTos": [
    {
      "customerCode": "'.$customerCode.'",
      "currencyCode": "USD",
      "contacts": [
        {
          "name": "'.$_POST['ship_first_name'].' '.$_POST['ship_last_name'].'",
          "type": "Contact",
          "companyName": "'.$_POST['ship_company'].'",
          "contactMethods": [
            {
              "method": "Phone",
              "value": "'.$_POST['ship_phone'].'"
            }
          ]
        }
      ]
    }
  ],
  "services": [
    {
      "suggestedScac": "'.$_POST['scac'].'",
      "suggestedCarrierPartyCode": "'.$_POST['carrierCode'].'",
      "locations": [
        {
          "type": "origin",
          "name": "CCR IND LLC",
          "address": {
            "address1": "'.$_POST['ship_add1'].'",
            "address2": "'.$_POST['ship_add2'].'",
            "city": "'.$_POST['ship_city'].'",
            "stateProvinceCode": "'.$_POST['ship_state'].'",
            "postalCode": "'.$_POST['ship_zip'].'",
            "country": "US"
          },
          "openDateTime": "'.$loadWS_ISO8601.'",
          "closeDateTime": "'.$loadWE_ISO8601.'",
          "specialRequirement": {
 			    "liftGate": false,
                "insidePickup": false,
                "residentialNonCommercial": false,
                "limitedAccess": false
 		},
        '.$shipSpecial.'
          "contacts": [
            {
              "name": "'.$_POST['ship_first_name'].' '.$_POST['ship_last_name'].'",
              "type": "Contact",
              "companyName": "CCR IND LLC",
              "contactMethods": [
                {
                  "method": "Phone",
                  "value": "'.$_POST['ship_phone'].'"
                },
                {
                  "method": "Email",
                  "value": "'.$_POST['ship_email'].'"
                }
              ]
            }
          ]'.$shipRefNum.'
        },
        {
          "type": "destination",
          "name": "'.$_POST['del_first_name'].' '.$_POST['del_last_name'].'",
          "address": {
            "address1": "'.$_POST['del_add1'].'",
            "address2": "'.$_POST['del_add2'].'",
            "city": "'.$_POST['del_city'].'",
            "stateProvinceCode": "'.$_POST['del_state'].'",
            "postalCode": "'.$_POST['del_zip'].'",
            "country": "US"
          },
          "specialRequirement": {
            '.$lg.'
			'.$indel.'
 			'.$resid.'
 			'.$limited.'
 			'.$term.'
			"appointmentNotification": true
          },
          '.$delSpecial.'
          "contacts": [
            {
              "name": "'.$_POST['del_first_name'].' '.$_POST['del_last_name'].'",
              "type": "Contact",
              "companyName": "Drop Location",
              "contactMethods": [
                {
                  "method": "Phone",
                  "value": "'.$_POST['del_phone'].'"
                },
                {
                  "method": "Email",
                  "value": "'.$_POST['del_email'].'"
                }
              ]
            }
          ]'.$delRefNum.'
        }
      ],
      "items": [
    '.$itemsfull2.'
	],
      "referenceNumbers": [
        {
          "type": "CRID",
          "value": "C'.$_POST['orderidallbookQ'].'"
        }
      ]
    }
  ],
  "measurementSystem": "Standard",
  "referenceNumbers": [

    {
        "type": "CUSTQUOTID",
        "value": "'.$_POST['quoteID'].'"
    }

    ]
}';
		//echo "DEBUG Itemsfull: $testbook<br><br>";
		$strip = array("\n", "\t", "\\");
		$bookquote = str_replace($strip, "", $bookquote);
		//echo "DEBUG QUOTE: $bookquote<br><br>";
		$jbquote = json_encode( $bookquote );
		//echo "DEBUG JSON: $jbquote<br><br>";
    	$auth = 'Authorization: Bearer '. $fqToken;
		
		$ch3 = curl_init();
		curl_setopt($ch3, CURLOPT_URL, 'https://api.navisphere.com/v1/orders');
		curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch3, CURLOPT_HTTPHEADER, [
    		$auth,
    		'Content-Type: application/json'
		]);
		curl_setopt($ch3, CURLOPT_POSTFIELDS, $jbquote);
		//echo "DEBUG setopts done.  Executing curl.<br><br>";
		$response = curl_exec($ch3);
		//echo "DEBUG response set.  Closing curl.<br><br>";
		curl_close($ch3);
		//echo "DEBUG curl closed. Json decode iniated.<br><br>";
		$data = json_decode($response);
		if ($data != "") {
			$num = $data->orderNumber;
			if ($num == "") { echo "DEBUG DATA dump: $response<br><br>"; }
			else { 
				$orderid = $_POST['orderidallbookQ'];
        		update_post_meta( $orderid, 'shiporder_ID', sanitize_text_field( $num ) );
				//echo "Order Booked on freightquote.com as Order Number: $num<br><br>"; 
				
				// display table
				echo "<table class='fqInputTable'>
		<form action='https://ccrind.com/wp-admin/edit.php?s=$orderid&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' method='post'>
	<tr>
		<th>Freight Quote Order Number</th>
	</tr>
	<tr>
		<input type='hidden' name='orderidallbookQ' value='$orderid'>
		<input type='hidden' name='orderNumber' value='$num'>
		<td>$num</td>
	</tr>
</table>
<p><input type='submit' value='Return to Order' /></p>
</form>
<br><br>
		<form action='https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Ffreightorder-admin-menu-ccr&orderid=$orderid&orderNumber=$num' method='post'>
<p><input type='submit' value='Retrieve Tracking Info' /></p>
</form>
";
				
				echo "<div style='display: none'>";
			}
		}
	}
}

// ship quote generator
function freightorder_admin_page_ccr_contents() {
	echo "<h2>Ship Order Information Retrieval using <a href='https://www.freightquote.com/book/#/single-page-quote' rel='noopener noreferrer' target='_blank'>freightquote.com</a></h2>";
	
	// baseline variables
    $clientID = "0oaqytpn1zrGXMNyR357";
    $clientSecret = "xSllN5OleLXhGEp6fY4vPVUP3MlroLHV8V7Xfc9s";
	$clientIDsand = "0oaqgzu6m1Z2lbKXv357";
    $clientSecretsand = "6v0z8Ophav7ySIUDngbYx5sNBYyKbTLhYxP2AgEJ";
    $customerCode = "C8664585";
	// check token age
	date_default_timezone_set("America/Chicago");
	$check = date("Y-m-d h:i:sa");
	//echo "<p>DEBUG Now: $check</p>";
	$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
	$fqToken = get_user_meta($userID, 'fq_token', true);
	$date = get_user_meta($userID, 'fq_token_age', true);
	$fqTokensand = get_user_meta($userID, 'fq_token_sand', true);
	$datesand = get_user_meta($userID, 'fq_token_age_sand', true);
	$date24 = strtotime($date . ' + 1 days');
	$check2 = strtotime($check);
	//echo "<p>DEBUG Saved Date + 24 hours: $date24</p>";
	// if the token age is older than 24 hours (86400sec = 60sec * 60mins * 24hours) or date is empty or token is empty, fetch a new token
	if ($check2 > $date24 || $date == "" || $fqToken == "" ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.navisphere.com/v1/oauth/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    	'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"client_id\": \"$clientID\", \"client_secret\": \"$clientSecret\", \"audience\": \"https://inavisphere.chrobinson.com\", \"grant_type\": \"client_credentials\" }");

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		$data = json_decode($response);
		
		$fqToken = $data->access_token;
		$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
		$date = date("Y-m-d h:i:sa");
		update_user_meta( $userID, "fq_token_age", sanitize_text_field( $date ) );
		update_user_meta( $userID, "fq_token", sanitize_text_field( $fqToken ) );
	}
	if ($check2 > $date24 || $datesand == "" || $fqTokensand == "" ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://sandbox-api.navisphere.com/v1/oauth/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
    	'Content-Type: application/json',
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"client_id\": \"$clientIDsand\", \"client_secret\": \"$clientSecretsand\", \"audience\": \"https://inavisphere.chrobinson.com\", \"grant_type\": \"client_credentials\" }");

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		$data = json_decode($response);
		
		$fqTokensand = $data->access_token;
		$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
		$date = date("Y-m-d h:i:sa");
		update_user_meta( $userID, "fq_token_age_sand", sanitize_text_field( $date ) );
		update_user_meta( $userID, "fq_token_sand", sanitize_text_field( $fqTokensand ) );
	}
	
	$orderid = $_GET['orderid'];
	$orderNumber = $_GET['orderNumber'];
	if ($orderNumber == "") { $_POST['orderNumber']; }
	
	$orderInfoForm = "<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 33%;
  max-width: 500px;
  padding: 10px;
  border-right: 5px solid black;
}

/* Clear floats after the columns */
.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>
	<form action='' method='post'>
		<p>CCR Order Number: $orderid</p>
		<p>freightquote.com Order Number: <input type='text' name='orderNumber' value='$orderNumber'></p>
		<p><input type='submit'></p>
	</form>";
	
	
	if ( $orderNumber == "" ) { echo $orderInfoForm; }
	else 
	{
		echo $orderInfoForm;
		$auth = 'Authorization: Bearer '. $fqToken;
			$url = "https://api.navisphere.com/v2/events?orderNumber=$orderNumber";
			//echo "DEBUG URL: $url<br><br>";
			$ch4 = curl_init();
			curl_setopt($ch4, CURLOPT_URL, $url);
			curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch4, CURLOPT_HTTPHEADER, [
    			$auth,
    			'Content-Type: application/json'
			]);
			//echo "DEBUG setopts done.  Executing curl.<br><br>";
			$response2 = curl_exec($ch4);
			//echo "DEBUG response set.  Closing curl.<br><br>";
			curl_close($ch4);
			//echo "DEBUG curl closed. Json decode iniated.<br><br>";
			$data2 = json_decode($response2);
			if ( current_user_can('administrator') ) {
				echo "<p style='overflow-wrap: break-word;'>DEBUG RESPONSE dump: $response2</p><br><br>"; 
			}
			//echo "DEBUG DATA dump: $data2<br><br>";
		
			if ($data2 != "") {
				/*$eventCount = $data2->totalCount - 1;
				while ($eventCount >= 0) {
					//echo "DEBUG: count: $eventCount<br>";
					if ($tnum == "") { $tnum = $data2->results[$eventCount]->event->orderDetail[0]->navisphereTrackingNumber; }
					//echo "DEBUG: Track Num: $tnum<br>";
					if ($link == "") { $link = $data2->results[$eventCount]->event->orderDetail[0]->navisphereTrackingLink; }
					//echo "DEBUG: Track Num: $tnum<br>";
					$eventCount = $eventCount - 1;
				}*/
				$tnum = $data2->results[0]->event->orderDetails[0]->navisphereTrackingNumber;
				if ($tnum == "") { $tnum = $data2->results[0]->event->orderDetail[0]->navisphereTrackingNumber; }
				//echo "DEBUG: Track Num: $tnum<br>";
				$link = $data2->results[0]->event->orderDetails[0]->navisphereTrackingLink;
				if ($link == "") { $link = $data2->results[0]->event->orderDetail[0]->navisphereTrackingLink; }
				$load = $data2->results[0]->event->loadNumbers[0];
				if ($load == "") { $load = $data2->results[0]->event->loadNumbers[0]; }
				$carrier = $data2->results[3]->event->carrier->name;
				if ($carrier == "") { $data2->results[3]->event->carrier->name; }
				$carrierCode = $data2->results[3]->event->carrier->carrierCode;
				if ($carrierCode == "") { $carrierCode = $data2->results[3]->event->carrier->carrierCode; }
				//echo "DEBUG: Track Num: $link<br><br>";
				$tnum = "<a href='$link' target='_blank'>$tnum</a>";
				update_post_meta( $orderid, 'shipordertrack_ID', $tnum );
				//echo "DEBUG Track Num: $tnum<br><br>";
				// build event table
				$eventTable = "<table class='fqInputTable'>
	<tr>
		<th>Event</th>
		<th>Time</th>
	</tr>";
				// display all events and when they occurred
				$eventCount = $data2->totalCount - 1;
				while ($eventCount >= 0) {
					//$time = $data2->results[$eventCount]->eventTime;
					//$time = date('Y-m-d', strtotime($time));
					//$event = $data2->results[$eventCount]->event->eventType;
					//echo "Event: " . $data2->results[$eventCount]->event->eventType . " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time: " .  date('m-d-Y h:ia', strtotime($data2->results[$eventCount]->eventTime)) . "<br>";
					$eventTable = $eventTable . "
	<tr>
		<td>" . $data2->results[$eventCount]->event->eventType . "</td>
		<td>" . date('m-d-Y h:ia', strtotime($data2->results[$eventCount]->eventTime)) . "</td>
	</tr>";
					$eventCount = $eventCount - 1;
				}
				//echo "<br>";
			}
			else {
				echo "<p style='overflow-wrap: break-word;'>DEBUG RESPONSE dump: $response2</p><br><br>";
			}
		$eventTable = $eventTable . "
</table>";
		
		// display tables
		echo $eventTable;
		echo "<br><br><br>";
		echo "<table class='fqInputTable'>
		<form action='https://ccrind.com/wp-admin/edit.php?s=$orderid&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' method='post'>
	<tr>
		<th>Freight Quote Order Number</th>
		<th>Freight Quote Tracking Number</th>
		<th>Freight Quote Load Number</th>
		<th>Freight Quote Carrier</th>
		<th>Freight Quote Carrier Code</th>
	</tr>
	<tr>
		<td>$orderNumber</td>
		<td>$tnum</td>
		<td>$load</td>
		<td>$carrier</td>
		<td>$carrierCode</td>
	</tr>
</table>
<p><input type='submit' value='Return to Order' /></p>
</form>";
				
				echo "<div style='display: none'>";
	}
}