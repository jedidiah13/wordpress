<?php
// admin notice to help with searches
add_action('admin_notices', 'general_admin_notice');
function general_admin_notice()
{
    global $pagenow;
    if ( $pagenow == 'edit.php' ) 
	{
		if ('product' === get_post_type($_GET['post'])) 
		{
			echo '<div class="notice notice-info">
             <p>Search for specific sku with =  ( Example:&nbsp; <span class="notice-accent-color"><strong>=12345</strong></span> ),&nbsp;&nbsp;&nbsp;Search location with @ and @= ( Example:&nbsp;   <span class="notice-accent-color"><strong>@B11</strong></span>  or  <span class="notice-accent-color"><strong>@=B11</strong></span> )&nbsp;&nbsp;&nbsp; Search all MS Sales with <span class="notice-accent-color"><strong>&all</strong></span>, </p>
             <p>Search lsn account with #, <span class="notice-accent-color"><strong>#all</strong></span> and <span class="notice-accent-color"><strong>#not</strong></span> ( Example:&nbsp;  <span class="notice-accent-color"><strong>#lsn3</strong></span> ),&nbsp;&nbsp;&nbsp;Search FBMP items with <span class="notice-accent-color"><strong>$all</strong></span> and <span class="notice-accent-color"><strong>$not</strong></span>, &nbsp;&nbsp;&nbsp;Search for Lister with * ( Example: &nbsp; <span class="notice-accent-color"><strong>*kk</strong></span> or <span class="notice-accent-color"><strong>*kelsey</strong></span> )</p>
			 <p>Search with like instead of exact, preface search with <span class="notice-accent-color"><strong>~</strong></span>,&nbsp;&nbsp;&nbsp;Search for products by ebay ID with <span class="notice-accent-color"><strong>e</strong></span></p>
         </div>'; 
		} /*close if ('product' */ 
	} /* close if ( $pagenow == 'edit.php' ) */ 
} /* closefunction general_admin_notice */
?>