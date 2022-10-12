<?php
/* code to make short description default to whatever we choose */
// display after the related products on the single product page
add_filter( 'woocommerce_after_single_product_summary', 'default_short_description', 10, 1);
function default_short_description( )
{
    global $product;
	
	// get the first 2 letters or digits of the product's sku
	$sku = $product->get_sku();
	$ft = substr($sku, 0, 2);
    
    if ( is_single( $product->id ) )
    {
		// if not a P&M sales sku
		if( $ft != "PM" ){
        $post_excerpt = '<div id="about us">
<div class="section">
<h4 style="color:#C40808; font-family: Black Ops One; font-size: 22px;">About CCR Industrial Sales:</h4><br>
<p style="font-size: 18px;">Please see the "<a href="https://ccrind.com/about-us/" target="_blank" rel="noopener" style="color: #ff0000">About Us</a>" page by clicking <a href="https://ccrind.com/about-us/" target="_blank" rel="noopener" style="color: #ff0000">here</a> or by clicking in the top or bottom navigation menus for information about our company and further information regarding our policies on making an offer, feedback, contacting us, shipping, return policies, payment, and our <a href="https://ccrind.com/wp-content/uploads/2018/10/Equipment-Sales-Agreement-Blank.docx" target="_blank" rel="noopener" style="color: #ff0000">custom sales agreement</a>.</p><br><br>
<!--<p>Our goal is to conduct an honest, customer oriented business. We deal in new, surplus, NOS (new old stock), liquidations, discontinued and used items, but we are not an authorized dealer for most of the items offered.</p>
<p>We describe items to the best of our ability, but it is the responsibility of our buyer to determine the applicability and safety of each item for their particular use.</p>
<h3 class="bar">Feedback:</h3>
<p>We work very hard to maintain our high feedback rating. Please contact us directly if you have any concerns about a product. We do our best to leave you feedback a soon as possible after confirmed payment, within 24 hours.</p>
<h3 class="bar">Contacting Us:</h3>
<p class="p1"><span class="s1">Our sales line and email address are at the bottom of the page should you need more information.</span></p>
<h3 class="bar">Shipping:</h3>
<p>We ship Monday through Friday (except U.S. holidays) via UPS ground, USPS, Federal Express, or LTL freight carriers. Orders normally leave our location within 24 hours of cleared payment Monday through Friday.</p>
<p>Tracking information is forwarded to buyers via email when items are shipped.</p>
<p>Special shipping requirements will be quoted.  <span class="s1">Please contact us for more information.</span></p>
<h3 class="bar">Return Policy:</h3>
<p>We are a liquidator.  Therefore, we sell everything as is. All items are non-returnable. Therefore, please ask all the questions you want, get extra pictures from us, etc. to avoid any costly complications.</p>
<h3 class="bar">Payment:</h3>
<p>We accept PayPal, Mastercard and Visa. Local pickup can have other payment arrangements made. Please contact us in advance.</p>
<h3 class="bar">Notice:</h3>
<p>It is our company policy to obtain a signed copy of our <a href="https://ccrind.com/wp-content/uploads/2018/10/Equipment-Sales-Agreement-Blank.docx" target="_blank" rel="noopener">custom sales agreement</a> for anything that sells for over $500. Upon you initiating the sale, we will customize a sales agreement and forward it to you to sign and date.</p>
<p>Without the previously mentioned signed and dated sales agreement, we will not ship the item.</p> -->
</div>
</div>';	
    }
		// if is a P&M Sales product
		if( $ft == "PM" ){
        $post_excerpt = '<div id="about us">
<div class="section">
<h4 style="color:#C40808; font-family: Black Ops One; font-size: 22px;">P&M Sales Disclaimer:</h4><br>
<p style="font-size: 18px;">We make every effort to present information that is accurate. However, it should be used as a guide only and not guaranteed. Under no circumstances will we be liable for any inaccuracies, claims or losses of any nature. Furthermore, inventory is subject to prior sale and prices are subject to change without notice. Prices may not include additional fees such as government fees and taxes, title and registration fees, finance charges, dealer document preparation fees, processing fees, emission testing and compliance charges. To ensure complete satisfaction, please verify accuracy with the dealer prior to purchase. </p><br><br>
</div>
</div>';	
    }
	// display the editted short description
    echo $post_excerpt;
	}
}
/* end default short description code */
?>