<?php

function fast_affiliate_update_ebay_config(){

    $ebay_appId = filter_var($_POST['ebay_appId'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_ebay_appId',$ebay_appId);

    $ebay_siteId= filter_var($_POST['ebay_siteId'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_ebay_siteId',$ebay_siteId);

    $ebay_campaingId= filter_var($_POST['ebay_campaingId'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_ebay_campaingId',$ebay_campaingId);

    $ebay_customId= filter_var($_POST['ebay_customId'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_ebay_customId',$ebay_customId);

    $programs_recorded=get_option('fast_affiliate_programs');
    
    $programs_ebay = fast_affiliate_get_programs_ebay();
    
    $final_programs = [];
    if ($programs_recorded) {
        $n_programs_recorded=count($programs_recorded);
        for($i=0;$i<$n_programs_recorded;$i++){
            if ($programs_recorded[$i]['platform_id']!='ebay'){
                $final_programs[]=$programs_recorded[$i];
            }
        }
    }
    
    if (is_array($programs_ebay) && count($programs_ebay)>0){
        $n_programs_ebay = count($programs_ebay);
        for ($program=0; $program<count($programs_ebay); $program++){
            $final_programs[]=$programs_ebay[$program];
        }
        if (count($final_programs)>0) {
            update_option('fast_affiliate_programs',$final_programs);
        }
    } else {
        echo 'Error: '. $programs_ebay;
    }

    wp_die();
}

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_ebay(){
    echo "<form method='post' action=''>";
    echo "<h3>".(__('eBay parameters','fast-affiliate'))."</h3>";

    echo (__('eBay appId','fast-affiliate'));
    $ebay_appId=get_option('fast_affiliate_ebay_appId');
    if (!isset($ebay_appId)){
        $ebay_appId="false";
    }
    echo "<input type='text' size='50' name='fast_affiliate_ebay_appId' id='fast_affiliate_ebay_appId' value='".$ebay_appId."'/>";
    echo " ";
    //echo "<a href='http://fast-affiliate.trencube.com/configuration-de-la-plateforme-ebay/' target='_blank'>".__('How to find those keys ?','fast-affiliate')."</a>";
    echo "<br>";

    echo (__('eBay Campaing Id','fast-affiliate'));
    $ebay_campaingId=get_option('fast_affiliate_ebay_campaingId');
    if (!isset($ebay_campaingId)){
        $ebay_campaingId="false";
    }
    echo "<input type='text' size='50' name='fast_affiliate_ebay_campaingId' id='fast_affiliate_ebay_campaingId' value='".$ebay_campaingId."'/>";
    echo "<br>";

    echo (__('eBay Custom Id','fast-affiliate'));
    $ebay_customId=get_option('fast_affiliate_ebay_customId');
    if (!isset($ebay_customId)){
        $ebay_customId="false";
    }
    echo "<input type='text' size='50' name='fast_affiliate_ebay_customId' id='fast_affiliate_ebay_customId' value='".$ebay_customId."'/>";
    echo "<br>";

    echo (__('eBay Country','fast-affiliate'));
    $ebay_siteId=get_option('fast_affiliate_ebay_siteId');
    if (!isset($ebay_siteId)){
        $ebay_siteId="false";
    }
    echo "<select id='fast_affiliate_ebay_siteId' name='fast_affiliate_ebay_siteId'>";
    // eBay ES
    if ($ebay_siteId=='EBAY-ES') {
        echo "<option selected value='EBAY-ES'>EBAY-ES</option>";
    }
    else {
        echo "<option value='EBAY-ES'>EBAY-ES</option>";
    }
    // eBay FR
    if ($ebay_siteId=='EBAY-FR') {
        echo "<option selected value='EBAY-FR'>EBAY-FR</option>";
    }
    else {
        echo "<option value='EBAY-FR'>EBAY-FR</option>";
    }
    // eBay UK
    if ($ebay_siteId=='EBAY-GB') {
        echo "<option selected value='EBAY-GB'>EBAY-GB</option>";
    }
    else {
        echo "<option value='EBAY-GB'>EBAY-GB</option>";
    }
    // eBay DE
    if ($ebay_siteId=='EBAY-DE') {
        echo "<option selected value='EBAY-DE'>EBAY-DE</option>";
    }
    else {
        echo "<option value='EBAY-DE'>EBAY-DE</option>";
    }
    // eBay IT
    if ($ebay_siteId=='EBAY-IT') {
        echo "<option selected value='EBAY-IT'>EBAY-IT</option>";
    }
    else {
        echo "<option value='EBAY-IT'>EBAY-IT</option>";
    }
    // eBay US
    if ($ebay_siteId=='EBAY-US') {
        echo "<option selected value='EBAY-US'>EBAY-US</option>";
    }
    else {
        echo "<option value='EBAY-US'>EBAY-US</option>";
    }
    echo "</select>";
    echo "<br>";

    echo "<input name='Submit' id='button_ebay' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='ebay_api_status'></div>";

    echo "<div id='ebay_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";
    $fast_affiliate_list=get_option('fast_affiliate_programs',false);

    echo "<br>";
    echo "<table class='programs_table'>";
    echo "<thead><th> ".(__("Company", "fast-affiliate"))." </th><th> ".(__("Program name", "fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    if(!$fast_affiliate_list){

    } else {
        foreach($fast_affiliate_list as $key => $value){
            if ($value['platform_id']=="ebay"){
                $program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
                echo "<tr><td> ".$value['program_site']." </td><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' height='30' width='80' ></td></tr>";
            }
        }
    }
    echo "</tbody></table>";
}

