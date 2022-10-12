<?php
/* add curbside notice for clothing */
/* inject title, youtube video, 360 content into listings if new style */
add_filter( 'the_content', 'ccr_add_something_description_tab' );
function ccr_add_something_description_tab( $content ){
	
	global $product;
	
	if( is_product() ) { 
		
		$cattag = "";
		$id = $product->get_id();
		
		if( has_term( 'clothing', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "<h3>Curbside pickup available.</h3><br>";
		}
		$content = $cattag . $content;
		
		if (strpos($content, "<h3>") !== false) {
			
		}
		else {
			$title = $product->get_title();
			$vid = get_post_meta( $id, '_video', true );
			
			$ts = get_post_meta( $id, '_threesixty', true );
			$image_id  = $product->get_image_id();
			$image_url = wp_get_attachment_image_url( $image_id, 'full' );
			
			if ($vid != ""){
				$vid_id = $vid_id = substr($vid, 17);
				$vid = '<p><iframe width="760" height="607" src="https://www.youtube.com/embed/' . $vid_id . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>';
			}
			if ($ts != ""){
				$ts = '<p>Click here to view item in 360 degrees:<br>
<a href="' . $ts . '" target="_blank" rel="noopener noreferrer">' . $ts . '</a></p>

<!-- BEGIN LINKED 360 --> <a href="' . $ts . '" rel="noopener noreferrer" target="_blank"><div class="link360"><img src="' . $image_url . '" /><img src="https://ccrind.com/wp-content/uploads/2020/07/sr-attachment-icon-360_onebw_word-2.png" class="tip360" /></div></a><!-- END LINKED 360 --><br>';
			}
			
			$content = '<h3>' . $title . '</h3>' . $vid . $ts . $content;
		}
	}
 
	return $content;
}
?>