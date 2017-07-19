<?php

function fast_affiliate_update_amazon_config(){

	$amazon_api_key = filter_var($_POST['amazon_api_key'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_amazon_api_key',$amazon_api_key);

	$amazon_locale= filter_var($_POST['amazon_locale'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_amazon_locale',$amazon_locale);

    $amazon_tracking_id= filter_var($_POST['amazon_tracking_id'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_amazon_tracking_id',$amazon_tracking_id);

    $amazon_secret_key= filter_var($_POST['amazon_secret_key'],FILTER_SANITIZE_STRING);
    update_option('fast_affiliate_amazon_secret_key',$amazon_secret_key);

	$programs_recorded=get_option('fast_affiliate_programs');
	
	$programs_amazon = fast_affiliate_get_programs_amazon();
	
	$final_programs = [];
	if ($programs_recorded) {
		$n_programs_recorded=count($programs_recorded);
		for($i=0;$i<$n_programs_recorded;$i++){
			if ($programs_recorded[$i]['platform_id']!='amazon'){
				$final_programs[]=$programs_recorded[$i];
			}
		}
	}
	
	if (is_array($programs_amazon) && count($programs_amazon)>0){
		$nb_programs_amazon = count($programs_amazon);
		for ($program=0;$program<$nb_programs_amazon;$program++){
			$final_programs[]=$programs_amazon[$program];
		}
		if (count($final_programs)>0) {
			update_option('fast_affiliate_programs',$final_programs);
		}
	} else {
		echo 'Error: '. $programs_amazon;
	}

    wp_die();
}

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_amazon(){
	echo "<form method='post' action=''>";
	echo "<h3>".(__('Amazon parameters','fast-affiliate'))."</h3>";

	echo (__('Amazon API key','fast-affiliate'));
	$api_key_amazon=get_option('fast_affiliate_amazon_api_key');
	if (!isset($api_key_amazon)){
		$api_key_amazon="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_amazon_api_key' id='fast_affiliate_amazon_api_key' value='".$api_key_amazon."'/>";
	echo " ";
	echo "<a href='http://fast-affiliate.trencube.com/configuration-de-la-plateforme-amazon/' target='_blank'>".__('How to find those keys ?','fast-affiliate')."</a>";
	echo "<br>";

	echo (__('Amazon Secret key','fast-affiliate'));
	$secret_key_amazon=get_option('fast_affiliate_amazon_secret_key');
	if (!isset($secret_key_amazon)){
		$secret_key_amazon="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_amazon_secret_key' id='fast_affiliate_amazon_secret_key' value='".$secret_key_amazon."'/>";
	echo "<br>";

	echo (__('Amazon tracking id','fast-affiliate'));
	$tracking_id_amazon=get_option('fast_affiliate_amazon_tracking_id');
	if (!isset($tracking_id_amazon)){
		$tracking_id_amazon="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_amazon_tracking_id' id='fast_affiliate_amazon_tracking_id' value='".$tracking_id_amazon."'/>";
	echo "<br>";

	echo (__('Amazon Country','fast-affiliate'));
	$locale_amazon=get_option('fast_affiliate_amazon_locale');
	if (!isset($locale_amazon)){
		$locale_amazon="false";
	}
	echo "<select id='fast_affiliate_amazon_locale' name='fast_affiliate_amazon_locale'>";
	// Amazon ES
	if ($locale_amazon=='ES') {
		echo "<option selected value='ES'>ES</option>";
	}
	else {
		echo "<option value='ES'>ES</option>";
	}
	// Amazon FR
	if ($locale_amazon=='FR') {
		echo "<option selected value='FR'>FR</option>";
	}
	else {
		echo "<option value='FR'>FR</option>";
	}
	// Amazon UK
	if ($locale_amazon=='UK') {
		echo "<option selected value='UK'>UK</option>";
	}
	else {
		echo "<option value='UK'>UK</option>";
	}
	// Amazon DE
	if ($locale_amazon=='DE') {
		echo "<option selected value='DE'>DE</option>";
	}
	else {
		echo "<option value='DE'>DE</option>";
	}
	// Amazon IT
	if ($locale_amazon=='IT') {
		echo "<option selected value='IT'>IT</option>";
	}
	else {
		echo "<option value='IT'>IT</option>";
	}
	// Amazon US
	if ($locale_amazon=='US') {
		echo "<option selected value='US'>US</option>";
	}
	else {
		echo "<option value='US'>US</option>";
	}
    echo "</select>";
    echo "<br>";

	echo "<input name='Submit' id='button_amazon' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='amazon_api_status'></div>";

	echo "<div id='amazon_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";
    $fast_affiliate_list=get_option('fast_affiliate_programs',false);

    echo "<br>";
    echo "<table class='programs_table'>";
    echo "<thead><th> ".(__("Company", "fast-affiliate"))." </th><th> ".(__("Program name", "fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    if(!$fast_affiliate_list){

    } else {
	    foreach($fast_affiliate_list as $key => $value){
	    	if ($value['platform_id']=="amazon"){
	    		$program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
	    		echo "<tr><td> ".$value['program_site']." </td><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' height='30' width='80' ></td></tr>";
    		}
    	}
    }
    echo "</tbody></table>";
}

