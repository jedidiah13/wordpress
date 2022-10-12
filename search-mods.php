<?php
/**
Search for multiple products in the same query by SKUs multi sku with a code to make it like instead of exact
Added by Jedidiah Fowler on 5-22-20
NOTE: Use ',' or '/' or ' ' as a sku delimiter in your search query. Example: '1234,1235,1236'
**/
/**
Search for multiple products in the same query by SKUs multi sku
Added by Jedidiah Fowler on 7-20-18
NOTE: Use ',' or '/' or ' ' as a sku delimiter in your search query. Example: '1234,1235,1236'
**/
function multiple_sku_search( $query_vars ) {

    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) {
		
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$search_term = str_replace(" ", ",", $search_term);
		$search_term = str_replace("/", ",", $search_term);
		$search_term = str_replace('"', ',', $search_term);
		$search_term = str_replace(",,,,", ",", $search_term);
		$search_term = str_replace(",,,", ",", $search_term);
		$search_term = str_replace(",,", ",", $search_term);
		
		if (strpos($search_term, ',') == true)
		{
			$skus = explode(',',$search_term);
		}
		else
			return $query_vars;

        $meta_query = array(
            'relation' => 'OR'
        );
		
        if(is_array($skus) && $skus) {
            foreach($skus as $sku) {
                $meta_query[] = array(
                    'key' => '_sku',
                    'value' => $sku,
                    'compare' => '='
                );
            }
        }

        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => array('publish', 'pending', 'draft', 'private', 'trash'),
			'orderby'   	  => '_sku',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
    }

    return $query_vars;
}
add_filter( 'request', 'multiple_sku_search', 20 );
/* end multi sku search code*/
/*************************************************************************************************************************/

// code to allow searching for exact skus (=) and warehouse locations (@ or @=) - Jedidiah Fowler 10-17-19
add_filter( 'request', 'exact_sku_search', 20 );
function exact_sku_search( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$searchtag2 = substr( $search_term, 0, 3 );
		
		if ( $searchtag == '=') {
			$search = substr( $search_term, 1 );
		}
		else if ($searchtag2 == "CCR") {
			$search2 = substr( $search_term, 3 );
		}
		
		if ( $searchtag != '=' ) { return $query_vars; }
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_sku',
            'value' => $search,
            'compare' => '='
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => array('product', 'product_variation'),
			'post_status'     => array('publish', 'pending', 'draft', 'private', 'trash'),
			'orderby'   	  => '_sku',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// exact (only active products)
add_filter( 'request', 'exact_active_sku_search', 20 );
function exact_active_sku_search( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 2 );
		$search = substr( $search_term, 2 );
			
		if ( $searchtag != '==' )
		{
			return $query_vars;
		}
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_sku',
            'value' => $search,
            'compare' => '='
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => array('product', 'product_variation'),
			'post_status'     => array('publish', 'pending', 'draft'),
			'orderby'   	  => '_sku',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// code to allow searching for warehouse location - Jedidiah Fowler 10-17-19
add_filter( 'request', 'warehouse_loc_search', 20 );
function warehouse_loc_search( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
			
		if ( $searchtag != '@' )
		{
			return $query_vars;
		}
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_warehouse_loc',
            'value' => $search,
            'compare' => 'LIKE'
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_warehouse_loc',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// warehouse search exact
add_filter( 'request', 'warehouse_loc_search_exact', 20 );
function warehouse_loc_search_exact( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 2 );
		$search = substr( $search_term, 2 );
			
		if ( $searchtag != '@=' )
		{
			return $query_vars;
		}
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_warehouse_loc',
            'value' => $search,
            'compare' => '='
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_warehouse_loc',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// search lsn account numbers exact 
add_filter( 'request', 'lsn_search', 20 );
function lsn_search( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
			
		if ( $searchtag != '#' )
		{
			return $query_vars;
		}
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_lsn',
            'value' => $search,
            'compare' => '='
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_lsn',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// search for all or not lsn account labeled items #all #not
add_filter( 'request', 'lsn_search_all', 20 );
function lsn_search_all( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
			
		if ( $searchtag != '#' )
		{
			return $query_vars;
		}
		
		if ($search == "all")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_lsn',
            'value' => 'n',
            'compare' => 'LIKE'
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_lsn',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "not")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
		 $meta_query[] = array(
			array(
			'key' => '_lsn',
            'value' => 'lsn',
            'compare' => 'NOT LIKE'
				),
			 array(
			'key' => '_lsn',
            'value' => 'ccrind',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_sku',
            'value' => 'MS',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_lsn',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query,
			'tax_query'		  => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array('air-compressors', 'atvs-utvs', 'battery-chargers', 'boats', 'building-materials', 'cleaning-equipment-supplies', 'doors-fixtures', 'electronics', 'fans', 'fencing', 'furniture', 'furniture-alt', 'garage-doors-openers', 'generators', 'heaters', 'heavy-equipment', 'hoists', 'mowers', 'office', 'outdoor-power-equipment', 'paint-sealer', 'pressure-washers', 'saws', 'skid-steer-attachments', 'skid-steers', 'sporting-goods', 'shipping-containers', 'tillers', 'tools', 'tractor-attachments', 'tractors', 'wood-chippers'),
					'operator' => 'IN'
					)
				)
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "mnot")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
			array(
			'key' => '_lsn',
            'value' => 'lsn',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_lsn',
            'value' => 'ccrind',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_lsn',
            'value' => 'x',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_lsn',
            'value' => 'm',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_sku',
            'value' => 'MS',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_soldby',
            'value' => 'auco',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => 'meta_value_num',
			'meta_key'		  => '_price',
            'order'     	  => 'desc',
            'meta_query'      => $meta_query,
			'tax_query'		  => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => array('air-compressors', 'atvs-utvs', 'battery-chargers', 'boats', 'building-materials', 'cleaning-equipment-supplies', 'doors-fixtures', 'electronics', 'fans', 'fencing', 'furniture', 'garage-doors-openers', 'generators', 'heaters', 'heavy-equipment', 'hoists', 'mowers', 'office', 'outdoor-power-equipment', 'paint-sealer', 'pressure-washers', 'saws', 'skid-steer-attachments', 'skid-steers', 'sporting-goods', 'shipping-containers', 'tillers', 'tools', 'tractor-attachments', 'tractors', 'wood-chippers'),
					'operator' => 'IN'
					)
				)
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
    }

    return $query_vars;
}
// search for all or not fbmp items fbmp search ( facebook search facebook search fbmp ) $all $all$ $all$not $not $mnot
// search for all p-msales.com items ( pm search pm )
add_filter( 'request', 'fbmp_search_all', 20 );
function fbmp_search_all( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
			
		if ( $searchtag != '$' )
		{
			return $query_vars;
		}
		
		if ($search == "all")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
                    'key' => '_fbmp',
                    'value' => 'facebook',
                    'compare' => 'LIKE'
                );

        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => 'meta_value_num',
			'meta_key'		  => '_price',
            'order'     	  => 'DESC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "all\$not")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
			array(
			'key' => '_fbmp',
            'value' => 'facebook',
            'compare' => 'LIKE'
				),
			array(
			'key' => '_fbmp_cost',
            'value' => '',
            'compare' => '='
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => 'meta_value_num',
			'meta_key'		  => '_price',
            'order'     	  => 'DESC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "all$")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
			array(
			'key' => '_fbmp',
            'value' => 'facebook',
            'compare' => 'LIKE'
				),
			array(
			'key' => '_fbmp_cost',
            'value' => 1,
            'compare' => '>='
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_regular_price',
            'order'     	  => 'DESC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "not")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
			array(
			'key' => '_fbmp',
            'value' => 'http',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_soldby',
            'value' => 'auco',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_regular_price',
            'order'     	  => 'DESC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		if ($search == "mnot")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
			array(
			'key' => '_fbmp',
            'value' => 'http',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_fbmp',
            'value' => 'multi',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_fbmp',
            'value' => 'exclude',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_sku',
            'value' => 'MS',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_soldby',
            'value' => 'auco',
            'compare' => 'NOT LIKE'
				),
			array(
			'key' => '_stock',
            'value' => 1,
            'compare' => '>='
				)
        );
		
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => 'meta_value_num',
			'meta_key'		  => '_regular_price',
            'order'     	  => 'desc',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
		
		
    }

    return $query_vars;
}
// search initials preparers initials _preparers_initials
add_filter( 'request', 'initials_search', 20 );
function initials_search( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
		
			
		if ( $searchtag != '*' )
		{
			return $query_vars;
		}
		
		// SEARCH BASED ON FIRST NAME TOO
		$search = strtoupper($search);
		
		if ($search == "KELSEY")
		{
			$search = "KK";
		}
		else if ($search == "RYAN")
		{
			$search = "RC";
		}
		else if ($search == "ADAM")
		{
			$search = "ABW";
		}
		else if ($search == "CHELSEA")
		{
			$search = "CK";
		}
		else if ($search == "JED" || $search == "JEDIDIAH")
		{
			$search = "JNF";
		}
		else if ($search == "DAN")
		{
			$search = "DT";
		}
		else if ($search == "SARA")
		{
			$search = "ST";
		}
		
		$meta_query = array(
            'relation' => 'OR'
        );
		
		$meta_query[] = array(
			'key' => '_preparers_initials',
            'value' => $search,
            'compare' => 'LIKE'
        );
		
		$args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => array('publish', 'pending', 'draft', 'private', 'trash'),
			'orderby'   	  => 'meta_value_num',
			'meta_key'		  => '_regular_price',
            'order'     	  => 'desc',
            'meta_query'      => $meta_query
			
        );
        $posts = get_posts( $args );
		
		if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		
	}
	return $query_vars;
}
// search for all mainstsales.com items ( ms sales ms search )
add_filter( 'request', 'ms_search_all', 20 );
function ms_search_all( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		$searchtag = substr( $search_term, 0, 1 );
		$search = substr( $search_term, 1 );
			
		if ( $searchtag != '&' )
		{
			return $query_vars;
		}
		
		if ($search == "all")
		{
			
		$meta_query = array(
            'relation' => 'OR'
        );
		
        $meta_query[] = array(
                    'key' => '_sku',
                    'value' => 'MS',
                    'compare' => 'LIKE'
                );

        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_sku',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
    }

    return $query_vars;
}

// search for all new facebook account posts
add_filter( 'request', 'fb_search_all', 20 );
function fb_search_all( $query_vars ) 
{
    global $typenow;
    global $wpdb;
    global $pagenow;

    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) ) 
	{	
		$search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
		
		if ($search_term == "newfb")
		{
			
		$meta_query = array(
            'relation' => 'AND'
        );
		
        $meta_query[] = array(
                    'key' => '_newFB',
                    'value' => FALSE,
                    'compare' => '!='
                );

        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
			'post_status'     => 'publish',
			'orderby'   	  => '_sku',
            'order'     	  => 'DSC',
            'meta_query'      => $meta_query
        );
        $posts = get_posts( $args );

        if ( ! $posts ) return $query_vars;

        foreach($posts as $post){
          $query_vars['post__in'][] = $post->ID;
        }
		}
    }

    return $query_vars;
}

// NOT CURRENTLY WORKING
// search order for multiple id, mulitple id order search, multiple order id search
add_filter( 'request', 'multiple_order_search', 20 );
function multiple_order_search( $query_vars ) {
global $typenow;
global $wpdb;
global $pagenow;
if ( 'shop_order' === $typenow && isset( $_GET['s'] ) && 'edit.php' === $pagenow ) {
    $search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
	
	$search_term = str_replace(" ", ",", $search_term);
		$search_term = str_replace("/", ",", $search_term);
		$search_term = str_replace('"', ',', $search_term);
		$search_term = str_replace(",,,,", ",", $search_term);
		$search_term = str_replace(",,,", ",", $search_term);
		$search_term = str_replace(",,", ",", $search_term);
		
		if (strpos($search_term, ',') == true)
		{
			$order_ids = explode(',',$search_term);
		}
		else
			return $query_vars;

        $meta_query = array(
            'relation' => 'OR'
        );
	
    if(is_array($order_ids) && $order_ids) {
        foreach($order_ids as $order_id) {
            $meta_query[] = array(
                'key' => '_order_number',
                'value' => $order_id,
                'compare' => '='
            );
        }
    }

    $args = array(
        'posts_per_page'  => -1,
        'post_type'       => 'shop_order',
        'meta_query'      => $meta_query
    );
    $posts = get_posts( $args ); 

    if ( ! $posts ) return $query_vars;

    foreach($posts as $post){
      $query_vars['post__in'][] = $post->ID;
    }
}
return $query_vars;
}
/*************************************************************************************************************************/
// code to allow searching for exact ebay ids (e), use "e" as the search prefix
add_filter( 'request', 'ebay_id_search', 20 );
function ebay_id_search( $query_vars )
{
    global $typenow;
    global $wpdb;
    global $pagenow;
    if ( 'product' === $typenow && isset( $_GET['s'] ) && ('edit.php' === $pagenow || 'admin.php' === $pagenow) )
    {
        $search_term = esc_sql( sanitize_text_field( $_GET['s'] ) );
        $searchtag = substr( $search_term, 0, 1 );
        $search = substr( $search_term, 1 );
        if ( $searchtag != 'e' ){return $query_vars;}
        $listings = WPLE_ListingQueryHelper::getWhere( 'ebay_id', trim($search) );
        if ( empty( $listings ) ) {return  $query_vars;}
		foreach($listings as $listing){
            $post_id = $listing->post_id;
            if ( $listing->parent_id ) {$post_id = $listing->parent_id;}
            $query_vars['post__in'][] = $post_id;
        }
    }
    return $query_vars;
}
/*************************************************************************************************************************/
/*end of search mods*/
?>