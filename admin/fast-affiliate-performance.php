<?php

function fast_affiliate_performance(){
    echo "<h2>Fast Affiliate - ".__("Performance", "fast-affiliate")."</h2>";
	
	echo "<form method='post' action='options.php'>";
    echo "</form>";
    
    echo "<br>";
    echo "<h3>".(__("Performance of your affiliates links","fast-affiliate"))."</h3>";
    echo "<br>";
    echo "<table class='stock_table tablesorter'>";
    echo "<thead><th> ".(__("Product","fast-affiliate"))." </th><th> ".(__("Post","fast-affiliate"))." </th><th> ".(__("Origin","fast-affiliate"))." </th><th> ".(__("Number of clicks","fast-affiliate"))." </th><th> ".(__("Number of views","fast-affiliate"))." </th><th> ".(__("Conversion rate %","fast-affiliate"))." </th></thead><tbody>";

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

                    $n_clicks=fast_affiliate_nb_clicks($link_id);
                    $n_views=get_post_meta($post_id,'fast_affiliate_views', true);
                    
                    $n_tab_line=count($n_clicks);
                    if ($n_tab_line>0) {
                        for ($i=0; $i<$n_tab_line; $i++){
                            echo "<tr><td><a href='".$post_links[$j]['affiliate_product_url']."' TARGET='_blank'> ".$post_links[$j]['product_name']." </a></td><td><a href='".$post_admin_link.$title."</a></td>";
                            echo "<td>".$n_clicks[$i]['source']."</td>";
                            echo "<td>".$n_clicks[$i]['clicks']."</td>";
                            echo "<td>".$n_views."</td>";
                            if (intval($n_clicks)!==0){
                                if (intval($n_views)!==0){
                                    echo "<td>".number_format($n_clicks[$i]['clicks'] * 100.0 / $n_views, 2)." % </td></tr>"; 
                                }
                                else {
                                    echo "<td>0</td>";
                                }
                            }
                            else {
                                echo "<td>0</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    else {
                        echo "<tr><td><a href='".$post_links[$j]['affiliate_product_url']."' TARGET='_blank'> ".$post_links[$j]['product_name']." </a></td><td><a href='".$post_admin_link.$title."</a></td>";
                        echo "<td>".(__("No clicks","fast-affiliate"))."</td>";
                        echo "<td>0</td>";
                        echo "<td>".$n_views."</td>";
                        echo "<td>0</td>";
                        echo "</tr>";
                    }
                }
            }
        }
    }

    echo "</tbody></table>";
    echo "<br>";
    
    wp_reset_postdata();

}
function fast_affiliate_nb_clicks($linkid){
    global $wpdb;

    $table_name = $wpdb->prefix . 'f_a_link_performance';
    $linkid=intval($linkid);
    $clicks = $wpdb->get_results( "SELECT source, clicks FROM $table_name WHERE linkid = $linkid",ARRAY_A);
    return $clicks;
}