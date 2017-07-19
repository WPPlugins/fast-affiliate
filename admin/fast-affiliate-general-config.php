<?php

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_general_config(){
    $show_price = get_option('fast_affiliate_show_price');

    echo "<form method='post' action=''>";
    echo "<h3>".(__('Configuration','fast-affiliate'))."</h3>";

    echo "<br>";

    echo "<p><label for='fast_affiliate_show_price'>" . __("Show price", "fast-affiliate") . "</label>&nbsp";

    if ($show_price) {
        echo "<input type='checkbox' id='fast_affiliate_show_price' name='fast_affiliate_show_price' checked/>";
    }
    else {
        echo "<input type='checkbox' id='fast_affiliate_show_price' name='fast_affiliate_show_price'/>";
    }
    
    echo "</p>";

    echo "<input name='Submit' id='button_general_config' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";
   
}


function fast_affiliate_update_general_config() {
    update_option('fast_affiliate_show_price', $_POST['show_price']);
    wp_die();
}