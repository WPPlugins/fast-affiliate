<?php
/**
 * Content of the effiliation tab
 *
 * @link       https://affiliate.trencube.com
 * @since      1.0.0
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/admin
 */
function fast_affiliate_update_effiliation_config(){

	$effiliation_api_key = filter_var($_POST['effiliation_api_key'], FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_effiliation_api_key',$effiliation_api_key);

	$programs_recorded=get_option('fast_affiliate_programs');
	$programs_effiliation = fast_affiliate_get_programs_effiliation();

	$final_programs = [];
	if ($programs_recorded) {
		$n_programs_recorded=count($programs_recorded);
		for($i=0;$i<$n_programs_recorded;$i++){
			if ($programs_recorded[$i]['platform_id']!='effiliation'){
				$final_programs[]=$programs_recorded[$i];
			}
		}
	}

	$nb_programs_effiliation = count($programs_effiliation);
	
	if (is_array($programs_effiliation) && count($programs_effiliation)>0){
		for ($program=0;$program<$nb_programs_effiliation;$program++){
			$final_programs[]=$programs_effiliation[$program];
		}
		if (count($final_programs)>0) {
			update_option('fast_affiliate_programs',$final_programs);
		}
	} else {
		echo "Error: " . $programs_effiliation;
	}

	wp_die();
}
/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_effiliation(){
	echo "<form method='post' action=''>";
	echo "<h3>".(__('Effiliation parameters','fast-affiliate'))."</h3>";

	$api_key_effiliation=get_option('fast_affiliate_effiliation_api_key');
	if (!isset($api_key_effiliation)){
		$api_key_effiliation="false";
	}
	echo "<br>";

	echo (__('Effiliation API Key','fast-affiliate'));
	echo "<input type='text' size='50' name='fast_affiliate_effiliation_api_key' id='fast_affiliate_effiliation_api_key' value='".$api_key_effiliation."' />";

	echo "<input name='Submit' id='button_effiliation' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
	echo " ";
	echo "<a href='http://fast-affiliate.trencube.com/configuration-de-la-plateforme-effiliation/' target='_blank'>".__('How to find this key ?','fast-affiliate')."</a>";
    echo "</form>";
    

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='effiliation_api_status'></div>";

    echo "<div id='effiliation_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";

    $fast_affiliate_list=get_option('fast_affiliate_programs',false);

    echo "<br>";
    echo "<table class='programs_table'>";
    echo "<thead><th> ".(__("Company","fast-affiliate"))." </th><th> ".(__("Name of the program","fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    if(!$fast_affiliate_list){

    } else {
	    foreach($fast_affiliate_list as $key => $value){
	    	if ($value['platform_id']=="effiliation"){
	    		$program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
	    		echo "<tr><td> ".$value['program_site']." </td><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' height='30' width='80' ></td></tr>";
	    	}
	    }
	}
    echo "</thead></table>";
}