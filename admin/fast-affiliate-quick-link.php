<?php

function fast_affiliate_add_quick_link(){
    $source_link = filter_var($_POST['source_link'],FILTER_SANITIZE_STRING);
    $link_name = filter_var($_POST['link_name'],FILTER_SANITIZE_STRING);
    $post_number = $_POST['postid'];
    $program_id = filter_var($_POST['program_id'],FILTER_SANITIZE_STRING);

    #Get user programs
    $fast_affiliate_programs=get_option('fast_affiliate_programs');


    $program = false;

    for ($i=0; $i<count($fast_affiliate_programs); $i++) {
        if ($program_id == $fast_affiliate_programs[$i]['program_id']) {
            $program = $fast_affiliate_programs[$i];
        }
    }

    $link = '';

    if ($program)  {
        if ($program['platform_id'] == 'amazon') {
            $amazon_tracking_id=get_option('fast_affiliate_amazon_tracking_id');
            $platform_data = ['amazon_tracking_id' => $amazon_tracking_id];
        }
        if ($program['platform_id'] == 'ebay') {
            $ebay_campaingId=get_option('fast_affiliate_ebay_campaingId');
            $platform_data = ['ebay_campaingId' => $ebay_campaingId];
        }
        if ($program['platform_id'] == 'effiliation') {
            $platform_data = [];
        }
        if ($program['platform_id'] == 'affilinet') {
            $affilinet_publisher_id=get_option('fast_affiliate_affilinet_publisher_id');
            $platform_data = ['affilinet_publisher_id' => $affilinet_publisher_id];
        }
        if ($program['platform_id'] == 'CJ') {
            $fast_affiliate_cj_site_id=get_option('fast_affiliate_cj_site_id');
            $platform_data = ['fast_affiliate_cj_site_id' => $fast_affiliate_cj_site_id];
        }

        $data = ['url' => $source_link, 'link_name' => $link_name, 'program' => $program, 'platform_data' => $platform_data];
        $link = fast_affiliate_get_quick_link($data);
    }

    $saved_products=get_post_meta($post_number,'fast_affiliate_products_choice',true);
    if (empty($saved_products)){
        $saved_products=[];
    }

    array_push($saved_products, $link);

    update_post_meta($post_number,'fast_affiliate_products_choice', $saved_products);
    update_meta_cache('post', $post_number);

    fast_affiliate_display_selected_array($saved_products);

    wp_die();

}