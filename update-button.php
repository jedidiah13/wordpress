<?php
//when the user click submit then we will call our template 
add_action('init', 'trim_button');
// button function start
function trim_button()
{
	// flags set to empty
	$postidall = ""; // update all id
	$orderidall = "";// update all order id
	$cancelorder = ""; // cancel order id
	$deleteshipqlog = "";
	$newbulk = ""; // bulk edit flag
	
	// update flags based on button pressed
	if( isset( $_POST['postidall'] )) { $postidall = $_POST['postidall']; }
	if( isset( $_POST['orderidall'] ) ) { $orderidall = $_POST['orderidall']; }
	if( isset( $_POST['cancelid'] ) ) { $cancelorder = $_POST['cancelid']; }
	if( isset( $_POST['deleteshipqlid'] ) ) { $deleteshipqlog = $_POST['deleteshipqlid']; }
	
	// post all button master button
	if ($postidall != "")
	{
		$product = wc_get_product( $postidall );
		$title = $product->get_title();
		if ( isset( $_POST['brandinput'] ) ) { $brand = $_POST['brandinput']; } 
		if ( isset( $_POST['mpninput'] ) ) { $mpn = $_POST['mpninput']; } 
		if ( isset( $_POST['gsfinput'] ) ) { $gsf = $_POST['gsfinput']; $gsf = strtoupper( $gsf ); } 
		if ( isset( $_POST['gsfinpute'] ) ) { $gsf = $_POST['gsfinpute']; $gsf = strtoupper( $gsf ); }
		if ( isset( $_POST['clcreate'] ) ) { $create_contact_log = $_POST['clcreate']; }
		if ( isset( $_POST['postregprice'] ) ) { $regprice = $_POST['postregprice']; } 
		//$saleprice = $_POST['postsaleprice']; //if ($saleprice == ""){ $saleprice = $_POST['postsalepricee']; }
		if ( isset( $_POST['postcost'] ) ) { $cost = $_POST['postcost']; }
		if ($cost == "" && isset( $_POST['postcoste'] ) ) { $cost = $_POST['postcoste']; }
		$priceflag = 0;
		$spriceflag = 0;
		$cpriceflag = 0;
		
		if ( isset( $_POST['deminputl'] ) ) { $l = $_POST['deminputl']; }
		if ( isset( $_POST['deminputlempty'] ) ) { $l = $_POST['deminputlempty']; }
		if ( isset( $_POST['deminputw'] ) ) { $w = $_POST['deminputw']; }
		if ( isset( $_POST['deminputwempty'] ) ) { $w = $_POST['deminputwempty']; }
		if ( isset( $_POST['deminputh'] ) ) { $h = $_POST['deminputh']; }
		if ( isset( $_POST['deminputhempty'] ) ) { $h = $_POST['deminputhempty']; }
		if ( isset( $_POST['wgtinput'] ) ) { $wgt = $_POST['wgtinput']; }
		if ( isset( $_POST['deminputwgtempty'] ) ) { $wgt = $_POST['deminputwgtempty']; }
		if ( isset( $_POST['cfeeinput'] ) ) { $cfee = $_POST['cfeeinput']; }
		if ( isset( $_POST['deminputcfeeempty'] ) ) { $cfee = $_POST['deminputcfeeempty']; }
		
		if ( isset( $_POST['postlocupdate'] ) ) { $loc = $_POST['postlocupdate']; } if ( isset($loc) ) { $loc = strtoupper($loc); }
		
		if ( isset( $_POST['shipclassinput'] ) ) { $shipc = $_POST['shipclassinput']; } 
		if ( isset( $_POST['customshipinput'] ) ) { $customship = $_POST['customshipinput']; } 
		if ( isset( $_POST['freightclassinput'] ) ) { $freightc = $_POST['freightclassinput']; } 
		$shipcint = 0;
		if ( isset( $_POST['cship_select'] ) ) { $customship2 = $_POST['cship_select']; } 
		if ( isset( $_POST['shipc_select'] ) ) { $shipcselect = $_POST['shipc_select']; } 
		
		$auc = $_POST['aucinput']; if ( $auc == "" ) { $auc = $_POST['aucinpute']; }
		global $aucsave;
		if ( isset( $_POST['aucdinput'] ) ) { $aucdatein = $_POST['aucdinput']; if ($aucdatein == "" && isset( $_POST['aucdinpute'] ) ) { $aucdatein = $_POST['aucdinpute']; } }
		if ( isset( $_POST['newaucdinput'] ) ) { $aucdate = $_POST['newaucdinput']; } 
		if ( isset( $_POST['gdlotinput'] ) ) { $GDLot = $_POST['gdlotinput']; }
		if ( isset( $_POST['gdlotinpute'] ) ) { $GDLot = $_POST['gdlotinpute']; }
		
		if ( isset( $_POST['dnlebay'] ) ) { $dnl = $_POST['dnlebay']; } 
		if ( isset( $_POST['newFB'] ) ) { $newFB = $_POST['newFB']; } 
		
		if ( isset( $_POST['condinput'] ) ) { $cond = $_POST['condinput']; } 
		if ( isset( $_POST['testinput'] ) ) { $test = $_POST['testinput']; $test = str_replace("'", "", $test); } 
		if ( isset( $_POST['addinfodisplay'] ) ) { $addinfo = $_POST['addinfodisplay']; } 
		$condflag = 0;
		
		if ( isset( $_POST['vlinkinput'] ) ) { $vlink = $_POST['vlinkinput']; } 
		if ( isset( $_POST['lsninput'] ) ) { $lsn = $_POST['lsninput']; } 
		if ( isset( $_POST['lsnlinput'] ) ) { $lsnlink = $_POST['lsnlinput']; } 
		if ( isset( $_POST['lsncinput'] ) ) { $lsnc = $_POST['lsncinput']; } 
		$lsnupdate = 0; // flag to populate LSN html sheet
		if ( isset( $_POST['fblinput'] ) ) { $fblink = $_POST['fblinput']; } 
		if ( isset( $_POST['fbcinput'] ) ) { $fbc = $_POST['fbcinput']; } 
		if ( isset( $_POST['cllinput'] ) ) { $cllink = $_POST['cllinput']; } 
		if ( isset( $_POST['clcinput'] ) ) { $clc = $_POST['clcinput']; } 
		if ( isset( $_POST['ebclinput'] ) ) { $ebclink = $_POST['ebclinput']; } 
		if ( isset( $_POST['ebccinput'] ) ) { $ebcc = $_POST['ebccinput']; } 
		if ( isset( $_POST['threesixtylink'] ) ) { $tslink = $_POST['threesixtylink']; } 
		if ( isset( $_POST['lsnaccdate'] ) ) { $lsnaccount = $_POST['lsnaccdate']; } 
		if ( isset( $_POST['lsndaterenew'] ) ) { $lsnrenewdate = $_POST['lsndaterenew']; } 
		
		if ( isset( $_POST['keytermsdisplay'] ) ) { $keyterms = $_POST['keytermsdisplay']; } 
		if ( isset( $_POST['fixinfodisplay'] ) ) { $fixinfo = $_POST['fixinfodisplay']; } 
		if ( isset( $_POST['notedandisplay'] ) ) { $notedan = $_POST['notedandisplay']; } 

		if ( isset( $_POST['soldbyform3'] ) ) { $soldby = $_POST['soldbyform3']; } 
		if ( isset( $_POST['formaction'] ) ) { $action = $_POST['formaction']; } 
		if ( isset( $_POST['postqty'] ) ) { $qty = $_POST['postqty']; } 
		
		if ( isset( $_POST['clearlinks'] ) ) { $clear = $_POST['clearlinks']; } 
		if ( isset( $_POST['restorelinks'] ) ) { $restore = $_POST['restorelinks']; } 
		if ( isset( $_POST['lsnsetrenew'] ) ) { $lsnsetrenew = $_POST['lsnsetrenew']; } 
		
		$updatedesc = "";
		$fblinkadded = 0;
		
		$bulk = $_POST['mybulkedit']; // bulk edit flag checkbox
		if ($bulk)
		{	
			$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
			$search_term = str_replace(" ", ",", $search_term);
		$search_term = str_replace("/", ",", $search_term);
		$search_term = str_replace(",,,,", ",", $search_term);
		$search_term = str_replace(",,,", ",", $search_term);
		$search_term = str_replace(",,", ",", $search_term);
		$search_term = str_replace('"', ',', $search_term);
		
		if (strpos($search_term, ',') == true)
		{
			$skus = explode(',',$search_term);
		}
		//$skus = get_query_IDs();
			
			// if check
		if ($skus != "") {
        if(is_array($skus)) {
            foreach($skus as $sku) {
                if ($sku != "") {
					
				$product = get_product_by_sku($sku);
				if ($product != null) {
				$postidall = $product->get_id(); 
				
				$priceflag = 0;
				$spriceflag = 0;
				$cpriceflag = 0;
			$tableupdate = array();
				
				global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email; 
		$lastuser = $current_user->user_firstname;
				
		$updatedesc = "";
		$updatedesc = $updatedesc . "
BULK CHANGE SELECTED";
		$updatedesc = "
USER: " . $email . " made the following changes:" . $updatedesc;
			
		// BRAND MODEL UPDATE
		if ($brand != ""){
		$oldbrand = get_post_meta( $postidall, '_ccrind_brand', true );
		if ($brand != $oldbrand)
		{
			update_post_meta( $postidall, '_ccrind_brand', wc_clean( $brand ) );
			$updatedesc = $updatedesc . "
BRAND:				CHANGED: " . $oldbrand . " -> " . $brand;
			array_push( $tableupdate, array("BRAND", $oldbrand, $brand) );
		} }
		if ($mpn != ""){
		$oldmpn = get_post_meta( $postidall, '_ccrind_mpn', true );
		if ($mpn != $oldmpn)
		{
			update_post_meta( $postidall, '_ccrind_mpn', wc_clean( $mpn ) );
			$updatedesc = $updatedesc . "
MODEL:				CHANGED: " . $oldmpn . " -> " . $mpn;
			array_push( $tableupdate, array("MODEL", $oldmpn, $mpn) );
		} }
		if ($gsf != ""){
		$oldgsf = get_post_meta( $postidall, '_gsf_value', true );
		if ($gsf != $oldgsf)
		{
			update_post_meta( $postidall, '_gsf_value', wc_clean( $gsf ) );
			$updatedesc = $updatedesc . "
GSF:				CHANGED: " . $oldgsf . " -> " . $gsf;
			array_push( $tableupdate, array("GSF", $oldgsf, $gsf) );
		} }
		
		// PRICE COST UPDATE
		// set new price
		if ($regprice != "") { 
			$oregprice = $product->get_regular_price();
			$product->set_price($regprice); $product->set_regular_price($regprice); $priceflag = 1;
			update_post_meta( $postidall, '_ccrind_price', wc_clean( $regprice ) );
		}
		// set new sale price, empty its value if clear or 0 are entered
		if ($saleprice != "")
		{
			$osaleprice = $product->get_sale_price();
			if ($saleprice == "clear" || $saleprice == "0" ) { $saleprice = '';	}
			$product->set_sale_price($saleprice); $spriceflag = 1;
		}
		// set new cost, empty its value if clear or 0 are entered
		if ($cost != "")
		{
			$ocost = get_post_meta( $postidall, '_cost', true );	
			if ($cost == "clear" || $cost == "0" ) { $cost = ""; }
			update_post_meta( $postidall, '_cost', wc_clean( $cost ) ); $cpriceflag = 1;
		}
		// build _last_change_desc 
		if ($priceflag) { $updatedesc = $updatedesc . "
PRICE:				CHANGED: " . $oregprice . " -> " . $regprice; array_push( $tableupdate, array("PRICE", $oregprice, $regprice) ); }
		if ($spriceflag) { $updatedesc = $updatedesc . "
SALE PRICE:			CHANGED: " . $osaleprice . " -> " . $saleprice; array_push( $tableupdate, array("SALE PRICE", $osaleprice, $saleprice) ); }
		if ($cpriceflag) { $updatedesc = $updatedesc . "
COST:				CHANGED: " . $ocost . " -> " . $cost; array_push( $tableupdate, array("COST", $ocost, $cost) ); }
		
		// LOCATION UPDATE
		if ($loc != ""){ $oloc = get_post_meta( $postidall, '_warehouse_loc', true ); update_post_meta( $postidall, '_warehouse_loc', wc_clean( $loc ) ); 
			$updatedesc = $updatedesc . "
WH LOC:				CHANGED: " . $oloc . " -> " . $loc; array_push( $tableupdate, array("WAREHOUSE LOCATION", $oloc, $loc) ); }
		
		// DIMENSIONS WEIGHT UPDATE
		if ($l != "") {
			if ($l == "clear" || $l == 0) { $l = ""; }
			$ol = get_post_meta( $postidall, '_length', true );
			update_post_meta( $postidall, '_length', wc_clean( $l ) );
			$updatedesc = $updatedesc . "
LENGTH:				CHANGED: " . $ol . " => " . $l; array_push( $tableupdate, array("LENGTH", $ol, $l) ); }
		if ($w != "") {
			if ($w == "clear" || $w == 0 ) { $w = ""; }
			$ow = get_post_meta( $postidall, '_width', true );
			update_post_meta( $postidall, '_width', wc_clean( $w ) ); 
			$updatedesc = $updatedesc . "
WIDTH:				CHANGED: " . $ow . " => " . $w; array_push( $tableupdate, array("WIDTH", $ow, $w) ); }
		if ($h != "") {
			if ($h == "clear" || $h == 0) { $h = ""; }
			$oh = get_post_meta( $postidall, '_height', true );
			update_post_meta( $postidall, '_height', wc_clean( $h ) );
			$updatedesc = $updatedesc . "
HEIGHT:				CHANGED: " . $oh ." => " . $h; array_push( $tableupdate, array("HEIGHT", $oh, $h) ); }
		if ($wgt != "") {
			if ($wgt == "clear" || $wgt == 0) { $wgt = ""; }
			$owgt = get_post_meta( $postidall, '_weight', true );
			update_post_meta( $postidall, '_weight', wc_clean( $wgt ) );
			$updatedesc = $updatedesc . "
WEIGHT:				CHANGED: " . $owgt . " => " . $wgt; array_push( $tableupdate, array("WEIGHT", $owgt, $wgt) ); }
		if ($cfee != "") {
			if ($cfee == "clear" || $cfee == 0) { $cfee = ""; }
			$ocfee = get_post_meta( $postidall, '_cratefee', true );
			update_post_meta( $postidall, '_cratefee', wc_clean( $cfee ) );
			$updatedesc = $updatedesc . "
PALLET FEE:			CHANGED: " . $ocfee . " => " . $cfee; array_push( $tableupdate, array("PALLET FEE", $ocfee, $cfee) ); }
		
		// SHIPPING INFO UPDATE
		if ($shipc != "") 
		{
			if ($shipc == "clear" || $shipc == 0 || $shipc == "0") 
				{ $shipcint = 0; }
			if ($shipc == "1" || $shipc == 1) 
				{ $shipcint = 2638; }
			if ($shipc == "2" || $shipc == 2) 
				{ $shipcint = 9156; }
			if ($shipc == "3" || $shipc == 3) 
				{ $shipcint = 9011; }
			if ($shipc == "4" || $shipc == 4) 
				{ $shipcint = 9080; }
			if ($shipc == "5" || $shipc == 5) 
				{ $shipcint = 9151; }
			if ($shipc == "6" || $shipc == 6) 
				{ $shipcint = 9152; }
			$oshipc = $product->get_shipping_class_id();
			$updatedesc = $updatedesc . "
SHIP CLASS:			CHANGED: " . $oshipc . " => " . $shipcint; array_push( $tableupdate, array("SHIP CLASS", $oshipc, $shipcint) );
			$product->set_shipping_class_id( $shipcint ); 
		}
		if ($customship != "") 
		{
			// bookmark cs
			if ($customship == "clear") 
			{ 
				$customship = ""; 
			}
			$ocustomship = get_post_meta( $postidall, '_customship', true );
			$updatedesc = $updatedesc . "
CUSTOMSHIP:			CHANGED: " . $ocustomship . " => " . $customship; array_push( $tableupdate, array("CUSTOMSHIP", $ocustomship, $customship) );
			
			update_post_meta( $postidall, '_customship', wc_clean( $customship ) ); 
			// remove from ebay if customship is 4
			if ($customship == 4 || $customship == 6 ) {
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $postidall );
			do_action('wplister_end_item', $listing_id ); }
		}
		if ($customship2 != "") 
		{
			$customship = $customship2;
			if ($customship == "7" || $customship == 7) { $customship = ""; }
			$ocustomship = get_post_meta( $postidall, '_customship', true );
			$updatedesc = $updatedesc . "
CUSTOMSHIP:			CHANGED: " . $ocustomship . " => " . $customship; array_push( $tableupdate, array("CUSTOMSHIP", $ocustomship, $customship) );
			
			update_post_meta( $postidall, '_customship', wc_clean( $customship ) ); 
			// remove from ebay if customship is 4
			if ($customship == 4 || $customship == 6 ) {
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $postidall );
			do_action('wplister_end_item', $listing_id ); }
		}
		if ($freightc != "") 
		{
			if ($freightc == "clear" || $freightc == 0) 
			{ 
				$freightc = ""; 
			}
			$ofreightc = get_post_meta( $postidall, '_ltl_freight', true );
			$updatedesc = $updatedesc . "
FREIGHT CLASS:			CHANGED: " . $ofreightc ." => " . $freightc; array_push( $tableupdate, array("FREIGHT CLASS", $ofreightc, $freightc) );
			update_post_meta( $postidall, '_ltl_freight', wc_clean( $freightc ) ); 
		}
		// ship class select box update
		if ($shipcselect != "") 
		{
			if ($shipcselect == "0" || $shipcselect == 0) 
				{ $shipcint = 0; }
			if ($shipcselect == "1" || $shipcselect == 1) 
				{ $shipcint = 2638; }
			if ($shipcselect == "2" || $shipcselect == 2) 
				{ $shipcint = 9156; }
			if ($shipcselect == "3" || $shipcselect == 3) 
				{ $shipcint = 9011; }
			if ($shipcselect == "4" || $shipcselect == 4) 
				{ $shipcint = 9080; }
			if ($shipcselect == "5" || $shipcselect == 5) 
				{ $shipcint = 9151; }
			if ($shipcselect == "6" || $shipcselect == 6) 
				{ $shipcint = 9152; }
			$oshipc = $product->get_shipping_class_id();
			$updatedesc = $updatedesc . "
SHIP CLASS:			CHANGED: " . $oshipc . " => " . $shipcint; array_push( $tableupdate, array("SHIP CLASS", $oshipc, $shipcint) );
			$product->set_shipping_class_id( $shipcint ); 
		}
		
		// AUCTION UPDATE
		if ($auc != "" || $aucsave == "clear") {
			if ($auc == "clear" || $aucsave == "clear") { $auc = ""; $aucsave = "clear"; }
			$oauc = get_post_meta( $postidall, '_auction', true );
			$updatedesc = $updatedesc . "
AUCTION:			CHANGED: " . $oauc . " => " . $auc; array_push( $tableupdate, array("AUCTION", $oauc, $auc) );
			update_post_meta( $postidall, '_auction', $auc); }
		if ($aucdatein == "clear") {
			$aucdatein = "";
			$oaucdate = get_post_meta( $postidall, '_auction_date', true );
			$updatedesc = $updatedesc . "
AUCDATE INPUT:			CHANGED: " . $oaucdate . " => " . $aucdatein; array_push( $tableupdate, array("AUC DATE INPUT", $oaucdate, $aucdatein) );
			update_post_meta( $postidall, '_auction_date', wc_clean( $aucdatein ) ); }
		if ($aucdate != "") {
			$oaucdate = get_post_meta( $postidall, '_auction_date', true );
			$updatedesc = $updatedesc . "
AUCDATE:			CHANGED: " . $oaucdate . " => " . $aucdate; array_push( $tableupdate, array("AUC DATE", $oaucdate, $aucdate) );
			update_post_meta( $postidall, '_auction_date', wc_clean( $aucdate ) ); }
					
		if ($GDLot != "") { // start
			$oGDLot = get_post_meta( $postidall, '_govdeals', true );
			//only execute if it changed
			if ($oGDLot == $GDLot){ /* do nothing */ } 
			else {
			if ($GDLot == "clear" || $GDLot == "0") { $GDLot = ""; }
			$updatedesc = $updatedesc . "
GovDeals Lot#:		CHANGED: " . $oGDLot . " => " . $GDLot; $auc; array_push( $tableupdate, array("GovDeals Lot#", $oGDLot, $GDLot) );
			update_post_meta( $postidall, '_govdeals', wc_clean( $GDLot ) ); } }
		
			// update the checkbox for do not list to ebay if it changed
			$odnl = get_post_meta( $postidall, '_dnl_eBay', true );
			if ($odnl != $dnl) {
			$updatedesc = $updatedesc . "
DNL EBAY:			CHANGED: " . $odnl . " => " . $dnl; array_push( $tableupdate, array("DNL EBAY", $odnl, $dnl) );
			update_post_meta( $postidall, '_dnl_eBay', wc_clean( $dnl ) ); } 
			
			// update the checkbox for new facebook account posting
			$onewFB = get_post_meta( $postidall, '_newFB', true );
			if ($onewFB != $newFB) {
			$updatedesc = $updatedesc . "
NEW FB:				CHANGED: " . $onewFB . " => " . $newFB; array_push( $tableupdate, array("NEW FB", $onewFB, $newFB) );
			update_post_meta( $postidall, '_newFB', wc_clean( $newFB ) ); } 
		
		// CONDITION AND TESTED STATUS UPDATE
		/*if ($cond != "") 
		{
			$cond = strtolower($cond);
			if ($cond == "clear") { $cond = ""; }
			// translate input code to ebay code and translate ebay code for description
			if ($cond == 0 || $cond == "parts" || $cond == "forparts" || $cond == "for parts") { $cond = 7000; $condt = "For Parts"; } // For parts
			else if ($cond == 1 || $cond == "used" ) { $cond = 3000; $condt = "Used"; } // Used
			else if ($cond == 2 || $cond == "new other" ) { $cond = 1500; $condt = "New Other"; } // New Other
			else if ($cond == 3 || $cond == "new" ) { $cond = 1000; $condt = "New"; } // New
			else if ($cond == 4 || $cond == "refurbished" ) { $cond = 2500; $condt = "Seller Refurbished"; } // Seller Refurbished
			$ocond = get_post_meta( $postidall, '_ebay_condition_id', true );
			// translate $ocond for description
			if ($ocond == 7000) { $ocond = "For Parts"; } // For parts
			else if ($ocond == 3000) { $ocond = "Used"; } // Used
			else if ($ocond == 1500) { $ocond = "New Other"; } // New Other
			else if ($ocond == 1000) { $ocond = "New"; } // New
			else if ($ocond == 2500) { $ocond = "Seller Refurbished"; } // Seller Refurbished
			$updatedesc = $updatedesc . "
CONDITION:			CHANGED: " . $ocond . " => " . $condt; $auc; array_push( $tableupdate, array("CONDITION", $ocond, $condt) );
			update_post_meta( $postidall, '_ebay_condition_id', wc_clean( $cond ) ); $condflag = 1;
		}
		if ($test != "") 
		{
			$otest = get_post_meta( $postidall, '_tested', true );
			//only execute if it changed
			if ($otest != $test){
			if ($test == "clear") { $test = ""; }
			$otest = get_post_meta( $postidall, '_tested', true );
			if ($otest != $test) {
			$updatedesc = $updatedesc . "
TESTED?:			CHANGED: " . $otest . " => " . $test; $auc; array_push( $tableupdate, array("TESTED?", $otest, $test) );
			update_post_meta( $postidall, '_tested', wc_clean( $test ) ); } }
		}
		if ($addinfo != "") 
		{
			$oaddinfo = get_post_meta( $postidall, '_extra_info', true );
			//only execute if it changed
			if ($oaddinfo == $addinfo){ /* do nothing */ /*} 
			else {
			if ($addinfo == "clear") { $addinfo = ""; }
			if ($oaddinfo != $addinfo) {
			$updatedesc = $updatedesc . "
ADD. INFO:			CHANGED: " . $oaddinfo . " => " . $addinfo; $auc; array_push( $tableupdate, array("ADDITIONAL INFO", $oaddinfo, $addinfo) );
			update_post_meta( $postidall, '_extra_info', wc_clean( $addinfo ) ); } }
		}*/
		
		// LINKS AND COST UPDATE
		if ($vlink != "") { // start
			$ovlink = get_post_meta( $postidall, '_video', true );
			//only execute if it changed
			if ($ovlink == $vlink){ /* do nothing */ } 
			else {
			if ($vlink == "clear" || $vlink == "0") { $vlink = ""; }
			$updatedesc = $updatedesc . "
YTLINK:				CHANGED: " . $ovlink . " => " . $vlink; $auc; array_push( $tableupdate, array("YTLINK", $ovlink, $vlink) );
			update_post_meta( $postidall, '_video', wc_clean( $vlink ) ); } } // end
				
		
		//$lsnarr = array();
		/*if ($lsn != "") { // start
			$olsn = get_post_meta( $postidall, '_lsn', true );
			//only execute if it changed
			if ($olsn == $lsn || $restore){ /* do nothing */ /*} 
			else {
			if ($lsn == "clear" || $lsn == "0") { $lsn = ""; }
			$updatedesc = $updatedesc . "
LSN:				CHANGED: " . $olsn . " => " . $lsn; $auc; array_push( $tableupdate, array("LSN", $olsn, $lsn) );
			update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) ); $lsnupdate = 1; } } // end
		
		if ($lsnlink != "") { // start
			$olsnlink = get_post_meta( $postidall, '_lsnlink', true );
			//only execute if it changed
			if ($olsnlink == $lsnlink){ /* do nothing */ /*} 
			else {
			if ($lsnlink == "clear" || $lsnlink == "0") { $lsnlink = ""; }
			$updatedesc = $updatedesc . "
LSNLINK:			CHANGED: " . $olsnlink . " => " . $lsnlink; array_push( $tableupdate, array("LSNLINK", $olsnlink, $lsnlink) );
			update_post_meta( $postidall, '_lsnlink', wc_clean( $lsnlink ) ); $lsnupdate = 1; } } // end
		
		if ($lsnc != "") { // start
			if ($lsnc == "clear" || $lsnc == "0") { $lsnc = ""; }
			$olsnc = get_post_meta( $postidall, '_lsn_cost', true );
			$updatedesc = $updatedesc . "
LSNCOST:			CHANGED: " . $olsnc . " => " . $lsnc; array_push( $tableupdate, array("LSN", $olsnc, $lsnc) );
			update_post_meta( $postidall, '_lsn_cost', wc_clean( $lsnc ) ); $lsnupdate = 1; } // end
		
		
		
		if ($fblink != "") { // start
			$ofblink = get_post_meta( $postidall, '_fbmp', true );
			//only execute if it changed
			if ($ofblink != $fblink){ 
			if ($fblink == "clear" || $fblink == "0") { $fblink = ""; }
			$updatedesc = $updatedesc . "
FB:					CHANGED: " . $ofblink . " => " . $fblink; array_push( $tableupdate, array("LSN", $ofblink, $fblink) );
			update_post_meta( $postidall, '_fbmp', wc_clean( $fblink ) );
			$fblinkadded = 1; } } // end
		
		if ($fbc != "") { // start
			if ($fbc == "clear" || $fbc == "0") { $fbc = ""; }
			$ofbc = get_post_meta( $postidall, '_fbmp_cost', true );
			$updatedesc = $updatedesc . "
FBCOST:				CHANGED: " . $ofbc . " => " . $fbc; array_push( $tableupdate, array("FBCOST", $ofbc, $fbc) );
			update_post_meta( $postidall, '_fbmp_cost', wc_clean( $fbc ) ); } // end
		
		if ($cllink != "") { // start
			$ocllink = get_post_meta( $postidall, '_cl', true );
			//only execute if it changed
			if ($ocllink == $cllink){ /* do nothing */ /*} 
			else {
			if ($cllink == "clear" || $cllink == "0") { $cllink = ""; }
			$updatedesc = $updatedesc . "
CL:					CHANGED: " . $ocllink . " => " . $cllink; array_push( $tableupdate, array("CL", $ocllink, $cllink) );
			update_post_meta( $postidall, '_cl', wc_clean( $cllink ) ); } } // end
		
		if ($clc != "") { // start
			if ($clc == "clear" || $clc == "0") { $clc = ""; }
			$oclc = get_post_meta( $postidall, '_cl_cost', true );
			$updatedesc = $updatedesc . "
CLCOST:				CHANGED: " . $oclc . " => " . $clc; array_push( $tableupdate, array("CLCOST", $oclc, $clc) );
			update_post_meta( $postidall, '_cl_cost', wc_clean( $clc ) ); } // end
		
		if ($ebclink != "") { // start
			$oebclink = get_post_meta( $postidall, '_ebayclass', true );
			//only execute if it changed
			if ($oebclink == $ebclink){ /* do nothing */ /*} 
			else {
			if ($ebclink == "clear" || $ebclink == "0") { $ebclink = ""; }
			$updatedesc = $updatedesc . "
eBayC:				CHANGED: " . $oebclink . " => " . $ebclink; array_push( $tableupdate, array("eBayC", $oebclink, $ebclink) );
			update_post_meta( $postidall, '_ebayclass', wc_clean( $ebclink ) ); } } // end
		
		if ($ebcc != "") { // start
			if ($ebcc == "clear" || $ebcc == "0") { $ebcc = ""; }
			$oebcc = get_post_meta( $postidall, '_ebayclass_cost', true );
			$updatedesc = $updatedesc . "
eBayCCOST:			CHANGED: " . $oebcc . " => " . $ebcc; array_push( $tableupdate, array("eBayCCOST", $oebcc, $ebcc) );
			update_post_meta( $postidall, '_ebayclass_cost', wc_clean( $ebcc ) ); } // end
		
		if ($tslink != "") { // start
			$otslink = get_post_meta( $postidall, '_threesixty', true );
			//only execute if it changed
			if ($otslink == $tslink){ /* do nothing */ /*} 
			else {
			if ($tslink == "clear" || $tslink == "0") { $tslink = ""; }
			$updatedesc = $updatedesc . "
360LINK:			CHANGED: " . $otslink . " => " . $tslink; array_push( $tableupdate, array("360LINK", $otslink, $tslink) );
			update_post_meta( $postidall, '_threesixty', wc_clean( $tslink ) ); } } // end
				
		if ($lsnaccount != "") {
			// set renew date for account in lsn log
			// format the name of the account input
			$lsnaccount = strtoupper($lsnaccount);
			if ( substr( $lsnaccount, 0, 1 ) == "C") { $lsnaccount = strtolower($lsnaccount); }
			// format the date input
			//$lsnrenewdate = $lsnrenewdate->format('m-d-y');
			$find = "renewDate $lsnaccount'>"; // look for that number in the table
			$find2 = "renewDateS $lsnaccount'>"; // look for that number in the table
			$find3 = "renewDateR $lsnaccount'>"; // look for that number in the table
			$reading = fopen("../library/LSN/LSN.html", "r"); // read file
			$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
			$replaced = false; // flag
			// read through the entire file
			while ( !feof($reading)) {
				$line = fgets($reading); // line by line
				if ( strpos($line, $find) || strpos($line, $find2) || strpos($line, $find3)) { 
					$newline = "	<th class='renewDateS $lsnaccount'>$lsnrenewdate</th>"; // empty cell
					$line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } // flag true and replace with empty cell code
				else { fwrite($writing, $line); } // write each line from read file to write file 
			}
			fclose($reading); fclose($writing); // close both working files
			// if a line was replaced during the above loop, overwrite the read file with the written file
			if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
			// if a line was NOT replaced, delete the unrequired write temporary file
			else { unlink("../library/LSN/LSN.tmp.html"); }
			lsn_scheduled_event();
		}*/
		
		if ($keyterms != "") 
		{
			$okeyterms = get_post_meta( $postidall, '_key_terms', true );
			//only execute if it changed
			if ($okeyterms == $keyterms){ /* do nothing */ } 
			else {
			if ($keyterms == "clear" ) { $keytermsInput = ""; }
			else { $keytermsInput = $keyterms; }
			$updatedesc = $updatedesc . "
KEYWORD TERMS:		CHANGED: " . $okeyterms . " => " . $keytermsInput; array_push( $tableupdate, array("KEYWORD TERMS", $okeyterms, $keytermsInput) ); 
			update_post_meta( $postidall, '_key_terms', $keytermsInput ); }
		}
		
		if ($fixinfo != "") 
		{
			$ofixinfo = get_post_meta( $postidall, '_fix_info', true );
			//only execute if it changed
			//$fixinfo = strtolower($fixinfo);
			if ($fixinfo == "clear" ) { $fixinfoInput = ""; }
			else { $fixinfoInput = $fixinfo; }
			$updatedesc = $updatedesc . "
FIXING INFO:		CHANGED: " . $ofixinfo . " => " . $fixinfoInput; array_push( $tableupdate, array("FIXING INFO", $ofixinfo, $fixinfoInput) ); 
			update_post_meta( $postidall, '_fix_info', $fixinfoInput ); 
		}
			
		if ($notedan != "") 
		{
			$onotedan = get_post_meta( $postidall, '_note_dan', true );
			//only execute if it changed
			if ($onotedan == $notedan){ /* do nothing */ } 
			else {
			if ($notedan == "clear" || $notedan == "") { $notedan = ""; }
			$onotedan = get_post_meta( $postidall, '_note_dan', true );
			if ($onotedan != $notedan) {
			//$updatedesc = $updatedesc . "
//DAN'S NOTES:		CHANGED: " . $onotedan . " => " . $notedan; 
			update_post_meta( $postidall, '_note_dan', $notedan ); } }
		}
		
		if ($soldby != "") {
			// save old value
			$osoldby = get_post_meta( $postidall, '_soldby', true );
			if ($osoldby == "") { $osoldby = "empty"; }
			// if clear is selected, empty _soldby, flag as 1
			if ($soldby == "clear"){ $soldby = ""; } 
			update_post_meta( $postidall, '_soldby', wc_clean( $soldby ) );
			if ($soldby == "") { $soldby = "empty"; }
			$updatedesc = $updatedesc . "
SOLDBY:				CHANGED: " . $osoldby . " => " . $soldby; array_push( $tableupdate, array("SOLDBY", $osoldby, $soldby) ); 
			update_post_meta( $postidall, '_soldby', $soldby );
		}
		
		// if sold, set stock 0 and mark status private (sold), flag as 1, email admin if qty changed
		if ($action == 'sold' )
		{ 
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			$product->set_stock_quantity(0); $product->set_status('private');
			
			$updatedesc = $updatedesc . "
ACTION:				MARKED SOLD: ". $oqty . " => 0, status => private" ; array_push( $tableupdate, array("ACTION - MARKED SOLD", "", "") );
			array_push( $tableupdate, array("--- QTY", $oqty, 0) );
			array_push( $tableupdate, array("--- STATUS", "(OLD STATUS)", "PRIVATE") );
			
			if ($oqty != 0 && $oqty != "")
			{
				if ($email != "jedidiah@ccrind.com") 
				{
					//$to = array("jedidiah@ccrind.com", "adam@ccrind.com");
					$to = "jedidiah@ccrind.com";
					$subject = "SOLD CCR Item Forced to SOLD: OUT OF STOCK, SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Line Edit Stock Change Column SOLD\n
If item is Out of Stock and Marked Sold, please remove links for FB and LSN.
Product ID: $postidall 
Product name: " . $product->get_title() . "
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1";
					wp_mail( $to, $subject, $message ); // email alert
				} 
			}
			sold_oos_log( $email, $product ); // create note in sold oos log
		}
		// if oos, set stock to 0 and mark status as publish (published), flag as 2, email admin if qty changed
		else if ($action == 'oos') 
		{ 
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			$product->set_stock_quantity(0); $product->set_status('publish');
			
			$updatedesc = $updatedesc . "
ACTION:				MARKED OOS: ". $oqty . " => 0, status unchanged" ; array_push( $tableupdate, array("ACTION - MARKED OOS", $oqty, "0, STATUS UNCHANGED") );
		
			if ($oqty != 0 && $oqty != "")
			{
				//$to = "jedidiah@ccrind.com, adam@ccrind.com";
				$to = "jedidiah@ccrind.com";
				$subject = "OoS CCR Item Forced to OUT OF STOCK, SKU:" . $product->get_sku();
				$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Line Edit Stock Change Column OoS\n
Item: " . $product->get_name() . "
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1

*** Please remove all FB, LSN, CL ads (if it is marked as sold or has a valid Sold By code) ***";
				wp_mail( $to, $subject, $message );
				sold_oos_log( $email, $product ); // create note in sold oos log
			}
		}
		// if qty, set qty of the stock to the specified amount in the last box submitted, flag as 3
		else if ($action == 'uqty')
		{
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			// if more than 0
			if ($qty > 0) { 
				$updatedesc = $updatedesc . "
ACTION:				UPDATED QTY: " . $oqty . " => " . $qty; array_push( $tableupdate, array("ACTION - UPDATED QTY", $oqty, $qty) );
				$product->set_stock_quantity($qty); 
				$product->set_status('publish'); 
				//Set product visible: 
				$terms = array();
				wp_set_object_terms( $postidall, $terms, 'product_visibility' );
			}
			// if 0
			else { 
				$updatedesc = $updatedesc . "
ACTION:				UPDATED QTY: " . $oqty . " => " . $qty; array_push( $tableupdate, array("ACTION - UPDATED QTY", $oqty, $qty) );
				$product->set_stock_quantity($qty); 
				$product->set_status('private'); 
			} 
			
			if ($oqty != $qty && $oqty != "")
			{
				if ($qty == 0) 
				{
					if ($email != "jedidiah@ccrind.com") 
					{
						if ( $product->get_sku() !="" ) 
						{
							//$to = "jedidiah@ccrind.com, adam@ccrind.com";
							$to = "jedidiah@ccrind.com";
							$subject = "OoS CCR Item Forced to OUT OF STOCK, SKU:" . $product->get_sku();
							$message = "SKU:  " . $product->get_sku() . " stock level changed from " . $oqty . " to 0 by " . $email . "\n
In Line Edit Stock Change Column UQTY to 0
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1

*** Please remove all FB, LSN, CL ads (if it is marked as sold or has a valid Sold By code) ***";
							wp_mail( $to, $subject, $message ); // email alert
						} 
					}
					sold_oos_log( $email, $product ); // create note in sold oos log
				}
				if ($qty > 0) {
					if ($email != "jedidiah@ccrind.com") {
						if ( $product->get_sku() !="" ) {
					$to = "jedidiah@ccrind.com";
					$subject = "QTY changed CCR Item SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level changed from " . $oqty . " to " . $qty  . " by " . $email . "\n
In Line Edit Stock Change Column UQTY > 0";
		
					wp_mail( $to, $subject, $message ); } } }// close if $qty > 0
			}
		}
		
		if ($clear){ // clear links

		$fbmp = get_post_meta( $postidall, '_fbmp', true );
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$ccl = get_post_meta( $postidall, '_cl', true );
		$ebc = get_post_meta( $postidall, '_ebayclass', true );
		
		// if link starts with http cut to ttp, and update meta
		if ($fbmp[0] == 'h') { $fbmp = substr($fbmp, 1); update_post_meta( $postidall, '_fbmp', wc_clean( $fbmp ) ); }
		// if lsn account starts with lsn or ccrind, cut lsn and ccr out, and update meta
		if ($lsn[0] == 'l' ||  $lsn[0] == 'c' ) { $lsn = substr($lsn, 3); update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) ); $lsnupdate = 1; }
		// if link starts with http cut to ttp, and update meta
		if ($ccl[0] == 'h') { $ccl = substr($ccl, 1); update_post_meta( $postidall, '_cl', wc_clean( $ccl ) ); }
		// if link starts with http cut to ttp, and update meta
		if ($ebc[0] == 'h') { $ebc = substr($ebc, 1); update_post_meta( $postidall, '_ebayclass', wc_clean( $ebc ) ); }
			
			$updatedesc = $updatedesc . "
ACTION:				CLEARED LINKS"; array_push( $tableupdate, array("ACTION - CLEARED LINKS", "" , "") );
			
		}

		if ($restore){
			
		$fbmp = get_post_meta( $postidall, '_fbmp', true );
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$lsnlink = get_post_meta( $postidall, '_lsnlink', true );
		$ccl = get_post_meta( $postidall, '_cl', true );
		$ebc = get_post_meta( $postidall, '_ebayclass', true );
	
		// if the link is ttp, make it http
		if ($fbmp != "" && $fbmp[0] == 't'){ $fbmp = "h" . $fbmp; }
		// if the account starts with i or any number add ccr or lsn to it
		if ($lsn != "")
		{
			if ($lsn[0] == 'i'){ $lsn = "ccr" . $lsn; }
			else { $lsn = "lsn" . $lsn; }
			$lsnupdate = 1;
		}
		else if ($lsn == "" && $lsnlink != "") {
			$lsn = "lsn";
			$lsnupdate = 1;
		}
		// if the link is ttp, make it http
		if ($ccl != "" && $ccl[0] == 't') { $ccl = "h" . $ccl; }
		// if the link is ttp, make it http
		if ($ebc != "" && $ebc[0] == 't'){ $ebc = "h" . $ebc; }
	
		update_post_meta( $postidall, '_fbmp', wc_clean( $fbmp ) );
		update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) );
		update_post_meta( $postidall, '_cl', wc_clean( $ccl ) );
		update_post_meta( $postidall, '_ebayclass', wc_clean( $ebc ) );
		
			$updatedesc = $updatedesc . "
ACTION:				RESTORED LINKS"; array_push( $tableupdate, array("ACTION - RESTORED LINKS", "" , "") );
			$lsnupdate = 1;
			
		}
		
		$product->save();
		do_action('wplister_revise_item', $postidall );
		$post = get_post($postidall);
		sd_on_product_save( $postidall, $post, true );		
					
			// removed $cpriceflag 
			if ( $priceflag == 1 || $spriceflag == 1 || $condflag == 1 ) 
			{
				$subject = "";
				// removed $cpriceflag 
				if ( $priceflag == 1 || $spriceflag == 1 ) { $subject = $subject . "PRICE  "; }
				if ( $condflag == 1 ) { $subject = $subject . "CONDITION  "; }
				$subject = $subject . "CHANGED, SKU: " . $product->get_sku();
				
				$to = "";
				if ( $email == "dan@ccrind.com" ) { $to = "jedidiah@ccrind.com"; }
				else if ( $email == "jedidiah@ccrind.com" ) { $to = "dan@ccrind.com"; }
				else if ( $email == "Adam" ) { $to = "dan@ccrind.com, jedidiah@ccrind.com"; }
				else if ( $email == "sharon@ccrind.com" ) { $to = "dan@ccrind.com, jedidiah@ccrind.com"; }
				wp_mail( $to, $subject, $updatedesc ); // email alert
				price_change_log( $email, $product, $oregprice, $regprice ); // create note in price change log
			}
			
			// track fb link changes
			if ( $fblinkadded == 1 )
			{
				if ( $email != "jedidiah@ccrind.com" ) {
					$subject = "";
					$subject = $subject . "FB Link Changed, SKU: " . $product->get_sku();
					$to = "jedidiah@ccrind.com";
				
					wp_mail( $to, $subject, $updatedesc ); 
				}
			}
		
		update_post_meta( $postidall, '_last_user', wc_clean( $lastuser ) );
		update_post_meta( $postidall, '_last_changed_field', wc_clean( "Inline edit" ) );
		update_post_meta( $postidall, '_last_change_desc', wc_clean( $updatedesc ) );
		$changeloc = "Inline Edit";
		// create text log of change
		make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
		if ($lsnupdate) { populate_lsn($postidall); }
		/*$sku = $product->get_sku();
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
" . $updatedesc . "
		
");
		fclose($file);
		
		// create update log table from existing array
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
		
		// html table product change log
		// if the file doesnt exist, format html with page title and table header cells
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/$sku.html") ) {
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","a");
			echo fwrite($file, "
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
</style>
<body>
<h2>SKU: $sku UPDATE LOG </h2>
<table>
	<tr>
		<th align='center' colspan='3'>". date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / ". $lastuser ." --- Inline Edit</th>
	</tr>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>

");
		fclose($file);
		}
		// if the file exists, only add another table of product change updates
		else {
			// open the file
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","c+");
			$found = false; // flag to verify if string is found
			$find = "</h1>";  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// once $find is found, read all the lines into the $filecontents variable
				if ($found) {
					$filecontents = $filecontents . $line;
					continue;
				}
				if ( strpos( $line, $find) !== false ) {
					$found = true;
				}
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, "
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
</style>
<body>
<h1>SKU: $sku UPDATE LOG </h1>
<div class='pl_table_title'>". date('Y-m-d    h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / <text class='pl_user$lastuser'>&nbsp;". $lastuser ."&nbsp;</text> --- Inline Edit</div>
<table>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>
<br>
$filecontents
");
		fclose($file);
		}*/
				}
				} // END OF  if ($sku != "")
		} // END OF  foreach($skus as $sku)
		} // END OF  if(is_array($skus) && $skus)
		} // END OF if ($skus != "")
		}  // end of if ($bulk) END BULK EDIT product
		
		// no bulk checked
		if (!$bulk)
		{
			$priceflag = 0;
			$spriceflag = 0;
			$cpriceflag = 0;
			$tableupdate = array();
			
		global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email; 
		$lastuser = $current_user->user_firstname;
				
		$updatedesc = "";
		$updatedesc = "
USER: " . $email . " made the following changes:" . $updatedesc;
			
		// BRAND MODEL UPDATE
		if ($brand != ""){
		$oldbrand = get_post_meta( $postidall, '_ccrind_brand', true );
		if ($brand != $oldbrand)
		{
			update_post_meta( $postidall, '_ccrind_brand', wc_clean( $brand ) );
			$updatedesc = $updatedesc . "
BRAND:				CHANGED: " . $oldbrand . " -> " . $brand;
			array_push( $tableupdate, array("BRAND", $oldbrand, $brand) );
		} }
		if ($mpn != ""){
		$oldmpn = get_post_meta( $postidall, '_ccrind_mpn', true );
		if ($mpn != $oldmpn)
		{
			update_post_meta( $postidall, '_ccrind_mpn', wc_clean( $mpn ) );
			$updatedesc = $updatedesc . "
MODEL:				CHANGED: " . $oldmpn . " -> " . $mpn;
			array_push( $tableupdate, array("MODEL", $oldmpn, $mpn) );
		} }
		if ($gsf != ""){
		$oldgsf = get_post_meta( $postidall, '_gsf_value', true );
		if ($gsf != $oldgsf)
		{
			update_post_meta( $postidall, '_gsf_value', wc_clean( $gsf ) );
			$updatedesc = $updatedesc . "
GSF:				CHANGED: " . $oldgsf . " -> " . $gsf;
			array_push( $tableupdate, array("GSF", $oldgsf, $gsf) );
		} }
		
		// PRICE COST UPDATE
		// set new price
		if ($regprice != "") { 
			$oregprice = $product->get_regular_price();
			$product->set_price($regprice); $product->set_regular_price($regprice); $priceflag = 1; 
			update_post_meta( $postidall, '_ccrind_price', wc_clean( $regprice ) );
		}
		// set new sale price, empty its value if clear or 0 are entered
		if ($saleprice != "")
		{
			$osaleprice = $product->get_sale_price();
			if ($saleprice == "clear" || $saleprice == "0" ) { $saleprice = '';	}
			$product->set_sale_price($saleprice); $spriceflag = 1;
		}
		// set new cost, empty its value if clear or 0 are entered
		if ($cost != "")
		{
			$ocost = get_post_meta( $postidall, '_cost', true );	
			if ($cost == "clear" || $cost == "0" ) { $cost = ""; }
			update_post_meta( $postidall, '_cost', wc_clean( $cost ) ); $cpriceflag = 1;
		}
		// build _last_change_desc 
		if ($priceflag) { $updatedesc = $updatedesc . "
PRICE:				CHANGED: " . $oregprice . " -> " . $regprice; array_push( $tableupdate, array("PRICE", $oregprice, $regprice) ); }
		if ($spriceflag) { $updatedesc = $updatedesc . "
SALE PRICE:			CHANGED: " . $osaleprice . " -> " . $saleprice; array_push( $tableupdate, array("SALE PRICE", $osaleprice, $saleprice) ); }
		if ($cpriceflag) { $updatedesc = $updatedesc . "
COST:				CHANGED: " . $ocost . " -> " . $cost; array_push( $tableupdate, array("COST", $ocost, $cost) ); }
		
		// LOCATION UPDATE
		if ($loc != ""){ $oloc = get_post_meta( $postidall, '_warehouse_loc', true ); update_post_meta( $postidall, '_warehouse_loc', wc_clean( $loc ) ); 
			$updatedesc = $updatedesc . "
WH LOC:				CHANGED: " . $oloc . " -> " . $loc; array_push( $tableupdate, array("WAREHOUSE LOCATION", $oloc, $loc) ); }
		
		// DIMENSIONS WEIGHT UPDATE
		if ($l != "") {
			if ($l == "clear" || $l == 0) { $l = ""; }
			$ol = get_post_meta( $postidall, '_length', true );
			update_post_meta( $postidall, '_length', wc_clean( $l ) );
			$updatedesc = $updatedesc . "
LENGTH:				CHANGED: " . $ol . " => " . $l; array_push( $tableupdate, array("LENGTH", $ol, $l) ); }
		if ($w != "") {
			if ($w == "clear" || $w == 0 ) { $w = ""; }
			$ow = get_post_meta( $postidall, '_width', true );
			update_post_meta( $postidall, '_width', wc_clean( $w ) ); 
			$updatedesc = $updatedesc . "
WIDTH:				CHANGED: " . $ow . " => " . $w; array_push( $tableupdate, array("WIDTH", $ow, $w) ); }
		if ($h != "") {
			if ($h == "clear" || $h == 0) { $h = ""; }
			$oh = get_post_meta( $postidall, '_height', true );
			update_post_meta( $postidall, '_height', wc_clean( $h ) );
			$updatedesc = $updatedesc . "
HEIGHT:				CHANGED: " . $oh ." => " . $h; array_push( $tableupdate, array("HEIGHT", $oh, $h) ); }
		if ($wgt != "") {
			if ($wgt == "clear" || $wgt == 0) { $wgt = ""; }
			$owgt = get_post_meta( $postidall, '_weight', true );
			update_post_meta( $postidall, '_weight', wc_clean( $wgt ) );
			$updatedesc = $updatedesc . "
WEIGHT:				CHANGED: " . $owgt . " => " . $wgt; array_push( $tableupdate, array("WEIGHT", $owgt, $wgt) ); }
		if ($cfee != "") {
			if ($cfee == "clear" || $cfee == 0) { $cfee = ""; }
			$ocfee = get_post_meta( $postidall, '_cratefee', true );
			update_post_meta( $postidall, '_cratefee', wc_clean( $cfee ) );
			$updatedesc = $updatedesc . "
PALLET FEE:			CHANGED: " . $ocfee . " => " . $cfee; array_push( $tableupdate, array("PALLET FEE", $ocfee, $cfee) ); }
		
		// SHIPPING INFO UPDATE
		if ($shipc != "") 
		{
			if ($shipc == "clear" || $shipc == 0 || $shipc == "0") 
				{ $shipcint = 0; }
			if ($shipc == "1" || $shipc == 1) 
				{ $shipcint = 2638; }
			if ($shipc == "2" || $shipc == 2) 
				{ $shipcint = 9156; }
			if ($shipc == "3" || $shipc == 3) 
				{ $shipcint = 9011; }
			if ($shipc == "4" || $shipc == 4) 
				{ $shipcint = 9080; }
			if ($shipc == "5" || $shipc == 5) 
				{ $shipcint = 9151; }
			if ($shipc == "6" || $shipc == 6) 
				{ $shipcint = 9152; }
			$oshipc = $product->get_shipping_class_id();
			$updatedesc = $updatedesc . "
SHIP CLASS:			CHANGED: " . $oshipc . " => " . $shipcint; array_push( $tableupdate, array("SHIP CLASS", $oshipc, $shipcint) );
			$product->set_shipping_class_id( $shipcint ); 
		}
		if ($customship != "") 
		{
			if ($customship == "clear") 
			{ 
				$customship = ""; 
			}
			$ocustomship = get_post_meta( $postidall, '_customship', true );
			$updatedesc = $updatedesc . "
CUSTOMSHIP:			CHANGED: " . $ocustomship . " => " . $customship; array_push( $tableupdate, array("CUSTOMSHIP", $ocustomship, $customship) );
			
			update_post_meta( $postidall, '_customship', wc_clean( $customship ) ); 
			// remove from ebay if customship is 4
			if ($customship == 4 || $customship == 6 ) {
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $postidall );
			do_action('wplister_end_item', $listing_id ); }
		}
		if ($customship2 != "") 
		{
			$customship = $customship2;
			if ($customship == "7" || $customship == 7) { $customship = ""; }
			$ocustomship = get_post_meta( $postidall, '_customship', true );
			$updatedesc = $updatedesc . "
CUSTOMSHIP:			CHANGED: " . $ocustomship . " => " . $customship; array_push( $tableupdate, array("CUSTOMSHIP", $ocustomship, $customship) );
			
			update_post_meta( $postidall, '_customship', wc_clean( $customship ) ); 
			// remove from ebay if customship is 4
			if ($customship == 4 || $customship == 6 ) {
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $postidall );
			do_action('wplister_end_item', $listing_id ); }
		}
		if ($freightc != "") 
		{
			if ($freightc == "clear" || $freightc == 0) 
			{ 
				$freightc = ""; 
			}
			$ofreightc = get_post_meta( $postidall, '_ltl_freight', true );
			$updatedesc = $updatedesc . "
FREIGHT CLASS:			CHANGED: " . $ofreightc ." => " . $freightc; array_push( $tableupdate, array("FREIGHT CLASS", $ofreightc, $freightc) );
			update_post_meta( $postidall, '_ltl_freight', wc_clean( $freightc ) ); 
		}
		// ship class select box update
		if ($shipcselect != "") 
		{
			if ($shipcselect == "0" || $shipcselect == 0) 
				{ $shipcint = 0; }
			if ($shipcselect == "1" || $shipcselect == 1) 
				{ $shipcint = 2638; }
			if ($shipcselect == "2" || $shipcselect == 2) 
				{ $shipcint = 9156; }
			if ($shipcselect == "3" || $shipcselect == 3) 
				{ $shipcint = 9011; }
			if ($shipcselect == "4" || $shipcselect == 4) 
				{ $shipcint = 9080; }
			if ($shipcselect == "5" || $shipcselect == 5) 
				{ $shipcint = 9151; }
			if ($shipcselect == "6" || $shipcselect == 6) 
				{ $shipcint = 9152; }
			$oshipc = $product->get_shipping_class_id();
			$updatedesc = $updatedesc . "
SHIP CLASS:			CHANGED: " . $oshipc . " => " . $shipcint; array_push( $tableupdate, array("SHIP CLASS", $oshipc, $shipcint) );
			$product->set_shipping_class_id( $shipcint ); 
		}
		
		// AUCTION UPDATE
		if ($auc != "") {
			if ($auc == "clear") { $auc = ""; }
			$oauc = get_post_meta( $postidall, '_auction', true );
			$updatedesc = $updatedesc . "
AUCTION:			CHANGED: " . $oauc . " => " . $auc; array_push( $tableupdate, array("AUCTION", $oauc, $auc) );
			update_post_meta( $postidall, '_auction', wc_clean( $auc ) ); }
		if ($aucdatein == "clear") {
			$aucdatein = "";
			$oaucdate = get_post_meta( $postidall, '_auction_date', true );
			$updatedesc = $updatedesc . "
AUCDATE INPUT:			CHANGED: " . $oaucdate . " => " . $aucdatein; array_push( $tableupdate, array("AUC DATE INPUT", $oaucdate, $aucdatein) );
			update_post_meta( $postidall, '_auction_date', wc_clean( $aucdatein ) ); }
		if ($aucdate != "") {
			$oaucdate = get_post_meta( $postidall, '_auction_date', true );
			$updatedesc = $updatedesc . "
AUCDATE:			CHANGED: " . $oaucdate . " => " . $aucdate; array_push( $tableupdate, array("AUC DATE", $oaucdate, $aucdate) );
			update_post_meta( $postidall, '_auction_date', wc_clean( $aucdate ) ); }
			
		if ($GDLot != "") { // start
			$oGDLot = get_post_meta( $postidall, '_govdeals', true );
			//only execute if it changed
			if ($oGDLot == $GDLot){ /* do nothing */ } 
			else {
			if ($GDLot == "clear" || $GDLot == "0") { $GDLot = ""; }
			$updatedesc = $updatedesc . "
GovDeals Lot#:		CHANGED: " . $oGDLot . " => " . $GDLot; $auc; array_push( $tableupdate, array("GovDeals Lot#", $oGDLot, $GDLot) );
			update_post_meta( $postidall, '_govdeals', wc_clean( $GDLot ) ); } }
		
			// update the checkbox for do not list to ebay if it changed
			$odnl = get_post_meta( $postidall, '_dnl_eBay', true );
			if ($odnl != $dnl) {
			$updatedesc = $updatedesc . "
DNL EBAY:			CHANGED: " . $odnl . " => " . $dnl; array_push( $tableupdate, array("DNL EBAY", $odnl, $dnl) );
			update_post_meta( $postidall, '_dnl_eBay', wc_clean( $dnl ) ); } 
			
			// update the checkbox for new facebook account posting
			$onewFB = get_post_meta( $postidall, '_newFB', true );
			if ($onewFB != $newFB) {
			$updatedesc = $updatedesc . "
NEW FB:				CHANGED: " . $onewFB . " => " . $newFB; array_push( $tableupdate, array("NEW FB", $onewFB, $newFB) );
			update_post_meta( $postidall, '_newFB', wc_clean( $newFB ) ); } 
		
		// CONDITION AND TESTED STATUS UPDATE
		if ($cond != "") 
		{
			$cond = strtolower($cond);
			if ($cond == "clear") { $cond = ""; }
			// translate input code to ebay code and translate ebay code for description
			if ($cond == 0 || $cond == "parts" || $cond == "forparts" || $cond == "for parts") { $cond = 7000; $condt = "For Parts"; } // For parts
			else if ($cond == 1 || $cond == "used" ) { $cond = 3000; $condt = "Used"; } // Used
			else if ($cond == 2 || $cond == "new other" ) { $cond = 1500; $condt = "New Other"; } // New Other
			else if ($cond == 3 || $cond == "new" ) { $cond = 1000; $condt = "New"; } // New
			else if ($cond == 4 || $cond == "refurbished" ) { $cond = 2500; $condt = "Seller Refurbished"; } // Seller Refurbished
			$ocond = get_post_meta( $postidall, '_ebay_condition_id', true );
			// translate $ocond for description
			if ($ocond == 7000) { $ocond = "For Parts"; } // For parts
			else if ($ocond == 3000) { $ocond = "Used"; } // Used
			else if ($ocond == 1500) { $ocond = "New Other"; } // New Other
			else if ($ocond == 1000) { $ocond = "New"; } // New
			else if ($ocond == 2500) { $ocond = "Seller Refurbished"; } // Seller Refurbished
			$updatedesc = $updatedesc . "
CONDITION:			CHANGED: " . $ocond . " => " . $condt; $auc; array_push( $tableupdate, array("CONDITION", $ocond, $condt) );
			update_post_meta( $postidall, '_ebay_condition_id', wc_clean( $cond ) ); $condflag = 1;
		}
		if ($test != "") 
		{
			$otest = get_post_meta( $postidall, '_tested', true );
			//only execute if it changed
			if ($otest != $test){
			if ($test == "clear") { $test = ""; }
			$otest = get_post_meta( $postidall, '_tested', true );
			if ($otest != $test) {
			$updatedesc = $updatedesc . "
TESTED?:			CHANGED: " . $otest . " => " . $test; $auc; array_push( $tableupdate, array("TESTED?", $otest, $test) );
			update_post_meta( $postidall, '_tested', wc_clean( $test ) ); } }
		}
		if ($addinfo != "") 
		{
			$oaddinfo = get_post_meta( $postidall, '_extra_info', true );
			//only execute if it changed
			if ($oaddinfo == $addinfo){ /* do nothing */ } 
			else {
			if ($addinfo == "clear") { $addinfo = ""; }
			if ($oaddinfo != $addinfo) {
			$updatedesc = $updatedesc . "
ADD. INFO:			CHANGED: " . $oaddinfo . " => " . $addinfo; $auc; array_push( $tableupdate, array("ADDITIONAL INFO", $oaddinfo, $addinfo) );
			update_post_meta( $postidall, '_extra_info', wc_clean( $addinfo ) ); } }
		}
		
		// LINKS AND COST UPDATE
		if ($vlink != "") { // start
			$ovlink = get_post_meta( $postidall, '_video', true );
			//only execute if it changed
			if ($ovlink == $vlink){ /* do nothing */ } 
			else {
			if ($vlink == "clear" || $vlink == "0") { $vlink = ""; }
			$updatedesc = $updatedesc . "
YTLINK:				CHANGED: " . $ovlink . " => " . $vlink; $auc; array_push( $tableupdate, array("YTLINK", $ovlink, $vlink) );
			update_post_meta( $postidall, '_video', wc_clean( $vlink ) ); } } // end
		
		if ($lsn != "") { // start
			$olsn = get_post_meta( $postidall, '_lsn', true );
			//only execute if it changed
			if ($olsn == $lsn){ /* do nothing */ } 
			else {
			if ($lsn == "clear" || $lsn == "0") { $lsn = ""; }
			$updatedesc = $updatedesc . "
LSN:				CHANGED: " . $olsn . " => " . $lsn; $auc; array_push( $tableupdate, array("LSN", $olsn, $lsn) );
			update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) ); $lsnupdate = 1;  } } // end
		
		if ($lsnlink != "") { // start
			$olsnlink = get_post_meta( $postidall, '_lsnlink', true );
			//only execute if it changed
			if ($olsnlink == $lsnlink){ /* do nothing */ } 
			else {
			if ($lsnlink == "clear" || $lsnlink == "0") { $lsnlink = ""; }
			$updatedesc = $updatedesc . "
LSNLINK:			CHANGED: " . $olsnlink . " => " . $lsnlink; array_push( $tableupdate, array("LSNLINK", $olsnlink, $lsnlink) );
			update_post_meta( $postidall, '_lsnlink', wc_clean( $lsnlink ) ); $lsnupdate = 1; } } // end
		
		if ($lsnc != "") { // start
			if ($lsnc == "clear" || $lsnc == "0") { $lsnc = ""; }
			$olsnc = get_post_meta( $postidall, '_lsn_cost', true );
			$updatedesc = $updatedesc . "
LSNCOST:			CHANGED: " . $olsnc . " => " . $lsnc; array_push( $tableupdate, array("LSN", $olsnc, $lsnc) );
			update_post_meta( $postidall, '_lsn_cost', wc_clean( $lsnc ) ); $lsnupdate = 1; } // end
		
		
		if ($fblink != "") { // start
			$ofblink = get_post_meta( $postidall, '_fbmp', true );
			//only execute if it changed
			if ($ofblink != $fblink){ 
			if ($fblink == "clear" || $fblink == "0") { $fblink = ""; }
			
			if ($fblink != "") {
				// generate fb id
				$fblink = strtolower( $fblink );
				$pos = strpos($fblink, "item/") + 5; // find where item/ is and account for its length of 5
				$fbID = substr($fblink, $pos);
				$len = strlen($fbID) - 1;
				$fbID = substr($fbID, 0, $len);
				update_post_meta( $postidall, '_fbID', wc_clean( $fbID ) );
			}
			$updatedesc = $updatedesc . "
FB:					CHANGED: " . $ofblink . " => " . $fblink; array_push( $tableupdate, array("FBMP", $ofblink, $fblink) );
			update_post_meta( $postidall, '_fbmp', wc_clean( $fblink ) );
			$fblinkadded = 1; } } // end
		
		if ($fbc != "") { // start
			if ($fbc == "clear" || $fbc == "0") { $fbc = ""; }
			$ofbc = get_post_meta( $postidall, '_fbmp_cost', true );
			$updatedesc = $updatedesc . "
FBCOST:				CHANGED: " . $ofbc . " => " . $fbc; array_push( $tableupdate, array("FBMP COST", $ofbc, $fbc) );
			update_post_meta( $postidall, '_fbmp_cost', wc_clean( $fbc ) ); } // end
		
		if ($cllink != "") { // start
			$ocllink = get_post_meta( $postidall, '_cl', true );
			//only execute if it changed
			if ($ocllink == $cllink){ /* do nothing */ } 
			else {
			if ($cllink == "clear" || $cllink == "0") { $cllink = ""; }
			$updatedesc = $updatedesc . "
CL:					CHANGED: " . $ocllink . " => " . $cllink; array_push( $tableupdate, array("CL", $ocllink, $cllink) );
			update_post_meta( $postidall, '_cl', wc_clean( $cllink ) ); } } // end
		
		if ($clc != "") { // start
			if ($clc == "clear" || $clc == "0") { $clc = ""; }
			$oclc = get_post_meta( $postidall, '_cl_cost', true );
			$updatedesc = $updatedesc . "
CLCOST:				CHANGED: " . $oclc . " => " . $clc; array_push( $tableupdate, array("CLCOST", $oclc, $clc) );
			update_post_meta( $postidall, '_cl_cost', wc_clean( $clc ) ); } // end
		
		if ($ebclink != "") { // start
			$oebclink = get_post_meta( $postidall, '_ebayclass', true );
			//only execute if it changed
			if ($oebclink == $ebclink){ /* do nothing */ } 
			else {
			if ($ebclink == "clear" || $ebclink == "0") { $ebclink = ""; }
			$updatedesc = $updatedesc . "
eBayC:				CHANGED: " . $oebclink . " => " . $ebclink; array_push( $tableupdate, array("eBayC", $oebclink, $ebclink) );
			update_post_meta( $postidall, '_ebayclass', wc_clean( $ebclink ) ); } } // end
		
		if ($ebcc != "") { // start
			if ($ebcc == "clear" || $ebcc == "0") { $ebcc = ""; }
			$oebcc = get_post_meta( $postidall, '_ebayclass_cost', true );
			$updatedesc = $updatedesc . "
eBayCCOST:			CHANGED: " . $oebcc . " => " . $ebcc; array_push( $tableupdate, array("eBayCCOST", $oebcc, $ebcc) );
			update_post_meta( $postidall, '_ebayclass_cost', wc_clean( $ebcc ) ); } // end
		
		if ($tslink != "") { // start
			$otslink = get_post_meta( $postidall, '_threesixty', true );
			//only execute if it changed
			if ($otslink == $tslink){ /* do nothing */ } 
			else {
			if ($tslink == "clear" || $tslink == "0") { $tslink = ""; }
			$updatedesc = $updatedesc . "
360LINK:			CHANGED: " . $otslink . " => " . $tslink; array_push( $tableupdate, array("360LINK", $otslink, $tslink) );
			update_post_meta( $postidall, '_threesixty', wc_clean( $tslink ) ); } } // end
			
		if ($lsnaccount != "") {
			
			if ($lsnaccount == "sort") {
				sort_lsn_table();
			}
			else {
				
			// set renew date for account in lsn log
			// format the name of the account input
			$lsnaccount = strtoupper($lsnaccount);
			if ( substr( $lsnaccount, 0, 1 ) == "C") { $lsnaccount = strtolower($lsnaccount); }
			// format the date input
			//$lsnrenewdate = $lsnrenewdate->format('m-d-y');
			$find = "renewDate $lsnaccount'>"; // look for that number in the table
			$find2 = "renewDateS $lsnaccount'>"; // look for that number in the table
			$find3 = "renewDateR $lsnaccount'>"; // look for that number in the table
			$reading = fopen("../library/LSN/LSN.html", "r"); // read file
			$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
			$replaced = false; // flag
			// interpret if renew date has the year
			if ($lsnrenewdate != "") {
				$parts = explode("/", $lsnrenewdate);
				if ($parts[02] == "") { $lsnrenewdate = $lsnrenewdate . "/23"; } }
			// read through the entire file
			while ( !feof($reading)) {
				$line = fgets($reading); // line by line
				if ( strpos($line, $find) || strpos($line, $find2) || strpos($line, $find3)) { 
					if ($lsnrenewdate == ""){
						$newline = "	<th class='renewDate $lsnaccount'>$lsnrenewdate</th>"; // empty cell
					}
					else {
						$newline = "	<th class='renewDateS $lsnaccount'>$lsnrenewdate</th>"; // empty cell
					}
					$line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } // flag true and replace with empty cell code
				else { fwrite($writing, $line); } // write each line from read file to write file 
			}
			fclose($reading); fclose($writing); // close both working files
			// if a line was replaced during the above loop, overwrite the read file with the written file
			if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
			// if a line was NOT replaced, delete the unrequired write temporary file
			else { unlink("../library/LSN/LSN.tmp.html"); }
			lsn_scheduled_event();
			
			}
		}
			
		if ($keyterms != "") 
		{
			$okeyterms = get_post_meta( $postidall, '_key_terms', true );
			//only execute if it changed
			if ($okeyterms == $keyterms){ /* do nothing */ } 
			else {
			if ($keyterms == "clear" ) { $keytermsInput = ""; }
			else { $keytermsInput = $keyterms; }
			$updatedesc = $updatedesc . "
KEYWORD TERMS:		CHANGED: " . $okeyterms . " => " . $keytermsInput; array_push( $tableupdate, array("KEYWORD TERMS", $okeyterms, $keytermsInput) ); 
			update_post_meta( $postidall, '_key_terms', $keytermsInput ); }
		}
		
		if ($fixinfo != "") 
		{
			$ofixinfo = get_post_meta( $postidall, '_fix_info', true );
			//only execute if it changed
			if ($ofixinfo == $fixinfo){ /* do nothing */ } 
			else {
			//$fixinfo = strtolower($fixinfo);
			if ($fixinfo == "clear" || $fixinfo == "") { $fixinfo = ""; }
			$ofixinfo = get_post_meta( $postidall, '_fix_info', true );
			if ($ofixinfo != $fixinfo) {
			$updatedesc = $updatedesc . "
FIXING INFO:		CHANGED: " . $ofixinfo . " => " . $fixinfo; array_push( $tableupdate, array("FIXING INFO", $ofixinfo, $fixinfo) );
			update_post_meta( $postidall, '_fix_info', $fixinfo ); } }
		}
			
		if ($notedan != "") 
		{
			$onotedan = get_post_meta( $postidall, '_note_dan', true );
			//only execute if it changed
			if ($onotedan == $notedan){ /* do nothing */ } 
			else {
			if ($notedan == "clear" || $notedan == "") { $notedan = ""; }
			$onotedan = get_post_meta( $postidall, '_note_dan', true );
			if ($onotedan != $notedan) {
			//$updatedesc = $updatedesc . "
//DAN'S NOTES:		CHANGED: " . $onotedan . " => " . $notedan; 
			update_post_meta( $postidall, '_note_dan', $notedan ); } }
		}
		
		if ($soldby != "") {
			// save old value
			$osoldby = get_post_meta( $postidall, '_soldby', true );
			if ($osoldby == "") { $osoldby = "empty"; }
			// if clear is selected, empty _soldby, flag as 1
			if ($soldby == "clear"){ $soldby = ""; } 
			update_post_meta( $postidall, '_soldby', wc_clean( $soldby ) );
			if ($soldby == "") { $soldby = "empty"; }
			$updatedesc = $updatedesc . "
SOLDBY:				CHANGED: " . $osoldby . " => " . $soldby; array_push( $tableupdate, array("SOLDBY", $osoldby, $soldby) ); 
			update_post_meta( $postidall, '_soldby', $soldby );
		}
		
		global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email; 
		$lastuser = $current_user->user_firstname;
		
		// if sold, set stock 0 and mark status private (sold), flag as 1, email admin if qty changed
		if ($action == 'sold' )
		{ 
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			$product->set_stock_quantity(0); $product->set_status('private');
			
			$updatedesc = $updatedesc . "
ACTION:				MARKED SOLD: ". $oqty . " => 0, status => private" ; array_push( $tableupdate, array("ACTION - MARKED SOLD", "", "") );
			array_push( $tableupdate, array("--- QTY", $oqty, 0) );
			array_push( $tableupdate, array("--- STATUS", "(OLD STATUS)", "PRIVATE") );
			
			if ($oqty != 0 && $oqty != "")
			{
				if ($email != "jedidiah@ccrind.com") 
				{
					//$to = array("jedidiah@ccrind.com", "adam@ccrind.com");
					$to = "jedidiah@ccrind.com";
					$subject = "SOLD CCR Item Forced to SOLD: OUT OF STOCK, SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Line Edit Stock Change Column SOLD\n
If item is Out of Stock and Marked Sold, please remove links for FB and LSN.
Product ID: $postidall 
Product name: " . $product->get_title() . "
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1";
					wp_mail( $to, $subject, $message ); // email alert
				} 
			}
			sold_oos_log( $email, $product ); // create note in sold oos log
		}
		// if oos, set stock to 0 and mark status as publish (published), flag as 2, email admin if qty changed
		else if ($action == 'oos') 
		{ 
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			$product->set_stock_quantity(0); $product->set_status('publish');
			
			$updatedesc = $updatedesc . "
ACTION:				MARKED OOS: ". $oqty . " => 0, status unchanged" ; array_push( $tableupdate, array("ACTION - MARKED OOS", $oqty, "0, STATUS UNCHANGED") );
		
			if ($oqty != 0 && $oqty != "")
			{
				//$to = "jedidiah@ccrind.com, adam@ccrind.com";
				$to = "jedidiah@ccrind.com";
				$subject = "OoS CCR Item Forced to OUT OF STOCK, SKU:" . $product->get_sku();
				$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Line Edit Stock Change Column OoS\n
Item: " . $product->get_name() . "
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1

*** Please remove all FB, LSN, CL ads (if it is marked as sold or has a valid Sold By code) ***";
				wp_mail( $to, $subject, $message );
				sold_oos_log( $email, $product ); // create note in sold oos log
			}
		}
		// if qty, set qty of the stock to the specified amount in the last box submitted, flag as 3
		else if ($action == 'uqty')
		{
			// save old values
			$oldstatus = $product->get_status(); $oqty = $product->get_stock_quantity();
			// if more than 0
			if ($qty > 0) { 
				$updatedesc = $updatedesc . "
ACTION:				UPDATED QTY: " . $oqty . " => " . $qty; array_push( $tableupdate, array("ACTION - UPDATED QTY", $oqty, $qty) );
				$product->set_stock_quantity($qty); 
				$product->set_status('publish'); 
			}
			// if 0
			else { 
				$updatedesc = $updatedesc . "
ACTION:				UPDATED QTY: " . $oqty . " => " . $qty; array_push( $tableupdate, array("ACTION - UPDATED QTY", $oqty, $qty) );
				$product->set_stock_quantity($qty); 
				$product->set_status('private'); 
			} 
			
			if ($oqty != $qty && $oqty != "")
			{
				if ($qty == 0) 
				{
					if ($email != "jedidiah@ccrind.com") 
					{
						if ( $product->get_sku() !="" ) 
						{
							//$to = "jedidiah@ccrind.com, adam@ccrind.com";
							$to = "jedidiah@ccrind.com";
							$subject = "OoS CCR Item Forced to OUT OF STOCK, SKU:" . $product->get_sku();
							$message = "SKU:  " . $product->get_sku() . " stock level changed from " . $oqty . " to 0 by " . $email . "\n
In Line Edit Stock Change Column UQTY to 0
https://ccrind.com/wp-admin/edit.php?s=%3D" . $product->get_sku() . "&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1

*** Please remove all FB, LSN, CL ads (if it is marked as sold or has a valid Sold By code) ***";
							wp_mail( $to, $subject, $message ); // email alert
						} 
					}
					sold_oos_log( $email, $product ); // create note in sold oos log
				}
				if ($qty > 0) {
					if ($email != "jedidiah@ccrind.com") {
						if ( $product->get_sku() !="" ) {
					$to = "jedidiah@ccrind.com";
					$subject = "QTY changed CCR Item SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level changed from " . $oqty . " to " . $qty  . " by " . $email . "\n
In Line Edit Stock Change Column UQTY > 0";
		
					wp_mail( $to, $subject, $message ); } } }// close if $qty > 0
			}
		}
		
		if ($clear){

		$fbmp = get_post_meta( $postidall, '_fbmp', true );
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$ccl = get_post_meta( $postidall, '_cl', true );
		$ebc = get_post_meta( $postidall, '_ebayclass', true );
		
		// if link starts with http cut to ttp, and update meta
		if ($fbmp[0] == 'h') { $fbmp = substr($fbmp, 1); update_post_meta( $postidall, '_fbmp', wc_clean( $fbmp ) ); }
		// if lsn account starts with lsn or ccrind, cut lsn and ccr out, and update meta
		if ($lsn[0] == 'l' ||  $lsn[0] == 'c' ) { $lsn = substr($lsn, 3); update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) ); $lsnupdate = 1; }
		// if link starts with http cut to ttp, and update meta
		if ($ccl[0] == 'h') { $ccl = substr($ccl, 1); update_post_meta( $postidall, '_cl', wc_clean( $ccl ) ); }
		// if link starts with http cut to ttp, and update meta
		if ($ebc[0] == 'h') { $ebc = substr($ebc, 1); update_post_meta( $postidall, '_ebayclass', wc_clean( $ebc ) ); }
			
			$updatedesc = $updatedesc . "
ACTION:				CLEARED LINKS"; array_push( $tableupdate, array("ACTION - CLEARED LINKS", "" , "") );
			
		}

		if ($restore){
			
		$fbmp = get_post_meta( $postidall, '_fbmp', true );
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$lsnlink = get_post_meta( $postidall, '_lsnlink', true );
		$ccl = get_post_meta( $postidall, '_cl', true );
		$ebc = get_post_meta( $postidall, '_ebayclass', true );
	
		// if the link is ttp, make it http
		if ($fbmp != "" && $fbmp[0] == 't'){ $fbmp = "h" . $fbmp; }
		// if the account starts with i or any number add ccr or lsn to it
		if ($lsn != "")
		{
			if ($lsn[0] == 'i'){ $lsn = "ccr" . $lsn; }
			else { $lsn = "lsn" . $lsn; }
			$lsnupdate = 1;
		}
		else if ($lsn == "" && $lsnlink != "") {
			$lsn = "lsn";
			$lsnupdate = 1;
		}
		// if the link is ttp, make it http
		if ($ccl != "" && $ccl[0] == 't') { $ccl = "h" . $ccl; }
		// if the link is ttp, make it http
		if ($ebc != "" && $ebc[0] == 't'){ $ebc = "h" . $ebc; }
	
		update_post_meta( $postidall, '_fbmp', wc_clean( $fbmp ) );
		update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) );
		update_post_meta( $postidall, '_cl', wc_clean( $ccl ) );
		update_post_meta( $postidall, '_ebayclass', wc_clean( $ebc ) );
		
			$updatedesc = $updatedesc . "
ACTION:				RESTORED LINKS"; array_push( $tableupdate, array("ACTION - RESTORED LINKS", "" , "") );
			
		}
		
		$product->save();
		do_action('wplister_revise_item', $postidall );
		$post = get_post($postidall);
		sd_on_product_save( $postidall, $post, true );		

		if ( $product->get_sku() != "" )
		{
			//$updatedesc = "USER: " . $email . " made the following changes:" . $updatedesc;
			// removed $cpriceflag 
			if ( $priceflag == 1 || $spriceflag == 1 || $condflag == 1 ) 
			{
				$subject = "";
				// removed $cpriceflag 
				if ( $priceflag == 1 || $spriceflag == 1 ) { $subject = $subject . "PRICE  "; }
				if ( $condflag == 1 ) { $subject = $subject . "CONDITION  "; }
				$subject = $subject . "CHANGED, SKU: " . $product->get_sku();
				
				$to = "";
				if ( $email == "dan@ccrind.com" ) { $to = "jedidiah@ccrind.com"; }
				else if ( $email == "jedidiah@ccrind.com" ) { $to = "dan@ccrind.com"; }
				else if ( $email == "Adam" ) { $to = "dan@ccrind.com, jedidiah@ccrind.com"; }
				else if ( $email == "sharon@ccrind.com" ) { $to = "dan@ccrind.com, jedidiah@ccrind.com"; }
				wp_mail( $to, $subject, $updatedesc ); // email alert
				price_change_log( $email, $product, $oregprice, $regprice ); // create note in price change log
			}
			
			// track fb link changes
			if ( $fblinkadded == 1 )
			{
				if ( $email != "jedidiah@ccrind.com" ) {
					$subject = "";
					$subject = $subject . "FB Link Changed, SKU: " . $product->get_sku();
					$to = "jedidiah@ccrind.com";
				
					wp_mail( $to, $subject, $updatedesc ); 
				}
			}
		}
		
		update_post_meta( $postidall, '_last_user', wc_clean( $lastuser ) );
		update_post_meta( $postidall, '_last_changed_field', wc_clean( "Inline edit" ) );
		update_post_meta( $postidall, '_last_change_desc', wc_clean( $updatedesc ) );
		$changeloc = "Inline Edit";
		// create text log of change
		make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
		if ($lsnupdate) { populate_lsn($postidall); }
			
		/*$sku = $product->get_sku();
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
" . $updatedesc . "
		
");
		fclose($file);
		
		// create update log table from existing array
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
		
		// html table product change log
		// if the file doesnt exist, format html with page title and table header cells
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/$sku.html") ) {
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","a");
			echo fwrite($file, "
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
</style>
<body>
<h1>SKU: $sku UPDATE LOG </h1>
<h5>". date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / ". $lastuser ." --- Inline Edit</h5>
<table>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>

");
		fclose($file);
		}
		// if the file exists, only add another table of product change updates
		else {
			// open the file
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","c+");
			$found = false; // flag to verify if string is found
			$find = "</h1>";  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// once $find is found, read all the lines into the $filecontents variable
				if ($found) {
					$filecontents = $filecontents . $line;
					continue;
				}
				if ( strpos( $line, $find) !== false ) {
					$found = true;
				}
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, "
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
</style>
<body>
<h1>SKU: $sku UPDATE LOG </h1>
<div class='pl_table_title'>". date('Y-m-d    h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / <text class='pl_user$lastuser'>&nbsp;". $lastuser ."&nbsp;</text> --- Inline Edit</div>
<table>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>
<br>
$filecontents
");
		fclose($file);
		}*/
			
			if ($create_contact_log) 
			{
				// create contact log page
				update_post_meta( $postidall, '_contact_log_made', 1 );
				$sku = $product->get_sku();
				$image = wp_get_attachment_url( get_post_thumbnail_id( $postidall ), 'single-post-thumbnail' );
				$image = "<a href=\"$image\"  rel=\"noopener noreferrer\" target=\"_blank\">
				<img width=\"180\" src=\"$image\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" loading=\"lazy\"></a>";
				$name = $product->get_name();
				$askprice = $product->get_regular_price(); $saleprice = $product->get_sale_price(); if ($saleprice != "") { $askprice = $saleprice; }
				$skul = strlen($sku);
				if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
				else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
				else { $sku_2 = $sku; $sku_3 = $sku; }
				
				global $current_user;
    			wp_get_current_user();
				$lastuser = $current_user->user_firstname;
				
				// make directory for the file if it does not exist
				if ( !file_exists("../library/product-contact-logs/$sku_2/$sku_3/") ) { 
					mkdir("../library/product-contact-logs/$sku_2/$sku_3/", 0744, true); }
				
	$hiddenDIV = PHP_EOL.'<div class="specialnote" ></div>'.PHP_EOL;
	$filestart = '
<!DOCTYPE html>
<html>
<head>

<style>
	body { background-color: #000000; color: #ffffff; }
	td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
	th { background-color: #c41a02; color: #ffffff; }
	.pl_table_title { font-size: 20px; font-weight: heavy; }
	tr:nth-child(even) { background-color: #c8c8c8; color: #000000; font-weight: bold; }
	tr:nth-child(odd) { background-color: #000000; color: #ffffff; font-weight: bold; }
	#contactTABLE > tbody > tr:nth-child(even) > td > input[type=text], #clnote2, #email2 { overflow: auto; background-color: rgba(0,0,0,0.0); color: #000000 !important; border: none; font-weight: bold; font-size: 16px; font-family: Arial; }
	#contactTABLE > tbody > tr:nth-child(odd) > td > input[type=text], #clnote2, #email2 { overflow: auto; background-color: rgba(0,0,0,0.0); color: #ffffff !important; border: none; font-weight: bold; font-size: 16px; font-family: Arial; }
	tr:nth-child(even) > td > #clnote2 { color: #000000 !important; }
	tr:nth-child(odd) > td > #clnote2 { color: #ffffff !important; }
	tr:nth-child(even) > td > #email2 { color: #000000 !important; }
	tr:nth-child(odd) > td > #email2 { color: #ffffff !important; }
	textarea { width: 400px; }
	contactlog {margin-left: 50px;}
	th.date, th.name, th.phone, th.offer { width: 160px; }
	th.email { width: 300px; }
	th.note { width: 400px; }
	td.askprice { text-align: center; }
	th.removerow { width: 50px; }
	.inline { display: inline; }
	.clnotediv { margin-top: 30px; }
	button, input[type=submit] { background-color: #a08100; color: #ffffff; border-radius: 5px; }
	button:hover, input[type=submit]:hover { background-color: #fff5ca; color: #000000; border: 2px solid #a08100; }
</style>

</head>

<body>

<div style="margin-left: 50px;">
<div style="display: inline-block;"><h2>SKU: '.$sku.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button onclick="dark_Run()">Dark</button> &nbsp;&nbsp;&nbsp; <button onclick="light_Run()">Light</button></h2></div>
<table class="productContactTable">
	<tr>
		<th>Product Image</th>
    	<th>Product Name</th>
    	<th>SKU</th>
    </tr>
	<tr>
		<td>'.$image.'</td>
    	<td>'.$name.'</td>
    	<td><b>'.$sku.'</b></td>
	</tr>
	<tr>
</table>
<h3>Enter new contact data:</h3>
	<form class="contactlog" action="https://ccrind.com/wp-admin/admin.php?page=ccr-admin-menu%2Fcontactlog-admin-menu-ccr.php" method="post">
		<input type="hidden" name="productID" value="'.$postidall.'">
		<input type="hidden" name="user" value="'.$lastuser.'">
		<div><p class="inline">Name: <input style="width: 300px;" type="text" name="name" /></p>&nbsp;&nbsp;
 		<p class="inline">Phone: <input style="width: 120px;" type="text" name="phone" /></p>&nbsp;&nbsp;
 		<p class="inline">Email: <input style="width: 300px;" type="text" name="email" /></p></div>
		<div class="clnotediv"><textarea id="clnote" class="clnote" name="clnote" rows="3" title="Enter customer note here." placeholder="Enter Note Here"></textarea></div>
		<p>Offered Price: <input style="width: 200px;" type="text" name="offer" /></p>
		<p><input type="submit" /></p>
<br><br>
<h2>PRODUCT SPECIAL INFO:</h2>
		'.$hiddenDIV.'
		<div class="clnotespecialinputdiv"><textarea id="clnotespecialinput" class="clnotespecialinput" name="clnotespecialinput" rows="3" title="Enter special info here." placeholder="Enter SPECIAL INFO Here"></textarea></div><br>
		<div><input type="submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label for="appendSI" class="appendSIboxl">Append Special Info</label>
		<input type="checkbox" id="appendSI" name="appendSI" class="appendSIbox" value="1"></div>
	</form>
<br><br>
<p>Click the buttons to sort the table.  Buttons denoted by headers with *</p>

<h2>PRODUCT CONTACT LOG:</h2>
<table id="contactTABLE">
	<tr>
		<th class="date"><button onclick="sortTableDATE()"><b>* DATE / TIME *</b></button></th>
		<th class="name"><button onclick="sortTableNAME()"><b>* NAME *</b></button></th>
		<th class="phone"><button onclick="sortTablePHONE()"><b>* PHONE *</b></button></th>
		<th class="email"><button onclick="sortTableEMAIL()"><b>* EMAIL *</b></button></th>
		<th class="offer"><button onclick="sortTableOFFER()"><b>* OFFER *</b></button></th>
		<th class="note">NOTE:</th>
		<th class="date"><button onclick="sortTableUSER()"><b>* USER *</b></button></th>
		<th class="removerow">Remove Row?</th>
		<th class="removerow">Submit Update</th>
	</tr>
	<div class="insert_here" ></div>
</table>

</div>
';
	
	$fileend = "</table>
<script>

function changeColor(bgcolor, fcolor) {
	document.body.style.background = bgcolor;
	document.body.style.color = fcolor;
}
function light_Run() {
	changeColor('#ffffff', '#000000');
}
function dark_Run() {
	changeColor('#000000', '#ffffff');
}

function sortTableDATE() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('contactTABLE');
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
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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

function sortTableNAME() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('contactTABLE');
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
      x = rows[i].getElementsByTagName('TD')[1];
      y = rows[i + 1].getElementsByTagName('TD')[1];
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

function sortTablePHONE() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('contactTABLE');
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

function sortTableEMAIL() {
  var table, rows, switching, i, x, y, shouldSwitch, a, b;
  table = document.getElementById('contactTABLE');
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
      x = rows[i].getElementsByTagName('TD')[3];
      y = rows[i + 1].getElementsByTagName('TD')[3];
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

function sortTableOFFER() {
  var table, rows, switching, i, x, y, shouldSwitch, a, b;
  table = document.getElementById('contactTABLE');
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
      x = rows[i].getElementsByTagName('TD')[4];
      y = rows[i + 1].getElementsByTagName('TD')[4];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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

function sortTableUSER() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('contactTABLE');
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
      x = rows[i].getElementsByTagName('TD')[6];
      y = rows[i + 1].getElementsByTagName('TD')[6];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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
			if ( !file_exists("../library/product-contact-logs/$sku_2/$sku_3/$sku.html") ) {
				$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
				$data = $filestart . $fileend;
				echo fwrite($file, $data);
				fclose($file);
			}
			// testing purposes only
			else {
				$file = fopen("../library/product-contact-logs/$sku_2/$sku_3/$sku.html","w");
				$data = $filestart . $fileend;
				echo fwrite($file, $data);
				fclose($file);
			}
			}
			
		} // end no bulk
		return; 
	}
	
/************************************************************************************************/
	// order all button master button to edit all aspects of an order inline order button post all, all orders admin orders, update order
	if ($orderidall != "") 
	{
		if( isset( $_POST['setEmailInput'] )) { $cEmail = $_POST['setEmailInput']; }
		if( isset( $_POST['setPhoneInput'] )) { $phone = $_POST['setPhoneInput']; }
		if( isset( $_POST['dnemailcheck'] )) { $dne = $_POST['dnemailcheck']; }
		if( isset( $_POST['gologcheck'] )) { $golog = $_POST['gologcheck']; }
		if( isset( $_POST['gologYearcheck'] )) { $gologYear = $_POST['gologYearcheck']; }
		if ($phone == "") { if( isset( $_POST['setPhoneInput2'] )) { $phone = $_POST['setPhoneInput2']; } }
		if ($phone != "") { $phone = str_replace("-", "", $phone); }
		if( isset( $_POST['addEmailInput'] )) { $addemails = $_POST['addEmailInput']; }
		if( isset( $_POST['formorderstatuschange'] )) { $statuschange = $_POST['formorderstatuschange']; }
		if( isset( $_POST['shipcostinput'] )) { 
			$shipcost = $_POST['shipcostinput'];
			$shipcost = str_replace("$", "", $shipcost); // take out leading $ if there is one
		}
		if( isset( $_POST['addressinputst'] )) { $shipst = $_POST['addressinputst']; }
		if( isset( $_POST['addressinput'] )) { $shipaddress = $_POST['addressinput']; }
		if( isset( $_POST['nameinput'] )) { 
			$name = $_POST['nameinput']; 
			$name = strtolower($name);
		}
		if( isset( $_POST['businput'] )) { $bname = $_POST['businput']; }
		if( isset( $_POST['addressinputst2'] )) { $shipst2 = $_POST['addressinputst2']; }
		if( isset( $_POST['addressinput2add'] )) { $moreaddress = $_POST['addressinput2add']; }
		if( isset( $_POST['addressinput2'] )) { $shipaddress2 = $_POST['addressinput2']; }
		if( isset( $_POST['shipaddonly'] )) { $shipaddonly = $_POST['shipaddonly']; }
		if( isset( $_POST['billaddonly'] )) { $billaddonly = $_POST['billaddonly']; }
		if( isset( $_POST['busi2add'] )) { $busi2add = $_POST['busi2add']; }
		if( isset( $_POST['addTypeInputBE'] )) { $addType = $_POST['addTypeInputBE']; }
		if( isset( $_POST['forkDockInputBE'] )) { $forkDock = $_POST['forkDockInputBE']; }
		if( isset( $_POST['dApptInputBE'] )) { $dAppt = $_POST['dApptInputBE']; }
		if( isset( $_POST['shipTypeInputBE'] )) { $shipType = $_POST['shipTypeInputBE']; }
		if( isset( $_POST['_found_byBE'] )) { $foundby = $_POST['_found_byBE']; }
		if( isset( $_POST['upscheck'] )) { $upscheck = $_POST['upscheck']; }
		if( isset( $_POST['ThirdPcheck'] )) { $ThirdPcheck = $_POST['ThirdPcheck']; }
		if( isset( $_POST['lpcheck'] )) { $lpcheck = $_POST['lpcheck']; }
		if( isset( $_POST['clearshipcheck'] )) { $clearshipcheck = $_POST['clearshipcheck']; }
		if( isset( $_POST['shipradio'] )) { 
			if ($_POST['shipradio'] == 1) { $upscheck = 1; }
			if ($_POST['shipradio'] == 2) { $ThirdPcheck = 1; }
			if ($_POST['shipradio'] == 3) { $lpcheck = 1; }
			if ($_POST['shipradio'] == 4) { $clearshipcheck = 1; }
			if ($_POST['shipradio'] == 5) { $termcheck= 1; } }
		if( isset( $_POST['clearpaycheck'] )) { $clearpaycheck = $_POST['clearpaycheck']; }
		if( isset( $_POST['trackNumInput'] )) { $ebtracknum = $_POST['trackNumInput']; }
		if( isset( $_POST['shipCostInput'] )) { $ourshipcost = $_POST['shipCostInput']; 
			$ourshipcost = str_replace("$", "", $ourshipcost); /* take out leading $ if there is one */ }
		if( isset( $_POST['carrierInput'] )) { $ebcarrier = $_POST['carrierInput']; }
		if( isset( $_POST['carrierInput2'] )) { $ebcarrier2 = $_POST['carrierInput2']; }
		$ebdate = $_POST['shipDateInput'];
		$ebfb = $_POST['feedbackInput'];
		$cashcheck = $_POST['cashcheck'];
		$checkcheck = $_POST['checkcheck'];
		$wirecheck = $_POST['wirecheck'];
		$payradio = $_POST["payradio"];
		if ($payradio == 1) { $cashcheck = 1; }
		if ($payradio == 2) { $checkcheck = 1; }
		if ($payradio == 3) { $wirecheck = 1; }
		$taxe = $_POST['taxexempt'];
		$taxeX = $_POST['taxexemptx'];
		$taxradio = $_POST["taxradio"];
		if ($taxradio == 1) { $taxe = 1; }
		if ($taxradio == 2) { $taxeX = 1; }
		$ebmsent = $_POST['addebaymsg'];
		$noteadded = $_POST['noteinput'];
		$makeCN = $_POST['customer_note_check'];
		$sendinvcheck = $_POST['sendinvcheck'];
		$sendinvwire = $_POST['sendinvwire'];
		$sendwireinfo = $_POST['sendwireinfo']; 
		$sendfollowup = $_POST['sendfollowup']; 
		$saSubmitted = $_POST['sa_checkboxinput']; 
		$saSigned = $_POST['sa_signed_checkboxinput']; 
		$terminalD = $_POST['terminalBE']; 
		$terminalZ = $_POST['terminal_zipBE']; 
		$term = get_post_meta( $orderidall, 'terminal_delivery', true );
		$shipquote = $_POST['_CCR_ship_costBE'];
		$shipquote = str_replace("$", "", $shipquote); // take out leading $ if there is one
		$l = $_POST['_length_inputBE']; 
		$w = $_POST['_width_inputBE']; 
		$h = $_POST['_height_inputBE']; 
		$lbs = $_POST['_weight_inputBE'];
		$pf = $_POST['_pallet_feeBE'];
		$address = array();
		$no = "";
		
		global $current_user;
    	wp_get_current_user();
		$lastuser = $current_user->user_firstname;
		$note = "";
		$paypalpaid = 0;
		$lineH = 1;

		$order    = wc_get_order( $orderidall );
		$status   = $order->get_status();
		$method   = $order->get_payment_method();
		$allitems = (array) $order->get_items();
		$items    = (array) $order->get_items('shipping');
		$feeitems = (array) $order->get_items('fee');
		
		$saCB = get_post_meta( $orderidall, 'sa_checkbox', true );
		$sasCB = get_post_meta( $orderidall, 'sa_signed_checkbox', true );
		$dneCB = get_post_meta( $orderidall, '_dnemail', true );

		// if SA Made / Submitted is checked
		if ($saSubmitted) {
			if ( $saCB ) { /* do nothing */ }
			else {
				update_post_meta( $orderidall, 'sa_checkbox', wc_clean( $saSubmitted ) ); $date = date("m-d-y"); update_post_meta( $orderidall, 'sa_made_date', wc_clean( $date ) );
				strtoupper($status); 
				$note = __("Sales Agreement MADE, marked by $lastuser, status left as $status");
				$order->add_order_note( $note );
				$to = email_order_update(); $subject = "Sales Agreement MADE for order: " . $orderidall . " by $lastuser";
				$msg2 = "Sales Agreement MADE for order: " . $orderidall . " by $lastuser"; $no = 1;
				wp_mail( $to, $subject, $msg2); generate_order_log($order, $orderidall); }
		}
		else { // clear SA MADE check and date
			if ( $saCB ) { update_post_meta( $orderidall, 'sa_checkbox', wc_clean( null ) ); update_post_meta( $orderidall, 'sa_made_date', wc_clean( null ) ); generate_order_log($order, $orderidall); } }
		
		// if SA Signed is checked
		if ($saSigned) {
			if ( $sasCB ) { /* do nothing */ }
			else {
				update_post_meta( $orderidall, 'sa_signed_checkbox', wc_clean( $saSigned ) ); $date = date("m-d-y"); update_post_meta( $orderidall, 'sa_signed_date', wc_clean( $date ) );
				$note = __("Sales Agreement SIGNED, marked by $lastuser, status left as $status");
				$order->add_order_note( $note );
				$to = email_order_update(); $subject = "Sales Agreement marked as SIGNED for order: " . $orderidall . " by $lastuser";
				$msg2 = "Sales Agreement marked as SIGNED for order: " . $orderidall . " by $lastuser"; $no = 1;
				wp_mail( $to, $subject, $msg2); generate_order_log($order, $orderidall); }
		}
		else { // clear SA SIGNED check and date
			if ( $sasCB ) { update_post_meta( $orderidall, 'sa_signed_checkbox', wc_clean( null ) ); update_post_meta( $orderidall, 'sa_signed_date', wc_clean( null ) ); generate_order_log($order, $orderidall); } }
		
		// flag to make sure we do not email customer during monthing email list
		if ($dne) {
			if ( $dneCB ) { /* do nothing */ }
			else {
				update_post_meta( $orderidall, '_dnemail', wc_clean( $dne ) );
				$note = __("Marked Do NOT Email, marked by $lastuser, status left as $status");
				$order->add_order_note( $note );
				$to = email_order_update(); $subject = "Marked Do NOT Email for order: " . $orderidall . " by $lastuser";
				$msg2 = "Marked Do NOT Email for order: " . $orderidall . " by $lastuser"; $no = 1;
				wp_mail( $to, $subject, $msg2); }
		}
		else { // clear DNE check a
			if ( $dneCB ) { update_post_meta( $orderidall, '_dnemail', wc_clean( null ) ); generate_order_log($order, $orderidall); } }
		// if generate order log is checked, run function
		if ($golog) { 
			// get date of order creation but change to date paid if possible
			$date = $order->get_date_created(); $date_converted = $date->format('m-d-y'); $month = $orderM = date("m",strtotime($date)); $year = date("Y",strtotime($date));
			$status   = $order->get_status();
			$paymethod = $order->get_payment_method();
			if ($paymethod == "Other" || $paymethod == "other") { $tid = $order->get_transaction_id(); $paymethod = $tid; }
			else if ($paymethod == "quickbookspay") { $paymethod = "Credit Card"; }
			else if ($paymethod == "paypal" || $paymethod === 'angelleye_ppcp') { $paymethod = "PayPal"; }
			else if ($paymethod == "stripe") { $paymethod = "Credit Card"; }
			else if ($paymethod == "CreditCard") { $paymethod = "eBay (CC)"; }
			else if ($paymethod == "cod") { $paymethod = ""; }
			if ($paymethod != ""  ) {
				$paydate_o = $order->get_date_paid(); 
				if ($paydate_o != "") { 
					$paydate = $paydate_o->format('m-d-Y'); 
					if ($status == "cancelled") { $styleflag = 'C'; }
					else { $styleflag = 'P';/* P for paid */  }
					$month = $paidM = substr($paydate, 0, 2); $paidY = date("Y",strtotime($paydate));
            		if ($paidY >= $year) { $savedY = $year; $year = $paidY; }
				}
			}
			
			//$to = "jed@ccrind.com"; $subject = "DEBUG1: generate order log check, " . $orderidall . " - $lastuser";
			//$msg2 = "DEBUG1: generate order log check" . $orderidall . " - $lastuser - Year: $year - PaidY: $paidY - SavedY: $savedY - OMonth: $orderM - PaidM: $paidM"; $no = 1;
			//wp_mail( $to, $subject, $msg2);
			
			$qbo_total = $_POST['inputQBOtotal'];
			$qbo_countc = $_POST['inputQBOcount'];
			$qbo_shipprofit = $_POST['inputQBOsp'];
			if ($qbo_total != "") {
				if ($qbo_total == "clear") { $qbo_total = $qbo_countc = $qbo_shipprofit = ""; }
				$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
				update_user_meta( $userID, "qbo_total$month", sanitize_text_field( $qbo_total ) );
				update_user_meta( $userID, "qbo_countc$month", sanitize_text_field( $qbo_countc ) );
				update_user_meta( $userID, "qbo_shipprofit$month", sanitize_text_field( $qbo_shipprofit ) ); }
			generate_order_log($order, $orderidall); 
			
			//$to = "jed@ccrind.com"; $subject = "DEBUG2: generate order log check, " . $orderidall . " - $lastuser";
			//$msg2 = "DEBUG2: generate order log check" . $orderidall . " - $lastuser - Year: $year - PaidY: $paidY - SavedY: $savedY - OMonth: $orderM - PaidM: $paidM"; $no = 1;
			//wp_mail( $to, $subject, $msg2);
		}
		if ($gologYear) {
			generate_order_logYEAR();
		}
		if ($sendinvcheck)
		{
			$salesrecord = "";
			$salesrecord = establish_if_ebay($orderidall);
			// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
			$order->set_status('pending'); update_post_meta( $orderidall, '_status_sort', wc_clean( 3 ) ); generate_order_log($order, $orderidall); // change status to pending payment
			update_post_meta( $orderidall, '_sent_invoice', wc_clean( date("y-m-d") ) );
			update_post_meta( $orderidall, '_saved_status', wc_clean( "pending" ) );
			$order->save();
			foreach ( $order->get_items() as $item_id => $item ) {
   				$product = $item->get_product();
				if (isset($product))
				{
					$id = $product->get_id();
   					$quantity = $item->get_quantity();
					$stock = $product->get_stock_quantity();
					if ($stock < 1){ $product->set_status('private'); } else { $product->set_status('published'); }
					if ($salesrecord == "") // ccrind order
					{ update_post_meta( $id, '_soldby', wc_clean( "wso" ) ); }
					else // ebay order
					{ update_post_meta( $id, '_soldby', wc_clean( "ebayo" ) ); }
					$product->save();
				}
			}
			$note = __("INVOICE SENT, status change ON HOLD to PENDING, updated by $lastuser");
			$order->add_order_note( $note );
			//$order->save();
			$note = "";

			// send email
			if ($salesrecord == "") // ccrind order
			{
				$msg2 = "WS on-hold Invoice sent for order C" . $orderidall;
				$subject = "WS on-hold Invoice sent for order C" . $orderidall;
			}
			else // ebay order
			{
				$msg2 = "eBay on-hold Invoice sent for order " . $salesrecord . " ID: " . $orderidall;
				$subject = "eBay on-hold Invoice sent for order " . $salesrecord;
			}
			$to = email_order_update();
			wp_mail( $to, $subject, $msg2);
			
			$wc_email = WC()->mailer()->get_emails()['WC_Email_Customer_Invoice'];
			$wc_email->trigger( $orderidall );
		}
		if ($sendfollowup)
		{
			update_post_meta( $orderidall, '_sent_followup', wc_clean( date("y-m-d") ) );
			// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
			// send email
			$paylink = $order->get_checkout_payment_url();
			$billing_first_name = $order->get_billing_first_name();
			$billing_last_name  = $order->get_billing_last_name();
			if ($billing_first_name == "") { $billing_first_name = "Valued"; $billing_last_name = "Customer"; }
			$msg2 = "<img src=\"https://ccrind.com/wp-content/uploads/2022/07/ccrind2022logoAlphaResizeWhiteRoundSmall.png\" alt=\"logo_img\" /><br>
<br>
<br>
<p style='font-family: Helvetica,Roboto,Arial,sans-serif; font-size: 14px; color: #5c5c5c; line-height: 150%;'>$billing_first_name $billing_last_name,<br>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We wanted to follow up with you on your potential purchase.  You should have received an email with a link to allow you to pay for your order.  If you are having problems or never received the email, please let us know how we can help.  If you have decided to cancel the order, please let us know.  If you have already spoken with one of our agents, please disregard this message. Thank you and have a great day.<br>
<br>
<br>
Also, if you are unable to find the email you can also pay at:<br><br>
<a href=\"$paylink\">Pay for your order by clicking this link</a> <br> </p>";
			$to = $order->get_billing_email();
			$subject = "ccrind.com Order: " . $orderidall;
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to, $subject, $msg2, $headers);
			
			strtoupper($status);
			$note = __("FOLLOW UP EMAIL SENT, status left as $status, updated by $lastuser");
			$order->add_order_note( $note );
			//$order->save();
			$note = "";
		}
		if ($sendinvwire) 
		{
			// check for email
			if ($order->get_billing_email() != "") 
			{
				// WIRE or CASH only invoice email code
				$fnameBill = $order->get_billing_first_name();
				$lnameBill = $order->get_billing_last_name();
				if ($fnameBill == "")
				{
					$saved_bill = get_post_meta( $orderidall, '_saved_billing', true );
					$billname = "Valued Customer";
				}
				else { $billname = $fnameBill . " " . $lnameBill; }
				$msg2 = "$billname,<br>
<br>
Your order, ($orderidall), contains an item that requires a CASH or WIRE TRANSFER payment ONLY.  You should receive an additional email with a detailed invoice for further information regarding the item(s).<br>  
<br>
You will receive another separate email with details regarding WIRE TRANSFER payment should you decide to pay by wire, or you can call us at:<br>
(931) 563-4704<br>
or email us at:<br>
sales@ccrind.com<br>
to discuss scheduling a CASH payment.<br>
<br>
Thank you for your business.<br>
<br>
CCR IND LLC";
				$subject = "ccrind.com Wire Only Item Order: " . $orderidall;
				$headers = array('Content-Type: text/html; charset=UTF-8');
				wp_mail( $order->get_billing_email(), $subject, $msg2, $headers);
			
				strtoupper($status);
				$note = __("WIRE ONLY EMAIL SENT, status left as $status, updated by $lastuser");
				$order->add_order_note( $note );
				$wc_email = WC()->mailer()->get_emails()['WC_Email_Customer_Invoice'];
				$wc_email->trigger( $orderidall );
				$no = 1;
				
				// send email
				if ($salesrecord == "") // ccrind order
				{
					$msg2 = "Wire Only: WS on-hold Invoice sent for order C" . $orderidall;
					$subject = "Wire Only: WS on-hold Invoice sent for order C" . $orderidall;
				}
				else // ebay order
				{
					$msg2 = "Wire Only: eBay on-hold Invoice sent for order " . $salesrecord . " ID: " . $orderidall;
					$subject = "Wire Only: eBay on-hold Invoice sent for order " . $salesrecord;
				}
				$to = email_order_update();
				$to = $to . ",sales@ccrind.com"; wp_mail( $to, $subject, $msg2); // send email to self
				update_post_meta( $orderidall, '_sent_wireinv', wc_clean( date("y-m-d") ) );
			} 
		}
		if ($sendwireinfo)
		{
			// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
			// send email
			$msg2 = "<pre><h4 style=\"font-size:20px\">CCR Industrial Sales</h4>
<h4 style=\"font-size:20px\">CCR IND LLC</h4>
<h4 style=\"font-size:20px\">ACH/WIRE INSTRUCTIONS</h4>
<u><strong>* Domestic Incoming Wire Instructions *</strong></u>
Wire to Bank:          
			FirstBank
			Nashville TN
Bank ABA #:    
			084307033
Beneficiary Name:       
			CCR IND LLC
Beneficiary Address:     
			400 Main Street
			Huntland, TN 37345
Beneficiary Account #:
			88412507	

<u><strong>* International Incoming Wire Instructions *</strong></u>
If the sending bank <u>does not</u> require a swift code & has a correspondent bank in the US send funds to:
Wire to Bank:          
			FirstBank
			Nashville TN
Bank ABA #:    
			084307033
Beneficiary Name:       
			CCR IND LLC
Beneficiary Address:     
			400 Main Street
			Huntland, TN 37345
Beneficiary Account #:
			88412507	
			

The below instructions are only to be used if the Sending Intl Bank requires a swift code to send the funds to us and <u>does not</u> have a correspondent bank in the US:
Wire to Bank:          
			First Horizon Bank
			165 Madison Ave
			Memphis, TN
SWIFT code:
			FTBMUS44
Beneficiary Name:       
			FirstBank
			211 Commerce St Ste 300
			Nashville TN 37201
Beneficiary Account #:
			21873
For Further Credit to:
			CCR IND LLC
			400 Main Street
			Huntland TN 37345
			Account # 88412507
			
The \"For Futher Credit Information\" should be placed in Payment Details field, Remittance Information (field 70) or Send to Rec Info field (field 72)

</pre>";
			$to = $order->get_billing_email();
			$subject = "ccrind.com Wire Transfer Instructions for Order: " . $orderidall;
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to, $subject, $msg2, $headers);
			update_post_meta( $orderidall, '_sent_wireinfo', wc_clean( date("y-m-d") ) );
			
			strtoupper($status);
			$note = __("WIRE INFO SENT, status left as $status, updated by $lastuser");
			$order->add_order_note( $note );
			$no = 1;
		}
		
		// set new shipping saved address ONLY use flag to see if name only
		$nameonly = true;
		if ($shipaddress2 != "") 
		{
			$namearr = explode(" ", $name);
			$fname = $namearr[0]; 
			$fname = ucwords($fname);
			$size = sizeof($namearr); // getting number to start loop
			$start = 1;
			while ( $start < $size ) { 
			$lname = $lname . " " . $namearr[$start]; 
			$start = $start + 1; }
			$lname = ucwords($lname);
			$shipst2 = strtolower($shipst2);
			$shipst2 = ucwords($shipst2);
			$adarr = explode(",", $shipaddress2);
			$city2 = $adarr[0];
				$city2 = strtolower($city2);
				$city2 = ucwords($city2);
				$save = $adarr[1];
				$save = ucwords($save);
				$adarr2 = preg_split('/\s+/', $save);
				$state2 = $adarr2[1];
				$state2 = strtoupper($state2);
				$postcode2 = $adarr2[2];
					
			$address = array(
				'first_name' => $fname,
				'last_name' => $lname,
				'company' => $bname,
				'country' => 'US',
				'address_1'  => $shipst2,
            	'address_2'  => '', 
            	'city'       => $city2,
            	'state'      => $state2,
            	'postcode'   => $postcode2
        	);
			
			if ($moreaddress != "") {
				$address = array(
				'first_name' => $fname,
				'last_name' => $lname,
				'company' => $bname,
				'country' => 'US',
				'address_1'  => $shipst2,
            	'address_2'  => $moreaddress, 
            	'city'       => $city2,
            	'state'      => $state2,
            	'postcode'   => $postcode2
        		);
			}
			
			if ($shipaddonly) {
				update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				$order->set_address( $address, 'shipping' );
			}
			else if ($billaddonly ) {
				update_post_meta( $orderidall, '_saved_billing', wc_clean( $address ) );
				$order->set_address( $address, 'billing' );
			}
			else {
				update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				update_post_meta( $orderidall, '_saved_billing', wc_clean( $address ) );
				$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
			}
			$order->calculate_totals(); 
			$nameonly = false;
			// set phone too if possible
			if ($phone != "") {
				$order->set_billing_phone($phone); 
				update_post_meta( $orderidall, '_saved_phone', wc_clean( $phone ) ); 
				$note = __("Address / Phone Input, updated by $lastuser"); }
			else { $note = __("Address Input, updated by $lastuser"); }
			$order->add_order_note( $note );
			$order->save();
			generate_order_log($order, $orderidall);
		}
		else if ( ($name != "") && $nameonly ) // set name only
		{
			$namearr = explode(" ", $name);
			$fname = $namearr[0]; 
			$fname = ucwords($fname);
			$size = sizeof($namearr); // getting number to start loop
			$start = 1;
			while ( $start < $size ) { 
			$lname = $lname . " " . $namearr[$start]; 
			$start = $start + 1; }
			$lname = ucwords($lname);
			
			$address = array(
				'first_name' => $fname,
				'last_name' => $lname
        	);
			
			if ($shipaddonly) {
				update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				$order->set_address( $address, 'shipping' );
			}
			else if ($billaddonly ) {
				update_post_meta( $orderidall, '_saved_billing', wc_clean( $address ) );
				$order->set_address( $address, 'billing' );
			}
			else {
				update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				update_post_meta( $orderidall, '_saved_billing', wc_clean( $address ) );
				$order->set_address( $address, 'shipping' );
				$order->set_address( $address, 'billing' );
			}
			$note = __("Address Input: name only, updated by $lastuser");
			$order->add_order_note( $note );
			$order->save();
			generate_order_log($order, $orderidall);
		}
		else if ($shipaddress != "") 
		{
			$adarr = explode(",", $shipaddress);
			$shipst = ucwords($shipst);
			$city = $adarr[0];
			$city = ucwords($city);
			$save = $adarr[1];
			$save = ucwords($save);
			$adarr = preg_split('/\s+/', $save);
			$state = $adarr2[1];
			$state = strtoupper($state);
			$postcode = $adarr2[2];
					
			$address = array(
				'country' => 'US',
				'address_1'  => $shipst,
            	'address_2'  => '', 
            	'city'       => $city,
            	'state'      => $state,
            	'postcode'   => $postcode
        	);
					
			$order->set_address( $address, 'shipping' );
			update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
			$order->calculate_totals(); 
			$note = __("Address Input, updated by $lastuser");
			$order->add_order_note( $note );
			$order->save();
			generate_order_log($order, $orderidall);
		}
		// update address shipping info if select boxes are set
		else if ($addType || $forkDock || $shipType || $foundby || $l || $w || $h || $lbs || $pf != "" || $shipquote || ($terminalD != ""  && $terminalD != $term) || $terminalZ != "" )
		{
			if ($addType) { update_post_meta( $orderidall, 'address_type', sanitize_text_field( $addType ) ); $list = $list . "Addr. Type: $addType, "; }
			if ($forkDock) { update_post_meta( $orderidall, 'unload_type', sanitize_text_field( $forkDock ) ); $list = $list . "Fork / Dock? $forkDock, "; } 
			if ($shipType) { update_post_meta( $orderidall, 'ship_type', sanitize_text_field( $shipType ) ); $list = $list . "Ship Type $shipType, "; }
			if ($foundby) { update_post_meta( $orderidall, '_found_by', sanitize_text_field( $foundby ) ); $list = $list . "Found by $foundby, "; }
			if ($terminalD != ""  && $terminalD != $term) { update_post_meta( $orderidall, 'terminal_delivery', sanitize_text_field( $terminalD ) ); $list = $list . "Terminal Delivery: $terminalD, "; }
			if ($terminalZ) { update_post_meta( $orderidall, 'terminal_zip', sanitize_text_field( $terminalZ ) ); $list = $list . "Terminal Zip: $terminalZ, "; }
			if ($l) { update_post_meta( $orderidall, 'shipq_length', sanitize_text_field( $l ) ); $list = $list . "QL: $l, "; }
			if ($w) { update_post_meta( $orderidall, 'shipq_width', sanitize_text_field( $w ) ); $list = $list . "QW: $w, "; }
			if ($h) { update_post_meta( $orderidall, 'shipq_height', sanitize_text_field( $h ) ); $list = $list . "QW: $h, "; }
			if ($lbs) { update_post_meta( $orderidall, 'shipq_weight', sanitize_text_field( $lbs ) ); $list = $list . "QLBS: $lbs, "; }
			if ($pf != "") { update_post_meta( $orderidall, 'shipq_pallet_fee', sanitize_text_field( $pf ) ); $list = $list . "Pallet $: $pf, "; }
			if ($shipquote != "" ) {
				if ($pf == "") { $pf = get_post_meta( $orderidall, 'shipq_pallet_fee', true ); }
				update_post_meta( $orderidall, 'shipq_CCRcost', sanitize_text_field( $shipquote ) ); $list = $list . "CCR $: $shipquote, ";
				$quoted_cost = ( $shipquote * 1.25 ) + $pf; $quoted_cost = number_format((float) $quoted_cost, 2, '.', '' ); 
				update_post_meta( $orderidall, 'shipq_price', sanitize_text_field( $quoted_cost ) ); $list = $list . "Quoted Customer $: $$quoted_cost";
			}
			generate_ship_quote_log($order, $orderidall);
			generate_order_log($order, $orderidall);
			$note = __("Address Ship / Found / Quote Info Input: $list updated by $lastuser");
			$order->add_order_note( $note );
		}
		else if ($clearpaycheck)
		{
			foreach ( $feeitems as $item_id => $feeitem ) {
				$fee_name = $feeitem->get_name();
				$fee_name = strtolower($fee_name);
				if (strpos( $fee_name, "credit") ) { $order->remove_item( $item_id ); }
			} 
			$order->set_payment_method('');
			$order->save();
		}
		else if ($cEmail != "") { $order->set_billing_email($cEmail); $order->save();}
		else if ($phone != "") 
		{ 
			$order->set_billing_phone($phone); 
			update_post_meta( $orderidall, '_saved_phone', wc_clean( $phone ) );
			$note = __("Phone Input, updated by $lastuser");
			$order->add_order_note( $note );
			$order->save();		   
		}
		else if ($addemails != "")
		{
			if ($addemails == "clear") { $addemails = "" ; }
			else {
				$add_emails = get_post_meta( $orderidall, '_add_emails', true );
				if ($add_emails != "") { $addemails = $add_emails . ", " . $addemails; }
			}
			update_post_meta( $orderidall, '_add_emails',  wc_clean( $addemails ) );
		}
		else if ($statuschange)
		{
			if ($statuschange == "pending") { $order->set_status('pending'); update_post_meta( $orderidall, '_status_sort', wc_clean( 3 ) ); // change status to pending payment
				update_post_meta( $orderidall, '_saved_status', wc_clean( "pending" ) ); 
				$order->save();
				generate_order_log($order, $orderidall);
			}
			if ($statuschange == "processing") { $order->set_status('processing'); update_post_meta( $orderidall, '_status_sort', wc_clean( 2 ) ); // change status to processing
				update_post_meta( $orderidall, '_saved_status', wc_clean( "processing" ) );
				$order->save();
				generate_order_log($order, $orderidall);
			}
			if ($statuschange == "on-hold") { $order->set_status('on-hold'); update_post_meta( $orderidall, '_status_sort', wc_clean( 1 ) ); // change status to on-hold
				update_post_meta( $orderidall, '_saved_status', wc_clean( "on-hold" ) );
				//update_post_meta( $orderidall, '_lock_status', 1 );
				$order->save();
				generate_order_log($order, $orderidall);
			}
			if ($statuschange == "completed") { $order->set_status('completed'); update_post_meta( $orderidall, '_status_sort', wc_clean( null ) ); // change status to completed
				update_post_meta( $orderidall, '_saved_status', wc_clean( "completed" ) );
				$order->save();
				generate_order_log($order, $orderidall);
			}
			if ($statuschange == "cancelled") { $order->set_status('cancelled'); update_post_meta( $orderidall, '_status_sort', wc_clean( null ) ); // change status to cancelled
				update_post_meta( $orderidall, '_saved_status', wc_clean( "cancelled" ) );
				$order->save();
				generate_order_log($order, $orderidall);
			}
			if ($statuschange == "refunded") { $order->set_status('refunded');  update_post_meta( $orderidall, '_status_sort', wc_clean( null ) ); // change status to refunded
				update_post_meta( $orderidall, '_saved_status', wc_clean( "refunded" ) );
				$order->save();
				generate_order_log($order, $orderidall);
			}
			
			$status = strtoupper($status); $statuschange = strtoupper($statuschange);
			$note = __("ORDER STATUS CHANGED, status change $status to $statuschange, updated by $lastuser");
			$order->add_order_note( $note );
		}
		else if ($ebtracknum != "") 
		{
			$ebtracknum = str_replace("-", "", $ebtracknum);
			$salesrecord = "";
			$salesrecord = establish_if_ebay($orderidall);
			if ($ebcarrier == "" && $ebcarrier2 == "") { $ebcarrier = "Freightquote.com"; }
			if ($salesrecord != "") // if ebay order
			{
				if ($ebdate == "") { $date = date("Y-m-d"); }
				else { $date = $ebdate; }
				if ($ebfb == "") { $fb = "Thank you for your business."; }
				else { $fb = $ebfb; }
				
				// mark order as shipped on eBay
				$args = array();
				$args['TrackingNumber']  = $ebtracknum;
				if ($ebcarrier != "") { $args['TrackingCarrier'] = $ebcarrier; }
				else { $args['TrackingCarrier'] = $ebcarrier2; }
				$args['ShippedTime']     = $date;     // optional
				$args['FeedbackText']    = $fb;   // optional
				do_action( 'wple_complete_sale_on_ebay', $orderidall, $args );
			}
			update_post_meta( $orderidall, '_ccr_ship_cost',  $ourshipcost );
			if ($ebcarrier == "clear") { $ebcarrier = ""; }
			update_post_meta( $orderidall, '_bst_tracking_provider', $ebcarrier );
			if ( $ebcarrier2 != "" ) 
			{ 
				if ($ebcarrier2 == "clear") { $ebcarrier2 = ""; }
				update_post_meta( $orderidall, '_bst_tracking_provider', $ebcarrier2 ); 
			}
			if ($ebtracknum == "clear") { $ebtracknum = ""; }
			update_post_meta( $orderidall, '_bst_tracking_number',  $ebtracknum );
			$date = date("m-d-y"); update_post_meta( $orderidall, '_ccr_ship_date',  $date );
				
				$status = strtoupper($status);
				$note = __("TRACKING INFO / SHIP COST ENTERED by $lastuser, Ship Cost: $ourshipcost, Carrier: $ebcarrier, Num: $ebtracknum, status changed from $status to COMPLETED");
				$order->add_order_note( $note );
				if ($ebtracknum != "clear") {
					$order->set_status('completed'); update_post_meta( $orderidall, '_status_sort', wc_clean( null ) ); generate_order_log($order, $orderidall);
				}
				$order->save();
			
				$firstitem = true;
				foreach ( $items as $item ) { 
					if ($firstitem) { 
						$ship_title = $item->get_method_title(); 
						$firstitem = false; 
					} 
				}
				// send email
				$msg2 = "TRACKING INFO ENTERED for Order: C" . $orderidall . " by $lastuser, Ship Type: $ship_title, Carrier: $ebcarrier, Num: $ebtracknum, status changed from $status to COMPLETED";
				$to = "jedidiah@ccrind.com, sales@ccrind.com";
				$subject = "Tracking Info Entered for Order: C" . $orderidall;
				wp_mail( $to, $subject, $msg2);
				if ($ourshipcost != "") {
				$msg2 = "SHIP COST for Order: C" . $orderidall . " by $lastuser";
				$to = "jedidiah@ccrind.com, sales@ccrind.com";
				$subject = "SHIP COST Entered for Order: C" . $orderidall;
				wp_mail( $to, $subject, $msg2); }
				
				if ( $ebcarrier2 == "" ){ 
					if ( $ebcarrier == "") {
						/* do nothing */ 
					}
					else { // send the tracking email
						global $wpdb; // this is how you get access to the database
                		$mailer = WC()->mailer();
                		$mails = $mailer->get_emails();
                		if ( ! empty( $mails ) ) {
                   			foreach ( $mails as $mail ) {
                        		if ( $mail->id == 'BST_Tracking_Order_Email' ) { $result = $mail->trigger( $orderidall ); } } }
					}
				}
				else { // send the tracking email
					global $wpdb; // this is how you get access to the database
                	$mailer = WC()->mailer();
                	$mails = $mailer->get_emails();
                	if ( ! empty( $mails ) ) {
                   		foreach ( $mails as $mail ) {
                        	if ( $mail->id == 'BST_Tracking_Order_Email' ) { $result = $mail->trigger( $orderidall ); } } }
				}
				
		}
		else if ($ebtracknum == "" && $ourshipcost != "") 
		{
			update_post_meta( $orderidall, '_ccr_ship_cost',  $ourshipcost );
			$status = strtoupper($status);
			$note = __("SHIP COST ENTERED by $lastuser, Ship Cost: $ourshipcost, status unchanged: $status");
			$order->add_order_note( $note );
			$msg2 = "SHIP COST for Order: C" . $orderidall . " by $lastuser";
				$to = "jedidiah@ccrind.com, sales@ccrind.com";
				$subject = "SHIP COST Entered for Order: C" . $orderidall;
				wp_mail( $to, $subject, $msg2);
		}
		else if ($noteadded) 
		{
			if ($makeCN)
			{
				global $current_user;
    			wp_get_current_user();
				$email = $current_user->user_email; 
				$lastuser = $current_user->user_firstname;
				date_default_timezone_set("America/Chicago");
				
				$currentNote = get_post_meta( $orderidall, '_ccr_customer_note', true );
				//$currentNote = $order->get_customer_note();
				if ($noteadded == "clear" || $noteadded == "0") { $order->set_customer_note( "" ); 
					update_post_meta( $orderidall, '_ccr_customer_note', "" ); $order->save(); }
				else if ($currentNote != "") { 
					if ( $lastuser == "Jedidiah" ) { 
					$lastuser = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Sharon') { 
					$lastuser = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Lamar' ) { 
					$lastuser = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Brian' ) { 
					$lastuser = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
					
					$noteadded = $noteadded . "<br>
" . date("m-d-y h:i") . " - " . $lastuser;
					$setNote = $noteadded  . "<br>
<br>
" . $currentNote; /*$order->set_customer_note( $setNote );*/ 
					update_post_meta( $orderidall, '_ccr_customer_note', $setNote ); $order->save(); }
				else {
					if ( $lastuser == "Jedidiah" ) { 
					$lastuser = "<text style='color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Jedidiah</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Sharon') { 
					$lastuser = "<text style='color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Sharon</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Lamar' ) { 
					$lastuser = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Lamar</strong> &nbsp;</text>"; }
					else if ( $lastuser == 'Brian' ) { 
					$lastuser = "<text style='color: #2c812b; background-color: #d5ffd5; border-radius: 10px; padding: 2px;'>&nbsp; <strong>Brian</strong> &nbsp;</text>"; }
					$noteadded = $noteadded . "<br>
" . date("m-d-y h:i") . " - " . $lastuser;
					/*$order->set_customer_note($noteadded);*/ 
					update_post_meta( $orderidall, '_ccr_customer_note', $noteadded ); $order->save(); }
			}
			else { $note = __("$noteadded, note added by $lastuser"); $order->add_order_note( $note ); }
		}
		else { // execute order updates
		// if the order is an invoice submission and is processing, mark it as "On Hold", upate the shipping method title, and empty out the payment method ("Invoice"), prep for shipping addition
		if ($method == "cod")
		{
			if ($status == "processing")
			{
				$order->set_status('on-hold'); update_post_meta( $orderidall, '_status_sort', wc_clean( 1 ) ); generate_order_log($order, $orderidall);
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
					else {$order->remove_item( $item_id ); }
    			}
				$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				//if( $product != "")
				//{
					$qty = $product->get_stock_quantity();
					if ($qty == 0)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						$tableupdate = array();
						$osb = get_post_meta( $id, '_soldby', true );
						update_post_meta( $id, '_soldby', wc_clean( "wso" ) ); 
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: $osb => wso";
						$updatedesc = $msg. "
		
";
						array_push( $tableupdate, array("MARKED PENDING", "(OLD STATUS)", "PRIVATE (SOLD)") ); 
						array_push( $tableupdate, array("SOLD BY", $osb, "wso") );
						$product->set_status('private'); 
						$product->save(); 
						$changeloc = "Order Change Edit (Auto)";
						make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
						
						// create text log of change
			/*$skul = strlen($sku);
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
 				$note = __("NEW ORDER set to ON HOLD, prepped for shipping addition by $lastuser");
			}
			update_post_meta( $orderidall, '_saved_status', wc_clean( "on-hold" ) );
		}
		// if the order is an ebay submission and is pending, empty out the payment method ("None"), prep for shipping addition
		$salesrecord = "";
		$salesrecord = establish_if_ebay($orderidall);
		if ($salesrecord != "") {
		if ($method == "None" || $method == "CashOnPickup" || $method == "CCAccepted" || $method == "Other" || $method == "other" || $method == "" )
		{
			if ($status == "pending" && $upscheck == "" && $ThirdPcheck == "" && $termcheck == "" && $cashcheck == "" && $checkcheck == "" && $wirecheck == "" && $taxe == "" && $ebmsent == "" )
			{
				$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$product = wc_get_product($item->get_product_id());
				//if( $product != "")
				//{
					$qty = $product->get_stock_quantity();
					if ($qty == 0)
					{
						$sku = $product->get_sku();
						$id = $product->get_id();
						$tableupdate = array();
						$osb = get_post_meta( $id, '_soldby', true );
						update_post_meta( $id, '_soldby', wc_clean( "ebayo" ) ); 
						$msg = "Order Change Triggered Product Status Change:
MARKED PENDING:		 CHANGED: Old Status => Private (Sold)
SOLD BY:			 CHANGED: old soldby => ebayo";
						array_push( $tableupdate, array("MARKED PENDING", "(OLD STATUS)", "PRIVATE (SOLD)") ); 
						array_push( $tableupdate, array("SOLD BY", $osb, "ebayo") );
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
				// wipe SIS with blank
				$transaction_id = get_post_meta($orderidall, '_transaction_id', true);
				if ($transaction_id == "SIS" ) { update_post_meta( $orderidall, '_transaction_id', wc_clean( "" ) ); }
				
				$order->set_payment_method('');
 				$note = __("NEW ORDER changed from PENDING to ON HOLD, prepped for shipping addition by $lastuser");
				update_post_meta( $orderidall, '_saved_status', wc_clean( 'on-hold' ) );
				$order->set_status('on-hold'); update_post_meta( $orderidall, '_status_sort', wc_clean( 1 ) ); generate_order_log($order, $orderidall); // change status to on-hold
 				//$order->save();
			}
		}
		}
		// if the order has been prepped for shipping cost input (empty payment method and status is on-hold)
		if ($method == "")
		{
			if ($status == "on-hold")
			{
				$removefee = false;
				$local = false;
				if ( $shipcost != "" || $lpcheck || $ThirdPcheck || $termcheck || $upscheck ) {
					
				$firstitem = true;
				if ( empty($items) ) 
				{
					$item = new WC_Order_Item_Shipping();
					if ($lpcheck) { $item->set_method_title( __("Local Pickup") ); $local = true; update_post_meta( $orderidall, 'ship_type', sanitize_text_field( "Local Pickup" ) ); }
					else { 
						if ($upscheck) { $item->set_method_title( __("UPS") ); }
						else if ($ThirdPcheck) { $item->set_method_title( __("3rd Party Freight") ); $local = true; }
						else if ($termcheck) { $item->set_method_title( __("Freight Shipping (Terminal)") ); }
						else { $item->set_method_title( __("Freight Shipping") ); }
					}
					if ($shipcost != "") { 
						if ($ThirdPcheck) { 
							// Get a new instance of the WC_Order_Item_Fee Object
							$item_fee = new WC_Order_Item_Fee();
							$item_fee->set_name( "Pallet Fee" ); // Generic fee name
							$item_fee->set_amount( $shipcost ); // Fee amount
							$item_fee->set_tax_class( '' ); // default for ''
							$item_fee->set_tax_status( 'taxable' ); // or 'none'
							$item_fee->set_total( $shipcost ); // Fee amount
							$order->add_item( $item_fee );
							$item->set_total( 0 );
						}
						else { 
							$item->set_total( $shipcost ); 
							$removefee = true;
						}
					} 
					$order->add_item( $item );
					$item->save();
				}
				else {
				foreach ( $items as $item ) {
					if ($firstitem) {
					if ($lpcheck) { $item->set_method_title( __("Local Pickup") ); $local = true; update_post_meta( $orderidall, 'ship_type', sanitize_text_field( "Local Pickup" ) ); }
					else { 
						if ($upscheck) { $item->set_method_title( __("UPS") ); }
						else if ($ThirdPcheck) { $item->set_method_title( __("3rd Party Freight") ); $local = true; }
						else if ($termcheck) { $item->set_method_title( __("Freight Shipping (Terminal)") ); }
						else { $item->set_method_title( __("Freight Shipping") ); }
					}
					if ($shipcost != "") { 
						if ($ThirdPcheck) { 
							// Get a new instance of the WC_Order_Item_Fee Object
							$item_fee = new WC_Order_Item_Fee();
							$item_fee->set_name( "Pallet Fee" ); // Generic fee name
							$item_fee->set_amount( $shipcost ); // Fee amount
							$item_fee->set_tax_class( '' ); // default for ''
							$item_fee->set_tax_status( 'taxable' ); // or 'none'
							$item_fee->set_total( $shipcost ); // Fee amount
							$order->add_item( $item_fee );
							$item->set_total( 0 );
						}
						else { 
							$item->set_total( $shipcost ); 
							$removefee = true;
						}
					} 
					$firstitem = false; 
					$item->save();}
				} }
				
				if ($removefee) {
					foreach ( $feeitems as $item_id => $feeitem ) {
						$fee_name = $feeitem->get_name();
						$fee_name = strtolower($fee_name);
						if (strpos( $fee_name, "pallet") ) { $order->remove_item( $item_id ); }
					} 
				}
				
				// Get the customer ship info
				if ($local) 
				{ 
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
				}
					
				// if data was input into the addressinput textarea		
				if (isset($shipaddress))
				{
					$adarr = explode(",", $shipaddress);
					$city2 = $adarr[0];
					$save = $adarr[1];
					$adarr2 = preg_split('/\s+/', $save);
					$state2 = $adarr2[1];
					$postcode2 = $adarr2[2];
					
					$address = array(
						'country' => 'US',
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city2,
            			'state'      => $state2,
            			'postcode'   => $postcode2
        			);
					
					$order->set_address( $address, 'shipping' );
					update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				}
					
				$city = $order->get_shipping_city();
				$state = $order->get_shipping_state();
				$postcode = $order->get_shipping_postcode();
				$country = $order->get_shipping_country();
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				);

				$order->calculate_totals();  // get new total
				$newTotal = $order->get_total();
				
				/* check for CC fee already there, if it is remove it
				foreach ( $feeitems as $item_id => $feeitem ) {
					$fee_name = $feeitem->get_name();
					$fee_name = strtolower($fee_name);
					if (strpos( $fee_name, "usage fee") ) { $order->remove_item( $item_id ); }
				}*/
				// add CC fee to order
				// Get a new instance of the WC_Order_Item_Fee Object 
				//$item_fee = new WC_Order_Item_Fee();
				// set the name of the fee
				/*$item_fee->set_name( "3% CREDIT CARD USAGE FEE (not charged if PayPal is used)" );
				$ccFee = 0.03 * $newTotal;  // calculate 3% of the current total
				$item_fee->set_amount( $ccFee ); 
				$item_fee->set_tax_class( '' ); 
				$item_fee->set_tax_status( 'taxable' ); 
				if ($taxe) { $item_fee->set_tax_class('zero-rate'); }
				if ($taxeX) { $item_fee->set_tax_class(''); }
				$item_fee->set_total( $ccFee );
				// Calculating Fee taxes
				$item_fee->calculate_taxes( $calculate_tax_for );
					
				// Add Fee item to the order
				$order->add_item( $item_fee );
				$order->calculate_totals(); */
				
				// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
				//update_post_meta( $orderidall, '_EBkeeponhold', wc_clean( 'pending' ) );
				//$order->set_status('pending'); update_post_meta( $orderidall, '_status_sort', wc_clean( 3 ) ); generate_order_log($order, $orderidall); // change status to pending payment
					
				// wipe SIS with blank
				$transaction_id = get_post_meta($orderidall, '_transaction_id', true);
				if ($transaction_id == "SIS" ) {
					$saved_id = get_post_meta( $orderidall, '_saved_ebay_transaction_id', true );
					update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) );
					
					// send email
					$msg2 = "SIS found " . $orderidall . " wiped SIS and saved: " . $saved_id;
					$to = "jedidiah@ccrind.com";
					$subject = "eBay Transaction ID Updated: " . $salesrecord;
					wp_mail( $to, $subject, $msg2);
				}
					
				// handle tax exempt check box to remove taxes
				if ( $taxe )
				{
					foreach ( $allitems as $item ) 
					{
						$item->set_tax_class('zero-rate');
						$city = '';
						$state = '';
						$postcode = '';
						$country = '';
						// Set the array for tax calculations
						$calculate_tax_for = array(
    						'country' => $country, 
    						'state' => $state, 
    						'postcode' => $postcode, 
    						'city' => $city
						);
						$item->calculate_taxes( $calculate_tax_for );
						$order->calculate_totals();
					}
				}
				if ( $taxeX )
				{
					foreach ( $allitems as $item ) 
					{
						$item->set_tax_class('');
						$city = '';
						$state = '';
						$postcode = '';
						$country = '';
						// Set the array for tax calculations
						$calculate_tax_for = array(
    						'country' => $country, 
    						'state' => $state, 
    						'postcode' => $postcode, 
    						'city' => $city
						);
						$item->calculate_taxes( $calculate_tax_for );
						$order->calculate_totals();
					}
				}
				
				// establish if order is ebay
				$salesrecord = "";
				$salesrecord = establish_if_ebay($orderidall);
					
					// send email
					/*if ($salesrecord == ""){ $msg2 = "WS on-hold Invoice sent for order C" . $orderidall;}
					else { $msg2 = "WS on-hold Invoice sent for order C" . $orderidall . " eBay order: " . $salesrecord; }
					$to = "jedidiah@ccrind.com";
					$subject = "Order shipping added, order: C" . $orderidall;
					wp_mail( $to, $subject, $msg2);*/
					
					$note = __("UPDATED, shipping, CC fee, taxes updated, status kept ON HOLD, updated by $lastuser");
					//$order->add_order_note( $note );
					//$order->save();
					
					//$wc_email = WC()->mailer()->get_emails()['WC_Email_Customer_Invoice'];
					//$wc_email->trigger( $orderidall );
				}
				if ( $clearshipcheck ) {
					//$order->remove_all_fees();
					foreach( $order->get_items('fee') as $item_id => $item_fee ) {
						$order->remove_item($item_id); }
					$items = (array) $order->get_items('shipping');
					foreach ( $items as $item ) {
						$item->set_method_title( __("Freight Shipping") ); $item->save(); }
					$order->calculate_totals(); }
			}
		}
		
		// if the payment has been submitted by the customer 
		if ($status == "on-hold" || $status == "pending")
		{
			// and payment method is credit card
			$tid = $order->get_transaction_id();
			if ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay") && $tid !== "" )
			{
				$order_shipping_total = $order->get_total_shipping();
				// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
				update_post_meta( $orderidall, '_saved_status', wc_clean( 'processing' ) );
				$order->set_status('processing'); update_post_meta( $orderidall, '_status_sort', wc_clean( 2 ) ); generate_order_log($order, $orderidall);
				//$order->save();
 				$note = __("CC PAYMENT CAPTURED, status change ON HOLD to PROCESSING by $lastuser");
				$msg2 = "Order Updated: " . $orderidall . " ON-HOLD";
				$to = email_order_update();
				$subject = "ONHOLD Order Marked Paid: " . $orderidall . " through Credit Card";
				wp_mail( $to, $subject, $msg2);
				
				// mark sold by code
				$salesrecord = "";
				$salesrecord = establish_if_ebay($orderidall);
				
			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$id = $item->get_product_id();
				$product = wc_get_product($id);
				//if( $product != "")
				//{
					$qty = $product->get_stock_quantity();
					if ($qty == 0)
					{
						mark_soldby_make_log($product, $salesrecord);
					}
					else { $product->set_status('published'); $product->save(); }
				//}
			}
				
			}
			// and payment method is paypal, attempt to remove credit card fee if exists
			if ( $method == "paypal" && $tid !== "" )
			{
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
				if ($local) 
				{ 
					$address = array(
						'country' => 'US',
						'company' => 'CCR IND LLC',
            			'address_1'  => '411 E Carroll St',
            			'address_2'  => '', 
            			'city'       => 'Tullahoma',
            			'state'      => 'TN',
            			'postcode'   => '37388',
        			);
        			$order->set_address( $address, 'shipping' );
					update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
					$order->calculate_totals(); 
					//$order->save();
				}
				
				foreach ( $feeitems as $item_id => $feeitem ) {
					$fee_name = $feeitem->get_name();
					$fee_name = strtolower($fee_name);
					if (strpos( $fee_name, "usage fee") ) { $order->remove_item( $item_id ); }
				}
				$order->calculate_totals();
				// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
				update_post_meta( $orderidall, '_saved_status', wc_clean( "processing" ) ); 
				$note = __("PP not CAPTURED, hit Processing button (...) to capture PayPal, status kept ON HOLD by $lastuser");
				$order->update_status('on-hold', $note, 1);
				$order->set_status('on-hold'); update_post_meta( $orderidall, '_status_sort', wc_clean( 1 ) ); generate_order_log($order, $orderidall);
				//$order->save();
				$paypalpaid = 1;
				$msg2 = "Order Updated: " . $orderidall . " ON-HOLD";
				$to = email_order_update();
				$subject = "ONHOLD Order Marked Paid: " . $orderidall . " through PayPal";
				wp_mail( $to, $subject, $msg2);
				
				// mark sold by code
				$salesrecord = "";
				$salesrecord = establish_if_ebay($orderidall);
				
			$items_first = $order->get_items();
			foreach( $items_first as $item )
			{
				$id = $item->get_product_id();
				$product = wc_get_product( $id );
				$qty = $product->get_stock_quantity();
				if ($qty == 0) { mark_soldby_make_log($product, $salesrecord); }
				else { $product->set_status('published'); $product->save(); }
			}	
				
			}
			if ($method == "" || $method =="Other" || $method =="other" || ( $method == "paypal" && $tid == "" ) || ( ($method == "intuit_payments_credit_card" || $method == "quickbookspay") && $tid == "" ) )
			{
				if ($cashcheck || $checkcheck || $wirecheck)
				{
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
					if ($local) 
					{ 
						$address = array(
						'country' => 'US',
						'company' => 'CCR IND LLC',
            			'address_1'  => '411 E Carroll St',
            			'address_2'  => '', 
            			'city'       => 'Tullahoma',
            			'state'      => 'TN',
            			'postcode'   => '37388',
        				);
        				$order->set_address( $address, 'shipping' );
						update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
						$order->calculate_totals(); 
						//$order->save();
					}
					
					foreach ( $feeitems as $item_id => $feeitem ) {
						$fee_name = $feeitem->get_name();
						$fee_name = strtolower($fee_name);
						if (strpos( $fee_name, "usage fee") ) { $order->remove_item( $item_id ); }
						$order->calculate_totals();
					}
					
					// used for ws and ebay redirection as well (ebay will come in as pending but be blank, ws will come in as processing but be blank
					update_post_meta( $orderidall, '_saved_status', wc_clean( "processing" ) ); 
					$order->set_status('processing'); update_post_meta( $orderidall, '_status_sort', wc_clean( 2 ) ); generate_order_log($order, $orderidall);
					$order->set_payment_method('Other');
					if ($cashcheck) { update_post_meta( $orderidall, '_transaction_id', wc_clean( 'Cash' ) ); update_post_meta( $orderidall, '_cashcheck', wc_clean( 'Cash' ) ); $note = __("CASH PAYMENT CAPTURED, status change ON HOLD to PROCESSING by $lastuser"); $paidby = "Cash"; }
					if ($checkcheck) { update_post_meta( $orderidall, '_transaction_id', wc_clean( 'Check' ) ); update_post_meta( $orderidall, '_cashcheck', wc_clean( 'Check' ) ); $note = __("CHECK PAYMENT CAPTURED, status change ON HOLD to PROCESSING by $lastuser"); $paidby = "Check"; }
					if ($wirecheck) { update_post_meta( $orderidall, '_transaction_id', wc_clean( 'Wire' ) ); update_post_meta( $orderidall, '_cashcheck', wc_clean( 'Wire' ) ); $note = __("WIRE PAYMENT CAPTURED, status change ON HOLD to PROCESSING by $lastuser"); $paidby = "Wire"; }
					$msg2 = "Order Updated: " . $orderidall . " ON-HOLD";
					$to = email_order_update();
					$subject = "ONHOLD Order Marked Paid: " . $orderidall . " through: ". $paidby;
					wp_mail( $to, $subject, $msg2);
					//$order->save();
					
					// mark sold by code
					$salesrecord = "";
					$salesrecord = establish_if_ebay($orderidall);
					
					//$items_first = $order->get_items();
					// bookmark wire
					//foreach( $order->get_items() as $items_id => $item )
					//{
					$items = $order->get_items();
					foreach( $items as $item )
					{
						$id = $item->get_product_id();
						$product = wc_get_product($id);
						if( $product != "")
						{
							$qty = get_post_meta( $id, '_stock', true );
							if ( $qty == 0 || $qty == 1 )
							{
								mark_soldby_make_log($product, $salesrecord);
							}
							else { $product->set_status('published'); $product->save(); }
						}
					}
					generate_order_log($order, $orderidall);
					$order->save();
				}
			}
			
			// email with payment method name
			$tid = $order->get_transaction_id();
			if ( ($method == "intuit_payments_credit_card" || $method == "paypal" || $method == "quickbookspay") && $tid !== "" ) 
			{
				if ($method == "intuit_payments_credit_card" || $method == "quickbookspay") { $pay = "Credit Card"; }
				else { $pay = "PayPal"; }
				$to = email_order_update();
				$subject = "ORDER Marked Paid: " . $orderidall . " through " . $pay;
				$msg = "ORDER Updated: " . $orderidall . " ON-HOLD marked paid through " . $pay . ", Transaction ID: " . $tid;
				//wp_mail( $to, $subject, $msg);
				
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
				if ($local) 
				{ 
					$address = array(
						'country' => 'US',
						'company' => 'CCR IND LLC',
            			'address_1'  => '411 E Carroll St',
            			'address_2'  => '', 
            			'city'       => 'Tullahoma',
            			'state'      => 'TN',
            			'postcode'   => '37388',
        			);
        			$order->set_address( $address, 'shipping' );
					update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
					$order->calculate_totals(); 
					//$order->save();
				}
			}
			//$order->save();
		}
		// if the order has finished processing and is paid for
		/*if ($status == "processing")
		{
			// and payment method is credit card or paypal
			if ($method == "intuit_payments_credit_card" || $method == "paypal" || $method == "Other" || $method == "quickbookspay")
			{
				$order->set_status('completed'); update_post_meta( $orderidall, '_status_sort', wc_clean( null ) ); generate_order_log($order, $orderidall);
 				$note = __("COMPLETED (SHIPPED), status change PROCESSING to COMPLETED by $lastuser");
				$msg2 = "Order Updated: " . $orderidall . " COMPLETED";
				$to = email_order_update();
				$subject = "PROCESSING Order Marked Complete: " . $orderidall;
				wp_mail( $to, $subject, $msg2);
				//$order->save();
			}
		}*/
		
		// handle tax exempt check box to remove taxes
		if ( $taxe )
		{
			foreach ( $allitems as $item ) // loop through all items
			{
				$item->set_tax_class('zero-rate');
				$city = '';$state = '';$postcode = '';$country = '';
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				); $item->calculate_taxes( $calculate_tax_for );
			}
			foreach ( $feeitems as $item ) // loop through fee items 
			{
				$item->set_tax_class('zero-rate');
				$city = '';$state = '';$postcode = '';$country = '';
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				); $item->calculate_taxes( $calculate_tax_for );
			}
			$order->calculate_totals();
			$note = __("MARKED EXEMPT by $lastuser");
		}
			// handle tax exempt check box to remove taxes
		if ( $taxeX )
		{
			foreach ( $allitems as $item ) // loop through all items
			{
				$item->set_tax_class('');
				$city = '';$state = '';$postcode = '';$country = '';
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				); $item->calculate_taxes( $calculate_tax_for );
			}
			foreach ( $feeitems as $item ) // loop through fee items 
			{
				$item->set_tax_class('');
				$city = '';$state = '';$postcode = '';$country = '';
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				); $item->calculate_taxes( $calculate_tax_for );
			}
			$order->calculate_totals();
			$note = __("MARKED TAXABLE by $lastuser");
		}
		
		if ( $ebmsent ) { $note = __("ebay message sent with payment link by $lastuser"); update_post_meta( $orderidall, '_sent_ebaymsg', wc_clean( date("y-m-d") ) ); }
		if ( $paypalpaid ) { $note = __("PP not CAPTURED, hit Processing button (...) to capture PayPal, status kept ON HOLD by $lastuser"); }

		// add the note and resave order for last action
		if ($note != "") {
			if ($no != 1) { $order->add_order_note( $note ); } 
		$order->save();
		return;
		}
	}
    }
    
	/*********************************************************************************/
	// cancel order button
	if ($cancelorder != "")
	{
		global $current_user;
    	wp_get_current_user();
		$lastuser = $current_user->user_firstname;
		$note = "";
		$order    = wc_get_order( $cancelorder );
		$canceldate = date('y-m-d');
		
		$items_first = $order->get_items();
		foreach( $items_first as $item )
		{
			$id = $item->get_product_id();
			$product = wc_get_product($id);
			update_post_meta( $id, '_soldby', wc_clean( "" ) );
			$product->set_status('publish'); 
		}
		$note = __("CANCELLED by $lastuser");
		$order->add_order_note( $note );
		$order->set_status('cancelled'); update_post_meta( $cancelorder, '_status_sort', wc_clean( null ) );
		update_post_meta( $cancelorder, '_saved_status', wc_clean( "cancelled" ) );
		//update_post_meta( $cancelorder, '_cancel_date', wc_clean( $canceldate ) );
		$order->set_date_paid($canceldate);
		$order->save();
		// send email
		$msg = $cancelorder . " cancelled.";
		$to = "jedidiah@ccrind.com";
		$subject = "Order CANCELLED:  " . $cancelorder;
		wp_mail( $to, $subject, $msg);
		generate_order_log($order, $cancelorder);
		return;
	}
	/*********************************************************************************/
	// delete ship quote log button
	if ($deleteshipqlog != "")
	{
		global $current_user;
		wp_get_current_user();
		$lastuser = $current_user->user_firstname;
		$note = "";
		$prefix = substr($deleteshipqlog, 0, 4);
		if (unlink("../library/order-logs/$prefix/ShipQ$deleteshipqlog.html")) { /* file deleted */
			$note = __("ORDER SHIP QUOTE LOG DELETED by $lastuser");
			$order    = wc_get_order( $deleteshipqlog );
			$order->add_order_note( $note );
		} else { /* file not deleted */ }
		return;
	}
}

/* END OF INLINE EDITTING BUTTON PROCESSING CODE ********************************************************************************/
// generate order log function
function generate_order_log($order, $orderidall) {
	if ($orderidall == 130193) { $extrafee = 85.775; }
	$allsku = ""; $allproduct = ""; $exempt = ""; $styleflag = "";
	$totalqty = 0; $count = 0; $cost = 0; $totalcost = 0;
	$date = $order->get_date_created(); $date_converted = $date->format('m-d-y'); $month = $orderM = date("m",strtotime($date)); $year = date("Y",strtotime($date));
	$status   = $order->get_status();
	$paymethod = $order->get_payment_method();
	if ($paymethod == "Other" || $paymethod == "other") { $tid = $order->get_transaction_id(); $paymethod = $tid; }
	else if ($paymethod == "quickbookspay") { $paymethod = "Credit Card"; }
	else if ($paymethod == "paypal" || $paymethod === 'angelleye_ppcp' || $paymethod === 'ppcp') { $paymethod = "PayPal"; }
	else if ($paymethod == "stripe") { $paymethod = "Credit Card"; }
	else if ($paymethod == "CreditCard") { $paymethod = "eBay (CC)"; }
	else if ($paymethod == "cod") { $paymethod = ""; }
	if ($paymethod != ""  ) {
		$paydate_o = $order->get_date_paid(); 
		if ($paydate_o != "") { 
			$paydate = $paydate_o->format('m-d-Y'); 
			if ($status == "cancelled") { $styleflag = 'C'; }
			else { $styleflag = 'P';/* P for paid */  }
			$month = $paidM = substr($paydate, 0, 2); $paidY = date("Y",strtotime($paydate));
            if ($paidY >= $year) { $savedY = $year; $year = $paidY; }
		
				$sub = $sub2 = $order->get_subtotal(); $dis = $order->get_total_discount(); $sub = $sub - $dis; $sub2 = $sub2 - $dis;
				$tax = $order->get_total_tax();
				$order_notes = get_private_order_notes( $orderidall );
				foreach($order_notes as $notes) {
    				$note_content = $notes['note_content'];
					if(strpos( $note_content, "MARKED EXEMPT") !== false) { $exempt = "exempt"; }
				}
				$shipping = $order->get_total_shipping();
				$fee_total = 0;
				foreach( $order->get_items('fee') as $item_id => $item_fee ) { $fee_total = $fee_total + $item_fee->get_total(); }
				$refund = $order->get_total_refunded();
				$fee_total = $fee_total - $refund;
				if ($orderidall == 130193) { $fee_total = -2685.78; }
			$ourshipcost = get_post_meta($orderidall, '_ccr_ship_cost', true);
		}
	}
	$saved_bill = get_post_meta( $orderidall, '_saved_billing', true );
	$testadd = $order->billing_address_1;
	if (!empty($saved_bill) && empty($testadd)) { 
		if ($saved_bill["first_name"]) { $cus_name = $saved_bill["first_name"] . " " . $saved_bill["last_name"]; }
	}
	else {
		if ($order->billing_first_name) { $cus_name = $order->billing_first_name . " " . $order->billing_last_name; }
	}
	if ($cus_name == "") { $cus_name = $order->get_billing_company(); }
	
	$saved_ship = get_post_meta( $orderidall, '_saved_shipping', true );
		$ship_add = $order->get_shipping_address_1();
		if (!empty($saved_ship) && empty($ship_add)) {
			if ($saved_ship["first_name"]) { $cus_ship_add = $saved_ship["first_name"] . " " . $saved_ship["last_name"]; }
			if ( ($saved_ship["first_name"] && $saved_ship["company"]) || ($saved_ship["first_name"] && $saved_ship["address_1"]) ) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($saved_ship["company"]) { $cus_ship_add = $cus_ship_add . $saved_ship["company"]; }
			if ($saved_ship["company"] && $saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($saved_ship["address_2"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . ", " . $saved_ship["address_2"] . ", " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; }
			else if ($saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . ", " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; $gmapadd = $add . $saved_ship["city"] . "+" . $saved_ship["state"] . "+" . $saved_ship["postcode"] . "+" . "US&z=16"; }
		}
		else {
			if ($order->shipping_first_name) { $cus_ship_add = $order->shipping_first_name . " " . $order->shipping_last_name; }
			if ( ($order->shipping_first_name && $order->shipping_company) || ($order->shipping_first_name && $order->shipping_address_1) ) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($order->shipping_company) { $cus_ship_add = $cus_ship_add . $order->shipping_company; }
			if ($order->shipping_company && $order->shipping_address_1) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($order->shipping_address_2) { $cus_ship_add = $cus_ship_add . $order->shipping_address_1 . ", " . $order->shipping_address_2 . ", " . $order->shipping_city . ", " . $order->shipping_state . " " . $order->shipping_postcode . " " . $order->shipping_country; }
			else if ($order->shipping_address_1) { $cus_ship_add = $cus_ship_add . $order->shipping_address_1 . ", " . $order->shipping_city . ", " . $order->shipping_state . " " . $order->shipping_postcode . " " . $order->shipping_country; $gmapadd = "$order->shipping_address_1+$order->shipping_city+$order->shipping_state+$order->shipping_postcode+US&z=16"; }
		}
	$cus_ship_add = "<a target='_blank' href='https://maps.google.com/maps?&q=$gmapadd'>$cus_ship_add</a>";
	$oEmail = $order->get_billing_email();
	$oEmail = "<a href='mailto:$oEmail'>$oEmail</a>";
	$phone = $order->get_billing_phone();
	$shiptype = $order->get_shipping_method();
	$foundBy = get_post_meta( $orderidall, '_found_by', true ); $foundBy = strtolower($foundBy);
	if (strpos($foundBy, 'oogle')) { $foundBy = ""; }
	else if ($foundBy == "ws") { $foundBy = ""; }
	else if (strpos($foundBy, 'cr')) { $foundBy = ""; }
	else if (strpos($foundBy, 'acebook')) { $foundBy = "fb"; }
	if ( $foundBy == "referral" && $styleflag == 'P' ) { $styleflag = "QBO"; $foundBy = "qbo"; }
	else if ( $foundBy == "fb" && $styleflag == 'P') { $styleflag = "FB"; }
	$ebayID = get_post_meta( $orderidall, '_ebayID', true );
	$items = $order->get_items();
	$product_cat = "";
	foreach( $items as $item ) 
	{	
		$product = wc_get_product($item->get_product_id());
		$sku = $product->get_sku();
   		$product_id = $product->get_id();
		if ($product != "") {
			$sku = $product->get_sku();
			$product_name = $item->get_name();
			$quantity = $item->get_quantity();
			if ($count == 0) { 
				$category = "";
				$primary_cat_id = get_post_meta($product->get_id(),'_yoast_wpseo_primary_product_cat',true);
				if($primary_cat_id) {
					$product_cat = get_term($primary_cat_id, 'product_cat');
				}
				else { // loop through all categories and display links
					$terms = get_the_terms( $product_id, 'product_cat' );
					$total = count($terms);
					$i = 0;
					foreach ($terms as $term) {
						$i++;
						$category = $category . $term->name;
						if ($i != $total) echo ', '; }
				}
				if(isset($product_cat->name)) { $category = $product_cat->name; }
				
				$sku = "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a>";
				$allsku = $allsku . $sku; 
				$allproduct = $allproduct . $product_name . " ($quantity)";
			}
			else { 
				$sku = "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a>";
				$allsku = $allsku . " / " . $sku; 
				$allproduct = $allproduct . " / " . $product_name . " ($quantity)";
			}
			// get cost
			$cost = $cost1 = $clcost = $fbcost = $lsncost = $totalcost = 0;
			if ( get_post_meta( $product_id, '_cost', true ) != "" ) {
				$cost1 = (int) get_post_meta( $product_id, '_cost', true ); } 
			$cost = $cost + ($cost1 * $quantity);
			if ( get_post_meta( $product_id, '_cl_cost', true ) != "" ) {
				$clcost = (int) get_post_meta( $product_id, '_cl_cost', true ); }
			if ( get_post_meta( $product_id, '_fbmp_cost', true ) != "" ) {
				$fbcost = (int) get_post_meta( $product_id, '_fbmp_cost', true ); }
			if ( get_post_meta( $product_id, '_lsn_cost', true ) != "" ) {
				$lsncost = $lsnc = (int) get_post_meta( $product_id, '_lsn_cost', true ); }
			$cost = $cost + $clcost + $fbcost + $lsncost;
			$totalcost = $totalcost + $cost + $clcost + $fbcost + $lsncost;
			$totalqty = $totalqty + $quantity;
			$count = $count + 1; 
		}	
	}
	// do not do anything else if the product field is blank
	if ($allproduct != "" || $shipping != "") 
	{
	$samade = get_post_meta( $orderidall, 'sa_made_date', true );
	$sasigned = get_post_meta( $orderidall, 'sa_signed_date', true );
	$shipdate = get_post_meta( $orderidall, '_ccr_ship_date', true );
	
	if ($cus_ship_add == "") {
		$cus_ship_add = get_post_meta( $orderidall, '_saved_shipping', true );
			if ($saved_ship["first_name"]) { $cus_ship_add = $saved_ship["first_name"] . " " . $saved_ship["last_name"]; }
			if ( ($saved_ship["first_name"] && $saved_ship["company"]) || ($saved_ship["first_name"] && $saved_ship["address_1"]) ) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($saved_ship["company"]) { $cus_ship_add = $cus_ship_add . $saved_ship["company"]; }
			if ($saved_ship["company"] && $saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . ", "; }
			if ($saved_ship["address_2"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . ", " . $saved_ship["address_2"] . ", " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; }
			else if ($saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . ", " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; }
	} 
	if ($phone == "") { $phone = get_post_meta( $orderidall, '_saved_phone', true ); }
	$shipmethod = $order->get_shipping_method(); $shiptype = get_post_meta( $orderidall, 'ship_type', true );
	if ($shiptype == "Local Pickup") { $shipmethod = "Local Pickup"; }
	if ( strpos($shipmethod, 'ocal Pickup') ) { $ourshipcost = 0; }
	else if (strpos($shipmethod, 'rd Party Freight') ) { $ourshipcost = 0; }
	if ( strpos($shipmethod, 'Custom Shipping Quote') ) { $shipmethod = "Freight Shipping"; }
	$cusnote = $order->get_customer_note();
	if ($cusnote != "") { $shipmethod = $shipmethod . ", " . $cusnote; }
	$p = "";
	if ($paymethod == "" ) { $cost = ""; }
	if ( ($allproduct != "") && ($count > 1) ) { $allproduct = $allproduct . " **( TOTAL ITEM QTY $totalqty)**"; }
	
	$Ototal = $sub + $tax + $shipping + $fee_total; if ($Ototal == 0) { $Ototal = ""; }
	if ($sub == 0 || $sub = "") { $totalcost = ""; } // dont display cost until the order is paid aka sub is not empty or 0
	
	if ($status == "cancelled" || $status == "refunded" ) {
		$samade = $sasigned = $shipdate = $p = '.'; $paymethod = "Cancelled"; $product_cat->name = $exempt = $Ototal = ""; $totalcost = $sub = $sub2 = $tax = $shipping = $fee_total = $ourshipcost = 0; $shipmethod = "Cancelled"; $styleflag = 'C'; /* C is for cancelled */
	}
	
	$dne = get_post_meta( $orderidall, '_dnemail', true );
	if ($dne) { $oEmail = ""; }
	$salesrecord = "";
	$order_notes = get_private_order_notes( $orderidall );
	$ebayusername = "";
		foreach($order_notes as $note)
		{
    		$note_content = $note['note_content'];
			if(strpos( $note_content, "eBay User ID:") !== false)
			{
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
	$ordernum = "<a class='ccr_order_num' href='https://ccrind.com/wp-admin/edit.php?s=$orderidall&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' rel='noopener noreferrer' target='_blank'><strong>C$orderidall</strong></a>"; 
	if ($ebayusername != "") { $cus_name = "$ebayuserlink / $cus_name"; }
	if (strlen($phone) == 10) { $phone = substr($phone, 0, 3) ."-". substr($phone, 3, 3) ."-". substr($phone, 6, 4); }
	// create log info for both log page
	$EBaltlogmsg = "
<table id='ebay_order' class='ebay_order'>
  <tr>																																			
    <th class='eBaynumber freeze'><button onclick='sortEBAYNUM()'><b>* Invoice # *</b></button></th>
	<th class='number right'>Associated Invoice #</th>
	<th class='date_created'>Sale/Invoice Date</th>
	<th class='skus'>CCR#</th>
	<th class='SAmade'>Sales Agreement Sent</th>
	<th class='SAsigned'>Sales Agreement Recieved</th>
	<th class='ship_date'>Ship/Pickup Date</th>
	<th class='category'>Item Category</th>
	<th class='products'>Item Description</th>
	<th class='pay_method'>Payment Type</th>
	<th class='pay_date'>Date Paid</th>
	<th class='blank'>Remove from eBay</th>
	<th class='blank'>Remove from CL / FB</th>
	<th class='blank'>Remove from LSN</th>
	<th class='blank'>Move Pix</th>
	<th class='blank'>Archive Tickets</th>
	<th class='cost'>Item Cost</th>
	<th class='sub_h_total'>Item Price</th>
	<th class='tax'>Item Taxes</th>
	<th class='exempt'>Tax Exempt</th>
	<th class='shipcost'>Shipping Cost</th>
	<th class='fee_h_s'>Additional Fees</th>
	<th class='grosstotal'>Total Cost</th>
	<th class='ourshipcost'>Our Shipping Cost</th>
	<th class='cusname'>Customer Name</th>
	<th class='cusshipadd'>Customer Shipping Address</th>
	<th class='email'>Email Address</th>
	<th class='phone'>Customer Phone Number</th>
	<th class='shipmethod'>Comments</th>
  </tr>";
	$altlogmsg = "
<table id='ws_order' class='ws_order'>
	<tr>
  	<th class='eBaynumber freeze'><button onclick='sortCCRNUM()'><b>* Invoice # *</b></button></th>
	<th class='date_created right'>Sale/Invoice Date</th>
	<th class='skus'>CCR#</th>
	<th class='SAmade'>Sales Agreement Sent</th>
	<th class='SAsigned'>Sales Agreement Recieved</th>
	<th class='ship_date'>Ship/Pickup Date</th>
	<th class='category'>Item Category</th>
	<th class='products'>Item Description</th>
	<th class='pay_method'>Payment Type</th>
	<th class='pay_date'>Date Paid</th>
	<th class='blank'>Remove from eBay</th>
	<th class='blank'>Remove from CL / FB</th>
	<th class='blank'>Remove from LSN</th>
	<th class='blank'>Move Pix</th>
	<th class='blank'>Archive Tickets</th>
	<th class='cost'>Item Cost</th>
	<th class='sub_h_total'>Item Price</th>
	<th class='tax'>Item Taxes</th>
	<th class='exempt'>Tax Exempt</th>
	<th class='shipcost'>Shipping Cost</th>
	<th class='fee_h_s'>Additional Fees</th>
	<th class='grosstotal'>Total Cost</th>
	<th class='ourshipcost'>Our Shipping Cost</th>
	<th class='cusname'>Customer Name</th>
	<th class='cusshipadd'>Customer Shipping Address</th>
	<th class='email'>Email Address</th>
	<th class='phone'>Customer Phone Number</th>
	<th class='shipmethod'>Comments</th>
	<th class='soldby_h'>Sold By:</th>
	</tr>";
	$EBaltlogmsg2 = "";
	if ($salesrecord != "") {
		$logmsg = "$ebaylink > $ordernum > $date_converted > $allsku > $samade > $sasigned > $shipdate > $category > $allproduct > $paymethod > $paydate > $p > $p > $p > $p > $p > $totalcost > $sub2 > $tax > $exempt > $shipping > $fee_total > $Ototal > $ourshipcost > $cus_name > $cus_ship_add > $oEmail > $phone > $shipmethod";
		$EBaltlogmsg2 = "
  	<tr class='tabledata$styleflag'>
    	<td class='EBnumber freeze'>$ebaylink</td>
		<td class='number right'>$ordernum</td>
		<td class='date_created'>$date_converted</td>
		<td class='skus'>$allsku</td>
		<td class='SAmade'>$samade</td>
		<td class='SAsigned'>$sasigned</td>
		<td class='ship_date'>$shipdate</td>
		<td class='category'>$category</td>
		<td class='products'>$allproduct</td>
		<td class='pay_method'>$paymethod</td>
		<td class='pay_date'>$paydate</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='cost'>$totalcost</td>
		<td class='sub_eb_total'>$sub2</td>
		<td class='tax'>$tax</td>
		<td class='exempt'>$exempt</td>
		<td class='shipcost'>$shipping</td>
		<td class='fees'>$fee_total</td>
		<td class='grosstotal'>$Ototal</td>
		<td class='ourshipcost'>$ourshipcost</td>
		<td class='cusname'>$cus_name</td>
		<td class='cusshipadd'>$cus_ship_add</td>
		<td class='email'>$oEmail</td>
		<td class='phone'>$phone</td>
		<td class='shipmethod'>$shipmethod</td>
	</tr>";
	}
	else {
		$logmsg = "$ordernum > $date_converted > $allsku > $samade > $sasigned > $shipdate > $product_cat->name > $allproduct > $paymethod > $paydate > $p > $p > $p > $p > $p > $totalcost > $sub2 > $tax > $exempt > $shipping > $fee_total > > $ourshipcost > $cus_name > $cus_ship_add > $oEmail > $phone > $shipmethod > $foundBy";
		$altlogmsg2 = "
	<tr class='tabledata$styleflag'>
		<td class='number freeze'>$ordernum</td>
		<td class='date_created right'>$date_converted</td>
		<td class='skus'>$allsku</td>
		<td class='SAmade'>$samade</td>
		<td class='SAsigned'>$sasigned</td>
		<td class='ship_date'>$shipdate</td>
		<td class='category'>$product_cat->name</td>
		<td class='products'>$allproduct</td>
		<td class='pay_method'>$paymethod</td>
		<td class='pay_date'>$paydate</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='blank'>$p</td>
		<td class='cost'>$totalcost</td>
		<td class='subtotal'>$sub2</td>
		<td class='tax'>$tax</td>
		<td class='exempt'>$exempt</td>
		<td class='shipcost'>$shipping</td>
		<td class='fees'>$fee_total</td>
		<td class='grosstotal'>$Ototal</td>
		<td class='ourshipcost'>$ourshipcost</td>
		<td class='cusname'>$cus_name</td>
		<td class='cusshipadd'>$cus_ship_add</td>
		<td class='email'>$oEmail</td>
		<td class='phone'>$phone</td>
		<td class='shipmethod'>$shipmethod</td>
		<td class='soldby'>$foundBy</td>
	</tr>";
	}
	$replacetags = array("\n", "\t", "\r");
	if ($EBaltlogmsg2 != "") { $EBaltlogmsg2 = str_replace( $replacetags, "", $EBaltlogmsg2); }
	$altlogmsg2 = str_replace( $replacetags, "", $altlogmsg2);
	$orderidL = strlen($orderidall);
	if ($orderidL == 6) { $prefix = substr($orderidall, 0, 4); $num = substr($orderidall, 4, 2); }
	
	// create order log
	// create a variable for changing all styles of the logs
	$filestyle = "table.ws_order, table.ebay_order { display: inline-block; overflow-x: auto; overflow: auto; white-space: nowrap;}
.table_wrapper { display: block; overflow-x: scroll; white-space: nowrap; }
.freeze { position: absolute; width: 150px; background-color: #ffffff !important;}
.right { padding-left: 200px !important; }
td.ws_total { background-color: #c40403; color: #ffffff; }
td.eb_total { background-color: #0264c4; color: #ffffff; }
td.ebws_total { background-color: #917cc2; color: #ffffff; }
td.qbo_total { background-color: #2da51c; color: #ffffff; }
td.fb_total { background-color: #94c2ff; }
td.total, td.total_tax, td.ws_total, td.eb_total, td.fb_total, td.wsall_total, td.ebws_total, td.shipcostp_total, td.freight_total, td.qbo_total { font-size: 24px; font-weight: heavy; }
td, th { border: 1px solid #dddddd; text-align: center; padding: 8px; text-overflow: wrap; }
th { background-color: #dddddd; word-wrap: break-word; font-size: 14px; }
tr { user-select: all; word-wrap: break-word; }
tr.tabledataC { background-color: #ffdadf; }
tr.tabledataP { background-color: #daffdc; }
tr.tabledataQBO { background-color: #2da51c; color: #ffffff; }
tr.tabledataFB { background-color: #94c2ff; color: #ffffff; }
th.number { width: 60px; }
th.date_created, th.SAmade, th.SAsigned, th.ship_date { width: 60px; }
th.products, td.products { max-width: 600px; word-wrap: auto; overflow:auto; }
th.cusshipadd { width: 200px; }
th.blank, td.blank { max-width: 30px; word-wrap: auto; overflow:auto;}";
	// create the directory for the file if it does not already exist
	if ( !file_exists("../library/order-logs/$prefix/") ) {
		mkdir("../library/order-logs/$prefix/", 0744, true); }
	// delete file before creating new one
	if (unlink("../library/order-logs/$prefix/$orderidall.html")) { /* file deleted */ } else { /* file not deleted */ }
	$file = fopen("../library/order-logs/$prefix/$orderidall.html","a");
	// variable to hold data common to both log types
	$filestart = "<!DOCTYPE html>
<html>
<head>
<style>
$filestyle
</style>
<body>
<h1>C$orderidall Log</h1>
<h2>" . date('m-d-Y    h:i:s', current_time( 'timestamp', 0 ) ) . "</h2>
	
" . $logmsg . "
<br><br>
";
		
$scripts = "
<script>
function sortEBAYNUM() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('ebay_order');
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

function sortCCRNUM() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('ws_order');
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
</script>
";
	// if ws use its order data, else use ebay order data
	if ($ebayID == "") { $allfile = $filestart . $altlogmsg . $altlogmsg2 . $scripts; echo fwrite($file, $allfile); }
	else { $allfile = $filestart . $EBaltlogmsg . $EBaltlogmsg2 . $scripts; echo fwrite($file, $allfile); }
	fclose($file); // close file
    //******************************************************************************//
	// create monthly log, start of process, only ws orders with a shipping address //
	//******************************************************************************//
	if ($cus_ship_add != "") {
	// translate the month number to month name
	if ($paidM != "") {$month = $paidM; }
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
	// make the directory, if it does not exist
	if ( !file_exists("../library/order-logs/Y$year/") ) {
		mkdir("../library/order-logs/Y$year/", 0744, true); }
	// create a hidden table row variable to mark divisions in the log
	$hiddenEBTBL = PHP_EOL."<tr class='ebay_end_cell' style='display:none;'></tr></table></div>".PHP_EOL;
	$hiddenTBL = PHP_EOL."<tr class='ws_end_cell' style='display:none;'></tr></table></div><br><br><br><br>".PHP_EOL;
	$hiddenTotalTBL = PHP_EOL."<tr class='total_end_cell' style='display:none;'></tr></table></div><br><br>".PHP_EOL;
	// assign variables to the file name we will be working with as well as test variable file name (debug use only)
	$monthfile = "../library/order-logs/Y$year/$month_trans.html";
	//$testlog = "../library/order-logs/Y$year/$month_trans.txt";
	// create a header variable for building the file structure, total_table is empty for adding later in function
	$filestart = "<!DOCTYPE html>
<html>
<head>
<style>
$filestyle
</style>
<body>
<h1>$month_trans $year Order Log</h1>
<div class='table_wrapper'>
<table class='total_table'></table>
$hiddenTotalTBL";
	// construct the entire file to be written to the log, format html with page title and table header cells
	$allfile = $filestart . "
<h2>WS / CCR Orders</h2>
<div class='table_wrapper'>
". $altlogmsg . "
". $altlogmsg2 . "
". $hiddenTBL . "
<h2>eBay Orders</h2>
<div class='table_wrapper'>
". $EBaltlogmsg . "
". $EBaltlogmsg2 . "
". $hiddenEBTBL . $scripts;
	// if the file doesnt exist go ahead and create it
	if ( !file_exists($monthfile) ) {
		$file = fopen($monthfile, "w");
		echo fwrite($file, $allfile);
		fclose($file);
	}
	else {  // the file already exists so lets do some checks
	if ($salesrecord == "") {
		// check if table data row for order already exists, ws
		$reading = fopen($monthfile, "r"); // read file
		$writing = fopen("../library/order-logs/Y$year/$month_trans.tmp.html", "w"); // write file
		$replaced = false; // flag
		$appended = false; // flag
		$find = $ordernum; // checking for existence based on order number
		$append = "ws_end_cell";
		// read through the entire file
		while (!feof($reading)) {
			$line = fgets($reading); // line by line
			// once $ordernum is found, overwrite the data already in the table
			if (strpos($line, $find)) {
				$line = $altlogmsg2; // replace line with data in $altlogmsg2
				fwrite($writing, $line . PHP_EOL);
				$replaced = true; // flag that a line was replaced
			}
			else if ( strpos($line, $append) && (!$replaced) )  {
				$line = $altlogmsg2 . PHP_EOL . $hiddenTBL; // replace line with data in $altlogmsg2 . $hiddenTBL
				fwrite($writing, $line);
				$appended = true; // flag that a line was replaced
			}
			else { fwrite($writing, $line); } // write each line from read file to write file
		}
		fclose($reading); fclose($writing); // close both working files
		// if a line was replaced during the above loop, overwrite the read file with the written file
		if ($replaced || $appended) { rename("../library/order-logs/Y$year/$month_trans.tmp.html", $monthfile); } 
		// if a line was NOT replaced, delete the unrequired write temporary file
		else { unlink("../library/order-logs/Y$year/$month_trans.tmp.html"); }
	}
	else {
		// check if table data row for order already exists, ebay
		// check for invalid ebay order
		if (strlen($salesrecord) == 5) {
		$reading = fopen($monthfile, "r"); // read file
		$writing = fopen("../library/order-logs/Y$year/$month_trans.tmp.html", "w"); // write file
		$replaced = false; // flag
		$appended = false; // flag
		$find = $ordernum; // checking for existence based on order number
		$append = "ebay_end_cell";
		// read through the entire file
		while (!feof($reading)) {
			$line = fgets($reading); // line by line
			// once $ordernum is found, overwrite the data already in the table
			if (strpos($line, $find)) {
				$line = $EBaltlogmsg2; // replace line with data in $EBaltlogmsg2
				fwrite($writing, $line . PHP_EOL);
				$replaced = true; // flag that a line was replaced
			}
			else if (strpos($line, $append) && (!$replaced) )  {
				$line = $EBaltlogmsg2 .PHP_EOL. $hiddenEBTBL; // replace line with data in $EBaltlogmsg2
				fwrite($writing, $line); // write line then another hidden line
				$appended = true; // flag that a line was replaced
			}
			else { fwrite($writing, $line); } // write each line from read file to write file
		}
		fclose($reading); fclose($writing); // close both working files
		// if a line was replaced during the above loop, overwrite the read file with the written file
		if ($replaced || $appended) { rename("../library/order-logs/Y$year/$month_trans.tmp.html", $monthfile); } 
		// if a line was NOT replaced, delete the unrequired write temporary file
		else { unlink("../library/order-logs/Y$year/$month_trans.tmp.html"); }
		}
	}
	} // end of... else {  // the file already exists so lets do some checks
		/**************************************************************/
		// read file for totals, create total table (since we did not copy it earlier)
		calc_order_log_totals($monthfile, $year, $month, $month_trans);
		
		// remove the order from the old month if paid in a new month
		if ($paidM != "" && $paidM != $orderM) {
			if ($year != $savedY) { $year = $savedY; }
			// translate the month number to month name for paid
			switch ($orderM) {
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
			$monthfile = "../library/order-logs/Y$year/$month_trans.html";
			calc_order_log_totals($monthfile, $year, $month, $month_trans);
		} 
	} // close if ($cus_ship_add != "") - only get process orders with addresses 
	} // close if ($allproduct != "") 
	return;
} // close function generate_order_log
/***********************************************************************************/
function calc_order_log_totals($monthfile, $year, $month, $month_trans) {
	
			$reading = fopen($monthfile, "r"); // read file
			$writing = fopen("../library/order-logs/Y$year/$month_trans.tmp.html", "w"); // write file
			$replaced = false; // flag
			$find = $ordernum; // checking for existence based on order number
			// read through the entire file
			while (!feof($reading)) {
				$line = fgets($reading); // line by line
				// once $ordernum is found, overwrite the data already in the table
				if (strpos($line, strval($find) ) ) { /* do nothing, skip the line */ $replaced = true; }
				else { fwrite($writing, $line); } // write each line from read file to write file
			}
			fclose($reading); fclose($writing); // close both working files
			// if a line was replaced during the above loop, overwrite the read file with the written file
			if ($replaced) { rename("../library/order-logs/Y$year/$month_trans.tmp.html", $monthfile); } 
			// if a line was NOT replaced, delete the unrequired write temporary file
			else { unlink("../library/order-logs/Y$year/$month_trans.tmp.html"); }
			
			
			// read file for totals, create total table (since we did not copy it earlier)
		$fileread = fopen($monthfile, "r"); // open file for reading
		$find_total = "class='subtotal'>";  // string to find (ws item prices)
		$find_soldby = "class='soldby'>";
		$find_eb_total = "class='sub_eb_total'>";  // string to find (ebay item prices)
		$find_tax_total = "class='tax'>";  // string to find (item taxes)
		$find_ship_meth = "Freight Ship";
		$emailarr = array();
		// running totals for cash value
		$total = $ws_total = $eb_total = $fb_total = $tax_total = $shipcostp_total = $freight_total = $ws_total_fee = $eb_total_fee = $fb_total_fee = $ebws_total_fee = $qbo_total_fee = 0;
		// get qbo total from saved value in admin user ccruser2
		$the_user = get_user_by('email', 'jedidiah@ccrind.com'); $userID = $the_user->ID;
		$qbo_total = get_user_meta( $userID, "qbo_total$month", true );
		$qbo_count = get_user_meta( $userID, "qbo_countc$month", true );
		$qbo_shipprofit = get_user_meta( $userID, "qbo_shipprofit$month", true );
		$qbo_shipprofit = floatval( $qbo_shipprofit );
		// running totals for number of orders
		$total_count = $ebws_total = $ws_count = $eb_count = $fb_count = $ebws_count = $freight_count = $total_countc = $ws_countc = $eb_countc = $fb_countc = $ebws_countc = $freight_countc = $qbows_total = 0;
		// debug
		$debug = "";
		$replacetags = array("</td>", "</tr>", "<td>", "<tr>", "\t", "\n", "$", ","); // filter out any data that will cause string conversion to error
		// read through the file until $find is found
		while ( ($line = fgets($fileread))  != false ) {
			// once $find is found, read the total, add to current ws total
			if ( strpos( $line, $find_total ) !== false ) {
				// total
				$string_total = substr( $line, strpos( $line, $find_total)+17); // getting the string number (17 length of the $find_total variable)
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$num_total = (float) $string_total; // convert string to float number value
				// fees
				$string_total = substr( $line, strpos( $line, "class='fees'>")+13); // getting the string number (13 length of the class='fees'>)
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$num_total_fee = (float) $string_total; // convert string to float number value
				$soldby = substr( $line, strpos( $line, $find_soldby)+15);
				$soldby = str_replace( $replacetags, "", $soldby);
				// check sold by codes, generate totals based off that value
				if ($soldby == "fb") {
					$fb_total = $fb_total + $num_total; // keep a running total of item prices fb
					$fb_total_fee = $fb_total_fee + $num_total_fee; // keep a running total of fee prices fb
					if ($num_total > 0) { $fb_countc = $fb_countc + 1; }
					$fb_count = $fb_count + 1; 
				}
				else if ($soldby == "ebay") {
					$ebws_total = $ebws_total + $num_total; // keep a running total of item prices
					$ebws_total_fee = $ebws_total_fee + $num_total_fee; // keep a running total of fee prices fb
					if ($num_total > 0) { $ebws_countc = $ebws_countc + 1; }
					$ebws_count = $ebws_count + 1;
				}
				else if ($soldby == "referral") {
					$qbows_total = $qbows_total + $num_total; // keep a running total of item prices
					$qbo_total_fee = $qbo_total_fee + $num_total_fee; // keep a running total of fee prices fb
					$qbo_countc = floatval($qbo_countc);
					if ($num_total > 0) { $qbo_countc = floatval($qbo_countc) + 1; }
					$qbo_count = floatval($qbo_count);
					$qbo_count = floatval($qbo_count) + 1;
				} 
				else {
					$ws_total = $ws_total + $num_total; // keep a running total of item prices ws
					$ws_total_fee = $ws_total_fee + $num_total_fee; // keep a running total of fee prices fb
					if ($num_total > 0) { $ws_countc = $ws_countc + 1; }
					$ws_count = $ws_count + 1; 
				}
			}
			// once $find is found, read the total, add to current ebay total
			if ( strpos( $line, $find_eb_total ) !== false ) {
				$string_total = substr( $line, strpos( $line, $find_eb_total)+21); // getting the string number (20 length of the $find_eb_total variable)
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$num_total = (float) $string_total; // convert string to float number value
				// fees
				$string_total = substr( $line, strpos( $line, "class='fees'>")+13); // getting the string number (13 length of the class='fees'>)
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$num_total_fee = (float) $string_total; // convert string to float number value
				$eb_total = $eb_total + $num_total; // keep a running total of item prices
				$eb_total_fee = $eb_total_fee + $num_total_fee; // keep a running total of fee prices fb
				if ($num_total > 0) { $eb_countc = $eb_countc + 1; }
				$eb_count = $eb_count + 1;
			}
			if ( strpos( $line, $find_tax_total ) !== false ) {
				$string_tax_total = substr( $line, strpos( $line, $find_tax_total)+12); // getting the string number (12 length of the $find_tax_total variable)
				$string_tax_total = str_replace( $replacetags, "", $string_tax_total); // filtering out data that causes errors
				$num_tax_total = (float) $string_tax_total; // convert string to float number value
				$tax_total = $tax_total + $num_tax_total; // keep a running total of item prices
			}
			// generate shipping cost profit / loss based on ship cost and ourshipcost
			if ( strpos( $line, "class='ourshipcost'>" ) !== false ) {
				$string_total = substr( $line, strpos( $line, "class='ourshipcost'>")+20); // getting the string number (20 length of the class='ourshipcost'>)
				// check for a null value, evidenced by an immediate opening bracket
				if (substr($string_total, 0, 1) == "<") { $string_total = "-1"; }
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$ourshipc = (float) $string_total; // convert string to float number value
				$string_total = substr( $line, strpos( $line, "class='shipcost'>")+17); // getting the string number (17 length of the class='shipcost'>)
				$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
				$shipc = (float) $string_total; // convert string to float number value
				//$debug = $debug . "  SC: " . $shipc . "  OSC: " . $ourshipc . "<br>"; 
				if ($ourshipc != -1) {
					$shipcostp_total = $shipcostp_total + ($shipc - $ourshipc); 
					if (strpos( $line, $find_ship_meth ) !== false) {
						$freight_total = $freight_total + $ourshipc; 
						$freight_count = $freight_count + 1; } } 
			}
			if ( strpos( $line, "<a href='mailto:" ) !== false ) {
				if ( strpos( $line, "class='tabledataC" )) { /* cancelled order do not include email in list */ }
				else {
					$pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
					preg_match_all($pattern, $line, $email);
					$email = $email[0];
					array_push($emailarr, $email);}
			}
		}
		// month array for projections
		$monthdays = array("01"=>31, "02"=>28, "03"=>31, "04"=>30, "05"=>31, "06"=>30, "07"=>31, "08"=>31, "09"=>30, "10"=>31, "11"=>30, "12"=>31);
		// month total * (day of month / current month days total)
		
		// build the table to display the item prices total
		$shipcostp_total = floatval( $shipcostp_total ) + floatval($qbo_shipprofit);
		$ws_total = floatval($ws_total) + floatval($ws_total_fee);
		$fb_total = floatval($fb_total) + floatval($fb_total_fee);
		$qbo_total = floatval( $qbo_total ) + floatval( $qbo_total_fee ) + floatval( $qbows_total );
		$eb_total = floatval($ebws_total) + floatval($eb_total) + floatval($ebws_total_fee) + floatval($eb_total_fee);
		$total = $ws_total + $eb_total + $fb_total + $qbo_total + $shipcostp_total;
		$wsp_total = $ws_total + $fb_total; 
		// projections
		// check to see if the current month is > than sheet month
		$cur_month = date('m');
		if ($month == $cur_month) {
			$total_p = $total / ( date('d') / $monthdays[$month] );
			$ws_total_p = $ws_total / ( date('d') / $monthdays[$month] );
			$fb_total_p = $fb_total / ( date('d') / $monthdays[$month] );
			$eb_total_p = $eb_total / ( date('d') / $monthdays[$month] );
			$qbo_total_p = $qbo_total / ( date('d') / $monthdays[$month] );
			$wsp_total_p = $wsp_total / ( date('d') / $monthdays[$month] );
			$ebws_total_p = $ebws_total / ( date('d') / $monthdays[$month] ); 
			$shipcostp_total_p = $shipcostp_total / ( date('d') / $monthdays[$month] ); 
			$freight_total_p = $freight_total / ( date('d') / $monthdays[$month] ); }
		else {
			$total_p = "N/A";
			$ws_total_p = "N/A";
			$fb_total_p = "N/A";
			$eb_total_p = "N/A";
			$qbo_total_p = "N/A";
			$wsp_total_p = "N/A";
			$ebws_total_p = "N/A"; 
			$shipcostp_total_p = "N/A"; 
			$freight_total_p = "N/A"; }
		// order counts / completed order counts
		$eb_count = $ebws_count + $eb_count; $eb_countc = $ebws_countc + $eb_countc;
		$total_count = $ws_count + $eb_count + $fb_count; $total_countc = $ws_countc + $eb_countc + $fb_countc; 
		$wsp_count = $ws_count + $fb_count; $wsp_countc = $ws_countc + $fb_countc;
		// average total per sale calc
		if ($total_countc != 0) {
		$total_avg = "$" . number_format($total / $total_countc, 2);}
		else { $total_avg = 0; }
		if ($ws_countc != 0) {
		$ws_avg = "$" . number_format($ws_total / $ws_countc, 2); }
		else { $ws_avg = 0; }
		if ($fb_countc != 0) {
		$fb_avg = "$" . number_format($fb_total / $fb_countc, 2); }
		else { $fb_avg = 0; }
		if ($eb_countc != 0) {
		$eb_avg = "$" . number_format($eb_total / $eb_countc, 2); }
		else { $eb_avg = 0; }
		if ($wsp_countc != 0) {
		$wsp_avg = "$" . number_format($wsp_total / $wsp_countc, 2); }
		else { $wsp_avg = 0; }
		if ($ebws_countc != 0) {
		$ebws_avg = "$" . number_format($ebws_total / $ebws_countc, 2); }
		else { $ebws_avg = 0; }
		if ($qbo_count != 0) {
		$qbo_avg = "$" . number_format($qbo_total / $qbo_count, 2); }
		else { $qbo_avg = 0; }
		if ($freight_count != 0) {
		$freight_avg = "$" . number_format($freight_total / $freight_count, 2); }
		else { $freight_avg = 0; }
		// formatting
		$total = number_format($total, 2); $ws_total = number_format($ws_total, 2); $eb_total = number_format($eb_total, 2); $qbo_total = number_format($qbo_total, 2); $fb_total = number_format($fb_total, 2); $tax_total = number_format($tax_total, 2); $wsp_total = number_format($wsp_total, 2); $ebws_total = number_format($ebws_total, 2); $shipcostp_total = number_format($shipcostp_total, 2); $freight_total = number_format($freight_total, 2);
		if ($total_p != "N/A") {
		$total_p = "$" . number_format($total_p, 2);
		$ws_total_p = "$" . number_format($ws_total_p, 2);
		$fb_total_p = "$" . number_format($fb_total_p, 2);
		$eb_total_p = "$" . number_format($eb_total_p, 2);
		$qbo_total_p = "$" . number_format($qbo_total_p, 2);
		$wsp_total_p = "$" . number_format($wsp_total_p, 2);
		$ebws_total_p = "$" . number_format($ebws_total_p, 2); 
		$shipcostp_total_p = "$" . number_format($shipcostp_total_p, 2); 
		$freight_total_p = "$" . number_format($freight_total_p, 2); }
		// table formation
		$totallog = "
<table class='total_table'>
	<tr>
		<th></th>
		<th>TOTAL</th>
		<th>WS PROCESSED</th>
		<th>CCR</th>
		<th>eBay</th>
		<th>eBay WS</th>
		<th>QBO</th>
		<th>Facebook</th>
		<th>Shipping Profit</th>
		<th>Freight Cost</th>
		<th>TAX</th>
		<th class='hide'>DEBUG</th>
	</tr>
	<tr>
		<th>REVENUE</th>
		<td class='total R'>$$total</td>
		<td class='wsall_total R'>$$wsp_total</td>
		<td class='ws_total R'>$$ws_total</td>
		<td class='eb_total R'>$$eb_total</td>
		<td class='ebws_total R'>$$ebws_total</td>
		<td class='qbo_total R'>$$qbo_total</td>
		<td class='fb_total R'>$$fb_total</td>
		<td class='shipcostp_total R'>$$shipcostp_total</td>
		<td class='freight_total R'>$$freight_total</td>
		<td class='total_tax R'>$$tax_total</td>
		<td class='hide'>$debug</td>
	</tr>
	<tr>
		<th># Completed Orders</th>
		<td class='total CO'>$total_countc</td>
		<td class='wsall_total CO'>$wsp_countc</td>
		<td class='ws_total CO'>$ws_countc</td>
		<td class='eb_total CO'>$eb_countc</td>
		<td class='ebws_total CO'>$ebws_countc</td>
		<td class='qbo_total CO'>$qbo_count</td>
		<td class='fb_total CO'>$fb_countc</td>
		<td class='shipcostp_total CO'></td>
		<td class='freight_total CO'>$freight_count</td>
		<td class='total_tax CO'></td>
		<td class='hide'></td>
	</tr>
	<tr>
		<th>AVG PER #</th>
		<td class='total APO'>$total_avg</td>
		<td class='wsall_total  APO'>$wsp_avg</td>
		<td class='ws_total  APO'>$ws_avg</td>
		<td class='eb_total  APO'>$eb_avg</td>
		<td class='ebws_total  APO'>$ebws_avg</td>
		<td class='qbo_total  APO'>$qbo_avg</td>
		<td class='fb_total  APO'>$fb_avg</td>
		<td class='shipcostp_total APO'></td>
		<td class='freight_total  APO'>$freight_avg</td>
		<td class='total_tax  APO'></td>
		<td class='hide'></td>
	</tr>
	<tr>
		<th># of Orders</th>
		<td class='total O'>$total_count</td>
		<td class='wsall_total O'>$wsp_count</td>
		<td class='ws_total O'>$ws_count</td>
		<td class='eb_total O'>$eb_count</td>
		<td class='ebws_total O'>$ebws_count</td>
		<td class='qbo_total O'>$qbo_count</td>
		<td class='fb_total O'>$fb_count</td>
		<td class='shipcostp_total O'></td>
		<td class='freight_total O'>$freight_count</td>
		<td class='total_tax O'></td>
		<td class='hide'></td>
	</tr>
	<tr>
		<th>PROJECTION</th>
		<td class='total P'>$total_p</td>
		<td class='wsall_total P'>$wsp_total_p</td>
		<td class='ws_total P'>$ws_total_p</td>
		<td class='eb_total P'>$eb_total_p</td>
		<td class='ebws_total P'>$ebws_total_p</td>
		<td class='qbo_total P'>$qbo_total_p</td>
		<td class='fb_total P'>$fb_total_p</td>
		<td class='shipcostp_total P'>$shipcostp_total_p</td>
		<td class='freight_total P'>$freight_total_p</td>
		<td class='total_tax P'></td>
		<td class='hide'></td>
	</tr>
</table>";
		$replacetags = array("\n", "\t", "\r"); // filert out formatting to make it 1 line
		$totallog = str_replace( $replacetags, "", $totallog);
		fclose($fileread); // close the read file
		//$file = fopen($monthfile, "a"); // open the file to append the total table to the current log file
		//echo fwrite($file, $totallog);
		//fclose($file);
		
		// find the table_data row and replace it with new table total
		$reading = fopen($monthfile, "r"); // read file
		$writing = fopen("../library/order-logs/Y$year/$month_trans.tmp.html", "w"); // temp write file
		$replaced = false; // flag
		$find = "total_table"; 
		//$finddelete = "total_end_cell";
		// read through the entire file
		while (!feof($reading)) {
			$line = fgets($reading); // line by line
			// once $ordernum is found, overwrite the data already in the table
			if (strpos($line, $find)) { $line = $totallog . PHP_EOL; $replaced = true; fwrite($writing, $line); } /* replace line with data in $totallog */ 
			//else if (strpos($line, $finddelete)) { $line = $hiddenTotalTBL; $replaced = true; fwrite($writing, $line); } /* replace line with data in $hiddenTotalTBL */ 
			else { fwrite($writing, $line); } // write each line from read file to write file 
		}
		fclose($reading); fclose($writing); // close both working files
		// if a line was replaced during the above loop, overwrite the read file with the written file
		if ($replaced) { rename("../library/order-logs/Y$year/$month_trans.tmp.html", $monthfile); } 
		// if a line was NOT replaced, delete the unrequired write temporary file
		else { unlink("../library/order-logs/Y$year/$month_trans.tmp.html"); }
	
	// write the emails to another file
	$writing = fopen("../library/order-logs/Y$year/emails/$month_trans-emails.html", "w"); // temp write file
	$filecontents = "<h2>$month_trans $year Emails</h2>" . PHP_EOL;
	$count = 0;
	$copyKey = "";
	foreach ( $emailarr as $email) {
		foreach ($email as $key) {
			if ($count == 0) {
				if (strpos($key, "members.ebay")) { $key = $key . "m"; }
				if ($copyKey != $key) { // do not write duplicate emails
					$filecontents = $filecontents . "<div>$key</div>" . PHP_EOL;
					$copyKey = $key;
					$count = 1;
				}
			}
			else if ($count == 1) { $count = 0; }
	} }
	if ($writing != 0) {
		fwrite($writing, $filecontents); fclose($writing); }
	
	return;
}
/***********************************************************************************/
// generate the order log Year bookmark year
function generate_order_logYEAR() {
	$date = date('m-d-Y'); $month = substr($date, 0, 2); $year = substr($date, 6, 4);
	
	// make the directory, if it does not exist
	if ( !file_exists("../library/order-logs/Y$year/") ) {
		mkdir("../library/order-logs/Y$year/", 0744, true); }
	
	$yearfile = "../library/order-logs/Y$year/$year.html";
	$replacetags = array("</td>", "</tr>", "<td>", "<tr>", "\t", "\n", "$", ","); // filter out any data that will cause string conversion to error
	$total = 0; $totalWS = 0; // totals
	$wslines = $eblines = "";
	//$debug = "";
	// loop through all month files and build totals
	for ($i=1; $i<13; $i++) {
		if ($i < 10) { $monthloop = "0" . (string) $i; }
		else { $monthloop = (string) $i; }
		switch ($monthloop) {
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
		$monthfile = "../library/order-logs/Y$year/$month_trans.html";
		// loop through file building elements
		if ( file_exists($monthfile) ) {
			$fileread = fopen($monthfile, "r"); // open file for reading
			// read through the file until $find is found
			while ( ($line = fgets($fileread))  != false ) {
				// find main totals
				if ( strpos( $line, "class='total R'>" ) !== false ) {
					$string_total = substr( $line, strpos( $line, "class='total R'>$" )+17); // getting the string number (17 length of class='total R'>$ )
					$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
					$totalarr = explode(' ', $string_total, 2);
					$num_total = (float) $totalarr[0]; // convert string to float number value
					$total = $total + $num_total; 
					switch ($monthloop) {
    					case "01": $jan_total = $num_total; break;
   						case "02": $feb_total = $num_total; break;
						case "03": $mar_total = $num_total; break;
						case "04": $apr_total = $num_total; break;
						case "05": $may_total = $num_total; break;
						case "06": $jun_total = $num_total; break;
						case "07": $jul_total = $num_total; break;
						case "08": $aug_total = $num_total; break;
						case "09": $sep_total = $num_total; break;
						case "10": $oct_total = $num_total; break;
						case "11": $nov_total = $num_total; break;
						case "12": $dec_total = $num_total; break;
					}
				} 
				// find CCR totals
				if ( strpos( $line, "class='wsall_total R'>" ) !== false ) {
					$string_total = substr( $line, strpos( $line, "class='ws_total R'>$" )+20); // getting the string number (23 length of class='ws_total R'>$ )
					$string_total = str_replace( $replacetags, "", $string_total); // filtering out data that causes errors
					$totalarr = explode(' ', $string_total, 2);
					$num_total = (float) $totalarr[0]; // convert string to float number value
					$totalWS = $totalWS + $num_total; 
					switch ($monthloop) {
    					case "01": $jan_totalWS = $num_total; break;
   						case "02": $feb_totalWS = $num_total; break;
						case "03": $mar_totalWS = $num_total; break;
						case "04": $apr_totalWS = $num_total; break;
						case "05": $may_totalWS = $num_total; break;
						case "06": $jun_totalWS = $num_total; break;
						case "07": $jul_totalWS = $num_total; break;
						case "08": $aug_totalWS = $num_total; break;
						case "09": $sep_totalWS = $num_total; break;
						case "10": $oct_totalWS = $num_total; break;
						case "11": $nov_totalWS = $num_total; break;
						case "12": $dec_totalWS = $num_total; break;
					}
				}
				if ( (strpos( $line, "class='ccr_order_num'" ) !== false) && (strpos( $line, "class='EBnumber'" ) == false) )  { $wslines = $wslines . $line; }
				if ( strpos( $line, "class='EBnumber'" ) !== false ) { $eblines = $eblines . $line; }
			}
		}
	} // loop done
	// get percentages
	$totalsArr = array($total, $jan_total, $feb_total, $mar_total, $apr_total, $may_total, $jun_total, $jul_total, $aug_total, $sep_total, $oct_total, $nov_total, $dec_total);
	$totalsWSArr = array($totalWS, $jan_totalWS, $feb_totalWS, $mar_totalWS, $apr_totalWS, $may_totalWS, $jun_totalWS, $jul_totalWS, $aug_totalWS, $sep_totalWS, $oct_totalWS, $nov_totalWS, $dec_totalWS);
	$totalWSpArr = array(); $i=0;
	for($i = 0; $i < 14; $i++) {
		$perc = ($totalsWSArr[$i] / $totalsArr[$i]) * 100;
		$perc = number_format($perc, 2);
		array_push($totalWSpArr, $perc);
	}
	
	$totalWSp = ($totalWS / $total)*100; $jan_totalWSp = ($jan_totalWS / $jan_total)*100; $feb_totalWSp = ($feb_totalWS / $feb_total)*100; $mar_totalWSp = ($mar_totalWS / $mar_total)*100; $apr_totalWSp = ($apr_totalWS / $apr_total)*100; $may_totalWSp = ($may_totalWS / $may_total)*100; $jun_totalWSp = ($jun_totalWS / $jun_total)*100; $jul_totalWSp = ($jul_totalWS / $jul_total)*100; $aug_totalWSp = ($aug_totalWS / $aug_total)*100; $sep_totalWSp = ($sep_totalWS / $sep_total)*100; $oct_totalWSp = ($oct_totalWS / $oct_total)*100; $nov_totalWSp = ($nov_totalWS / $nov_total)*100; $dec_totalWSp = ($dec_totalWS / $dec_total)*100;
	// format totals
	$total = number_format($total, 2); $totalWS = number_format($totalWS, 2); $jan_total = number_format($jan_total, 2); $feb_total = number_format($feb_total, 2); $mar_total = number_format($mar_total, 2); $apr_total = number_format($apr_total, 2); $may_total = number_format($may_total, 2); $jun_total = number_format($jun_total, 2); $jul_total = number_format($jul_total, 2); $aug_total = number_format($aug_total, 2); $sep_total = number_format($sep_total, 2); $oct_total = number_format($oct_total, 2); $nov_total = number_format($nov_total, 2); $dec_total = number_format($dec_total, 2); $jan_totalWS = number_format($jan_totalWS, 2); $feb_totalWS = number_format($feb_totalWS, 2); $mar_totalWS = number_format($mar_totalWS, 2); $apr_totalWS = number_format($apr_totalWS, 2); $may_totalWS = number_format($may_totalWS, 2); $jun_totalWS = number_format($jun_totalWS, 2); $jul_totalWS = number_format($jul_totalWS, 2); $aug_totalWS = number_format($aug_totalWS, 2); $sep_totalWS = number_format($sep_totalWS, 2); $oct_totalWS = number_format($oct_totalWS, 2); $nov_totalWS = number_format($nov_totalWS, 2); $dec_totalWS = number_format($dec_totalWS, 2); $jan_totalWSp = number_format($jan_totalWSp, 2); $feb_totalWSp = number_format($feb_totalWSp, 2); $mar_totalWSp = number_format($mar_totalWSp, 2); $apr_totalWSp = number_format($apr_totalWSp, 2); $may_totalWSp = number_format($may_totalWSp, 2); $jun_totalWSp = number_format($jun_totalWSp, 2); $jul_totalWSp = number_format($jul_totalWSp, 2); $aug_totalWSp = number_format($aug_totalWSp, 2); $sep_totalWSp = number_format($sep_totalWSp, 2); $oct_totalWSp = number_format($oct_totalWSp, 2); $nov_totalWSp = number_format($nov_totalWSp, 2); $dec_totalWSp = number_format($dec_totalWSp, 2); $totalWSp = number_format($totalWSp, 2);
	// form file
	$allfile = "<!DOCTYPE html>
<html>
<head>
<style>
table.ws_order, table.ebay_order { display: inline-block; overflow-x: auto; overflow: auto; white-space: nowrap; position: relative; }
.table_wrapper { display: block; overflow-x: auto; white-space: nowrap; overflow-y: scroll; max-height: 30em; }
.table_wrapper_2 { display: block; overflow-x: auto; white-space: nowrap; }
td.ws_total { background-color: #c40403; color: #ffffff; }
td.eb_total { background-color: #0264c4; color: #ffffff; }
td.ebws_total { background-color: #917cc2; color: #ffffff; }
td.qbo_total { background-color: #2da51c; color: #ffffff; }
td.fb_total { background-color: #94c2ff; }
td.total, td.total_tax, td.ws_total, td.eb_total, td.fb_total, td.wsall_total, td.ebws_total, td.shipcostp_total, td.freight_total, td.qbo_total { font-size: 24px; font-weight: heavy; }
td, th { border: 1px solid #dddddd; text-align: center; padding: 8px; text-overflow: wrap; }
th { background-color: #dddddd; word-wrap: break-word; font-size: 14px; position: sticky; top: 0px; }
tr { user-select: all; word-wrap: break-word; }
tr.tabledataC { background-color: #ffdadf; }
tr.tabledataP { background-color: #daffdc; }
th.number { width: 60px; }
th.date_created, th.SAmade, th.SAsigned, th.ship_date { width: 60px; }
th.products, td.products { max-width: 600px; word-wrap: auto; overflow:auto; }
th.cusshipadd { width: 200px; }
th.blank, td.blank { max-width: 30px; word-wrap: auto; overflow:auto;}
.total.Rall { background-color: #b0c7af; }
.total.Rws { background-color: #c40403; color: #ffffff; }
.debug.R { display: none; }
</style>
<body>

<h1>$year Order Log Totals</h1>
<h2>" . date('m-d-Y    h:i:s', current_time( 'timestamp', 0 ) ) . "</h2>
<div class='table_wrapper_2'>
<table class='total_table'>
	<tr>
		<th></th>
		<th>TOTAL</th>
		<th>CCR TOTAL</th>
		<th>CCR %</th>
		<th class='debug R'>DEBUG</th>
	</tr>
	<tr>
		<th>REVENUE</th>
		<td class='total Rall'>$$total</td>
		<td class='total Rws'>$$totalWS</td>
		<td class='total Rwsperc'>$totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>01-January</th>
		<td class='total R'>$$jan_total</td>
		<td class='total R'>$$jan_totalWS</td>
		<td class='total Rwsperc'>$jan_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>02-February</th>
		<td class='total R'>$$feb_total</td>
		<td class='total R'>$$feb_totalWS</td>
		<td class='total Rwsperc'>$feb_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>03-March</th>
		<td class='total R'>$$mar_total</td>
		<td class='total R'>$$mar_totalWS</td>
		<td class='total Rwsperc'>$mar_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>04-April</th>
		<td class='total R'>$$apr_total</td>
		<td class='total R'>$$apr_totalWS</td>
		<td class='total Rwsperc'>$apr_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>05-May</th>
		<td class='total R'>$$may_total</td>
		<td class='total R'>$$may_totalWS</td>
		<td class='total Rwsperc'>$may_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>06-June</th>
		<td class='total R'>$$jun_total</td>
		<td class='total R'>$$jun_totalWS</td>
		<td class='total Rwsperc'>$jun_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>07-July</th>
		<td class='total R'>$$jul_total</td>
		<td class='total R'>$$jul_totalWS</td>
		<td class='total Rwsperc'>$jul_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>08-August</th>
		<td class='total R'>$$aug_total</td>
		<td class='total R'>$$aug_totalWS</td>
		<td class='total Rwsperc'>$aug_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>09-September</th>
		<td class='total R'>$$sep_total</td>
		<td class='total R'>$$sep_totalWS</td>
		<td class='total Rwsperc'>$sep_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>10-October</th>
		<td class='total R'>$$oct_total</td>
		<td class='total R'>$$oct_totalWS</td>
		<td class='total Rwsperc'>$oct_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>11-November</th>
		<td class='total R'>$$nov_total</td>
		<td class='total R'>$$nov_totalWS</td>
		<td class='total Rwsperc'>$nov_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
	<tr>
		<th>12-December</th>
		<td class='total R'>$$dec_total</td>
		<td class='total R'>$$dec_totalWS</td>
		<td class='total Rwsperc'>$dec_totalWSp%</td>
		<td class='debug R'></td>
	</tr>
</table></div><br><br>

<h2>WS / CCR Orders</h2>
<div class='table_wrapper'>
<table id='ws_order' class='ws_order'>
<thead>
	<tr>
	<th class='eBaynumber'><button onclick='sortCCRNUM()'><b>* Invoice # *</b></button></th>
	<th class='date_created'>Sale/Invoice Date</th>
	<th class='skus'>CCR#</th>
	<th class='SAmade'>Sales Agreement Sent</th>
	<th class='SAsigned'>Sales Agreement Recieved</th>
	<th class='ship_date'>Ship/Pickup Date</th>
	<th class='category'>Item Category</th>
	<th class='products'>Item Description</th>
	<th class='pay_method'>Payment Type</th>
	<th class='pay_date'>Date Paid</th>
	<th class='blank'>Remove from eBay</th>
	<th class='blank'>Remove from CL / FB</th>
	<th class='blank'>Remove from LSN</th>
	<th class='blank'>Move Pix</th>
	<th class='blank'>Archive Tickets</th>
	<th class='cost'>Item Cost</th>
	<th class='sub_h_total'>Item Price</th>
	<th class='tax'>Item Taxes</th>
	<th class='exempt'>Tax Exempt</th>
	<th class='shipcost'>Shipping Cost</th>
	<th class='fees'>Additional Fees</th>
	<th class='grosstotal'>Total Cost</th>
	<th class='ourshipcost'>Our Shipping Cost</th>
	<th class='cusname'>Customer Name</th>
	<th class='cusshipadd'>Customer Shipping Address</th>
	<th class='email'>Email Address</th>
	<th class='phone'>Customer Phone Number</th>
	<th class='shipmethod'>Comments</th>
	<th class='soldby_h'>Sold By:</th>
	</tr></thead>
<tbody>
$wslines
</tbody>
</table></div><br><br>

<h2>eBay Orders</h2>
<div class='table_wrapper'>
<table id='ebay_order' class='ebay_order'>
  	<tr>
	<th class='eBaynumber'><button onclick='sortEBAYNUM()'><b>* Invoice # *</b></button></th>
	<th class='number'>Associated Invoice #</th>
	<th class='date_created'>Sale/Invoice Date</th>
	<th class='skus'>CCR#</th>
	<th class='SAmade'>Sales Agreement Sent</th>
	<th class='SAsigned'>Sales Agreement Recieved</th>
	<th class='ship_date'>Ship/Pickup Date</th>
	<th class='category'>Item Category</th>
	<th class='products'>Item Description</th>
	<th class='pay_method'>Payment Type</th>
	<th class='pay_date'>Date Paid</th>
	<th class='blank'>Remove from eBay</th>
	<th class='blank'>Remove from CL / FB</th>
	<th class='blank'>Remove from LSN</th>
	<th class='blank'>Move Pix</th>
	<th class='blank'>Archive Tickets</th>
	<th class='cost'>Item Cost</th>
	<th class='sub_h_total'>Item Price</th>
	<th class='tax'>Item Taxes</th>
	<th class='exempt'>Tax Exempt</th>
	<th class='shipcost'>Shipping Cost</th>
	<th class='fees'>Additional Fees</th>
	<th class='grosstotal'>Total Cost</th>
	<th class='ourshipcost'>Our Shipping Cost</th>
	<th class='cusname'>Customer Name</th>
	<th class='cusshipadd'>Customer Shipping Address</th>
	<th class='email'>Email Address</th>
	<th class='phone'>Customer Phone Number</th>
	<th class='shipmethod'>Comments</th>
  	</tr>
$eblines
</table>

<script>
function sortEBAYNUM() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('ebay_order');
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

function sortCCRNUM() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById('ws_order');
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
</script>
</div>";
	// if the file doesnt exist go ahead and create it
	$file = fopen($yearfile, "w");
	echo fwrite($file, $allfile);
	fclose($file);
	
	return;
}
/***********************************************************************************/
// generate ship quote log function
function generate_ship_quote_log($order, $orderidall) {
	$allsku = ""; $allproduct = ""; $exempt = "";
	$totalqty = 0; $count = 0; $cost = 0;
	$date = $order->get_date_created(); $date = $date->format('m-d-Y');
	$status   = $order->get_status();
	$paymethod = $order->get_payment_method();
	if ($paymethod == "Other" || $paymethod == "other") { $tid = $order->get_transaction_id(); $paymethod = $tid; }
	else if ($paymethod == "quickbookspay") { $paymethod = "Credit Card"; }
	else if ($paymethod == "paypal" || $paymethod === 'angelleye_ppcp') { $paymethod = "PayPal"; }
	else if ($paymethod == "stripe") { $paymethod = "Credit Card"; }
	else if ($paymethod == "cod") { $paymethod = ""; }
	if ($paymethod != "" ) {
		$paydate = $order->get_date_paid(); if ($paydate != "") { $paydate = $paydate->format("m-d-Y"); }
				$sub = $order->get_subtotal(); $dis = $order->get_total_discount(); $sub = $sub - $dis;
				$tax = $order->get_total_tax();
				$order_notes = get_private_order_notes( $orderidall );
				foreach($order_notes as $notes) {
    				$note_content = $notes['note_content'];
					if(strpos( $note_content, "MARKED EXEMPT") !== false) {
						$exempt = "exempt";
					}
				}
				$shipping = $order->get_total_shipping();
				$fee_total = 0;
				foreach( $order->get_items('fee') as $item_id => $item_fee ) { $fee_total = $fee_total + $item_fee->get_total(); } 
		$ourshipcost = get_post_meta($orderidall, '_ccr_ship_cost', true);
	}
	$saved_bill = get_post_meta( $orderidall, '_saved_billing', true );
	$testadd = $order->billing_address_1;
	if (!empty($saved_bill) && empty($testadd)) { 
		if ($saved_bill["first_name"]) { $cus_name = $saved_bill["first_name"] . " " . $saved_bill["last_name"]; }
	}
	else {
		if ($order->billing_first_name) { $cus_name = $order->billing_first_name . " " . $order->billing_last_name; }
	}
	if ($cus_name == "") { $cus_name = $order->get_billing_company(); }
	
	$saved_ship = get_post_meta( $orderid, '_saved_shipping', true );
		$ship_add = $order->get_shipping_address_1();
		if (!empty($saved_ship) && empty($ship_add)) {
			if ($saved_ship["first_name"]) { $cus_ship_add = $saved_ship["first_name"] . " " . $saved_ship["last_name"]; }
			if ( ($saved_ship["first_name"] && $saved_ship["company"]) || ($saved_ship["first_name"] && $saved_ship["address_1"]) ) { $cus_ship_add = $cus_ship_add . "<br> "; }
			if ($saved_ship["company"]) { $cus_ship_add = $cus_ship_add . $saved_ship["company"]; }
			if ($saved_ship["company"] && $saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . "<br> "; }
			if ($saved_ship["address_2"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . "<br> " . $saved_ship["address_2"] . "<br> " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"];  }
			else if ($saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . "<br> " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; $gmapadd = $add . $saved_ship["city"] . "+" . $saved_ship["state"] . "+" . $saved_ship["postcode"] . "+" . "US&z=16"; }
		}
		else {
			if ($order->shipping_first_name) { $cus_ship_add = $order->shipping_first_name . " " . $order->shipping_last_name; }
			if ( ($order->shipping_first_name && $order->shipping_company) || ($order->shipping_first_name && $order->shipping_address_1) ) { $cus_ship_add = $cus_ship_add . "<br> "; }
			if ($order->shipping_company) { $cus_ship_add = $cus_ship_add . $order->shipping_company; }
			if ($order->shipping_company && $order->shipping_address_1) { $cus_ship_add = $cus_ship_add . "<br> "; }
			if ($order->shipping_address_2) { $cus_ship_add = $cus_ship_add . $order->shipping_address_1 . "<br> " . $order->shipping_address_2 . "<br> " . $order->shipping_city . ", " . $order->shipping_state . " " . $order->shipping_postcode . " " . $order->shipping_country; }
			else if ($order->shipping_address_1) { $cus_ship_add = $cus_ship_add . $order->shipping_address_1 . "<br> " . $order->shipping_city . ", " . $order->shipping_state . " " . $order->shipping_postcode . " " . $order->shipping_country; $gmapadd = "$order->shipping_address_1+$order->shipping_city+$order->shipping_state+$order->shipping_postcode+US&z=16"; }
		} 
	
			$cus_ship_add = "<a target='_blank' href='https://maps.google.com/maps?&q=$gmapadd'>$cus_ship_add</a>";
	$oEmail = $order->get_billing_email();
	$oEmail = "<a href='mailto:$oEmail'>$oEmail</a>";
	$phone = $order->get_billing_phone();
	$shiptype = $order->get_shipping_method();
	$foundBy = get_post_meta( $orderidall, '_found_by', true ); $foundBy = strtolower($foundBy);
	if (strpos($foundBy, 'oogle')) { $foundBy = ""; }
	else if (strpos($foundBy, 'cr')) { $foundBy = ""; }
	else if (strpos($foundBy, 'acebook')) { $foundBy = "fb"; }
	$ebayID = get_post_meta( $orderidall, '_ebayID', true );
	if ($ebayID != "") { $ebayID = "<a class='ccr_order_num' href='https://ccrind.com/wp-admin/edit.php?s=$orderidall&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' rel='noopener noreferrer' target='_blank'><strong>$ebayID</strong></a>"; }
	$items = $order->get_items();
	foreach( $items as $item ) 
	{	
		$product = wc_get_product($item->get_product_id());
		$sku = $product->get_sku();
   		$product_id = $product->get_id();
		if ($product != "") {
			$sku = $product->get_sku();
			$sku = "<a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a>";
			$product_name = $item->get_name();
			$quantity = $item->get_quantity();
			if ($count == 0) { 
				$primary_cat_id = get_post_meta($product_id,'_yoast_wpseo_primary_product_cat',true);
				if($primary_cat_id) { $product_cat = get_term($primary_cat_id, 'product_cat'); }
				$allsku = $allsku . $sku; 
				$allproduct = $allproduct . $product_name . " ($quantity)";
			}
			else { 
				$allsku = $allsku . " / " . $sku; 
				$allproduct = $allproduct . " / " . $product_name . " ($quantity)";
			}
			// get cost
			// get cost
			$cost = $cost1 = $clcost = $fbcost = $lsncost = $totalcost = 0;
			if ( get_post_meta( $product_id, '_cost', true ) != "" ) {
				$cost1 = (int) get_post_meta( $product_id, '_cost', true ); } 
			$cost = $cost + ($cost1 * $quantity);
			if ( get_post_meta( $product_id, '_cl_cost', true ) != "" ) {
				$clcost = (int) get_post_meta( $product_id, '_cl_cost', true ); }
			if ( get_post_meta( $product_id, '_fbmp_cost', true ) != "" ) {
				$fbcost = (int) get_post_meta( $product_id, '_fbmp_cost', true ); }
			if ( get_post_meta( $product_id, '_lsn_cost', true ) != "" ) {
				$lsncost = $lsnc = (int) get_post_meta( $product_id, '_lsn_cost', true ); }
			$cost = $cost + $clcost + $fbcost + $lsncost;
			$totalcost = $totalcost + $cost + $clcost + $fbcost + $lsncost;
			$totalqty = $totalqty + $quantity;
			$count = $count + 1; 
		}	
	}
	$samade = get_post_meta( $orderidall, 'sa_made_date', true );
	$sasigned = get_post_meta( $orderidall, 'sa_signed_date', true );
	$shipdate = get_post_meta( $orderidall, '_ccr_ship_date', true );
	if ($cus_ship_add == "") {
		$cus_ship_add = get_post_meta( $orderidall, '_saved_shipping', true );
			if ($saved_ship["first_name"]) { $cus_ship_add = $saved_ship["first_name"] . " " . $saved_ship["last_name"]; }
			if ( ($saved_ship["first_name"] && $saved_ship["company"]) || ($saved_ship["first_name"] && $saved_ship["address_1"]) ) { $cus_ship_add = $cus_ship_add . "<br>"; }
			if ($saved_ship["company"]) { $cus_ship_add = $cus_ship_add . $saved_ship["company"]; }
			if ($saved_ship["company"] && $saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . "<br> "; }
			if ($saved_ship["address_2"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . "<br> " . $saved_ship["address_2"] . "<br> " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; }
			else if ($saved_ship["address_1"]) { $cus_ship_add = $cus_ship_add . $saved_ship["address_1"] . "<br> " . $saved_ship["city"] . ", " . $saved_ship["state"] . " " . $saved_ship["postcode"] . " " . $saved_ship["country"]; }
	}
	if ($phone == "") { $phone = get_post_meta( $orderidall, '_saved_phone', true ); }
	$shipmethod = $order->get_shipping_method();
	if ( strpos($shipmethod, 'ocal Pickup') ) { $ourshipcost = 0; }
	else if (strpos($shipmethod, 'rd Party Freight') ) { $ourshipcost = 0; }
	if ( strpos($shipmethod, 'Custom Shipping Quote') ) { $shipmethod = "Freight Shipping"; }
	$cusnote = $order->get_customer_note();
	if ($cusnote != "") { $shipmethod = $shipmethod . ", " . $cusnote; }
	$p = "";
	if ($paymethod == "" ) { $cost = ""; }
	if ( ($allproduct != "") && ($count > 1) ) { $allproduct = $allproduct . " **( TOTAL ITEM QTY $totalqty)**"; }
	if ($status == "cancelled") {
		$samade = "."; $sasigned = "."; $shipdate = '.'; $paymethod = "Cancelled"; $paydate = $exempt = ""; $p = '.'; $cost = $sub = $tax = $shipping = $fee_total = $ourshipcost = 0; $shipmethod = "Cancelled"; $product_cat->name = ""; 
	}
	// get ship quote page info
	global $current_user;
	wp_get_current_user();
	$user = $current_user->display_name; // get quoter name
	$ebayusername = "";
	$order_notes = get_private_order_notes( $orderidall );
	foreach($order_notes as $note)
	{
    	$note_content = $note['note_content'];
		if(strpos( $note_content, "eBay User ID:") !== false) {
			$ebayusername = substr ( $note_content, strpos( $note_content, "eBay User ID:") + 14 , strpos( $note_content, "eBay Sales Record ID:") - 14 ); // get ebay user name
		}
	}
	$items = $order->get_items();
	$dims = "";
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
				if ($sku != "") { $dims = $dims . "SKU: <a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a> - "; } else { $dims = $dims . "(SKU) - "; }
				if ($length != "") { $dims = $dims . "$length\" L - "; } else { $dims = $dims . "(L) - "; }
				if ($width != "") { $dims = $dims . "$width\" W - "; } else { $dims = $dims . "(W) - "; }
				if ($height != "") { $dims = $dims . "$height\" H - "; } else { $dims = $dims . "(H) - "; }
				//echo "$length\" L<br> $width\" W<br> $height\" H";
				if ( $weight != "" ) { $dims = $dims . "$weight lbs, "; } else { $dims = $dims . "(lbs), "; }
				// pallet fee
				$cratefee = get_post_meta($item->get_product_id(), '_cratefee', true);
				if ($cratefee > 0) { $dims = $dims . "<text class='cratefee' id='cratefee'>Pallet Fee: $$cratefee</text>     "; }
			}
		}
	$td = get_post_meta( $orderidall, 'terminal_delivery', true ); 
	$tz = get_post_meta( $orderidall, 'terminal_zip', true ); 
	$l = get_post_meta( $orderidall, 'shipq_length', true ); 
	$w = get_post_meta( $orderidall, 'shipq_width', true ); 
	$h = get_post_meta( $orderidall, 'shipq_height', true ); 
	$lbs = get_post_meta( $orderidall, 'shipq_weight', true ); 
	$pf = get_post_meta( $orderidall, 'shipq_pallet_fee', true ); 
	if ($l != "" || $w != "" || $h != "" || $lbs != "" || $pf != "") { $dims = $dims . "<br>QUOTE DIMENSIONS INPUT:<br>";}
	if ($l != "") { $dims = $dims . "$l\" L<br>"; } else { $dims = $dims . "(L input)<br> "; }
	if ($w != "") { $dims = $dims . "$w\" W<br>"; } else { $dims = $dims . "(W input)<br> "; }
	if ($h != "") { $dims = $dims . "$h\" H<br>"; } else { $dims = $dims . "(H input)<br> "; }
	if ( $lbs != "" ) { $dims = $dims . "$lbs lbs<br>"; } else { $dims = $dims . "(lbs)<br> "; }
	if ($pf > 0) { $dims = $dims . "<text class='cratefee' id='cratefee'>Pallet Fee: $$pf</text><br>"; }
	$quoteprice = get_post_meta( $orderidall, 'shipq_price', true );
	$addType = get_post_meta( $orderidall, 'address_type', true );
	$forkDock = get_post_meta( $orderidall, 'unload_type', true );
	$shipType = get_post_meta( $orderidall, 'ship_type', true );
	$ourshipcost = get_post_meta( $orderidall, 'shipq_CCRcost', true );
	$datetime = date('m-d-Y h:i:s', current_time( 'timestamp', 0 ) );
	$ordernum = "<a class='ccr_order_num' href='https://ccrind.com/wp-admin/edit.php?s=$orderidall&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' rel='noopener noreferrer' target='_blank'><strong>C$orderidall</strong></a>"; 
	$quoteID = get_post_meta( $orderidall, 'shipq_ID', true );
	
	$orderidL = strlen($orderidall);
	if ($orderidL == 6) { $prefix = substr($orderidall, 0, 4); $num = substr($orderidall, 4, 2); }
	
	//create ship quote log
	if ( !file_exists("../library/order-logs/$prefix/") ) {
		mkdir("../library/order-logs/$prefix/", 0744, true); }
	// delete file before creating new one
	//if (unlink("../library/order-logs/$prefix/ShipQ$orderidall.html")) { /* file deleted */ } else { /* file not deleted */ }
    
	// style table 
	if ($user == "Sharon Tobitt") { $usercell_bgcolor = "#72adff"; $userfn = strtok($user, " "); }
	else if ($user == "Jedidiah Fowler") { $usercell_bgcolor = "#8587bd"; $userfn = strtok($user, " "); }
	else if ($user == "Lamar Brackeen") { $usercell_bgcolor = "#d5ffd5"; $userfn = strtok($user, " "); }
    else if ($user == "Brian Oatney") { $usercell_bgcolor = "#d5ffd5"; $userfn = strtok($user, " "); }
	
	// if the file doesnt exist, format html with page title and table header cells
	if ( !file_exists("../library/order-logs/$prefix/ShipQ$orderidall.html") ) {
		// create log info for ship quote page
	if ($ebayID != "") {
		//$sqmsg = "Quote generated by: $user <br> CCR#s: $allsku <br> Order#: $ebayID <br> Add. Type: $addType <br> Forklift/Dock: $forkDock <br> (Term PU) <br> (Term Zip) <br> eBayID: $ebayusername <br> Name: $cus_name <br> Ship Address: $cus_ship_add <br> $dims <br> Pallet Fee: $$pf <br> Cost to CCR: $$ourshipcost <br> Quote Generated Cost: $$quoteprice";
		$altsqmsg = "
<table>
  <tr>
    <th>Date / Time</th><th>Quote generated by:</th><th>SKUs:</th><th>Order Number:</th><th>Address Type:</th><th>Forklift/Dock:</th><th>Terminal Delivery:</th><th>Terminal Zip:</th><th>Name:</th><th>Shipping Address:</th><th>Dimensions of SKUs:</th><th>Pallet Fee:</th><th>Quoted Cost to CCR:</th><th>Quote Generated Cost:</th>
  </tr>
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$allsku</td><td>$ordernum<br>freightquoteID: $quoteID</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$ebayusername<br>$cus_name</td><td>$cus_ship_add</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
	}
	else {
		//$sqmsg = "Quote generated by: $user <br> CCR#s: $allsku <br> Order#: $ordernum <br> Add. Type: $addType <br> Forklift/Dock: $forkDock <br> (Term PU) <br> (Term Zip) <br> Name: $cus_name <br> Ship Address: $cus_ship_add <br> $dims <br> Pallet Fee: $$pf <br> Cost to CCR: $$ourshipcost <br> Quote Generated Cost: $$quoteprice";
		$altsqmsg = "
<table>
  <tr>
    <th>Date / Time</th><th>Quote generated by:</th><th>SKUs:</th><th>Order Number:</th><th>Address Type:</th><th>Forklift/Dock:</th><th>Terminal Delivery:</th><th>Terminal Zip:</th><th>Name:</th><th>Shipping Address:</th><th>Dimensions of SKUs:</th><th>Pallet Fee:</th><th>Quoted Cost to CCR:</th><th>Quote Generated Cost:</th>
  </tr>
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$allsku</td><td>$ordernum<br>freightquoteID: $quoteID</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$cus_name</td><td>$cus_ship_add</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
	}
		
		$file = fopen("../library/order-logs/$prefix/ShipQ$orderidall.html","a");
		echo fwrite($file, "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
tr { user-select: all; }
td.$userfn { background-color: $usercell_bgcolor; }
</style>
<body>
<h1>C$orderidall Shipping Quote Log</h1>

" . $altsqmsg . "

");
		fclose($file);
	}
	// the file exists, only add another table data row
	else {
		// create log info for ship quote page
	if ($ebayID != "") {
		//$sqmsg = "Quote generated by: $user <br> CCR#s: $allsku <br> Order#: $ebayID <br> Add. Type: $addType <br> Forklift/Dock: $forkDock <br> (Term PU) <br> (Term Zip) <br> eBayID: $ebayusername <br> Name: $cus_name <br> Ship Address: $cus_ship_add <br> $dims <br> Pallet Fee: $$pf <br> Cost to CCR: $$ourshipcost <br> Quote Generated Cost: $$quoteprice";
		$altsqmsg = "
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$allsku</td><td>$ordernum<br>freightquoteID: $quoteID</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$ebayusername<br>$cus_name</td><td>$cus_ship_add</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
	}
	else {
		$ordernum = "<a class='ccr_order_num' href='https://ccrind.com/wp-admin/edit.php?s=$orderidall&post_status=all&post_type=shop_order&action=-1&m=0&_customer_user&paged=1' rel='noopener noreferrer' target='_blank'><strong>C$orderidall</strong></a>"; 
		//$sqmsg = "Quote generated by: $user <br> CCR#s: $allsku <br> Order#: $ordernum <br> Add. Type: $addType <br> Forklift/Dock: $forkDock <br> (Term PU) <br> (Term Zip) <br> Name: $cus_name <br> Ship Address: $cus_ship_add <br> $dims <br> Pallet Fee: $$pf <br> Cost to CCR: $$ourshipcost <br> Quote Generated Cost: $$quoteprice";
		$altsqmsg = "
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$allsku</td><td>$ordernum<br>freightquoteID: $quoteID</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$cus_name</td><td>$cus_ship_add</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
	}
		
		$file = fopen("../library/order-logs/$prefix/ShipQ$orderidall.html","a");
		echo fwrite($file, "
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
tr { user-select: all; }
td.$userfn { background-color: $usercell_bgcolor; }
</style>

" . $altsqmsg . "

");
	fclose($file);
	}
}
/***********************************************************************************/
// generate ship quote log Product function
function generate_ship_quote_log_Product($productid, $product) {
	$sku = $product->get_sku();
	global $current_user;
	wp_get_current_user();
	$user = $current_user->display_name; // get quoter name
	$dims = "";
	if ($product != ""){
				$length = $product->get_length();
        		$width = $product->get_width();
        		$height = $product->get_height();
				$weight = $product->get_weight();
				// l, w, h, weight
				if ($sku != "") { $dims = $dims . "SKU: <a class='order_item_link' href='https://ccrind.com/wp-admin/edit.php?s=%3D$sku&post_status=all&post_type=product&action=-1&soldby_filter&product_visibility=0&product_type&stock_status&paged=1&postidfirst=106269&action2=-1' rel='noopener noreferrer' target='_blank'><strong>$sku</strong></a> - "; } else { $dims = $dims . "(SKU) - "; }
				if ($length != "") { $dims = $dims . "$length\" L - "; } else { $dims = $dims . "(L) - "; }
				if ($width != "") { $dims = $dims . "$width\" W - "; } else { $dims = $dims . "(W) - "; }
				if ($height != "") { $dims = $dims . "$height\" H - "; } else { $dims = $dims . "(H) - "; }
				if ( $weight != "" ) { $dims = $dims . "$weight lbs, "; } else { $dims = $dims . "(lbs), "; }
				// pallet fee
				$cratefee = get_post_meta($productid, '_cratefee', true);
				if ($cratefee > 0) { $dims = $dims . "<text class='cratefee' id='cratefee'>Pallet Fee: $$cratefee</text>     "; }
	}
	$td = get_post_meta( $productid, 'terminal_delivery', true ); 
	$tz = get_post_meta( $productid, 'terminal_zip', true ); 
	$l = get_post_meta( $productid, 'shipq_length', true ); 
	$w = get_post_meta( $productid, 'shipq_width', true ); 
	$h = get_post_meta( $productid, 'shipq_height', true ); 
	$lbs = get_post_meta( $productid, 'shipq_weight', true ); 
	$pf = get_post_meta( $productid, 'shipq_pallet_fee', true ); 
	if ($l != "" || $w != "" || $h != "" || $lbs != "" || $pf != "") { $dims = $dims . "<br>QUOTE DIMENSIONS INPUT:<br>";}
	if ($l != "") { $dims = $dims . "$l\" L<br>"; } else { $dims = $dims . "(L input)<br> "; }
	if ($w != "") { $dims = $dims . "$w\" W<br>"; } else { $dims = $dims . "(W input)<br> "; }
	if ($h != "") { $dims = $dims . "$h\" H<br>"; } else { $dims = $dims . "(H input)<br> "; }
	if ( $lbs != "" ) { $dims = $dims . "$lbs lbs<br>"; } else { $dims = $dims . "(lbs)<br> "; }
	if ($pf > 0) { $dims = $dims . "<text class='cratefee' id='cratefee'>Pallet Fee: $$pf</text><br>"; }
	$cus_name = get_post_meta( $productid, 'QnameID', true );
	$quoteprice = get_post_meta( $productid, 'shipq_price', true );
	$addType = get_post_meta( $productid, 'address_type', true );
	$forkDock = get_post_meta( $productid, 'unload_type', true );
	$shipType = get_post_meta( $productid, 'ship_type', true );
	$ourshipcost = get_post_meta( $productid, 'shipq_CCRcost', true );
	$date = date('Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
	$datetime = date('Y-m-d H:i:s', strtotime($date. ' + 5 hours') );
	$quoteID = get_post_meta( $productid, 'shipq_ID', true );
	
	$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
	
	// make directory for the file if it does not exist
		if ( !file_exists("../library/product-quote-logs/$sku_2/$sku_3/") ) { 
			mkdir("../library/product-quote-logs/$sku_2/$sku_3/", 0744, true); }
    
	// style table 
	if ($user == "Sharon Tobitt") { $usercell_bgcolor = "#72adff"; $userfn = strtok($user, " "); }
	else if ($user == "Jedidiah Fowler") { $usercell_bgcolor = "#8587bd"; $userfn = strtok($user, " "); }
	else if ($user == "Lamar Brackeen") { $usercell_bgcolor = "#d5ffd5"; $userfn = strtok($user, " "); }
	else if ($user == "Brian Oatney") { $usercell_bgcolor = "#d5ffd5"; $userfn = strtok($user, " "); }
    
	$altsqmsg = "
<table>
  <tr>
    <th>Date / Time</th><th>Quote generated by:</th><th>SKUs:</th><th>Address Type:</th><th>Forklift/Dock:</th><th>Terminal Delivery:</th><th>Terminal Zip:</th><th>Name:</th><th>Shipping Zip:</th><th>Dimensions of SKUs:</th><th>Pallet Fee:</th><th>Quoted Cost to CCR:</th><th>Quote Generated Cost:</th>
  </tr>
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$sku</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$cus_name</td><td>$tz</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
	
	// if the file doesnt exist, format html with page title and table header cells
	if ( !file_exists("../library/product-quote-logs/$sku_2/$sku_3/ShipQ$sku.html") ) {
		// create log info for ship quote page
		$file = fopen("../library/product-quote-logs/$sku_2/$sku_3/ShipQ$sku.html","a");
		echo fwrite($file, "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
tr { user-select: all; }
td.Sharon { background-color: #72adff; }
td.Jedidiah { background-color: #8587bd; }
td.Lamar { background-color: #d5ffd5; }
td.Brian { background-color: #d5ffd5; }
</style>
<body>
<h1>$sku Shipping Quote Log</h1>

" . $altsqmsg . "

");
		fclose($file);
	}
	// the file exists, only add another table data row
	else {
		// create log info for ship quote page
		$altsqmsg = "
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$sku</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$cus_name</td><td>$tz</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
		
		$file = fopen("../library/product-quote-logs/$sku_2/$sku_3/ShipQ$sku.html","a");
		echo fwrite($file, "

" . $altsqmsg . "

");
	fclose($file);
	}
	if ( !file_exists("../library/product-quote-logs/ShipQuoteALL.html") ) {
		$file2 = fopen("../library/product-quote-logs/ShipQuoteALL.html","a");
		echo fwrite($file2, "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
tr { user-select: all; }
td.Sharon { background-color: #72adff; }
td.Jedidiah { background-color: #8587bd; }
td.Lamar { background-color: #d5ffd5; }
td.Brian { background-color: #d5ffd5; }
</style>
<body>
<h1>Shipping Quote Log</h1>

" . $altsqmsg . "

");
		fclose($file2);
	}
	// the file exists, only add another table data row
	else {
		// create log info for ship quote page
		$altsqmsg = "
  <tr>
    <td>$datetime</td><td class='$userfn'>$user</td><td>$sku</td><td>$addType</td><td>$forkDock</td><td>$td</td><td>$tz</td><td>$cus_name<br>freightquoteID: $quoteID</td><td>$tz</td><td>$dims</td><td>$$pf</td><td>$$ourshipcost</td><td>$$quoteprice</td>
  </tr>";
		
		$file2 = fopen("../library/product-quote-logs/ShipQuoteALL.html","a");
		echo fwrite($file2, "

" . $altsqmsg . "

");
	fclose($file2);
	}
}
/*************************************************************************/
function populate_lsn($postidall) {
	if ( file_exists("../library/LSN/LSN.html") ) {
		$sku = get_post_meta( $postidall, '_sku', true );
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$lsnlink = get_post_meta( $postidall, '_lsnlink', true );
		$lsnc = get_post_meta( $postidall, '_lsn_cost', true );
		$lsn = strtoupper($lsn);
		if ( substr( $lsn, 0, 1 ) == "C") { $lsn = strtolower($lsn); }
		// remove if blank or truncated account name
		if ($lsn == "" || substr( $lsn, 0, 1 ) == "1" || substr( $lsn, 0, 1 ) == "2" || substr( $lsn, 0, 1 ) == "3" || substr( $lsn, 0, 1 ) == "4" || substr( $lsn, 0, 1 ) == "5" || substr( $lsn, 0, 1 ) == "6" || substr( $lsn, 0, 1 ) == "7" || substr( $lsn, 0, 1 ) == "8" || substr( $lsn, 0, 1 ) == "9" || substr( $lsn, 0, 1 ) == "I" ) 
		{
			$find = "-$sku"; // look for that number in the table
			$reading = fopen("../library/LSN/LSN.html", "r"); // read file
			$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
			$replaced = false; // flag
			// read through the entire file
			while ( !feof($reading)) {
				$line = fgets($reading); // line by line
				if ( strpos($line, $find) ) { 
					$pos = strpos($line, "ccrNum") + 7;
					$end = strpos($line, "-");
					$end = $end - $pos;
					$lsnerase = substr($line, $pos, $end);
					$newline = "	<td class='ccrNumE $lsnerase'></td>"; // empty cell
					$line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } // flag true and replace with empty cell code
				else { fwrite($writing, $line); } // write each line from read file to write file 
			}
			fclose($reading); fclose($writing); // close both working files
			// if a line was replaced during the above loop, overwrite the read file with the written file
			if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
			// if a line was NOT replaced, delete the unrequired write temporary file
			else { unlink("../library/LSN/LSN.tmp.html"); }
		}
		// account name valid, replace or add
		else if ( substr( $lsn, 0, 1 ) == "L" || substr( $lsn, 0, 1 ) == "c"  ) // valid lsn account name, add or replace
		{
			// erase current location
			$find = "-$sku"; // look for that number in the table
			$reading = fopen("../library/LSN/LSN.html", "r"); // read file
			$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
			$replaced = false; // flag
			// read through the entire file
			while ( !feof($reading)) {
				$line = fgets($reading); // line by line
				if ( strpos($line, $find) ) { 
					$pos = strpos($line, "ccrNum") + 7;
					$end = strpos($line, "-");
					$end = $end - $pos;
					$lsnerase = substr($line, $pos, $end);
					$newline = "	<td class='ccrNumE $lsnerase'></td>"; // empty cell
					$line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } // flag true and replace with empty cell code
				else { fwrite($writing, $line); } // write each line from read file to write file 
			}
			fclose($reading); fclose($writing); // close both working files
			// if a line was replaced during the above loop, overwrite the read file with the written file
			if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
			// if a line was NOT replaced, delete the unrequired write temporary file
			else { unlink("../library/LSN/LSN.tmp.html"); }
			
			// append $sku to lsn account
				$find = "ccrNumE $lsn'"; // look for the first empty cell under the appropriate $lsn account
				$reading = fopen("../library/LSN/LSN.html", "r"); // read file
				$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
				$replaced = false; // flag
				// build variable to insert into cell
				$newline = "	<td class='ccrNum $lsn-$sku'><a href='$lsnlink' rel='noopener noreferrer' target='_blank'>$sku</a></td>";
				// read through the entire file
				while ( !feof($reading)) {
					$line = fgets($reading); // line by line
					// once $find is found, overwrite the data already in the table
					if ( strpos($line, $find) && (!$replaced) ) { $line = $newline . PHP_EOL; $replaced = true; fwrite($writing, $line); } /* replace line with data in $totallog */ 
					else { fwrite($writing, $line); } // write each line from read file to write file 
				}
				fclose($reading); fclose($writing); // close both working files
				// if a line was replaced during the above loop, overwrite the read file with the written file
				if ($replaced) { rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html"); } 
				// if a line was NOT replaced, delete the unrequired write temporary file
				else { unlink("../library/LSN/LSN.tmp.html"); }
		}
		// get account ad counts
		lsn_counts_and_dates();
		//lsn_scheduled_event();
	}
}
// count lsn
function lsn_counts_and_dates () {
	// count variables
		$clsn10 = $clsn23 = $clsn24 = $clsn = $clsn1 = $clsn2 = $clsn3 = $clsn4 = $clsn5 = $clsn6 = $clsn7 = $clsn8 = $clsn9 = $clsn11 = $clsn12 = $clsn13 = $clsn14 = $clsn15 = $clsn16 = $clsn17 = $clsn18 = $clsn19 = $clsn20 = $clsn21 = $clsn22 = $clsn25 = $clsn26 = $clsn27 = $clsn28 = $clsn29 = $clsn50 = $clsn52 = $clsn56 = $clsn61 = $clsn63 = $renewc = 0;
		// read through to get counts
		$find = "class='ccrNum ";
		$datearr = array();
		$reading = fopen("../library/LSN/LSN.html", "r"); // read file
		$debug = "";
		// read through the entire file
		while ( !feof($reading)) {
			$line = fgets($reading); // line by line
			if ( strpos($line, $find) ) { 
				$pos = strpos($line, "ccrNum") + 7;
				$end = strpos($line, "-");
				$end = $end - $pos;
				$lsnacct = substr($line, $pos, $end); // account number
				switch ($lsnacct) {
					case "LSN10": $clsn10 = $clsn10 + 1; break;
					case "LSN23": $clsn23 = $clsn23 + 1; break;
					case "LSN24": $clsn24 = $clsn24 + 1; break;
    				case "LSN": $clsn = $clsn + 1; break;
					case "LSN1": $clsn1 = $clsn1 + 1; break;
					case "LSN2": $clsn2 = $clsn2 + 1; break;
					case "LSN3": $clsn3 = $clsn3 + 1; break;
    				case "LSN4": $clsn4 = $clsn4 + 1; break;
					case "LSN5": $clsn5 = $clsn5 + 1; break;
					case "LSN6": $clsn6 = $clsn6 + 1; break;
					case "LSN7": $clsn7 = $clsn7 + 1; break;
    				case "LSN8": $clsn8 = $clsn8 + 1; break;
					case "LSN9": $clsn9 = $clsn9 + 1; break;
					case "LSN11": $clsn11 = $clsn11 + 1; break;
					case "LSN12": $clsn12 = $clsn12 + 1; break;
    				case "LSN13": $clsn13 = $clsn13 + 1; break;
					case "LSN14": $clsn14 = $clsn14 + 1; break;
					case "LSN15": $clsn15 = $clsn15 + 1; break;
					case "LSN16": $clsn16 = $clsn16 + 1; break;
    				case "LSN17": $clsn17 = $clsn17 + 1; break;
					case "LSN18": $clsn18 = $clsn18 + 1; break;
					case "LSN19": $clsn19 = $clsn19 + 1; break;
					case "LSN20": $clsn20 = $clsn20 + 1; break;
    				case "LSN21": $clsn21 = $clsn21 + 1; break;
					case "LSN22": $clsn22 = $clsn22 + 1; break;
					case "LSN25": $clsn25 = $clsn25 + 1; break;
					case "LSN26": $clsn26 = $clsn26 + 1; break;
    				case "LSN27": $clsn27 = $clsn27 + 1; break;
					case "LSN28": $clsn28 = $clsn28 + 1; break;
					case "LSN29": $clsn29 = $clsn29 + 1; break;
					case "LSN50": $clsn50 = $clsn50 + 1; break;
					case "LSN52": $clsn52 = $clsn52 + 1; break;
    				case "LSN56": $clsn56 = $clsn56 + 1; break;
					case "LSN61": $clsn61 = $clsn61 + 1; break;
					case "LSN63": $clsn63 = $clsn63 + 1; break;
				}
			}
			if ( strpos($line, "class='renewDateS") || strpos($line, "class='renewDateR") ) {
				if ( strpos($line, "/") ) { // if the renewDate line contains formatting specifying a date
					// extrapolate the date from $line
					$pos = strpos($line, ">") + 1;
					$end = strpos($line, "</th>");
					$end = $end - $pos; 
					$rdate = substr($line, $pos, $end); 
					if ( strpos($rdate, "/") ) { 
						$rdate = strtotime($rdate); 
						array_push($datearr, $rdate); // push the date onto the array stack  
					}
				}
			}
			if ( strpos($line, "class='renewDateR ") ) { $renewc = $renewc + 1; }
		}
		$activeNum = $clsn10 + $clsn23 + $clsn24 + $clsn + $clsn1 + $clsn2 + $clsn3 + $clsn4 + $clsn5 + $clsn6 + $clsn7 + $clsn8 + $clsn9 + $clsn11 + $clsn12 + $clsn13 + $clsn14 + $clsn15 + $clsn16 + $clsn17 + $clsn18 + $clsn19 + $clsn20 + $clsn21 + $clsn22 + $clsn25 + $clsn26 + $clsn27 + $clsn28 + $clsn29 + $clsn50 + $clsn52 + $clsn56 + $clsn61 + $clsn63;
		$lowdate = min($datearr);
		$lowdate = date('m/d/y', $lowdate);
		fclose($reading); // tallied
		// write counts we just tallied to the file
		$find = "class='count "; // look for the first empty cell under the appropriate $lsn account
		$findZ = "class='Zcount ";
		$find2 = "class='color_key activeskuscount";
		$find3 = "class='color_key nextRdate";
		$reading = fopen("../library/LSN/LSN.html", "r"); // read file
		$writing = fopen("../library/LSN/LSN.tmp.html", "w"); // temp write file
		$replaced = false; // flag
		// read through the entire file
		while ( !feof($reading)) {
			$line = fgets($reading); // line by line
			if ( strpos($line, $find) || strpos($line, $findZ) ) { 
				$pos = strpos($line, "count") + 6;
				$end = strpos($line, ">") - 1;
				$end = $end - $pos;
				$lsnacct = substr($line, $pos, $end);
				switch ($lsnacct) {
					case "LSN10": if ($clsn10 == 0) { $newline = "	<th class='Zcount LSN10'>$clsn10</th>"; } else { $newline = "	<th class='count LSN10'>$clsn10</th>"; } break;
					case "LSN23": if ($clsn23 == 0) { $newline = "	<th class='Zcount LSN23'>$clsn23</th>"; } else { $newline = "	<th class='count LSN23'>$clsn23</th>"; } break;
					case "LSN24": if ($clsn24 == 0) { $newline = "	<th class='Zcount LSN24'>$clsn24</th>"; } else { $newline = "	<th class='count LSN24'>$clsn24</th>"; } break;
    				case "LSN": if ($clsn == 0) { $newline = "	<th class='Zcount LSN'>$clsn</th>"; } else { $newline = "	<th class='count LSN'>$clsn</th>"; } break;
					case "LSN1": if ($clsn1 == 0) { $newline = "	<th class='Zcount LSN1'>$clsn1</th>"; } else { $newline = "	<th class='count LSN1'>$clsn1</th>"; } break;
					case "LSN2": if ($clsn2 == 0) { $newline = "	<th class='Zcount LSN2'>$clsn2</th>"; } else { $newline = "	<th class='count LSN2'>$clsn2</th>"; } break;
					case "LSN3": if ($clsn3 == 0) { $newline = "	<th class='Zcount LSN3'>$clsn3</th>"; } else { $newline = "	<th class='count LSN3'>$clsn3</th>"; } break;
    				case "LSN4": if ($clsn4 == 0) { $newline = "	<th class='Zcount LSN4'>$clsn4</th>"; } else { $newline = "	<th class='count LSN4'>$clsn4</th>"; } break;
					case "LSN5": if ($clsn5 == 0) { $newline = "	<th class='Zcount LSN5'>$clsn5</th>"; } else { $newline = "	<th class='count LSN5'>$clsn5</th>"; } break;
					case "LSN6": if ($clsn6 == 0) { $newline = "	<th class='Zcount LSN6'>$clsn6</th>"; } else { $newline = "	<th class='count LSN6'>$clsn6</th>"; } break;
					case "LSN7": if ($clsn7 == 0) { $newline = "	<th class='Zcount LSN7'>$clsn7</th>"; } else { $newline = "	<th class='count LSN7'>$clsn7</th>"; } break;
    				case "LSN8": if ($clsn8 == 0) { $newline = "	<th class='Zcount LSN8'>$clsn8</th>"; } else { $newline = "	<th class='count LSN8'>$clsn8</th>"; } break;
					case "LSN9": if ($clsn9 == 0) { $newline = "	<th class='Zcount LSN9'>$clsn9</th>"; } else { $newline = "	<th class='count LSN9'>$clsn9</th>"; } break;
					case "LSN11": if ($clsn11 == 0) { $newline = "	<th class='Zcount LSN11'>$clsn11</th>"; } else { $newline = "	<th class='count LSN11'>$clsn11</th>"; } break;
					case "LSN12": if ($clsn12 == 0) { $newline = "	<th class='Zcount LSN12'>$clsn12</th>"; } else { $newline = "	<th class='count LSN12'>$clsn12</th>"; } break;
    				case "LSN13": if ($clsn13 == 0) { $newline = "	<th class='Zcount LSN13'>$clsn13</th>"; } else { $newline = "	<th class='count LSN13'>$clsn13</th>"; } break;
					case "LSN14": if ($clsn14 == 0) { $newline = "	<th class='Zcount LSN14'>$clsn14</th>"; } else { $newline = "	<th class='count LSN14'>$clsn14</th>"; } break;
					case "LSN15": if ($clsn15 == 0) { $newline = "	<th class='Zcount LSN15'>$clsn15</th>"; } else { $newline = "	<th class='count LSN15'>$clsn15</th>"; } break;
					case "LSN16": if ($clsn16 == 0) { $newline = "	<th class='Zcount LSN16'>$clsn16</th>"; } else { $newline = "	<th class='count LSN16'>$clsn16</th>"; } break;
    				case "LSN17": if ($clsn17 == 0) { $newline = "	<th class='Zcount LSN17'>$clsn17</th>"; } else { $newline = "	<th class='count LSN17'>$clsn17</th>"; } break;
					case "LSN18": if ($clsn18 == 0) { $newline = "	<th class='Zcount LSN18'>$clsn18</th>"; } else { $newline = "	<th class='count LSN18'>$clsn18</th>"; } break;
					case "LSN19": if ($clsn19 == 0) { $newline = "	<th class='Zcount LSN19'>$clsn19</th>"; } else { $newline = "	<th class='count LSN19'>$clsn19</th>"; } break;
					case "LSN20": if ($clsn20 == 0) { $newline = "	<th class='Zcount LSN20'>$clsn20</th>"; } else { $newline = "	<th class='count LSN20'>$clsn20</th>"; } break;
    				case "LSN21": if ($clsn10 == 0) { $newline = "	<th class='Zcount LSN21'>$clsn10</th>"; } else { $newline = "	<th class='count LSN21'>$clsn10</th>"; } break;
					case "LSN22": if ($clsn21 == 0) { $newline = "	<th class='Zcount LSN22'>$clsn21</th>"; } else { $newline = "	<th class='count LSN22'>$clsn21</th>"; } break;
					case "LSN25": if ($clsn25 == 0) { $newline = "	<th class='Zcount LSN25'>$clsn25</th>"; } else { $newline = "	<th class='count LSN25'>$clsn25</th>"; } break;
					case "LSN26": if ($clsn26 == 0) { $newline = "	<th class='Zcount LSN26'>$clsn26</th>"; } else { $newline = "	<th class='count LSN26'>$clsn26</th>"; } break;
    				case "LSN27": if ($clsn27 == 0) { $newline = "	<th class='Zcount LSN27'>$clsn27</th>"; } else { $newline = "	<th class='count LSN27'>$clsn27</th>"; } break;
					case "LSN28": if ($clsn28 == 0) { $newline = "	<th class='Zcount LSN28'>$clsn28</th>"; } else { $newline = "	<th class='count LSN28'>$clsn28</th>"; } break;
					case "LSN29": if ($clsn29 == 0) { $newline = "	<th class='Zcount LSN29'>$clsn29</th>"; } else { $newline = "	<th class='count LSN29'>$clsn29</th>"; } break;
					case "LSN50": if ($clsn50 == 0) { $newline = "	<th class='Zcount LSN50'>$clsn50</th>"; } else { $newline = "	<th class='count LSN50'>$clsn50</th>"; } break;
					case "LSN52": if ($clsn52 == 0) { $newline = "	<th class='Zcount LSN52'>$clsn52</th>"; } else { $newline = "	<th class='count LSN52'>$clsn52</th>"; } break;
    				case "LSN56": if ($clsn56 == 0) { $newline = "	<th class='Zcount LSN56'>$clsn56</th>"; } else { $newline = "	<th class='count LSN56'>$clsn56</th>"; } break;
					case "LSN61": if ($clsn61 == 0) { $newline = "	<th class='Zcount LSN61'>$clsn61</th>"; } else { $newline = "	<th class='count LSN61'>$clsn61</th>"; } break;
					case "LSN63": if ($clsn63 == 0) { $newline = "	<th class='Zcount LSN63'>$clsn63</th>"; } else { $newline = "	<th class='count LSN63'>$clsn63</th>"; } break;
				}
				$line = $newline . PHP_EOL; fwrite($writing, $line); 
			} 
			else if ( strpos($line, $find2) ) {
				$newline = "	<td class='color_key activeskuscount'>$activeNum</td>";
				$line = $newline . PHP_EOL; fwrite($writing, $line); 
			}
			else if ( strpos($line, $find3) ) {
				$newline = "	<td class='color_key nextRdate'>$lowdate</td>";
				$line = $newline . PHP_EOL; fwrite($writing, $line); 
			}
			else if ( strpos($line, "color_key renewDueCount") ) {
				$newline = "	<td class='color_key renewDueCount'>$renewc</td>";
				$line = $newline . PHP_EOL; fwrite($writing, $line); 
			}
			else { fwrite($writing, $line); } // write each line from read file to write file 
		}
		fclose($reading); fclose($writing); // close both working files
		rename("../library/LSN/LSN.tmp.html", "../library/LSN/LSN.html");
		unlink("../library/LSN/LSN.tmp.html"); 
}

function sort_lsn_table () {
	
	// build a list of all ccr numbers in the lsn table
	$find = "target='_blank'>";
	// read through to get counts
		$CCRarr = array();
		$reading = fopen("../library/LSN/LSN.html", "r"); // read file
		$debug = "";
		// read through the entire file
		while ( !feof($reading)) {
			$line = fgets($reading); // line by line
			if ( strpos($line, $find) ) { 
				$pos = strpos($line, $find) + 16;
				$end = strpos($line, "</a></td>");
				$end = $end - $pos;
				$CCRNum = substr($line, $pos, $end); // CCR number
				array_push($CCRarr, $CCRNum); // put value into array for reading later
			}
		}
	fclose($reading);
	
	// debug read array into a file for testing
	//$writing = fopen("../library/LSN/LSN.debug.html", "w"); // temp write file
	foreach ($CCRarr as $sku) {
		//$line = $num . PHP_EOL; fwrite($writing, $line); 
		$products = wc_get_products( array( 'sku' => $sku ) );
		$product = reset( $products );
		if ( is_bool($product) ) { /* do nothing */ }
		else {
		$postidall = $product->get_id();
		
		$lsn = get_post_meta( $postidall, '_lsn', true );
		// if lsn account starts with lsn or ccrind, cut lsn and ccr out, and update meta
		if ($lsn[0] == 'l' ||  $lsn[0] == 'c' ) { $lsn = substr($lsn, 3); update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) ); }
		
		$lsn = get_post_meta( $postidall, '_lsn', true );
		$lsnlink = get_post_meta( $postidall, '_lsnlink', true );
		// if the account starts with i or any number add ccr or lsn to it
		if ($lsn != "")
		{
			if ($lsn[0] == 'i'){ $lsn = "ccr" . $lsn; }
			else { $lsn = "lsn" . $lsn; }
		}
		else if ($lsn == "" && $lsnlink != "") {
			$lsn = "lsn";
		}
		update_post_meta( $postidall, '_lsn', wc_clean( $lsn ) );
		populate_lsn($postidall);
		}
	}
	//fclose($writing); // close both working files
}

function input_ship_charge( $orderid, $charge ) {
	
	$order    = wc_get_order( $orderid );
	$status   = $order->get_status();
	$method   = $order->get_payment_method();
	$shipcost = $charge;
	$orderidall = $orderid;
	$items    = (array) $order->get_items('shipping');
	
	global $current_user;
    	wp_get_current_user();
		$email = $current_user->user_email; 
		$lastuser = $current_user->user_firstname;
	// if the order has been prepped for shipping cost input (empty payment method and status is on-hold)
		if ($method == "" && $status == "on-hold")
		{
				$removefee = false;
				$local = false;
				if ( $shipcost != "" || $lpcheck || $ThirdPcheck || $termcheck || $upscheck ) {
					
				$firstitem = true;
				if ( empty($items) ) 
				{
					$item = new WC_Order_Item_Shipping();
					if ($lpcheck) { $item->set_method_title( __("Local Pickup") ); $local = true; update_post_meta( $orderidall, 'ship_type', sanitize_text_field( "Local Pickup" ) ); }
					else { 
						if ($upscheck) { $item->set_method_title( __("UPS") ); }
						else if ($ThirdPcheck) { $item->set_method_title( __("3rd Party Freight") ); $local = true; }
						else if ($termcheck) { $item->set_method_title( __("Freight Shipping (Terminal)") ); }
						else { $item->set_method_title( __("Freight Shipping") ); }
					}
					if ($shipcost != "") { 
						if ($ThirdPcheck) { 
							// Get a new instance of the WC_Order_Item_Fee Object
							$item_fee = new WC_Order_Item_Fee();
							$item_fee->set_name( "Pallet Fee" ); // Generic fee name
							$item_fee->set_amount( $shipcost ); // Fee amount
							$item_fee->set_tax_class( '' ); // default for ''
							$item_fee->set_tax_status( 'taxable' ); // or 'none'
							$item_fee->set_total( $shipcost ); // Fee amount
							$order->add_item( $item_fee );
							$item->set_total( 0 );
						}
						else { 
							$item->set_total( $shipcost ); 
							$removefee = true;
						}
					} 
					$order->add_item( $item );
					$item->save();
				}
				else {
				foreach ( $items as $item ) {
					if ($firstitem) {
					if ($lpcheck) { $item->set_method_title( __("Local Pickup") ); $local = true; update_post_meta( $orderidall, 'ship_type', sanitize_text_field( "Local Pickup" ) ); }
					else { 
						if ($upscheck) { $item->set_method_title( __("UPS") ); }
						else if ($ThirdPcheck) { $item->set_method_title( __("3rd Party Freight") ); $local = true; }
						else if ($termcheck) { $item->set_method_title( __("Freight Shipping (Terminal)") ); }
						else { $item->set_method_title( __("Freight Shipping") ); }
					}
					if ($shipcost != "") { 
						if ($ThirdPcheck) { 
							// Get a new instance of the WC_Order_Item_Fee Object
							$item_fee = new WC_Order_Item_Fee();
							$item_fee->set_name( "Pallet Fee" ); // Generic fee name
							$item_fee->set_amount( $shipcost ); // Fee amount
							$item_fee->set_tax_class( '' ); // default for ''
							$item_fee->set_tax_status( 'taxable' ); // or 'none'
							$item_fee->set_total( $shipcost ); // Fee amount
							$order->add_item( $item_fee );
							$item->set_total( 0 );
						}
						else { 
							$item->set_total( $shipcost ); 
							$removefee = true;
						}
					} 
					$firstitem = false; 
					$item->save();}
				} }
				
				if ($removefee) {
					foreach ( $feeitems as $item_id => $feeitem ) {
						$fee_name = $feeitem->get_name();
						$fee_name = strtolower($fee_name);
						if (strpos( $fee_name, "pallet") ) { $order->remove_item( $item_id ); }
					} 
				}
				
				// Get the customer ship info
				if ($local) 
				{ 
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
				}
					
				// if data was input into the addressinput textarea		
				if (isset($shipaddress))
				{
					$adarr = explode(",", $shipaddress);
					$city2 = $adarr[0];
					$save = $adarr[1];
					$adarr2 = preg_split('/\s+/', $save);
					$state2 = $adarr2[1];
					$postcode2 = $adarr2[2];
					
					$address = array(
						'country' => 'US',
						'address_1'  => $shipst,
            			'address_2'  => '', 
            			'city'       => $city2,
            			'state'      => $state2,
            			'postcode'   => $postcode2
        			);
					
					$order->set_address( $address, 'shipping' );
					update_post_meta( $orderidall, '_saved_shipping', wc_clean( $address ) );
				}
					
				$city = $order->get_shipping_city();
				$state = $order->get_shipping_state();
				$postcode = $order->get_shipping_postcode();
				$country = $order->get_shipping_country();
				// Set the array for tax calculations
				$calculate_tax_for = array(
    				'country' => $country, 
    				'state' => $state, 
    				'postcode' => $postcode, 
    				'city' => $city
				);

				$order->calculate_totals();  // get new total
				$newTotal = $order->get_total();
					
				// wipe SIS with blank
				$transaction_id = get_post_meta($orderidall, '_transaction_id', true);
				if ($transaction_id == "SIS" ) {
					$saved_id = get_post_meta( $orderidall, '_saved_ebay_transaction_id', true );
					update_post_meta( $orderid, '_transaction_id', wc_clean( $saved_id ) );
					
					// send email
					$msg2 = "SIS found " . $orderidall . " wiped SIS and saved: " . $saved_id;
					$to = "jedidiah@ccrind.com";
					$subject = "eBay Transaction ID Updated: " . $salesrecord;
					wp_mail( $to, $subject, $msg2);
				}
					
				// handle tax exempt check box to remove taxes
				if ( $taxe )
				{
					foreach ( $allitems as $item ) 
					{
						$item->set_tax_class('zero-rate');
						$city = '';
						$state = '';
						$postcode = '';
						$country = '';
						// Set the array for tax calculations
						$calculate_tax_for = array(
    						'country' => $country, 
    						'state' => $state, 
    						'postcode' => $postcode, 
    						'city' => $city
						);
						$item->calculate_taxes( $calculate_tax_for );
						$order->calculate_totals();
					}
				}
				if ( $taxeX )
				{
					foreach ( $allitems as $item ) 
					{
						$item->set_tax_class('');
						$city = '';
						$state = '';
						$postcode = '';
						$country = '';
						// Set the array for tax calculations
						$calculate_tax_for = array(
    						'country' => $country, 
    						'state' => $state, 
    						'postcode' => $postcode, 
    						'city' => $city
						);
						$item->calculate_taxes( $calculate_tax_for );
						$order->calculate_totals();
					}
				}
				
				// establish if order is ebay
				$salesrecord = "";
				$salesrecord = establish_if_ebay($orderidall);
					
					$note = __("UPDATED AUTOMATICALLY by SHIPQUOTE INTERFACE, shipping, CC fee, taxes updated, status kept ON HOLD, updated by $lastuser");
					$order->add_order_note( $note );
					$order->save();
				}
		}
}
?>
