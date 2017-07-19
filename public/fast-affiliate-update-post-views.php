<?php

function fast_affiliate_update_post_views(){
    $post_id = intval($_POST['post_id']);
    $n_views=get_post_meta($post_id,'fast_affiliate_views', true);
    $n_views=intval($n_views)+1;
    update_post_meta($post_id,'fast_affiliate_views',$n_views);

    wp_die();

}