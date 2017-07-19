<?php

function fast_affiliate_stock(){
    echo "<h2>Fast Affiliate - ".__("Stock", "fast-affiliate")."</h2>";
	
	echo "<form method='post' action='options.php'>";

	$links=fast_affiliate_get_recorded_links();
	$n_links=count($links);

    echo "</form>";
    echo "<br>";
    echo "<h3>".(__("States of your affiliates links","fast-affiliate"))."</h3>";
    echo "<br>";
    echo "<table class='stock_table tablesorter'>";
    echo "<thead><th> ".(__("Product","fast-affiliate"))." </th><th> ".(__("Post","fast-affiliate"))." </th><th> ".(__("Availability","fast-affiliate"))." </th></thead><tbody>";

    $args = array('post_type' => 'post', 'posts_per_page' => -1 );
    $fast_affiliate_query = new WP_Query($args);

    if($fast_affiliate_query->have_posts()) {
    	while ( $fast_affiliate_query->have_posts() ) {
    		$fast_affiliate_query->the_post() ;
    		$post_id=get_the_ID(); 
    		$title = get_the_title();
            $post_admin_link = admin_url('post.php?post='.$post_id)."&action=edit#fast_affiliate_meta_box' TARGET='_blank'> ";
            $post_links = get_post_meta($post_id,'fast_affiliate_products_choice', true); 
            $n_post_links=count($post_links);

    		if (!empty($post_links)){
    			for ($j=0; $j<$n_post_links; $j++){
		    		$link_id=$post_links[$j]['link_id'];
		    		$availability=__("Not Available","fast-affiliate");
	    			for ($i=0; $i<$n_links; $i++){
	    				if($link_id==$links[$link_id]['link_id']){
	    					if ($links[$link_id]['product_availability']){
	    						$availability=__("Available","fast-affiliate");
	    					}
                            else {
	    						$availability=__("Not Available","fast-affiliate");
	    					}
	    				}
	    			}	
		    		echo "<tr><td><a href='".$post_links[$j]['affiliate_product_url']."' TARGET='_blank'> ".$post_links[$j]['product_name']." </a></td><td><a href='".$post_admin_link.$title."</a></td><td> ".$availability." </td></tr>";
		    	}
	    	}
	    }
	}

	echo "</tbody></table>";
    echo "<br>";
    
    wp_reset_postdata();

}