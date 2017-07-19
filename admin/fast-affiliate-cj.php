<?php

function fast_affiliate_update_cj_config(){
	$fast_affiliate_cj_site_id = filter_var($_POST['fast_affiliate_cj_site_id'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_cj_site_id',$fast_affiliate_cj_site_id);

	$fast_affiliate_cj_developer_key = filter_var($_POST['fast_affiliate_cj_developer_key'],FILTER_SANITIZE_STRING);

	update_option('fast_affiliate_cj_developer_key',$fast_affiliate_cj_developer_key);

	$programs_recorded=get_option('fast_affiliate_programs');
	
	$programs_cj = fast_affiliate_get_programs_cj();
	
	$final_programs = [];
	if ($programs_recorded) {
		$n_programs_recorded=count($programs_recorded);
		for($i=0;$i<$n_programs_recorded;$i++){
			if ($programs_recorded[$i]['platform_id']!='CJ'){
				$final_programs[]=$programs_recorded[$i];
			}
		}
	}

	$nb_programs_cj = count($programs_cj);
	if (is_array($programs_cj) && count($programs_cj)>0){
		for ($program=0;$program<$nb_programs_cj;$program++){
			$final_programs[]=$programs_cj[$program];
		}
		if (count($final_programs)>0) {
			update_option('fast_affiliate_programs',$final_programs);
		}
	} else {
		echo "Error: " . $programs_cj;
	}


    wp_die();
}

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_cj(){
	echo "<form method='post' action=''>";
	echo "<h3>".(__('CJ parameters','fast-affiliate'))."</h3>";

	echo (__('Site id','fast-affiliate'));
	$fast_affiliate_cj_site_id=get_option('fast_affiliate_cj_site_id');
	if (!isset($fast_affiliate_cj_site_id)){
		$fast_affiliate_cj_site_id="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_cj_site_id' id='fast_affiliate_cj_site_id' value='".$fast_affiliate_cj_site_id."'/>";
    echo "<br>";

   	echo (__('Developper key','fast-affiliate'));
	$fast_affiliate_cj_developer_key=get_option('fast_affiliate_cj_developer_key');
	if (!isset($fast_affiliate_cj_developer_key)){
		$fast_affiliate_cj_developer_key="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_cj_developer_key' id='fast_affiliate_cj_developer_key' value='".$fast_affiliate_cj_developer_key."'/>";
    echo "<br>";

	echo "<input name='Submit' id='button_cj' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='cj_api_status'></div>";
    echo "<div id='cj_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";
    $fast_affiliate_list=get_option('fast_affiliate_programs',false);

    echo "<br>";
    echo "<table class='programs_table'>";
    echo "<thead><th> ".(__("Company", "fast-affiliate"))." </th><th> ".(__("Program name", "fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    if(!$fast_affiliate_list){

    } else {
	    foreach($fast_affiliate_list as $key => $value){
	    	if ($value['platform_id']=="CJ"){
	    		$program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
                if ($program_logo_url == '') {
                    echo "<tr><td> ".$value['program_site']." </td><td> ".$value['program_name']." </td><td><span id='program_name'>" . $value['program_name'] . "</span></td></tr>";
                }
                else {
                    echo "<tr><td> ".$value['program_site']." </td><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' height='30' width='30' ></td></tr>";
                }
    		}
    	}
    }
    echo "</tbody></table>";
}