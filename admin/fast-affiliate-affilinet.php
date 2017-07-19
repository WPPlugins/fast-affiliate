<?php

function fast_affiliate_update_affilinet_config(){

	$affilinet_publisher_password = filter_var($_POST['affilinet_publisher_password'], FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_affilinet_publisher_password',$affilinet_publisher_password);

	$affilinet_products_token = filter_var($_POST['affilinet_products_password'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_affilinet_products_password',$affilinet_products_token);

	$affilinet_publisher_id = filter_var($_POST['affilinet_publisher_id'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_affilinet_publisher_id',$affilinet_publisher_id);

	$programs_recorded=get_option('fast_affiliate_programs');
	$programs_affilinet = fast_affiliate_get_programs_affilinet();
	
	$final_programs = [];
	if ($programs_recorded) {
		$n_programs_recorded=count($programs_affilinet);
		for($i=0;$i<$n_programs_recorded;$i++){
			if ($programs_recorded[$i]['platform_id']!='affilinet'){
				$final_programs[]=$programs_recorded[$i];
			}
		}
	}

	
	if (is_array($programs_affilinet) && count($programs_recorded)){
		$nb_programs_affilinet = count($programs_affilinet);
		for ($program=0;$program<$nb_programs_affilinet;$program++){
			$final_programs[]=$programs_affilinet[$program];
		}
		if (count($final_programs)>0) {
			update_option('fast_affiliate_programs',$final_programs);
		}
	} else {
		echo 'Error: ' . $programs_affilinet;
	}

    wp_die();

}

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_affilinet(){
	echo "<form method='post' action=''>";
	echo "<h3>".(__('Affilinet parameters','fast-affiliate'))."</h3>";

	echo (__('Affilinet Publisher Password','fast-affiliate'));
	$affilinet_publisher_password=get_option('fast_affiliate_affilinet_publisher_password');
	if (!isset($affilinet_publisher_password)){
		$affilinet_publisher_password="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_affilinet_publisher_password' id='fast_affiliate_affilinet_publisher_password' value='".$affilinet_publisher_password."'/>";
	echo "<br>";

	echo (__('Affilinet Products Password','fast-affiliate'));
	$affilinet_products_password=get_option('fast_affiliate_affilinet_products_password');
	if (!isset($affilinet_products_password)){
		$affilinet_products_password="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_affilinet_products_password' id='fast_affiliate_affilinet_products_password' value='".$affilinet_products_password."'/>";
	echo "<br>";

	echo (__('Affilinet Publisher id','fast-affiliate'));
	$affilinet_publisher_id=get_option('fast_affiliate_affilinet_publisher_id');
	if (!isset($affilinet_publisher_id)){
		$affilinet_publisher_id="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_affilinet_publisher_id' id='fast_affiliate_affilinet_publisher_id' value='".$affilinet_publisher_id."'/>";
	echo "<br>";

    echo "<br>";

	echo "<input name='Submit' id='button_affilinet' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='affilinet_api_status'></div>";
    echo "<div id='affilinet_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";
    $fast_affiliate_list=get_option('fast_affiliate_programs');

    echo "<br>";
    echo "<table class='programs_table'>";
    echo "<thead><th> ".(__("Program name", "fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    foreach($fast_affiliate_list as $key => $value){
    	if ($value['platform_id']=="affilinet"){
    		$program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
    		echo "<tr><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' height='30' width='80' ></td></tr>";
    	}
    }
    echo "</tbody></table>";
}