<?php


function fast_affiliate_after($content){
    if(is_single()){
        $post_id=intval($GLOBALS['post']->ID);
        $choices = get_post_meta($post_id,'fast_affiliate_products_choice', true);

        $products_content = "";
        $full_content = $content;
        $full_content = $full_content . "<div id='fa_post_id' data-post_id=" . $post_id . "></div>"; 

        $show_price = get_option('fast_affiliate_show_price');
        
        if (is_array($choices)) {
            foreach($choices as $product){

                if (array_key_exists('link_type', $product ) == false) {
                    $product['link_type'] = "Product Link";
                }
                if ($product['link_type']=="Product Link"){

                    $programs=get_option('fast_affiliate_programs');
                    foreach($programs as $program) {
                        if ($product['program_id']==$program['program_id']){
                            $program_logo_url=$program['program_logo_url'];
                            $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
                            $program_name = $program['program_name'];
                        }
                    }
                    $products_content = $products_content."<div class='fast_affiliate_product'>";
                        $products_content = $products_content."<a class='fa_product_footer' href=".$product['affiliate_product_url']." target='_blank' rel='nofollow' data-link_id=" . $product['link_id'] . ">";
                            $products_content = $products_content."<div class='fast_affiliate_left_column'>";
                                $products_content = $products_content."<p>";
                                    $products_content = $products_content."<img src='".$product['product_url_image']."' alt='product'>";
                                $products_content = $products_content."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_middle_column'>";
                                $products_content = $products_content."<p>".$product['product_name']."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_right_column'>";
                                $products_content = $products_content."<span>";
                                    if ($show_price) {
                                        if (strcmp($product['product_currency'],"EUR")==0){
                                            $currency="€";
                                        } else {
                                            $currency=$product['product_currency'];
                                        }
                                        $products_content = $products_content . "<div class='offer_price'>" . $product['product_price'] . " " . $currency . "</div>";
                                    }
                                    $products_content = $products_content."<div class='fast_affiliate_button_offer'>".(__('See Offer','fast-affiliate'))."</div>";
                                    if ($program_logo_url == "") {
                                        $products_content = $products_content."<span id='program_name'>".$program_name."</span>";
                                    }
                                    else {
                                        $products_content = $products_content."<img src='".$program_logo_url."' alt='Shop logo'>";
                                    }
                                $products_content = $products_content."</span>";
                            $products_content = $products_content."</div>";
                        $products_content = $products_content."</a>";
                    $products_content = $products_content."</div>";
                } else {
                    // Quick Link type
                    $programs=get_option('fast_affiliate_programs');
                    foreach($programs as $program) {
                        if ($product['program_id']==$program['program_id']){
                            $program_logo_url=$program['program_logo_url'];
                            $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
                            $program_name = $program['program_name'];
                        }
                    }
                    $products_content = $products_content."<div class='fast_affiliate_product'>";
                        $products_content = $products_content."<a class='fa_product_footer' href=".$product['affiliate_product_url']." target='_blank' rel='nofollow' data-link_id=" . $product['link_id'] . ">";
                            $products_content = $products_content."<div class='fast_affiliate_left_column'>";
                                $products_content = $products_content."<p>";
                                    $products_content = $products_content."<img src='".$program_logo_url."' alt='product'>";
                                $products_content = $products_content."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_middle_column'>";
                                $products_content = $products_content."<p>".$product['product_name']."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_right_column'>";
                                $products_content = $products_content."<span>";
                                    if ($show_price) {
                                        if (strcmp($product['product_currency'],"EUR")==0){
                                            $currency="€";
                                        } else {
                                            $currency=$product['product_currency'];
                                        }
                                        $products_content = $products_content . "<div class='offer_price'>" . $product['product_price'] . " " . $currency . "</div>";
                                    }
                                    $products_content = $products_content."<div class='fast_affiliate_button_offer'>".(__('See Offer','fast-affiliate'))."</div>";
                                    if ($program_logo_url == "") {
                                        $products_content = $products_content."<span id='program_name'>".$program_name."</span>";
                                    }
                                    else {
                                        $products_content = $products_content."<img src='".$program_logo_url."' alt='Shop logo'>";
                                    }
                                $products_content = $products_content."</span>";
                            $products_content = $products_content."</div>";
                        $products_content = $products_content."</a>";
                    $products_content = $products_content."</div>";
                }
            }
            $full_content = $full_content . $products_content;
        }
        return $full_content;
    }
    return $content;
}

function fast_affiliate_shortcode($param){
    extract(
        shortcode_atts(
            array(
                'link_id' => 0
            ),
            $param
        )
    );
    $post_id=intval($GLOBALS['post']->ID);
    $choices = get_post_meta($post_id,'fast_affiliate_products_choice', true);
    $content="";
    $products_content = "";

    $show_price = get_option('fast_affiliate_show_price');
    
    if (is_array($choices)) {
        $content = $content . "<div id='fa_post_id' data-post_id=" . $post_id . "></div>"; 
        foreach($choices as $product){
            if (array_key_exists('link_type', $product ) == false) {
                $product['link_type'] = "Product Link";
            }
            if ($product['link_type']=="Product Link"){
                if ($product['link_id']==$link_id){
                    $programs=get_option('fast_affiliate_programs');
                    foreach($programs as $program) {
                        if ($product['program_id']==$program['program_id']){
                            $program_logo_url=$program['program_logo_url'];
                            $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
                            $program_name = $program['program_name'];
                        }
                    }
                    $products_content = $products_content."<div class='fast_affiliate_product'>";
                        $products_content = $products_content."<a class='fa_product_shortcode' href=".$product['affiliate_product_url']." target='_blank' rel='nofollow' data-link_id=" . $product['link_id'] . ">";
                            $products_content = $products_content."<div class='fast_affiliate_left_column'>";
                                $products_content = $products_content."<p>";
                                    $products_content = $products_content."<img src='".$product['product_url_image']."' alt='product'>";
                                $products_content = $products_content."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_middle_column'>";
                                $products_content = $products_content."<p>".$product['product_name']."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_right_column'>";
                                $products_content = $products_content."<span>";
                                    if ($show_price) {
                                        if (strcmp($product['product_currency'],"EUR")==0){
                                            $currency="€";
                                        } else {
                                            $currency=$product['product_currency'];
                                        }
                                        $products_content = $products_content . "<div class='offer_price'>" . $product['product_price'] . " " . $currency . "</div>";
                                    }
                                    $products_content = $products_content."<div class='fast_affiliate_button_offer'>".(__('See Offer','fast-affiliate'))."</div>";
                                    if ($program_logo_url == "") {
                                        $products_content = $products_content."<span id='program_name'>".$program_name."</span>";
                                    }
                                    else {
                                        $products_content = $products_content."<img src='".$program_logo_url."' alt='Shop logo'>";
                                    }
                                $products_content = $products_content."</span>";
                            $products_content = $products_content."</div>";
                        $products_content = $products_content."</a>";
                    $products_content = $products_content."</div>";
                }
            } else { // Quick link case
                if ($product['link_id']==$link_id){
                    $programs=get_option('fast_affiliate_programs');
                    foreach($programs as $program) {
                        if ($product['program_id']==$program['program_id']){
                            $program_logo_url=$program['program_logo_url'];
                            $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
                            $program_name = $program['program_name'];
                        }
                    }
                    $products_content = $products_content."<div class='fast_affiliate_product'>";
                        $products_content = $products_content."<a class='fa_product_shortcode' href=".$product['affiliate_product_url']." target='_blank' rel='nofollow' data-link_id=" . $product['link_id'] . ">";
                            $products_content = $products_content."<div class='fast_affiliate_left_column'>";
                                $products_content = $products_content."<p>";
                                    $products_content = $products_content."<img src='".$program_logo_url."' alt='product'>";
                                $products_content = $products_content."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_middle_column'>";
                                $products_content = $products_content."<p>".$product['product_name']."</p>";
                            $products_content = $products_content."</div>";
                            $products_content = $products_content."<div class='fast_affiliate_right_column'>";
                                $products_content = $products_content."<span>";
                                    if ($show_price) {
                                        if (strcmp($product['product_currency'],"EUR")==0){
                                            $currency="€";
                                        } else {
                                            $currency=$product['product_currency'];
                                        }
                                        $products_content = $products_content . "<div class='offer_price'>" . $product['product_price'] . " " . $currency . "</div>";
                                    }
                                    $products_content = $products_content."<div class='fast_affiliate_button_offer'>".(__('See Offer','fast-affiliate'))."</div>";
                                    if ($program_logo_url == "") {
                                        $products_content = $products_content."<span id='program_name'>".$program_name."</span>";
                                    }
                                    else {
                                        $products_content = $products_content."<img src='".$program_logo_url."' alt='Shop logo'>";
                                    }
                                $products_content = $products_content."</span>";
                            $products_content = $products_content."</div>";
                        $products_content = $products_content."</a>";
                    $products_content = $products_content."</div>";
                }
            }
        }
    } else {
        // No products in this post
    }
    return $products_content;
}

function fast_affiliate_delete_post($postid){
    $saved_products=get_post_meta($postid,'fast_affiliate_products_choice', true);
    if ($saved_products==""){
        $n_saved_products=0;
    } else {
        $n_saved_products=count($saved_products);
    }
    
    $unlink=[];
    for ($i=0; $i<$n_saved_products; $i++){
        $unlink[]= $saved_products[$i]['link_id'];
    }
    if (count($unlink)>0){
        fast_affiliate_signal_unselected($unlink);
    }
    
}